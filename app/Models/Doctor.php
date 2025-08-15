<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
        'license_number',
        'address',
        'status',
        'profile_photo_path',
        'user_id',
        'password',
    ];

    protected $casts = [
        'status' => 'boolean', // Optional: Cast to boolean if preferred
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}