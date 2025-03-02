<?php

namespace holoo\modules\Invoices\services;

use holoo\modules\Bases\Helper\Responses;

class InoviceServices
{

    public function __construct( protected TncCrmServices $crmServices  , protected  Responses $responses)
    {

    }
   public function getUserInformation($code)
   {
       return  $this->crmServices->getSerialData($code);
   }
    public function getPrices($serial)
    {
        return  $this->crmServices->getPayment($serial, true, '');
    }
    public function ApiPrices($serial)
    {
          $result =    $this->crmServices->getPayment($serial, true, '');
           if($result->getOriginalContent()['status'] === 'true'){
              $data = $result->getOriginalContent()['data'];

               return  $this->responses->success([
                   'sumPrice'=>  $data->sumPrice,
                   'maliyat'=>  $data->maliyat,
                   'shahrdary'=>  $data->shahrdary,
                   'totalprice'=>  $data->totalprice,
                   'title'=>  $data->article[0]->title,
                   'qty'=>  $data->article[0]->qty,
                   'price'=>  $data->article[0]->price,
               ],''
               );

           }
           return $result;

    }


}














