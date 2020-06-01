<?php

namespace App\Http\Controllers\Dashboard\Laporan;

use App\Models\InfoModal;
use App\Models\Transaksi\Kas;
use App\Models\Transaksi\Keuangan;
use App\Models\Transaksi\Transaksi;
use Carbon\Carbon;

class LaporanService {

    public function collectTanggal() {
        $rawTanggal = Keuangan::selectRaw("distinct year(tanggal) as 'tahun', month(tanggal) as 'bulan'")
            ->get()
            ->map(function($data) {
                $tahun_bulan = $data->tahun.'-'.str_pad($data->bulan, 2, '0', STR_PAD_LEFT);
                $carbon = Carbon::parse($tahun_bulan);
                $bulan_text = $carbon->englishMonth;

                return [
                    'tahun_bulan' => $tahun_bulan,
                    'tahun_bulan_format' => $bulan_text.' '.$carbon->year
                ];
            });

        return collect($rawTanggal)->sortByDesc('tahun_bulan')->values()->all();
    }

    public function getBulanLalu($tahun_bulan) {
        $carbon = Carbon::parse($tahun_bulan);
        $bulanLalu = $carbon->subMonth();
        return $bulanLalu->year.'-'.str_pad($bulanLalu->month, 2, '0', STR_PAD_LEFT);
    }

    public function getLabaRugi($tahun_bulan) {
        $transaksi = Transaksi::where('tanggal', 'like', "%$tahun_bulan%")->where('jenis', 'penjualan')->get();

        $penjualan = ($transaksi->isNotEmpty()) ? $transaksi->sum('total') : 0 ;
        $potongan_penjualan = ($transaksi->isNotEmpty()) ? $transaksi->sum('diskon') : 0 ;
        $penjualan = $penjualan + $potongan_penjualan;
        $penjualan_bersih = $penjualan - $potongan_penjualan;
        $hpp = ($transaksi->isNotEmpty()) ? $transaksi->sum('total_hpp') : 0 ;
        $laba_kotor = $penjualan_bersih - $hpp;

        $utilitas = Kas::where('kategori_id', 1)->where('tanggal', 'like', "%$tahun_bulan%")->where('jenis', 'pengeluaran')->get();
        $beban_utilitas = ($utilitas->isNotEmpty()) ? $utilitas->sum('total') : 0;

        $iklan = Kas::where('kategori_id', 2)->where('tanggal', 'like', "%$tahun_bulan%")->where('jenis', 'pengeluaran')->get();
        $beban_iklan = ($iklan->isNotEmpty()) ? $iklan->sum('total') : 0;

        $sewa = Kas::where('kategori_id', 3)->where('tanggal', 'like', "%$tahun_bulan%")->where('jenis', 'pengeluaran')->get();
        $beban_sewa = ($sewa->isNotEmpty()) ? $sewa->sum('total') : 0;

        $pemeliharaan = Kas::where('kategori_id', 4)->where('tanggal', 'like', "%$tahun_bulan%")->where('jenis', 'pengeluaran')->get();
        $beban_pemeliharaan = ($pemeliharaan->isNotEmpty()) ? $pemeliharaan->sum('total') : 0;

        $gaji = Kas::where('kategori_id', 5)->where('tanggal', 'like', "%$tahun_bulan%")->where('jenis', 'pengeluaran')->get();
        $beban_gaji = ($gaji->isNotEmpty()) ? $gaji->sum('total') : 0;

        $perlengkapan = Kas::where('kategori_id', 6)->where('tanggal', 'like', "%$tahun_bulan%")->where('jenis', 'pengeluaran')->get();
        $beban_perlengkapan = ($perlengkapan->isNotEmpty()) ? $perlengkapan->sum('total') : 0;

        $laba_bersih = $laba_kotor - ($beban_utilitas + $beban_iklan + $beban_sewa + $beban_pemeliharaan + $beban_gaji + $beban_perlengkapan);

        $data = [
            'penjualan' => $penjualan,
            'potongan_penjualan' => $potongan_penjualan,
            'penjualan_bersih' => $penjualan_bersih,
            'hpp' => $hpp,
            'laba_kotor' => $laba_kotor,
            'beban_utilitas' => $beban_utilitas,
            'beban_iklan' => $beban_iklan,
            'beban_sewa' => $beban_sewa,
            'beban_pemeliharaan' => $beban_pemeliharaan,
            'beban_gaji' => $beban_gaji,
            'beban_perlengkapan' => $beban_perlengkapan,
            'laba_bersih' => $laba_bersih
        ];

        return $data;
    }

    private function labaDitahanAwal($tahun_bulan) {
        $labaawal = 0;
        $tanggal = $this->colllectRangeTanggal($tahun_bulan);

        foreach ($tanggal as $t) {
            $labarugi = $this->getLabaRugi($t);
            $labaawal += $labarugi['laba_bersih'];
        }

        return [
            'laba_bersih' => $labaawal
        ];
    }

    public function getPerubahanEkuitas($tahun_bulan) {
        $tanggal = $tahun_bulan;
        $labarugisekarang = $this->getLabaRugi($tanggal);

        $tanggal_lalu = $this->getBulanLalu($tanggal);
        // $labarugilalu = $this->getLabaRugi($tanggal_lalu);
        $labarugilalu = $this->labaDitahanAwal($tanggal_lalu);

        $labarugitersedia = $labarugilalu['laba_bersih'] + $labarugisekarang['laba_bersih'];

        $prive = Kas::where('kategori_id', 7)->where('tanggal', 'like', "%$tahun_bulan%")->where('jenis', 'pengeluaran')->get();
        $beban_prive = ($prive->isNotEmpty()) ? $prive->sum('total') : 0;

        $labaakhir = $labarugitersedia - $beban_prive;

        $data = [
            'laba_rugi_lalu' => $labarugilalu['laba_bersih'],
            'laba_rugi_sekarang' => $labarugisekarang['laba_bersih'],
            'laba_rugi_tersedia' => $labarugitersedia,
            'prive' => $beban_prive,
            'laba_rugi_akhir' => $labaakhir
        ];

        return $data;
    }

    public function getNeraca($tahun_bulan) {
        $labaakhir = $this->getPerubahanEkuitas($tahun_bulan);
        // $transaksi = Transaksi::where('tanggal', 'like', "%$tahun_bulan%")->where('jenis', 'pembelian')->get();

        $kas = $this->getKas($tahun_bulan);
        // $pembelian = ($transaksi->isNotEmpty()) ? $transaksi->sum('total') : 0 ;

        // $tr_asset = Keuangan::where('tanggal', 'like', "%$tahun_bulan%")->where('keterangan', 'asset')->get();
        // $asset = ($tr_asset->isNotEmpty()) ? $tr_asset->sum('total') : 0 ;
        $persediaan = $this->hitungPersediaan($tahun_bulan);
        $asset = $this->hitungAsset($tahun_bulan);

        // $aktiva = $kas + $pembelian + $asset;
        $aktiva = $kas + $persediaan + $asset;

        $modal = $this->hitungModal($tahun_bulan);
        $laba_rugi_akhir = $labaakhir['laba_rugi_akhir'];
        $pasiva = $modal + $laba_rugi_akhir;

        $data = [
            'kas' => $kas,
            // 'pembelian' => $pembelian,
            'persediaan' => $persediaan,
            'asset' => $asset,
            'aktiva' => $aktiva,
            'modal' => $modal,
            'laba_rugi_akhir' => $laba_rugi_akhir,
            'pasiva' => $pasiva
        ];

        return $data;
    }

    public function hitungModal($tahun_bulan) {
        $infoModal = InfoModal::first();
        $bulanLalu = $this->getBulanLalu($tahun_bulan);

        // if ($check = Keuangan::where('tanggal', 'like', "%$bulanLalu%")->first()) {
        //     $modal = $this->getPerubahanEkuitas($bulanLalu);
        //     return $modal['laba_rugi_akhir'];
        // }
        // else {
        //     return $infoModal->modal;
        // }
        return $infoModal->modal;
    }

    private function hitungPersediaan($tahun_bulan) {
        $tanggal = $this->colllectRangeTanggal($tahun_bulan);
        $pembelian = Transaksi::where('jenis', 'pembelian')->where(function($q) use ($tanggal) {
            foreach ($tanggal as $d) {
                $q->orWhere('tanggal', 'like', "%$d%");
            }
        })->sum('total_hpp');

        $penjualan = Transaksi::where('jenis', 'penjualan')->where(function($q) use ($tanggal) {
            foreach ($tanggal as $d) {
                $q->orWhere('tanggal', 'like', "%$d%");
            }
        })->sum('total_hpp');

        return $pembelian - $penjualan;
    }

    private function hitungAsset($tahun_bulan) {
        $tanggal = $this->colllectRangeTanggal($tahun_bulan);
        $tr_asset = Keuangan::where('keterangan', 'asset')->where(function($q) use ($tanggal) {
            foreach ($tanggal as $d) {
                $q->orWhere('tanggal', 'like', "%$d%");
            }
        });

        return $tr_asset->sum('total');
    }

    private function colllectRangeTanggal($tahun_bulan) {
        $allTanggal = $this->collectTanggal();
        $indexSearch = array_search($tahun_bulan, array_column($allTanggal, 'tahun_bulan'));
        $newTanggal = [];

        if (is_numeric($indexSearch)) {
            for ($i = $indexSearch; $i < count($allTanggal) ; $i++) { 
                array_push($newTanggal, $allTanggal[$i]['tahun_bulan']);
            }
    
        }
        else {
            array_push($newTanggal, $tahun_bulan);
        }

        return $newTanggal;
    }

    private function processSum($jenis, array $data) {
        $keuangan = Keuangan::where('jenis', $jenis)->where(function($q) use ($data) {
            foreach ($data as $d) {
                $q->orWhere('tanggal', 'like', "%$d%");
            }
        });

        return $keuangan->sum('total');
    }

    private function sumKas($tahun_bulan) {
        $tanggal = $this->colllectRangeTanggal($tahun_bulan);
        $masuk = $this->processSum('masuk', $tanggal);
        $keluar = $this->processSum('keluar', $tanggal);
        return $masuk - $keluar;
    }

    public function getKas($tahun_bulan) {
        return $this->sumKas($tahun_bulan);
    }
}