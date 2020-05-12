<?php

namespace App\Traits;

use App\Models\InfoModal;
use App\Models\Transaksi\Keuangan;

trait KeuanganKas {

    public static function bootKeuanganKas() {
        static::saved(function ($model) {
            $info = InfoModal::first();
            $kas = ($model->jenis == 'pengeluaran') ? ($info->kas - $model->total):($info->kas + $model->total); 
            $info->update([
                'kas' => $kas
            ]);
            
            Keuangan::create([
                'kas_id' => $model->id,
                'tanggal' => $model->tanggal,
                'jenis' => ($model->jenis == 'pengeluaran') ? 'keluar':'masuk',
                'keterangan' => 'kas',
                'total' => $model->total,
                'sisa_kas' => $kas
            ]);

        });
    }
}
