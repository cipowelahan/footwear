<?php

namespace App\Http\Controllers\Dashboard\Kas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaksi\Kas as ModelData;
use App\Models\Master\KasKategori;

class Kas extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }

    public function index(Request $req) {
        $kas = ModelData::select('tr_kas.*', 'm_kas_kategori.id as k_id', 'm_kas_kategori.nama as k_nama')
        ->when($req->filled('search'), function($q) use ($req) {
            $q  
                ->orWhereHas('kategori', function($d) use ($req) {
                    $d->where('nama', 'like', '%'.$req->search.'%');
                })
                ->orWhere('id', 'like', '%'.$req->search.'%')
                ->orWhere('nama', 'like', '%'.$req->search.'%')
                ->orWhere('tanggal', 'like', '%'.$req->search.'%')
                ->orWhere('total', 'like', '%'.$req->search.'%');
        })
        ->with('kategori')
        ->join('m_kas_kategori', 'm_kas_kategori.id', '=', 'tr_kas.kategori_id')
        ->when($req->filled('jenis'), function($q) use ($req) {
            $q->where('jenis', $req->jenis);
        })
        ->when($req->filled('order_column'), function($q) use ($req) {
            $column = $req->order_column;
            if ($column == 'kategori') $column = 'm_kas_kategori.nama';
            $q->orderBy($column, $req->order);
        }, function($q) {
            $q->orderBy('tanggal', 'desc');
        })
        ->paginate(10);
        return view('dashboard.pages.kas.kas.index', compact('kas'));
    }

    public function create(Request $req) {
        if ($req->isMethod('get')) {
            $kategori = KasKategori::get();
            return view('dashboard.pages.kas.kas.create', compact('kategori'));
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }
        
        $req->merge(['total' => str_replace(',','',$req->total)]);
        $kas = ModelData::create($req->except('_token'));
        return response("1");
    }

    public function update(Request $req) {
        $kas = ModelData::find($req->id);

        if ($req->isMethod('get')) {
            $kategori = KasKategori::get();
            return view('dashboard.pages.kas.kas.edit', compact('kas', 'kategori'));
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }

        $req->merge(['total' => str_replace(',','',$req->total)]);
        $kas->update($req->except('_token'));
        return response("1");
    }

    public function delete(Request $req) {
        $kas = ModelData::find($req->id);
        $kas->delete();
        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }
}