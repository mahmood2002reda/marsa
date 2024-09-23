<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TourTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'tour_duration', 'must_know', 'location', 'type', 'governorate', 
        'tour_id', 'locale', 'name', 'description', 'services'
    ];


    public function images()
    {
        return $this->hasManyThrough(TourImage::class, Tour::class, 'id', 'tour_id', 'tour_id', 'id');
    }
}



