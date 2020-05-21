<?php

namespace App\Models\Transaksi;

use App\Traits\KeuanganAsset;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model {

    use KeuanganAsset;
    
    protected $table = 'tr_asset';

    protected $guarded = [];

    public $timestamps = false;

    protected $appends = [
        'harga_beli_format'
    ];

    public static function getRules() {
        return [
            'nama' => 'required',
            'tanggal' => 'required|date',
            'harga_beli' => 'required'
        ];
    }

    public static function getMessages() {
        return [
            'nama.required' => 'Nama Dibutuhkan',
            'tanggal.required' => 'Tanggal Dibutuhkan',
            'tanggal.date' => 'Gunakan Format Tanggal Y-M-D',
            'harga_beli.required' => 'Harga Beli Dibutuhkan',
        ];
    }

    public function getHargaBeliFormatAttribute() {
        return number_format($this->harga_beli);
    }

    public function kategori() {
        return $this->belongsTo('App\Models\Master\AssetKategori', 'kategori_id');
    }

    public function keuangan() {
        return $this->hasOne('App\Models\Transaksi\Keuangan', 'asset_id');
    }
}
