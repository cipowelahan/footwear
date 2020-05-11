<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Karyawan as ModelData;

class Karyawan extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }

    public function index(Request $req) {
        $karyawan = ModelData::when($req->filled('search'), function($q) use ($req) {
            $q
                ->orWhereHas('user', function($d) use ($req) {
                    $d->where('nama', 'like', '%'.$req->search.'%');
                })
                ->orWhere('id', 'like', '%'.$req->search.'%')
                ->orWhere('nama', 'like', '%'.$req->search.'%')
                ->orWhere('jabatan', 'like', '%'.$req->search.'%')
                ->orWhere('posisi', 'like', '%'.$req->search.'%')
                ->orWhere('kontak', 'like', '%'.$req->search.'%');
        })->when(auth()->user()->role_id != 1, function($q) {
            $q->where('user_id', auth()->id());
        })->with('user')->paginate(10);
        return view('dashboard.pages.karyawan.index', compact('karyawan'));
    }

    public function create(Request $req) {
        if ($req->isMethod('get')) {
            return view('dashboard.pages.karyawan.create');
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }
        
        $req->merge(['user_id' => auth()->id()]);
        $karyawan = ModelData::create($req->except('_token'));
        return response("1");
    }

    public function update(Request $req) {
        $karyawan = ModelData::find($req->id);

        if ($req->isMethod('get')) {
            return view('dashboard.pages.karyawan.edit', compact('karyawan'));
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }

        $karyawan->update($req->except('_token'));
        return response("1");
    }

    public function delete(Request $req) {
        $karyawan = ModelData::find($req->id);
        $karyawan->delete();
        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }
}