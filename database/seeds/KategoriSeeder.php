<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder {

    public function run() {
        DB::table('m_produk_kategori')->insert([
            [ 'id' => 1, 'nama' => 'Sepatu' ],
            [ 'id' => 2, 'nama' => 'Kaos' ],
            [ 'id' => 3, 'nama' => 'Kaos Kaki' ],
            [ 'id' => 4, 'nama' => 'Topi' ],
        ]);
        
        DB::table('m_kas_kategori')->insert([
            [ 'id' => 1, 'nama' => 'Utilitas' ],
            [ 'id' => 2, 'nama' => 'Iklan' ],
            [ 'id' => 3, 'nama' => 'Sewa' ],
            [ 'id' => 4, 'nama' => 'Pemeliharaan dan Perbaikan' ],
            [ 'id' => 5, 'nama' => 'Gaji dan Upah' ],
            [ 'id' => 6, 'nama' => 'Perlengkapan' ],
            [ 'id' => 7, 'nama' => 'Prive' ],
            [ 'id' => 8, 'nama' => 'Modal' ],
        ]);

        DB::table('m_asset_kategori')->insert([
            [ 'id' => 1, 'nama' => 'Kendaraan' ],
            [ 'id' => 2, 'nama' => 'Peralatan' ],
        ]);
    }
}
