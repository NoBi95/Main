<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Important: use this!
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
}
