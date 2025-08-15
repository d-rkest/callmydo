<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    protected $fillable = [
        'user_id', 'report_type', 'file_path', 'status', 'doctor_id',
        'findings', 'diagnosis', 'cause', 'remedy', 'treatment_plan', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function medications()
    {
        return $this->belongsToMany(Medication::class, 'report_medications')->withPivot('dosage');
    }
}