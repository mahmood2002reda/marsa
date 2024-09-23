<?php

namespace App\Services;

use App\Models\Tour;
use Exception;

class PriceService
{
    /**
     * 
     * @param int 
     * @param int 
     * @param int 
     * @return float 
     * @throws \Exception.
     */
    public function totalPrice($id, $personNumber = 1, $childNumber = 0) {
        $orgenalPrice = Tour::where('id', $id)->pluck('price')->first();
        
        if (!$orgenalPrice) {
            throw new Exception("Tour not found");
        }

        $childPrice = ($orgenalPrice * 0.75) * $childNumber;

        $totalPrice = ($orgenalPrice * $personNumber) + $childPrice;

        return $totalPrice;
    }
}
