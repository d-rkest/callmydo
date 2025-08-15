<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorReview extends Model
{
    protected $fillable = ['appointment_id', 'doctor_id', 'rating', 'comment'];
}