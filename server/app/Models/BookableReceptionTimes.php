<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function reserved_bookings(): HasOne
    {
        return $this->hasOne(ReservedBookings::class);
    }

    public function doctors(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
