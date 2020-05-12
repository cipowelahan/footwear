<?php

namespace App\Models\Transaksi;

use App\Traits\KeuanganTransaksi;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model {

    use KeuanganTransaksi;
    
    protected $table = 'tr_transaksi';

    protected $guarded = [];

    public $timestamps = false;

    public function tr_produk() {
        return $this->hasMany('App\Models\Transaksi\TransaksiProduk', 'transaksi_id');
    }

    public function keuangan() {
        return $this->hasMany('App\Models\Transaksi\Keuangan', 'transaksi_id');
    }

}
