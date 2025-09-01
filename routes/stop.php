<?php
use App\Http\Controllers\StopController;
use Illuminate\Support\Facades\Route;
// Stops imbriqués dans Routes
Route::resource('routes.stops', StopController::class);
