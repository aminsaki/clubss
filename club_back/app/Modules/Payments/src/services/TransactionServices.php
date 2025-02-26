<?php

namespace App\Modules\Payments\src\services;

use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Payments\Contracts\PaymentInterface;


class TransactionServices
{
    public function __construct(protected  PaymentInterface $payment, protected Responses $responses)
    {}
    public function getTransaction($request): \Illuminate\Http\JsonResponse
    {
        $transaction = $this->payment->withAndPaginateRole($request, 20);
        if ($transaction) {
            return $this->responses->success($transaction, trans('validation.success'));
        }
        return $this->responses->notFound('', trans('validation.notFound'));
    }
//    public function getTransactionId($data, $model): \Illuminate\Http\JsonResponse
//    {
//        if ($payment = $this->payment->firstWhereModle(['id' => $data], 'user')) {
//            return $this->responses->success($payment, trans('validation.success'));
//        }
//        return $this->responses->notFound('', trans('validation.notFound'));
//    }
//    public function getTransactionIdMode($data, $model): mixed
//    {
//        return $this->payment->firstWhereModle($data, $model);
//    }
//    public function search($request): \Illuminate\Http\JsonResponse
//    {
//        if (!empty($request)) {
//            return $this->responses->success($this->payment->searchPayment($request), trans('validation.success'));
//        }
//        return $this->getTransaction($request);
//    }
//    public function serachExcel($request): \Illuminate\Http\JsonResponse
//    {
//       return $this->exportExcel($this->payment->queryExcel($request));
//    }
}
