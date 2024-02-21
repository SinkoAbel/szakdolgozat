<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedBookings extends Model
{
    use HasFactory;

    protected $fillable = [
        'bookable_reception_times_id',
        'user_id'
    ];
}
