<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteFactory extends Factory
{
    protected $model = Route::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->streetName . ' Route',
            'description' => $this->faker->sentence(),
            'scheduled_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }
}
