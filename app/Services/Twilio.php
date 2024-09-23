<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;

class Twilio
{
    public function send($user)
{
    $sid = env('TWILIO_SID');
    $token = env('TWILIO_TOKEN');
    $client = new Client($sid, $token);

    try {
        $message = $client->messages->create(
            $user->phone,
            [
                'from' => env('TWILIO_FROM_NUMBER'),
                'body' => "Hey $user->name! Your OTP is $user->otp!"
            ]
        );
        Log::info('Message SID: ' . $message->sid);
    } catch (TwilioException $e) {
        Log::alert('Twilio Error: ' . $e->getMessage());
    }
}

}