<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User as ModelData;
use Hash;

class User extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }

    public function index(Request $req) {
        $user = ModelData::when($req->filled('search'), function($q) use ($req) {
            $q
                ->orWhere('id', 'like', '%'.$req->search.'%')
                ->orWhere('nama', 'like', '%'.$req->search.'%')
                ->orWhere('username', 'like', '%'.$req->search.'%')
                ->orWhere('no_hp', 'like', '%'.$req->search.'%')
                ->orWhere('alamat', 'like', '%'.$req->search.'%');
        })->paginate(10);
        return view('dashboard.pages.user.index', compact('user'));
    }

    public function create(Request $req) {
        if ($req->isMethod('get')) {
            return view('dashboard.pages.user.create');
        }

        $validation = Validator::make($req->all(), array_merge(ModelData::getRules(), [
            'password' => 'required|min:1'
        ]), array_merge(ModelData::getMessages(), [
            'password.required' => 'Password Dibutuhkan'
        ]));
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }
        
        $req->merge([
            'password' => Hash::make($req->password),
            'foto' => 'assets/image/profil.jpg'
        ]);

        $user = ModelData::create($req->except('_token'));
        return response("1");
    }

    public function update(Request $req) {
        $user = ModelData::find($req->id);

        if ($req->isMethod('get')) {
            return view('dashboard.pages.user.edit', compact('user'));
        }

        $validation = Validator::make($req->all(), ModelData::getRules($user->id), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }

        $password = $req->filled('password') ? Hash::make($req->password) : $user->password;
        $req->merge(['password' => $password]);

        $user->update($req->except('_token'));
        return response("1");
    }

    public function delete(Request $req) {
        $user = ModelData::find($req->id);
        $foto = $user->foto;
        $user->delete();

        if ($req->id == auth()->id()) {
            auth()->logout();
        }

        if (strpos('assets', $foto) !== false) @unlink(public_path().'/'.$foto);

        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }
}