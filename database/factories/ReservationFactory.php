<?php
namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'tour_id' => \App\Models\Tour::factory(),
            'number_of_people' => rand(1, 5),
            'number_of_children' => rand(0, 3),
            'reservation_number' => Str::random(8),
            'reservation_date' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

