<?php

namespace App\services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function sendSms(string $phone, string $message): bool
    {
        try {
            $url = env('SMS_URL');
            $apiKey = env('SMS_API_KEY');
            $senderId = env('SMS_SENDER_ID');

            $response = Http::asForm()->post($url, [
                'api_key' => $apiKey,
                'senderid' => $senderId,
                'number' => $phone,
                'message' => $message,
            ]);

            if ($response->successful()) {
                $result = $response->json();

                if (isset($result['response_code']) && $result['response_code'] == 202) {
                    Log::info("BulkSMSBD: SMS successfully sent to {$phone}");
                    return true;
                }
                Log::error("BulkSMSBD API Error for {$phone}: " . json_encode($result));
                return false;
            }
            Log::error("BulkSMSBD HTTP Error for {$phone}: Status " . $response->status());
            return false;

        } catch (Exception $e) {
            Log::error("SMS Sending Failed: " . $e->getMessage());
            return false;
        }
    }
}
