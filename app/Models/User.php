<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    protected $fillable = [
        'nama', 'username', 'password', 'level', 
        'no_hp', 'alamat', 'foto'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
