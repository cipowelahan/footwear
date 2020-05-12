<?php

namespace App\Models\Master;

use App\Traits\KeuanganAsset;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model {

    use KeuanganAsset;
    
    protected $table = 'm_asset';

    protected $guarded = [];

    public function kategori() {
        return $this->belongsTo('App\Models\Master\AssetKategori', 'kategori_id');
    }

    public function keuangan() {
        return $this->hasMany('App\Models\Transaksi\Keuangan', 'asset_id');
    }
}
