<?php

namespace App\Models\Transaksi;

use App\Traits\KeuanganKas;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model {

    use KeuanganKas;
    
    protected $table = 'tr_kas';

    protected $guarded = [];

    public $timestamps = false;

    protected $appends = [
        'total_format'
    ];

    public static function getRules() {
        return [
            'nama' => 'required',
            'tanggal' => 'required|date',
            'total' => 'required'
        ];
    }

    public static function getMessages() {
        return [
            'nama.required' => 'Nama Dibutuhkan',
            'tanggal.required' => 'Tanggal Dibutuhkan',
            'tanggal.date' => 'Gunakan Format Tanggal Y-M-D',
            'total.required' => 'Harga Beli Dibutuhkan',
        ];
    }

    public function getTotalFormatAttribute() {
        return number_format($this->total);
    }

    public function kategori() {
        return $this->belongsTo('App\Models\Master\KasKategori', 'kategori_id');
    }

    public function keuangan() {
        return $this->hasOne('App\Models\Transaksi\Keuangan', 'kas_id');
    }

}
