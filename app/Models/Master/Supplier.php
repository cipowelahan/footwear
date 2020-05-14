<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {
    
    protected $table = 'm_supplier';

    protected $guarded = [];

    public static function getRules() {
        return [
            'nama' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
        ];
    }

    public static function getMessages() {
        return [
            'nama.required' => 'Nama Dibutuhkan',
            'no_hp.required' => 'No HP Dibutuhkan',
            'alamat.required' => 'Alamat Dibutuhkan',
        ];
    }

    public function transaksi() {
        return $this->hasMany('App\Models\Transaksi\Transaksi', 'supplier_id');
    }
}
