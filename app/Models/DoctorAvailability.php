<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAvailability extends Model
{
    protected $fillable = [
        'user_id', 'day', 'start_time', 'end_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}