<?php

namespace Database\Factories;

use App\Models\Stop;
use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

class StopFactory extends Factory
{
    protected $model = Stop::class;

    public function definition(): array
    {
        return [
            'route_id' => Route::inRandomOrder()->first()?->id ?? Route::factory(),
            'address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(47.20, 47.30), // exemple pour Nantes
            'longitude' => $this->faker->longitude(-1.60, -1.50),
            'order' => $this->faker->numberBetween(1, 20),
            'delivered' => $this->faker->boolean(70), // 70% livré
        ];
    }
}
