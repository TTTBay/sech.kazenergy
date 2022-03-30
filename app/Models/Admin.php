<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admins';

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = ['password'];


}