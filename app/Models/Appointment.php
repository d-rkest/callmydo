<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id', 
        'doctor_id', 
        'appointment_date', 
        'appointment_time', 
        'status', 
        'reason', 
        'room_url',
        'findings', 
        'diagnosis', 
        'recommendations'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class);
    }
}