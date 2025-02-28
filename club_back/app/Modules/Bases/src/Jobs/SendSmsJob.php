<?php

namespace holoo\modules\Bases\Jobs;

use holoo\modules\Bases\servers\sms\SmsInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected  $phoneNumber ,  protected  $message)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(SmsInterface $sms ): void
    {
        try {

            $response =  $sms->send($this->phoneNumber, $this->message);

            Log::info("SMS was successfully sent to {$this->phoneNumber}: {$this->message}", ['response' => $response]);
        } catch (\Exception $e) {
            Log::error("Error sending SMS to {$this->phoneNumber}: " . $e->getMessage());        }
    }
}






















