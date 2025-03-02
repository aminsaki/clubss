<?php

namespace holoo\modules\Invoices\services;

use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Invoices\Contracts\InvoiceInterface;
use holoo\modules\Invoices\Models\Inovice;
use Illuminate\Support\Facades\Log;
use SoapClient;

class TncCrmServices
{
    protected string $crmServiceWSDL = "http://service.tnc.ir:8080/WebSite/WebSite?wsdl";
    protected int $terminalId = 23067;
    protected $referenceId;
    protected SoapClient $soapClient;
    private static ?TncCrmServices $instance = null;

    public function __construct(protected Responses $responses, protected InvoiceInterface $invoice)
    {
        $wsdlContent = @file_get_contents($this->crmServiceWSDL);
        if ($wsdlContent === false) {
            $this->responses->notFound('', "خطا: فایل WSDL از مسیر {$this->crmServiceWSDL} بارگذاری نشد.");
            return false;
        }
        $this->soapClient = new SoapClient($this->crmServiceWSDL);
        $this->referenceId = $this->getReferenceId($this->terminalId);
    }

    public static function getInstance(): ?TncCrmServices
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function getReferenceId($terminalId): string
    {
        try {
            $referenceId = $this->soapClient->GetReferenceId($terminalId);
            return md5("!TNC@23067#" . $referenceId . "$");
        } catch (SoapFault $e) {
            return $this->responses->notFound('', "خطا در دریافت شناسه مرجع: " . $e->getMessage());
        }
    }

    public function getSerialData($serial)
    {
        try {
            $data = [
                'ReferenceId' => $this->referenceId,
                'serial' => $serial,
            ];
            $result = $this->soapClient->__soapCall('getSerialData', $data);
            return $this->responses->success(json_decode($result), '', true);
        } catch (SoapFault $e) {
            $this->responses->notFound('', "خطا در دریافت اطلاعات سریال: " . $e->getMessage());
            log::error(' getSerialData error' . '=>' . 'خطایی در دریافت اطلاعات سریال رخ داده است. لطفاً بعداً دوباره امتحان کنید.');
        }
    }

    public function setSalePayment($softCode, $newKits, $billCode, $siteId, $party, $serial): void
    {
        try {
            $data = [
                'ReferenceId' => $this->referenceId,
                'softcode' => $softCode,
                'newKits' => $newKits,
                'billCode' => $billCode,
                'siteId' => $siteId,
                'party' => json_encode($party, JSON_UNESCAPED_UNICODE)
            ];
            $result = $this->soapClient->__soapCall('setSalePayment', [$data]);
            $this->invoice->update(['serial' => $serial], ['response' => $result]);
        } catch (SoapFault $e) {
            $this->invoice->update(['serial' => $serial], ['response' => $e->getMessage()]);
        }
    }

    public function getPayment($serial, $renew = false, $newCode = '')
    {
        try {
            $data = [
                'ReferenceId' => $this->referenceId,
                'Serial' => $serial,
                'CompanyId' => 1,
                'IsTamdid' => $renew ? 1 : 0,
                'IsNewVer' => false,
                'NewKits' => '',
                'IsNeedCD' => 0,
                'newCode' => json_encode(['isLogin' => false, 'newCode' => $newCode])
            ];
            $result = $this->soapClient->__soapCall('getPayment', $data);
            $json = json_decode($result);
            $result = Inovice::where(['serial' => $json->serialInfo->serial])->first();
            if (!$result) {
                $this->invoice->create([
                    'partyName' => $json->serialInfo->partyName,
                    'partyFamily' => $json->serialInfo->partyFamily,
                    'partyAddress' => $json->serialInfo->partyAddress,
                    'partyNationalCode' => $json->serialInfo->partyNationalCode,
                    'partyTell' => $json->serialInfo->partyTell,
                    'partyMobile' => $json->serialInfo->partyMobile,
                    'serial' => $json->serialInfo->serial,
                    'uuid' => $json->uuid,
                ]);
            }
            return $this->responses->success($json, '', true);
        } catch (SoapFault $e) {
            log::error('error' . '=>' . 'خطایی در دریافت اطلاعات پرداخت رخ داده است. لطفاً بعداً دوباره امتحان کنید.');
            return $this->responses->notFound('', "خطا در دریافت اطلاعات پرداخت: " . $e->getMessage());
        }
    }

    public function setPayment($uuid, $billCode)
    {
        try {
            $data = [
                'ReferenceId' => $this->referenceId,
                'uuid' => $uuid,
                'billCode' => $billCode,
            ];

            $result = $this->soapClient->__soapCall('setPayment', $data);
            $inovice = Inovice::where(['uuid'=>$uuid])->update(['response'=>$result]);
            //return $this->responses->success($result, '', true);
        } catch (SoapFault $e) {
            $inovice = Inovice::where(['uuid'=>$uuid])->update(['response'=> $e->getMessage()]);
            log::error('error' . ' => ' . 'خطایی در ثبت پرداخت رخ داده است. لطفاً بعداً دوباره امتحان کنید.');
        }
    }
}
