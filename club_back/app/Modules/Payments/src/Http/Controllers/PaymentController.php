<?php

namespace holoo\modules\Payments\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Payments\src\services\HolooSubscription;
use App\Modules\Smss\src\Jobs\SendSmsPaymentJob;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Bases\servers\bank\PaymentGatewayInterface;
use holoo\modules\Payments\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
     public function __construct(
         protected Responses $responses,
         protected  PaymentGatewayInterface $gateway,
         protected  HolooSubscription $holooSubscription,
     ){}
    public function pay(Request $request)
    {
        $price = $request->uid;
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
        if (!empty($result) && $result !== false ) {
            $this->holooSubscription->confirmRenewal([
                'username'=>$payment->mobile,
                'product_serial_number' => $payment->serial_number ,
                 'transaction_number'=> $payment->ref_id ,
                'payment_status'=>'success'
            ]);
           /// SendSmsPaymentJob::dispatch($payment->mobile, trans('messages.sendSmsOnlineFirst'));

            return redirect()->to(config('app.web_url') . 'SUCCESSFUL/' . $result . '/' . $payment->created_at);
        }
        $this->holooSubscription->confirmRenewal([
            'username'=>$payment->mobile,
            'product_serial_number' => $payment->serial_number ,
            'transaction_number'=> ($payment->ref_id)? $payment->ref_id : '',
            'payment_status'=>'failed'
        ]);
        return $this->handleErrorStatus($request->Status);
    }

    protected function handleErrorStatus($status): \Illuminate\Http\RedirectResponse
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
}
