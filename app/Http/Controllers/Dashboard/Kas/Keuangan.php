<?php

namespace App\Http\Controllers\Dashboard\Kas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi\Keuangan as ModelData;

class Keuangan extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }

    public function index(Request $req) {
        $keuangan = ModelData::when($req->filled('search'), function($q) use ($req) {
            $q  
                ->orWhere('tanggal', 'like', '%'.$req->search.'%')
                ->orWhere('total', 'like', '%'.$req->search.'%');
        })
        ->with(['asset.kategori', 'kas.kategori', 'transaksi'])
        ->when($req->filled('keterangan'), function($q) use ($req) {
            $q->where('keterangan', $req->keterangan);
        })
        ->when($req->filled('jenis'), function($q) use ($req) {
            $q->where('jenis', $req->jenis);
        })
        ->when($req->filled('order_column'), function($q) use ($req) {
            $column = $req->order_column;
            $q->orderBy($column, $req->order);
        }, function($q) {
            $q->orderBy('tanggal', 'desc');
        })
        ->when($req->filled('tanggal_mulai'), function($q) use ($req) {
            $q->where('tanggal', '>=', $req->tanggal_mulai);
        })
        ->when($req->filled('tanggal_selesai'), function($q) use ($req) {
            $q->where('tanggal', '<=', $req->tanggal_selesai);
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('dashboard.pages.kas.keuangan.index', compact('keuangan'));
    }

}