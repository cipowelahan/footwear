<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthSeeder extends Seeder {

    public function run() {
        User::create([
            'nama' => 'admin',
            'username' => 'admin1234',
            'password' => Hash::make('admin1234'),
            'level' => 1,
            'foto' => 'assets/image/profil.jpg'
        ]);  
    }
}
