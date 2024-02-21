<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookableReceptionTimes extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'date',
        'time',
        'duration'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'time',
    ];
}
