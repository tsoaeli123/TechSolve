<?php

namespace App\Services;
use Twilio\Rest\Client;

class TwilioService
{


protected $twilio;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    
        
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );


    }

  public function sendSMS($to, $message)
    {
        return $this->twilio->messages->create($to, [
            'from' => config('services.twilio.from'),
            'body' => $message
        ]);
    }


}
