<?php

namespace App\Http\Controllers\Dashboard\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi\Keuangan;
use Carbon\Carbon;

class Laporan extends Controller {

    private $service;

    public function __construct() {
        $this->middleware('ajax');
        $this->service = new LaporanService();
    }

    public function bukubesar(Request $req) {
        $carbon = Carbon::now();
        $bulan = str_pad($carbon->month, 2, '0', STR_PAD_LEFT);

        $mulai = $carbon->year.'-'.$bulan.'-01';
        $selesai = $carbon->year.'-'.$bulan.'-'.str_pad($carbon->daysInMonth, 2, '0', STR_PAD_LEFT);

        $keuangan = Keuangan::when($req->filled('tanggal_mulai'), function($q) use ($req) {
            $q->where('tanggal', '>=', $req->tanggal_mulai);
        }, function($q) use ($mulai) {
            $q->where('tanggal', '>=', $mulai);
        })
        ->when($req->filled('tanggal_selesai'), function($q) use ($req) {
            $q->where('tanggal', '<=', $req->tanggal_selesai);
        }, function($q) use ($selesai) {
            $q->where('tanggal', '<=', $selesai);
        })
        ->orderBy('id', 'asc')
        ->get();
        return view('dashboard.pages.laporan.buku-besar', compact('keuangan', 'mulai', 'selesai'));
    }

    public function labarugi(Request $req) {
        if ($req->isMethod('get')) {
            $tanggal = $this->service->collectTanggal();
            $labarugi = $this->service->getLabaRugi($tanggal[0]['tahun_bulan']);
            return view('dashboard.pages.laporan.laba-rugi', compact('tanggal', 'labarugi'));
        }

        $labarugi = $this->service->getLabaRugi($req->tanggal);
        return response()->json($labarugi);
    }

    public function perubahanekuitas(Request $req) {
        if ($req->isMethod('get')) {
            $tanggal = $this->service->collectTanggal();
            $perubahanekuitas = $this->service->getPerubahanEkuitas($tanggal[0]['tahun_bulan']);
            return view('dashboard.pages.laporan.perubahan-ekuitas', compact('tanggal', 'perubahanekuitas'));
        }

        $perubahanekuitas = $this->service->getPerubahanEkuitas($req->tanggal);
        return response()->json($perubahanekuitas);
    }

    public function neraca(Request $req) {
        if ($req->isMethod('get')) {
            $tanggal = $this->service->collectTanggal();
            $neraca = $this->service->getNeraca($tanggal[0]['tahun_bulan']);
            return view('dashboard.pages.laporan.neraca', compact('tanggal', 'neraca'));
        }

        $neraca = $this->service->getNeraca($req->tanggal);
        return response()->json($neraca);
    }

    public function persediaan(Request $req) {
        if ($req->isMethod('get')) {
            $tanggal = $this->service->collectTanggal();
            $produk = $this->service->getPersediaan($tanggal[0]['tahun_bulan']);
            return view('dashboard.pages.laporan.persediaan', compact('tanggal', 'produk'));
        }

        $produk = $this->service->getPersediaan($req->tanggal);
        return response()->json($produk);
    }

    public function pembelian(Request $req) {
        if ($req->isMethod('get')) {
            $tanggal = $this->service->collectTanggal();
            $produk = $this->service->getTransaksi('pembelian', $tanggal[0]['tahun_bulan']);
            $jumlah = $produk->sum('sum_jumlah');
            $harga = $produk->sum('sum_total');
            return view('dashboard.pages.laporan.pembelian', compact('tanggal', 'produk', 'jumlah', 'harga'));
        }

        $produk = $this->service->getTransaksi('pembelian', $req->tanggal);
        $jumlah = $produk->sum('sum_jumlah');
        $harga = $produk->sum('sum_total');
        return response()->json([
            'produk' => $produk,
            'jumlah' => $jumlah,
            'harga' => $harga
        ]);
    }

    public function penjualan(Request $req) {
        if ($req->isMethod('get')) {
            $tanggal = $this->service->collectTanggal();
            $produk = $this->service->getTransaksi('penjualan', $tanggal[0]['tahun_bulan']);
            $jumlah = $produk->sum('sum_jumlah');
            $harga = $produk->sum('sum_total');
            return view('dashboard.pages.laporan.penjualan', compact('tanggal', 'produk', 'jumlah', 'harga'));
        }

        $produk = $this->service->getTransaksi('penjualan', $req->tanggal);
        $jumlah = $produk->sum('sum_jumlah');
        $harga = $produk->sum('sum_total');
        return response()->json([
            'produk' => $produk,
            'jumlah' => $jumlah,
            'harga' => $harga
        ]);
    }
}