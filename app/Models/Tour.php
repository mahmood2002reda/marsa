<?php

namespace App\Models;

use App\Models\Type;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class Tour extends Model
{
    use HasFactory;    
    use Translatable;


    protected $table = 'tours';
    public $translatedAttributes = [
        'tour_duration', 'must_know', 'location', 'type', 'governorate',
        'name', 'description', 'services'
    ];

protected $fillable = [
    'start_date', 'price', 'latitude', 'longitude',
];
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tour');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function toursImage()
{
    return $this->hasMany(TourImage::class); // Assuming this is a one-to-many relationship
}
    
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
