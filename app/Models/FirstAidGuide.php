<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstAidGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'steps',
        'video_url',
    ];
}