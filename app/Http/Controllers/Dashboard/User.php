<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User as ModelData;
use App\Models\Role;
use Hash;

class User extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }

    public function index(Request $req) {
        $user = ModelData::with('role')->when($req->filled('search'), function($q) use ($req) {
            $q
                ->orWhereHas('role', function($d) use ($req) {
                    $d->where('nama', 'like', '%'.$req->search.'%');
                })
                ->orWhere('id', 'like', '%'.$req->search.'%')
                ->orWhere('nama', 'like', '%'.$req->search.'%')
                ->orWhere('email', 'like', '%'.$req->search.'%')
                ->orWhere('nama_perusahaan', 'like', '%'.$req->search.'%')
                ->orWhere('kontak', 'like', '%'.$req->search.'%');
        })->paginate(10);
        return view('dashboard.pages.user.index', compact('user'));
    }

    public function indexRole() {
        $role = Role::get();
        return view('dashboard.pages.user.index-role', compact('role'));
    }

    public function create(Request $req) {
        if ($req->isMethod('get')) {
            $role = Role::get();
            return view('dashboard.pages.user.create', compact('role'));
        }

        $validation = Validator::make($req->all(), array_merge(ModelData::getRules(), [
            'password' => 'required|min:1'
        ]), array_merge(ModelData::getMessages(), [
            'password.required' => 'Password Dibutuhkan'
        ]));
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }
        
        $req->merge(['password' => Hash::make($req->password)]);

        $user = ModelData::create($req->except('_token'));
        return response("1");
    }

    public function update(Request $req) {
        $user = ModelData::find($req->id);

        if ($req->isMethod('get')) {
            $role = Role::get();
            return view('dashboard.pages.user.edit', compact('user', 'role'));
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
        $user->karyawan()->delete();
        $user->loker()->delete();
        $user->delete();

        if ($req->id == auth()->id()) {
            auth()->logout();
        }

        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }
}