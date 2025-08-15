<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    protected $fillable = [
        'name', 'uses', 'potency_level', 'recommended_dosage_children',
        'recommended_dosage_adults', 'side_effects', 'contraindications',
        'storage_condition', 'other_key_information', 'image_url'
    ];

    public function reports()
    {
        return $this->belongsToMany(MedicalReport::class, 'report_medications')->withPivot('dosage');
    }
}