<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservedBookings extends Model
{
    use HasFactory;

    protected $fillable = [
        'bookable_reception_times_id',
        'user_id'
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookable_reception_times(): BelongsTo
    {
        return $this->belongsTo(BookableReceptionTimes::class);
    }
}
