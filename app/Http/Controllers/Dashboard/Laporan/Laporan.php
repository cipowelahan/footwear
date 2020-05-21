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
            return view('dashboard.pages.laporan.laba-rugi', compact('tanggal'));
        }

        $labarugi = $this->service->getLabaRugi($req->tanggal);
        return response()->json($labarugi);
    }

    public function perubahanekuitas(Request $req) {
        if ($req->isMethod('get')) {
            $tanggal = $this->service->collectTanggal();
            return view('dashboard.pages.laporan.perubahan-ekuitas', compact('tanggal'));
        }

        $perubahanekuitas = $this->service->getPerubahanEkuitas($req->tanggal);
        return response()->json($perubahanekuitas);
    }

    public function neraca(Request $req) {
        if ($req->isMethod('get')) {
            $tanggal = $this->service->collectTanggal();
            return view('dashboard.pages.laporan.neraca', compact('tanggal'));
        }

        $neraca = $this->service->getNeraca($req->tanggal);
        return response()->json($neraca);
    }
}