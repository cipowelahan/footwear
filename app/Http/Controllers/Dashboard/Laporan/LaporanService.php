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

    public function getPerubahanEkuitas($tahun_bulan) {
        $tanggal = $tahun_bulan;
        $labarugisekarang = $this->getLabaRugi($tanggal);

        $tanggal_lalu = $this->getBulanLalu($tanggal);
        $labarugilalu = $this->getLabaRugi($tanggal_lalu);

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
        $infoModal = InfoModal::first();
    }
}