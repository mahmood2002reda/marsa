<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Tour;
use App\Models\Offer;

class TourObserver
{
    /**
     * Handle the Tour "created" event.
     */
    public function created(Tour $tour): void
    {
        //
    }

    /**
     * Handle the Tour "updated" event.
     */
   
     
    public function updated(Tour $tour)
    {
        if ($tour->has_offer == 1 && $tour->getOriginal('has_offer') == 0) {

            // تعيين قيمة new_price بناءً على منطق معين
            $newPrice = $tour->price * 0.9; // خصم 10% كافتراض

            // تعيين تاريخ نهاية العرض بناءً على منطق معين
            $offerEndDate = Carbon::now()->addDays(7); // على سبيل المثال 7 أيام

            // إضافة السجل في جدول offer
            Offer::create([
                'tour_id' => $tour->id,
                'new_price' => $newPrice, // تأكد من أن هذه القيمة ليست فارغة
                'offer_end_date' => $offerEndDate, // تعيين تاريخ نهاية العرض
            ]);
        }
    }
    

    /**
     * Handle the Tour "deleted" event.
     */
    public function deleted(Tour $tour): void
    {
        //
    }

    /**
     * Handle the Tour "restored" event.
     */
    public function restored(Tour $tour): void
    {
        //
    }

    /**
     * Handle the Tour "force deleted" event.
     */
    public function forceDeleted(Tour $tour): void
    {
        //
    }
}
