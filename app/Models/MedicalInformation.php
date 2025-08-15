<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalInformation extends Model
{
    protected $fillable = [
        'user_id',
        'height',
        'blood_group',
        'genotype',
        'known_allergies',
        'health_issues',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}