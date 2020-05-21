<?php

namespace App\Http\Controllers\Dashboard\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Laporan extends Controller {

    private $service;

    public function __construct() {
        $this->middleware('ajax');
        $this->service = new LaporanService();
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

    }
}