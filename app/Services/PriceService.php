<?php

namespace App\Services;

use App\Models\Tour;
use Exception;

class PriceService
{
    /**
     * حساب السعر الكلي للجولة بناءً على عدد الأشخاص وعدد الأطفال.
     * 
     * @param int $id معرف الجولة (Tour ID).
     * @param int $personNumber عدد الأشخاص البالغين.
     * @param int $childNumber عدد الأطفال.
     * @return float السعر الكلي للجولة.
     * @throws \Exception إذا لم يتم العثور على الجولة.
     */
    public function totalPrice($id, $personNumber = 1, $childNumber = 0) {
        // استرجاع السعر الأصلي للجولة
        $orgenalPrice = Tour::where('id', $id)->pluck('price')->first();
        
        // إذا لم يتم العثور على الجولة، نرمي استثناء
        if (!$orgenalPrice) {
            throw new Exception("Tour not found");
        }

        // حساب السعر للأطفال (75% من السعر للطفل الواحد)
        $childPrice = ($orgenalPrice * 0.75) * $childNumber;

        // حساب السعر الكلي
        $totalPrice = ($orgenalPrice * $personNumber) + $childPrice;

        return $totalPrice;
    }
}
