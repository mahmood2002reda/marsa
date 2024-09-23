<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tour_id',
        'number_of_people',
        'number_of_children',
        'reservation_number',
        'reservation_date',
        'total_price',
        'payment_status'
    ];

    /**
     * Get the user that owns the reservation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tour that owns the reservation.
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
