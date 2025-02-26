<?php

namespace holoo\modules\Payments\Contracts;

interface PaymentInterface
{
    public function searchPayment($data);


    public function withAndPaginateRole($request, $page);


    public function queryExcel($request);
}
