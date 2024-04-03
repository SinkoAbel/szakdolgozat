<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public static array $ROLES = [
        UserRolesEnum::PATIENT,
        UserRolesEnum::DOCTOR,
        UserRolesEnum::ADMIN
    ];

    public static array $TOKEN_TYPE = [
        'Patient-Token',
        'Doctor-Token',
        'Admin-Token'
    ];

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
        return $this->hasOne(PatientDetail::class);
    }

    // Doctor roles
    public function bookable_reception_times(): HasMany
    {
        return $this->hasMany(BookableReceptionTimes::class);
    }

    public function reserved_bookings(): HasMany
    {
        return $this->hasMany(ReservedBookings::class);
    }

    public function scopeFilterUserRole(Builder $query, string $userRole): Builder
    {
        return $query->role($userRole);
    }
}
