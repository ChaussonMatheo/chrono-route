<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Route;
use App\Models\Stop;
use App\Models\DeliveryLog;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Création de 5 utilisateurs
        User::factory(5)->create();

        // Chaque user reçoit 2 routes
        Route::factory(10)->create()->each(function ($route) {
            // Chaque route contient entre 5 et 15 stops
            $stops = Stop::factory(rand(5, 15))->create([
                'route_id' => $route->id,
            ]);

            // Chaque stop a entre 0 et 2 logs
            $stops->each(function ($stop) {
                DeliveryLog::factory(rand(0, 2))->create([
                    'stop_id' => $stop->id,
                ]);
            });
        });
    }
}
