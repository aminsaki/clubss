<?php

namespace holoo\modules\Payments\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Payments\src\services\HolooSubscription;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Bases\Jobs\SendSmsJob;
use holoo\modules\Bases\servers\bank\PaymentGatewayInterface;
use holoo\modules\Invoices\Models\Inovice;
use holoo\modules\Invoices\services\TncCrmServices;
use holoo\modules\Payments\Models\Payment;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
     public function __construct(
         protected Responses $responses,
         protected  PaymentGatewayInterface $gateway,
         protected  HolooSubscription $holooSubscription,
         protected TncCrmServices $crmServices
     ){}
    public function pay(Request $request)
    {
        $price = $request->uid;
//        $price = 20000;
        $mobile = $request->mobile;
        $serial_number = $request->serial_number;
        if ($price < 20000 || empty($price)) {
            return $this->responses->notFound('', 'مبلغ شما باید بیشتر از 2000 تومان باشد');
        }
        $result = $this->gateway->startPayment(
            $price,
            "پشتیبانی انلاین هلو استور",
            $mobile,
            '',
            $serial_number);
        if ($result === false) {
            return $this->handleErrorStatus("errors");
        }
        return $result;
    }
    public function verify(Request $request): \Illuminate\Http\RedirectResponse
    {
        $payment = Payment::where(['transaction_id' => $request->Authority])->first();
        if (empty($payment)) {
            return redirect()->to(config('app.web_url') . 'UNKNOWN');
        }
        $result = $this->gateway->verify($request->all());

        $username = $this->formatMobileNumber($payment->mobile);
        $paymentStatus = (!empty($result) && $result !== false) ? 'success' : 'failed';

        $this->holooSubscription->confirmRenewal([
            'username'               => $username,
            'product_serial_number'  => $payment->serial_number,
            'transaction_number'     => $payment->transaction_id,
            'payment_status'         => $paymentStatus
        ]);
        if ($paymentStatus === 'success') {
            SendSmsJob::dispatchSync($payment->mobile, trans('messages.successfully'));
            $inovice = Inovice::where(['serial'=>$payment->serial_number])->first();
            $this->crmServices->setPayment($inovice->uuid , $result);
            return redirect()->to(config('app.web_url') . 'SUCCESSFUL/' . $result . '/' . $payment->created_at);
        }
         return $this->handleErrorStatus($request->Status);
    }
    private function handleErrorStatus($status): \Illuminate\Http\RedirectResponse
    {
        switch ($status) {
            case 'UNKNOWN':
                return redirect()->to(config('app.web_url') . 'UNKNOWN');
            case 'NOK':
                return redirect()->to(config('app.web_url') . 'NOK');
            case 'errors':
                return redirect()->to(config('app.web_url') . 'errors');
            default:
                return redirect()->to(config('app.web_url') . 'UNKNOWN');
        }
    }
    private function formatMobileNumber(string $mobile): string
    {
        return (strpos($mobile, '0') === 0) ? '+98' . substr($mobile, 1) : $mobile;
    }
}
