<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryLogController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// DeliveryLogs imbriqués dans Stops (eux-mêmes dans Routes)
Route::resource('routes.stops.delivery_logs', DeliveryLogController::class);
Route::resource('routes', RouteController::class);
Route::resource('routes.stops', StopController::class);
Route::get('routes/{route}/start', [RouteController::class, 'start'])->name('routes.start');
Route::post('routes/{route}/stops/{stop}/deliver', [StopController::class, 'markDelivered'])->name('stops.deliver');


foreach (glob(__DIR__.'/routes/*.php') as $routeFile) {
    require $routeFile;
}

require __DIR__.'/auth.php';
