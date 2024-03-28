<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservedBookings extends Model
{
    use HasFactory;

    protected $fillable = [
        'bookable_reception_times_id',
        'patient_user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function patient_users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_user_id');
    }

    public function bookable_reception_times(): BelongsTo
    {
        return $this->belongsTo(BookableReceptionTimes::class, 'bookable_reception_times_id');
    }
    
    public function scopeFilterForPatient(Builder $query, int $patientID): Builder
    {
        return $query->where('patient_user_id', $patientID);
    }
}
