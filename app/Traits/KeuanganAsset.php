<?php

namespace App\Traits;

use App\Models\InfoModal;
use App\Models\Transaksi\Keuangan;

trait KeuanganAsset {

    public static function bootKeuanganAsset() {
        static::created(function ($model) {
            $info = InfoModal::first();
            $kas = $info->kas - $model->harga_beli;
            $info->update([
                'kas' => $kas
            ]);

            Keuangan::create([
                'asset_id' => $model->id,
                'tanggal' => $model->tanggal,
                'jenis' => 'keluar',
                'keterangan' => 'asset',
                'total' => $model->harga_beli,
                'sisa_kas' => $kas
            ]);

        });

        // static::updated(function ($model) {
        //     Keuangan::create([
        //         'asset_id' => $model->id,
        //         'tanggal' => $model->tanggal,
        //         'jenis' => 'keluar',
        //         'keterangan' => 'asset',
        //         'total' => $model->harga_beli,
        //         'sisa_kas' => '100000000'
        //     ]);
        // });
    }
}
