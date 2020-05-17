<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Produk extends Model {
    
    protected $table = 'm_produk';

    protected $guarded = [];

    protected $appends = [
        'harga_beli_format',
        'harga_jual_format',
        'hpp'
    ];

    public static function getRules($id = 0) {
        return [
            'kode' => [
                'required',
                Rule::unique('m_produk')->ignore($id)
            ],
            'nama' => 'required',
            'stok' => 'required|integer',
            'merk' => 'required',
            'warna' => 'required',
            'ukuran' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
        ];
    }

    public static function getMessages() {
        return [
            'kode.required' => 'Kode Dibutuhkan',
            'kode.unique' => 'Kode Sudah Dipakai',
            'nama.required' => 'Nama Dibutuhkan',
            'stok.required' => 'Stok Dibutuhkan',
            'stok.integer' => 'Gunakan Angka Bulat untuk Stok',
            'merk.required' => 'Merk Dibutuhkan',
            'warna.required' => 'Warna Dibutuhkan',
            'ukuran.required' => 'Ukuran Dibutuhkan',
            'harga_beli.required' => 'Harga Beli Dibutuhkan',
            'harga_jual.required' => 'Harga Jual Dibutuhkan',
        ];
    }

    public function getHargaBeliFormatAttribute() {
        return number_format($this->harga_beli);
    }

    public function getHargaJualFormatAttribute() {
        return number_format($this->harga_jual);
    }

    public function getHppAttribute() {
        return $this->harga_beli;
    }

    public function kategori() {
        return $this->belongsTo('App\Models\Master\ProdukKategori', 'kategori_id');
    }

    public function tr_produk() {
        return $this->hasMany('App\Models\Transaksi\TransaksiProduk', 'produk_id');
    }
}
