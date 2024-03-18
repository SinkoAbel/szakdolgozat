<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'birthday',
        'birthplace',
        'city',
        'zip',
        'street',
        'house_number',
        'insurance_number',
        'phone',
    ];

    protected $casts = [
        'birthday' => 'date:Y-m-d'
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
