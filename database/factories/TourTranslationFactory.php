<?php

namespace Database\Factories;

use App\Models\TourTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourTranslationFactory extends Factory
{
    protected $model = TourTranslation::class;

    public function definition()
    {
        return [
            'tour_id' => \App\Models\Tour::factory(),  // Make sure a Tour exists for the translation
            'tour_duration' => $this->faker->numberBetween(1, 10),
            'must_know' => $this->faker->paragraph,
            'location' => $this->faker->city,
            'type' => $this->faker->word,
            'governorate' => $this->faker->state,
            'locale' => $this->faker->randomElement(['en', 'ar']),
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'services' => $this->faker->sentence,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
