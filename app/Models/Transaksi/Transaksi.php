<?php

namespace App\Models\Transaksi;

use App\Traits\KeuanganTransaksi;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model {

    use KeuanganTransaksi;
    
    protected $table = 'tr_transaksi';

    protected $guarded = [];

    public $timestamps = false;

    protected $appends = [
        'diskon_format',
        'total_format'
    ];

    public function getDiskonFormatAttribute() {
        return number_format($this->diskon);
    }

    public function getTotalFormatAttribute() {
        return number_format($this->total);
    }

    public function tr_produk() {
        return $this->hasMany('App\Models\Transaksi\TransaksiProduk', 'transaksi_id');
    }

    public function supplier() {
        return $this->belongsTo('App\Models\Master\Supplier', 'supplier_id');
    }

    public function keuangan() {
        return $this->hasMany('App\Models\Transaksi\Keuangan', 'transaksi_id');
    }

}
