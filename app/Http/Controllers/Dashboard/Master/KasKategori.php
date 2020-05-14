<?php

namespace App\Http\Controllers\Dashboard\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\KasKategori as ModelData;

class KasKategori extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }

    public function index(Request $req) {
        $kaskategori = ModelData::when($req->filled('search'), function($q) use ($req) {
            $q
                ->orWhere('id', 'like', '%'.$req->search.'%')
                ->orWhere('nama', 'like', '%'.$req->search.'%');
        })
        ->when($req->filled('order_column'), function($q) use ($req) {
            $q->orderBy($req->order_column, $req->order);
        })
        ->paginate(10);
        return view('dashboard.pages.master.kaskategori.index', compact('kaskategori'));
    }

    public function create(Request $req) {
        if ($req->isMethod('get')) {
            return view('dashboard.pages.master.kaskategori.create');
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }
        
        $kaskategori = ModelData::create($req->except('_token'));
        return response("1");
    }

    public function update(Request $req) {
        $kaskategori = ModelData::find($req->id);

        if ($req->isMethod('get')) {
            return view('dashboard.pages.master.kaskategori.edit', compact('kaskategori'));
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }

        $kaskategori->update($req->except('_token'));
        return response("1");
    }

    public function delete(Request $req) {
        $kaskategori = ModelData::find($req->id);
        $kaskategori->delete();
        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }
}