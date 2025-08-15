<?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Model;

   class DoctorDetail extends Model
   {
       protected $table = 'doctor_details';
       protected $fillable = ['user_id', 'phone', 'specialization', 'license_number', 'address'];

       public function user()
       {
           return $this->belongsTo(User::class);
       }
   }