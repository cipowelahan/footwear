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
            [ 'id' => 1, 'nama' => 'Penggajian' ],
            [ 'id' => 2, 'nama' => 'Operasional' ],
            [ 'id' => 3, 'nama' => 'Modal' ],
            [ 'id' => 4, 'nama' => 'Sewa' ],
        ]);

        DB::table('m_asset_kategori')->insert([
            [ 'id' => 1, 'nama' => 'Kendaraan' ],
            [ 'id' => 2, 'nama' => 'Peralatan' ],
            [ 'id' => 3, 'nama' => 'Perlengkapan' ],
        ]);
    }
}
