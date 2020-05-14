<?php

namespace App\Http\Controllers\Dashboard\Kas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaksi\Asset as ModelData;
use App\Models\Master\AssetKategori;

class Asset extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }

    public function index(Request $req) {
        $asset = ModelData::select('tr_asset.*', 'm_asset_kategori.id as k_id', 'm_asset_kategori.nama as k_nama')
        ->when($req->filled('search'), function($q) use ($req) {
            $q  
                ->orWhereHas('kategori', function($d) use ($req) {
                    $d->where('nama', 'like', '%'.$req->search.'%');
                })
                ->orWhere('id', 'like', '%'.$req->search.'%')
                ->orWhere('nama', 'like', '%'.$req->search.'%')
                ->orWhere('tanggal', 'like', '%'.$req->search.'%')
                ->orWhere('harga_beli', 'like', '%'.$req->search.'%');
        })
        ->with('kategori')
        ->join('m_asset_kategori', 'm_asset_kategori.id', '=', 'tr_asset.kategori_id')
        ->when($req->filled('order_column'), function($q) use ($req) {
            $column = $req->order_column;
            if ($column == 'kategori') $column = 'm_asset_kategori.nama';
            $q->orderBy($column, $req->order);
        }, function($q) {
            $q->orderBy('tanggal', 'desc');
        })
        ->paginate(10);
        return view('dashboard.pages.kas.asset.index', compact('asset'));
    }

    public function create(Request $req) {
        if ($req->isMethod('get')) {
            $kategori = AssetKategori::get();
            return view('dashboard.pages.kas.asset.create', compact('kategori'));
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }
        
        $req->merge(['harga_beli' => str_replace(',','',$req->harga_beli)]);
        $asset = ModelData::create($req->except('_token'));
        return response("1");
    }

    public function update(Request $req) {
        $asset = ModelData::find($req->id);

        if ($req->isMethod('get')) {
            $kategori = AssetKategori::get();
            return view('dashboard.pages.kas.asset.edit', compact('asset', 'kategori'));
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }

        $req->merge(['harga_beli' => str_replace(',','',$req->harga_beli)]);
        $asset->update($req->except('_token'));
        return response("1");
    }

    public function delete(Request $req) {
        $asset = ModelData::find($req->id);
        $asset->delete();
        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }
}