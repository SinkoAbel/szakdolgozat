<?php

namespace App\Models;

use App\Http\Enums\UserRolesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function patient_details(): HasOne
    {
        return $this->hasRole(UserRolesEnum::PATIENT->value) ? 
            $this->hasOne(PatientDetail::class) :
            null;
    }

    // Doctor roles
    public function bookable_reception_times(): HasMany|null
    {
        return $this->hasRole(UserRolesEnum::DOCTOR->value) ?
            $this->hasMany(BookableReceptionTimes::class) :
            null;
    }

    // Patient roles
    public function reserved_bookings(): HasMany|null
    {
        return $this->hasRole(UserRolesEnum::PATIENT->value) ?
            $this->hasMany(ReservedBookings::class) :
            null;
    }
}
