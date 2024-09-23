<?php

namespace App\Services;

use App\Models\Reservation;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentService
{
    public function processPayment($reservationId, $stripeToken)
    {
        $reservation = Reservation::findOrFail($reservationId);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => $reservation->total_price * 100, 
                'currency' => 'egp',
                'description' => 'Payment for Reservation ' . $reservation->reservation_number,
                'source' => $stripeToken,
            ]);

            $reservation->update(['payment_status' => 'paid']);

            return ['success' => true, 'message' => 'Payment successful!'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
