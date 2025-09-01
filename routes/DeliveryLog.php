<?php
use App\Http\Controllers\DeliveryLogController;
use Illuminate\Support\Facades\Route;
// DeliveryLogs imbriqués dans Stops (eux-mêmes dans Routes)
Route::resource('routes.stops.delivery_logs', DeliveryLogController::class);
