<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $table = 'routes';

    protected $fillable = [
        'name',
        'description',
        'scheduled_date',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function stops()
    {
        return $this->hasMany(Stop::class);
    }
}
