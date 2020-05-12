<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model {
    
    protected $table = 'm_produk';

    protected $guarded = [];

    public function kategori() {
        return $this->belongsTo('App\Models\Master\ProdukKategori', 'kategori_id');
    }

    public function tr_produk() {
        return $this->hasMany('App\Models\Transaksi\TransaksiProduk', 'produk_id');
    }
}
