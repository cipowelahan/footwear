<?php

namespace App\Http\Controllers\Dashboard\Laporan;

use App\Models\InfoModal;
use App\Models\Master\Produk;
use App\Models\Transaksi\Kas;
use App\Models\Transaksi\Keuangan;
use App\Models\Transaksi\Transaksi;
use App\Models\Transaksi\TransaksiProduk;
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

            $prive = Kas::where('kategori_id', 7)->where('tanggal', 'like', "%$t%")->where('jenis', 'pengeluaran')->get();
            $beban_prive = ($prive->isNotEmpty()) ? $prive->sum('total') : 0;
            $labaawal -= $beban_prive;
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

    private function hitungStokProduk($produk, array $tanggal) {
        $pembelian = TransaksiProduk::where('produk_id', $produk->id)->whereHas('transaksi', function($q) use ($tanggal) {
            $q->where('jenis', 'pembelian')->where(function($qb) use ($tanggal) {
                foreach ($tanggal as $d) {
                    $qb->orWhere('tanggal', 'like', "%$d%");
                }
            });
        })->sum('jumlah');

        $penjualan = TransaksiProduk::where('produk_id', $produk->id)->whereHas('transaksi', function($q) use ($tanggal) {
            $q->where('jenis', 'penjualan')->where(function($qb) use ($tanggal) {
                foreach ($tanggal as $d) {
                    $qb->orWhere('tanggal', 'like', "%$d%");
                }
            });
        })->sum('jumlah');

        $selisih = $pembelian - $penjualan;
        return $selisih;
    }

    public function getPersediaan($tahun_bulan) {
        $produk = Produk::with('kategori')->get();
        $tanggal = $this->colllectRangeTanggal($tahun_bulan);

        $produk->map(function($item) use ($tanggal) {
            $item->stok = $this->hitungStokProduk($item, $tanggal);
            $item->total = number_format($item->stok * $item->harga_beli);
            return $item;
        });

        return $produk;
    }

    public function getTotalDiskon($tahun_bulan) {
        $diskon = Transaksi::where('jenis', 'penjualan')->where('tanggal', 'like', "%$tahun_bulan%")->sum('diskon');
        return $diskon;
    }

    public function getTransaksi($jenis, $tahun_bulan) {
        $uniqueKodeNama = TransaksiProduk::selectRaw("distinct kode_produk, nama_produk")->orderBy('kode_produk', 'asc')->get();
        $tanggal = $tahun_bulan;

        $uniqueKodeNama->map(function($item) use ($tanggal, $jenis) {
            $transaksi = TransaksiProduk::with('transaksi')
            ->where('kode_produk', $item->kode_produk)->where('nama_produk', $item->nama_produk)
            ->whereHas('transaksi', function($q) use ($tanggal, $jenis) {
                $q->where('jenis', $jenis)->where('tanggal', 'like', "%$tanggal%");
            })->get();

            $list_transaksi = [];
            foreach ($transaksi as $tr) {
                
                $raw_tr = (object) [
                    'id' => $tr->transaksi->id,
                    'tanggal' => $tr->transaksi->tanggal,
                    'user' => $tr->transaksi->user,
                    'harga' => number_format($tr->harga),
                    'jumlah' => $tr->jumlah,
                    'total' => $tr->total,
                    'total_format' => number_format($tr->total)
                ];
                array_push($list_transaksi, $raw_tr);
            }

            $item->list_transaksi = $list_transaksi;
            $item->sum_jumlah = $transaksi->sum('jumlah');
            $item->sum_total = $transaksi->sum('total');
            $item->sum_total_format = number_format($item->sum_total);
            return $item;

        });

        return $uniqueKodeNama;
    }

    private function rand_color() {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public function getConvertChart($data) {
        $filterData = $data->filter(function($item, $key) {
            return $item->sum_jumlah > 0;
        })->all();

        $labels = [];
        $datas = [];
        $colors = [];

        foreach ($filterData as $v) {
            array_push($labels, "($v->kode_produk) $v->nama_produk");
            array_push($datas, $v->sum_jumlah);
            array_push($colors, $this->rand_color());
        }

        return [
            'labels' => $labels,
            'datas' => $datas,
            'colors' => $colors
        ];
    }
}