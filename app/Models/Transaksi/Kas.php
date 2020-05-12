<?php

namespace App\Models\Transaksi;

use App\Traits\KeuanganKas;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model {

    use KeuanganKas;
    
    protected $table = 'tr_kas';

    protected $guarded = [];

    public $timestamps = false;

    public function kategori() {
        return $this->belongsTo('App\Models\Master\KasKategori', 'kategori_id');
    }

    public function keuangan() {
        return $this->hasMany('App\Models\Transaksi\Keuangan', 'kas_id');
    }

}
