<?php

namespace App\Http\Controllers\Dashboard\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Produk as ModelData;
use App\Models\Master\ProdukKategori;
use File, DB, Exception;

class Produk extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }

    private function beforeSave($req, $imageUrl = null) {
        if ($req->hasFile('foto')) {
            $file = $req->file('foto');
            $extension = $file->getClientOriginalExtension(); 
            $fileName = time().'.'.$extension;
            $path = public_path().'/images/produk';
            $upload = $file->move($path,$fileName);
            $foto = "images/produk/$fileName";
            if ($imageUrl) $lastImage = $imageUrl;
        }
        else {
            $foto = $imageUrl ?? 'assets/image/no-image.png';
        }

        $data = $req->except('_token');
        $data['foto'] = $foto;

        if (isset($lastImage)) $data['lastImage'] = $lastImage;

        return $data;
    }

    public function index(Request $req) {
        $produk = ModelData::select('m_produk.*', 'm_produk_kategori.id as k_id', 'm_produk_kategori.nama as k_nama')
        ->when($req->filled('search'), function($q) use ($req) {
            $q  
                ->orWhereHas('kategori', function($d) use ($req) {
                    $d->where('nama', 'like', '%'.$req->search.'%');
                })
                ->orWhere('id', 'like', '%'.$req->search.'%')
                ->orWhere('kode', 'like', '%'.$req->search.'%')
                ->orWhere('nama', 'like', '%'.$req->search.'%')
                ->orWhere('merk', 'like', '%'.$req->search.'%')
                ->orWhere('stok', 'like', '%'.$req->search.'%')
                ->orWhere('harga_beli', 'like', '%'.$req->search.'%')
                ->orWhere('harga_jual', 'like', '%'.$req->search.'%');
        })
        ->with('kategori')
        ->join('m_produk_kategori', 'm_produk_kategori.id', '=', 'm_produk.kategori_id')
        ->when($req->filled('order_column'), function($q) use ($req) {
            $column = $req->order_column;
            if ($column == 'kategori') $column = 'm_produk_kategori.nama';
            $q->orderBy($column, $req->order);
        })
        ->paginate(10);
        return view('dashboard.pages.master.produk.index', compact('produk'));
    }

    public function create(Request $req) {
        if ($req->isMethod('get')) {
            $kategori = ProdukKategori::get();
            return view('dashboard.pages.master.produk.create', compact('kategori'));
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }
        
        $req->merge([
            'harga_beli' => str_replace(',','',$req->harga_beli),
            'harga_jual' => str_replace(',','',$req->harga_jual)
        ]);

        try {
            DB::beginTransaction();
            $data = $this->beforeSave($req);
            $produk = ModelData::create($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $response = $e->getMessage();
        }
        
        return response($response ?? "1");
    }

    public function update(Request $req) {
        $produk = ModelData::find($req->id);

        if ($req->isMethod('get')) {
            $kategori = ProdukKategori::get();
            return view('dashboard.pages.master.produk.edit', compact('produk', 'kategori'));
        }

        $validation = Validator::make($req->all(), ModelData::getRules($produk->id), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }

        $req->merge([
            'harga_beli' => str_replace(',','',$req->harga_beli),
            'harga_jual' => str_replace(',','',$req->harga_jual)
        ]);
        
        try {
            DB::beginTransaction();
            $data = $this->beforeSave($req, $produk->foto);
            
            if (isset($data['lastImage'])) {
                if (strpos('assets', $data['lastImage']) !== false) @unlink(public_path().'/'.$data['lastImage']);
                unset($data['lastImage']);
            }
            
            $produk->update($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $response = $e->getMessage();
        }
        
        return response($response ?? "1");
    }

    public function delete(Request $req) {
        $produk = ModelData::find($req->id);
        $produk->delete();
        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }

    public function api(Request $req) {
        $produk = ModelData::when($req->filled('search'), function($q) use ($req) {
            $q 
                ->orWhere('kode', 'like', '%'.$req->search.'%')
                ->orWhere('nama', 'like', '%'.$req->search.'%');
        })
        ->when($req->filled('exclude'), function($q) use ($req) {
            $exclude = explode(',', $req->exclude);
            $q->whereNotIn('id', $exclude);
        })
        ->with('kategori')
        ->orderBy('nama', 'asc')
        ->paginate(10);
        return response()->json($produk);
    }
}