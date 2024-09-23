<?php

namespace Database\Seeders;

use App\Models\TourImage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TourImage::factory()->count(10)->create(); // Creates 10 random images
    }
}
