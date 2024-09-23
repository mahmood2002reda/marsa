<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourTranslation;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 tours and associate translations with them
        Tour::factory()
            ->count(10)
            ->create()
            ->each(function ($tour) {
                // Create English translation
                TourTranslation::factory()->create([
                    'tour_id' => $tour->id,
                    'locale' => 'en',
                ]);

                // Create Arabic translation
                TourTranslation::factory()->create([
                    'tour_id' => $tour->id,
                    'locale' => 'ar',
                ]);
            });
    }
}
