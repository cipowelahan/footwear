<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Hash;

class Profil extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }
    
    public function profil(Request $req) {
        $user = Auth::user();
        if ($req->isMethod('get')) {
            return view('dashboard.pages.profil.profil', compact('user'));
        }

        $validation = Validator::make($req->all(), User::getRules($user->id), User::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }

        $user->update($req->except('_token'));

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function password(Request $req) {
        if ($req->isMethod('get')) {
            return view('dashboard.pages.profil.password');
        }

        $user = Auth::user();
        $validation = Validator::make($req->all(), [
            'old_password' => 'required|min:1',
            'password' => 'required|min:1'
        ], [
            'old_password.required' => 'Kata Sandi Lama Dibutuhkan',
            'password.required' => 'Kata Sandi Baru Dibutuhkan'
        ]);
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }

        if (Hash::check($req->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($req->password)
            ]);
            return response("1");
        }
        return response("Kata Sandi Lama Tidak Cocok");
    }
}