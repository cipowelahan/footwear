<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Model;

class TransaksiProduk extends Model {
    
    protected $table = 'tr_transaksi_produk';

    protected $guarded = [];

    public $timestamps = false;

    public function transaksi() {
        return $this->belongsTo('App\Models\Transaksi\Transaksi', 'transaksi_id');
    }

    public function produk() {
        return $this->belongsTo('App\Models\Master\Produk', 'produk_id');
    }

}
