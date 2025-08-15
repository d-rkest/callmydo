<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Illness extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'symptoms',
        'local_remedy',
        'otc_medications',
    ];
}