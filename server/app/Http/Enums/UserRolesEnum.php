<?php

namespace App\Http\Enums;

enum UserRolesEnum: string
{
    case PATIENT = 'patient';
    case DOCTOR = 'doctor';
    case ADMIN = 'admin';
}
