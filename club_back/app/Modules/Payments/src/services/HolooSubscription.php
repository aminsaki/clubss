<?php

namespace App\Modules\Payments\src\services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HolooSubscription
{
    public function confirmRenewal($data = [])
    {
        Log::info('Sending request to Holoo Subscription Renewal API', [
            'url' => 'https://holoo.bizups.ai/api/holoo/subscription-renewal/confirm',
            'payload' => $data,
        ]);
        try {
            $result =Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://holoo.bizups.ai/api/holoo/subscription-renewal/confirm', $data);

            Log::info('Response from Holoo Subscription Renewal API', [
                'status_code' => $result->status(),
                'response_body' => $result->body(),
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Error in Holoo Subscription Renewal API request', [
                'error_message' => $e->getMessage(),
                'payload' => $data,
            ]);

            return null;
        }
    }
}
