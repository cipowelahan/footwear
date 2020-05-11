<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuTamu;
use App\Models\Pengaduan;

class Kontak extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }

    public function indexBukuTamu(Request $req) {
        $bukutamu = BukuTamu::when($req->filled('search'), function($q) use ($req) {
            $q
                ->orWhere('nama', 'like', '%'.$req->search.'%')
                ->orWhere('email', 'like', '%'.$req->search.'%')
                ->orWhere('phone', 'like', '%'.$req->search.'%')
                ->orWhere('pesan', 'like', '%'.$req->search.'%');
        })->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.pages.kontak.index-bukutamu', compact('bukutamu'));
    }

    public function deleteBukuTamu(Request $req) {
        $bukutamu = BukuTamu::find($req->id);
        $bukutamu->delete();
        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }

    public function indexPengaduan(Request $req) {
        $pengaduan = Pengaduan::when($req->filled('search'), function($q) use ($req) {
            $q
                ->orWhere('nama', 'like', '%'.$req->search.'%')
                ->orWhere('email', 'like', '%'.$req->search.'%')
                ->orWhere('phone', 'like', '%'.$req->search.'%')
                ->orWhere('pesan', 'like', '%'.$req->search.'%');
        })->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.pages.kontak.index-pengaduan', compact('pengaduan'));
    }

    public function updateStatusPengaduan(Request $req) {
        $pengaduan = Pengaduan::find($req->id);
        $pengaduan->update(['status' => $req->status]);
        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }

    public function deletePengaduan(Request $req) {
        $pengaduan = Pengaduan::find($req->id);
        if ($pengaduan->gambar) unlink(public_path()."/$pengaduan->gambar");
        $pengaduan->delete();
        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }
}