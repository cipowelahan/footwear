<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class KasKategori extends Model {
    
    protected $table = 'm_kas_kategori';

    protected $guarded = [];

    public $timestamps = false;

    public function kas() {
        return $this->hasMany('App\Models\Transaksi\Kas', 'kategori_id');
    }
}
