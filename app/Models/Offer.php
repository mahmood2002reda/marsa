<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'tour_id',
        'new_price',
        'offer_end_date',
    ];
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    
}
