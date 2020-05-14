<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class ProdukKategori extends Model {
    
    protected $table = 'm_produk_kategori';

    protected $guarded = [];

    public $timestamps = false;

    public static function getRules() {
        return [
            'nama' => 'required'
        ];
    }

    public static function getMessages() {
        return [
            'nama.required' => 'Nama Dibutuhkan'
        ];
    }

    public function produk() {
        return $this->hasMany('App\Models\Master\Produk', 'kategori_id');
    }
}
