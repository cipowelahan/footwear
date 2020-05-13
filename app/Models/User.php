<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Validation\Rule;

class User extends Authenticatable {

    use Notifiable;

    protected $fillable = [
        'nama', 'username', 'password', 'level', 
        'no_hp', 'alamat', 'foto'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getRules($id = 0) {
        return [
            'nama' => 'required',
            'username' => [
                'required',
                Rule::unique('users')->ignore($id)
            ]
        ];
    }

    public static function getMessages() {
        return [
            'nama.required' => 'Nama Dibutuhkan',
            'username.required' => 'Username Dibutuhkan',
            'username.unique' => 'Username Sudah Digunakan',
        ];
    }
}
