<?php

namespace Database\Factories;

use App\Models\DeliveryLog;
use App\Models\Stop;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryLogFactory extends Factory
{
    protected $model = DeliveryLog::class;

    public function definition(): array
    {
        return [
            'stop_id' => Stop::inRandomOrder()->first()?->id ?? Stop::factory(),
            'delivered_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'status' => $this->faker->randomElement(['success', 'failed', 'absent']),
            'notes' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
        ];
    }
}
