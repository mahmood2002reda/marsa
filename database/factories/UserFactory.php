<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'notation' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // You can use Hash::make instead
            'remember_token' => Str::random(10),
            'verification_token' => Str::random(50),
            'verification_token_till' => now()->addDays(2),
            'otp' => rand(100000, 999999),
            'otp_till' => now()->addMinutes(5),
            'fcm_token' => Str::random(60),
            'preferred_locale' => $this->faker->randomElement(['en', 'ar']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
