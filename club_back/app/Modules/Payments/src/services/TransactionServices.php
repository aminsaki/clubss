<?php

namespace App\Modules\Payments\src\services;

use Faker\Provider\en_UG\PhoneNumber;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Invoices\Contracts\InvoiceInterface;
use holoo\modules\Invoices\services\TncCrmServices;
use holoo\modules\Payments\Contracts\PaymentInterface;


class TransactionServices
{
    public function __construct(
        protected PaymentInterface $payment,
        protected Responses        $responses,
        protected TncCrmServices   $tncs,
        protected InvoiceInterface $invoice
    )
    {
    }

    public function getTransaction($request): \Illuminate\Http\JsonResponse
    {
        $transaction = $this->payment->withAndPaginateRole($request, 20);
        if ($transaction) {
            return $this->responses->success($transaction, trans('validation.success'));
        }
        return $this->responses->notFound('', trans('validation.notFound'));
    }

    public function requestTnc($serial): void
    {
        $invoces = $this->invoice->firstWhereModle(['serial' => $serial]);
        $this->tncs->setSalePayment(
            $invoces->softcode, $invoces->newKits, $invoces->billCode, $invoces->siteId,
            [
                $invoces->partyName,
                $invoces->partyFamily,
                $invoces->partyAddress,
                $invoces->partyTell,
                $invoces->partyMobile,
                $invoces->partyNationalCode,
                $invoces->postCode
            ],
            $serial
        );
    }


}
