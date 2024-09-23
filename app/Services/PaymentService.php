<?php

namespace App\Services;

use App\Models\Reservation;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentService
{
    public function processPayment($reservationId, $stripeToken)
    {
        // استرجاع الحجز باستخدام المعرف
        $reservation = Reservation::findOrFail($reservationId);

        // إعداد Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // تنفيذ عملية الدفع باستخدام Stripe
            $charge = Charge::create([
                'amount' => $reservation->total_price * 100, // تحويل المبلغ إلى سنتات
                'currency' => 'egp', // التأكد من أن العملة صحيحة
                'description' => 'Payment for Reservation ' . $reservation->reservation_number,
                'source' => $stripeToken,
            ]);

            // تحديث حالة الحجز إلى "مدفوع"
            $reservation->update(['payment_status' => 'paid']);

            return ['success' => true, 'message' => 'Payment successful!'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
