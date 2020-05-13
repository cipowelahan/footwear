<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use File, DB, Exception, Hash;

class Profil extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }

    private function beforeSave($req, $imageUrl = null) {
        if ($req->hasFile('foto')) {
            $file = $req->file('foto');
            $extension = $file->getClientOriginalExtension(); 
            $fileName = time().'.'.$extension;
            $path = public_path().'/images/profil';
            $upload = $file->move($path,$fileName);
            $foto = "images/profil/$fileName";
            if ($imageUrl) $lastImage = $imageUrl;
        }
        else {
            $foto = $imageUrl ?? null;
        }

        $data = $req->except('_token');
        $data['foto'] = $foto;

        if (isset($lastImage)) $data['lastImage'] = $lastImage;

        return $data;
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

        try {
            DB::beginTransaction();

            $data = $this->beforeSave($req, $user->foto);

            if (isset($data['lastImage'])) {
                @unlink(public_path().'/'.$data['lastImage']);
                unset($data['lastImage']);
            }
            $user->update($data);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    
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