<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;

class Dashboard extends Controller {

    public function __construct() {
        $this->middleware('ajax')->only([
            'main', 'error'
        ]);
    }
    
    public function index() {
        return view('dashboard.pages.dashboard');
    }

    public function main() {
        return view('dashboard.pages.main');
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
            'email' => 'required',
            'password' => 'required|min:1'
        ]);

        $credential = [
            'email' => $req->email,
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
}