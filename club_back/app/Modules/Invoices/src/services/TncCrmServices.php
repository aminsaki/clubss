<?php

namespace holoo\modules\Invoices\services;

use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Invoices\Contracts\InvoiceInterface;
use holoo\modules\Invoices\Models\Inovice;
use Illuminate\Support\Facades\Log;
use SoapClient;
use SoapFault;

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
            Log::error("WSDL file could not be loaded from: {$this->crmServiceWSDL}");
            $this->responses->notFound('', "Error: WSDL file could not be loaded.");
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
            Log::error("Failed to retrieve reference ID: " . $e->getMessage());
            return $this->responses->notFound('', "Error retrieving reference ID: " . $e->getMessage());
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

            Log::info("getSerialData successful: " . $result);

            return $this->responses->success(json_decode($result), '', true);
        } catch (SoapFault $e) {
            Log::error("getSerialData failed: " . $e->getMessage());
            return $this->responses->notFound('', "Error retrieving serial data: " . $e->getMessage());
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
            Log::info("setSalePayment successful for serial: " . $serial);
            $this->invoice->update(['serial' => $serial], ['response' => $result]);
        } catch (SoapFault $e) {
            Log::error("setSalePayment failed for serial: " . $serial . " | Error: " . $e->getMessage());
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

            if (!$json || !isset($json->serialInfo->serial)) {
                Log::error("getPayment response is invalid for serial: " . $serial);
                return $this->responses->notFound('', "Invalid payment data received.");
            }

            $existingInvoice = Inovice::where(['serial' => $json->serialInfo->serial])->first();
            if (!$existingInvoice) {
                $this->invoice->create([
                    'partyName' => $json->serialInfo->partyName ?? "",
                    'partyFamily' => $json->serialInfo->partyFamily ?? "",
                    'partyAddress' => $json->serialInfo->partyAddress ?? "",
                    'partyNationalCode' => $json->serialInfo->partyNationalCode ?? "",
                    'partyTell' => $json->serialInfo->partyTell ?? "",
                    'partyMobile' => $json->serialInfo->partyMobile ?? "",
                    'serial' => $json->serialInfo->serial,
                    'uuid' => $json->uuid ?? "",
                ]);
            }
            Log::error("getPayment response: " . json_encode($json));
            return $this->responses->success($json, '', true);
        } catch (SoapFault $e) {
            Log::error("getPayment failed for serial: " . $serial . " | Error: " . $e->getMessage());
            return $this->responses->notFound('', "Error retrieving payment information: " . $e->getMessage());
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
            Log::info("setPayment successful for UUID: " . $uuid);
            Inovice::where(['uuid' => $uuid])->update(['response' => $result]);
        } catch (SoapFault $e) {
            Log::error("setPayment failed for UUID: " . $uuid . " | Error: " . $e->getMessage());
            Inovice::where(['uuid' => $uuid])->update(['response' => $e->getMessage()]);
        }
    }
}
