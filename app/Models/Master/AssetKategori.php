<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class AssetKategori extends Model {
    
    protected $table = 'm_asset_kategori';

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

    public function asset() {
        return $this->hasMany('App\Models\Transaksi\Asset', 'kategori_id');
    }
}
