<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName', 'middleName', 'lastName', 'mobile', 'email', 'passwordHash',
        'registerAt', 'lastLogin', 'intro', 'profile'
    ];

    protected $hidden = [
        'passwordHash'
    ];

    protected $dates = [
        'registerAt', 'lastLogin'
    ];
}
