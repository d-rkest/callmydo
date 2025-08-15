<?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Model;

   class UserDetail extends Model
   {
       protected $table = 'user_details';
       protected $fillable = ['user_id', 'phone', 'gender', 'date_of_birth', 'address', 'next_of_kin_name', 'next_of_kin_email', 'next_of_kin_phone', 'next_of_kin_relationship'];

       public function user()
       {
           return $this->belongsTo(User::class);
       }
   }