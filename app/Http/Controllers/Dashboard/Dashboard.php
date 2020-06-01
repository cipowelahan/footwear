<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InfoModal;
use App\Models\User;
use App\Models\Transaksi\Kas;
use DB, Hash;

class Dashboard extends Controller {

    public function __construct() {
        $this->middleware('ajax')->only([
            'main', 'error'
        ]);
    }
    
    public function index() {
        if (InfoModal::first()) return view('dashboard.pages.dashboard');
        return redirect()->route('dashboard.modal');
    }

    public function modal(Request $req) {
        if ($req->isMethod('get')) {
            if (InfoModal::first()) return redirect()->route('dashboard');
            return view('dashboard.pages.modal');
        }

        $this->validate(request(), [
            'modal' => 'required',
            'tanggal' => 'required|date'
        ], [
            'modal.required' => 'Modal Dibutuhkan',
            'tanggal.required' => 'Tanggal Dibutuhkan',
            'tanggal.date' => 'Gunakan Format Tanggal Y-M-D',
        ]);

        $req->merge(['modal' => str_replace(',','',$req->modal)]);
        
        InfoModal::create([
            'modal' => $req->modal, 
            'kas' => '0'
        ]);

        Kas::create([
            'tanggal' => $req->tanggal,
            'kategori_id' => 8,
            'jenis' => 'pemasukan',
            'nama' => 'Modal Awal',
            'total' => $req->modal
        ]);
        
        return redirect()->route('dashboard');
    }

    public function main() {
        $info = InfoModal::first();
        return view('dashboard.pages.main', compact('info'));
    }

    public function error(Request $req) {
        return view('dashboard.pages.error', [
            'title' => $req->title,
            'messages' => $req->messages
        ]);
    }

    public function register(Request $req) {
        if (request()->isMethod('get')) {
            return view('auth.register');
        }

        $this->validate(request(), [
            'nama' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:1',
            'kontak' => 'required',
            'nama_perusahaan' => 'required',
            'kelamin' => 'required',
        ]);
        $user = $req->all();
        $user['password'] = Hash::make($user['password']);
        $user['role_id'] = 3;
        User::create($user);
        return redirect()->route('login')->with('must-login', 'silahkan login');
    }

    public function login(Request $req) {
        if (request()->isMethod('get')) {
            return view('auth.login');
        }
        
        $this->validate(request(), [
            'username' => 'required',
            'password' => 'required|min:1'
        ]);

        $credential = [
            'username' => $req->username,
            'password' => $req->password
        ];

        if (Auth::attempt($credential)) {
            return redirect()->route('dashboard');
        }
        else {
            return back()->with('must-login', 'hak akses tidak diterima');
        }
    }

    public function logout(Request $req) {
        Auth::logout();
        return redirect()->route('login');
    }

    public function resetData() {
        $tables = [
            'info_modal', 'tr_keuangan', 'tr_transaksi',
            'tr_kas', 'tr_asset', 
            // 'm_produk', 'm_supplier'
        ];

        foreach ($tables as $table) {
            DB::table($table)->delete();
            DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1");
        }

        DB::table('m_produk')->update(['stok' => 0]);

        // $ignore = ['.', '..', '.gitignore'];
        // $publicImages = scandir(public_path('images'));

        // foreach ($ignore as $i) {
        //     if (($key = array_search($i, $publicImages)) !== false) {
        //         unset($publicImages[$key]);
        //     }
        // }

        // foreach ($publicImages as $img_dir) {
        //     $this->delete_files(public_path('images/'.$img_dir));
        // }

        return redirect()->route('dashboard');
    }

    private function delete_files($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                $this->delete_files( $file );      
            }

            @rmdir( $target );
        } elseif(is_file($target)) {
            @unlink( $target );  
        }
    }
}