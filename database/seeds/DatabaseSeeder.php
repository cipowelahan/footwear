<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    
    public function run() {
        $this->call(KategoriSeeder::class);
        $this->call(AuthSeeder::class);
    }
}
