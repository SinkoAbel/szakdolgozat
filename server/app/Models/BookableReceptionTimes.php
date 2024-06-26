<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BookableReceptionTimes extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_user_id',
        'date',
        'start_time',
        'end_time',
        'booked',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'start_time' => 'date:H:i',
        'end_time' => 'date:H:i',
        'booked' => 'boolean'
    ];

    public function reserved_bookings(): HasOne
    {
        return $this->hasOne(ReservedBookings::class);
    }

    public function doctor_users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_user_id');
    }

    public function scopeFilterForDoctor(Builder $query, int $doctorID): Builder
    {
        return $query->where('doctor_user_id', $doctorID);
    }

    public function scopeFilterBookedAppointments(Builder $query, bool $booked): Builder
    {
        return $query->where('booked', $booked);
    }

    public function scopeFilterFromToday(Builder $query, bool $required): Builder
    {
        if ($required) {
            return $query->where('date', '>=', Carbon::now()->format('Y-m-d'));
        } else {
            return $query;
        }
    }
}
