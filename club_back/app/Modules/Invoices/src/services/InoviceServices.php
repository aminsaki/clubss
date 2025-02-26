<?php

namespace holoo\modules\Invoices\services;

class InoviceServices
{

    public function __construct( protected TncCrmServices $crmServices)
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
         $result =   $this->crmServices->getPayment($serial, true, '');
          dd($result);

    }


}














