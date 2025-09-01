<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryLog extends Model
{
    use HasFactory;

    protected $table = 'delivery_logs';

    protected $fillable = [
        'stop_id',
        'delivered_at',
        'status',
        'notes',
    ];

    public function stop()
    {
        return $this->belongsTo(Stop::class);
    }
}
