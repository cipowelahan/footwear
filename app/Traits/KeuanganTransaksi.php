<?php

namespace App\Traits;

use App\Models\InfoModal;
use App\Models\Transaksi\Keuangan;

trait KeuanganTransaksi {

    public static function bootKeuanganTransaksi() {
        static::created(function ($model) {
            $info = InfoModal::first();
            $kas = ($model->jenis == 'pembelian') ? ($info->kas - $model->total):($info->kas + $model->total); 
            $info->update([
                'kas' => $kas
            ]);
            
            Keuangan::create([
                'transaksi_id' => $model->id,
                'tanggal' => $model->tanggal,
                'jenis' => ($model->jenis == 'pembelian') ? 'keluar':'masuk',
                'keterangan' => 'transaksi',
                'total' => $model->total,
                'sisa_kas' => $kas
            ]);

        });
    }
}
