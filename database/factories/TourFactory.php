<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    public function definition()
    {
        return [
            'images' => json_encode([$this->faker->imageUrl()]),
            'start_date' => $this->faker->date(),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'has_offer' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
