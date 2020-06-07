<?php

namespace App\Http\Controllers\Dashboard\Laporan;

use App\Http\Controllers\Controller;
use PDF;

class CetakLaporan extends Controller {

    private $service;
    
    private $bulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];

    public function __construct() {
        $this->service = new LaporanService();
    }

    private function getTanggal($tanggal) {
        $splitTanggal = explode('-', $tanggal);
        return $this->bulan[$splitTanggal[1]].' '.$splitTanggal[0];
    }

    public function labarugi($tanggal) {
        $labarugi = $this->service->getLabaRugi($tanggal);
        $labarugi['tanggal'] = $this->getTanggal($tanggal);
        $pdf = PDF::loadView('dashboard.pages.laporan.pdf.laba-rugi', $labarugi);
        return $pdf->stream('Laba Rugi '.$tanggal.'.pdf');
    }

    public function perubahanekuitas($tanggal) {
        $perubahanekuitas = $this->service->getPerubahanEkuitas($tanggal);
        $perubahanekuitas['tanggal'] = $this->getTanggal($tanggal);
        $pdf = PDF::loadView('dashboard.pages.laporan.pdf.perubahan-ekuitas', $perubahanekuitas);
        return $pdf->stream('Perubahan Ekuitas '.$tanggal.'.pdf');
    }

    public function neraca($tanggal) {
        $neraca = $this->service->getNeraca($tanggal);
        $neraca['tanggal'] = $this->getTanggal($tanggal);
        $pdf = PDF::loadView('dashboard.pages.laporan.pdf.neraca', $neraca);
        return $pdf->stream('Neraca '.$tanggal.'.pdf');
    }

    public function persediaan($tanggal) {
        $persediaan['persediaan'] = $this->service->getPersediaan($tanggal);
        $persediaan['tanggal'] = $this->getTanggal($tanggal);
        $pdf = PDF::loadView('dashboard.pages.laporan.pdf.persediaan', $persediaan);
        return $pdf->stream('Persediaan '.$tanggal.'.pdf');
    }

    public function pembelian($tanggal) {
        $pembelian['pembelian'] = $this->service->getTransaksi('pembelian', $tanggal);
        $pembelian['tanggal'] = $this->getTanggal($tanggal);
        $pembelian['jumlah'] = $pembelian['pembelian']->sum('sum_jumlah');
        $pembelian['harga'] = $pembelian['pembelian']->sum('sum_total');
        $pdf = PDF::loadView('dashboard.pages.laporan.pdf.pembelian', $pembelian);
        return $pdf->stream('Pembelian '.$tanggal.'.pdf');
    }

    public function penjualan($tanggal) {
        $penjualan['penjualan'] = $this->service->getTransaksi('penjualan', $tanggal);
        $penjualan['tanggal'] = $this->getTanggal($tanggal);
        $penjualan['jumlah'] = $penjualan['penjualan']->sum('sum_jumlah');
        $penjualan['harga'] = $penjualan['penjualan']->sum('sum_total');
        $pdf = PDF::loadView('dashboard.pages.laporan.pdf.penjualan', $penjualan);
        return $pdf->stream('Penjualan '.$tanggal.'.pdf');
    }
}