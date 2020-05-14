<?php

namespace App\Http\Controllers\Dashboard\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\AssetKategori as ModelData;

class AssetKategori extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }

    public function index(Request $req) {
        $assetkategori = ModelData::when($req->filled('search'), function($q) use ($req) {
            $q
                ->orWhere('id', 'like', '%'.$req->search.'%')
                ->orWhere('nama', 'like', '%'.$req->search.'%');
        })
        ->when($req->filled('order_column'), function($q) use ($req) {
            $q->orderBy($req->order_column, $req->order);
        })
        ->paginate(10);
        return view('dashboard.pages.master.assetkategori.index', compact('assetkategori'));
    }

    public function create(Request $req) {
        if ($req->isMethod('get')) {
            return view('dashboard.pages.master.assetkategori.create');
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }
        
        $assetkategori = ModelData::create($req->except('_token'));
        return response("1");
    }

    public function update(Request $req) {
        $assetkategori = ModelData::find($req->id);

        if ($req->isMethod('get')) {
            return view('dashboard.pages.master.assetkategori.edit', compact('assetkategori'));
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }

        $assetkategori->update($req->except('_token'));
        return response("1");
    }

    public function delete(Request $req) {
        $assetkategori = ModelData::find($req->id);
        $assetkategori->delete();
        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }
}