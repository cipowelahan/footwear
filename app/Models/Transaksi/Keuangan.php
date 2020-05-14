<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model {
    
    protected $table = 'tr_keuangan';

    protected $guarded = [];

    public $timestamps = false;

    public function asset() {
        return $this->belongsTo('App\Models\Transaksi\Asset', 'asset_id');
    }

    public function kas() {
        return $this->belongsTo('App\Models\Transaksi\Kas', 'kas_id');
    }

    public function transaksi() {
        return $this->belongsTo('App\Models\Transaksi\Transaksi', 'transaksi_id');
    }

}
