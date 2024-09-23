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

            $newPrice = $tour->price * 0.9; 

            $offerEndDate = Carbon::now()->addDays(7); 

            Offer::create([
                'tour_id' => $tour->id,
                'new_price' => $newPrice, 
                'offer_end_date' => $offerEndDate, 
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
