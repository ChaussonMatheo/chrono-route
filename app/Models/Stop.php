<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    use HasFactory;

    protected $table = 'stops';

    protected $fillable = [
        'route_id',
        'address',
        'latitude',
        'longitude',
        'order',
        'delivered',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
    public function deliveryLogs()
    {
        return $this->hasMany(DeliveryLog::class);
    }
}
