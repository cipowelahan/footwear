<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect()->route('dashboard');
});

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function() {
    Route::match(['get', 'post'], '/login', 'Dashboard\Dashboard@login')->name('login');
    // Route::match(['get', 'post'], '/register', 'Dashboard\Dashboard@register')->name('register');
});

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth.dashboard'], function() {
    Route::get('/', 'Dashboard\Dashboard@index')->name('dashboard');
    Route::get('/main', 'Dashboard\Dashboard@main');
    Route::post('/error', 'Dashboard\Dashboard@error');
    Route::get('/logout', 'Dashboard\Dashboard@logout')->name('logout');
    Route::match(['get', 'post'], '/modal', 'Dashboard\Dashboard@modal')->name('dashboard.modal');

    Route::group(['prefix' => 'pencarikerja'], function () {
        Route::get('/', 'Dashboard\PencariKerja@index');
        Route::match(['get', 'post'], '/create', 'Dashboard\PencariKerja@create');
        Route::match(['get', 'post'], '/edit', 'Dashboard\PencariKerja@update');
        Route::match(['get', 'post'], '/upload', 'Dashboard\PencariKerja@upload');
        Route::post('/delete', 'Dashboard\PencariKerja@delete');
        Route::get('/download', 'Dashboard\PencariKerja@indexDownload');
        Route::post('/download', 'Dashboard\PencariKerja@postDownload');
        Route::get('/send-message', 'Dashboard\PencariKerja@indexSendMessage');
        Route::post('/send-message', 'Dashboard\PencariKerja@downloadSendMessage');
        Route::get('/send-message/search', 'Dashboard\PencariKerja@getSendMessage');
    });

    Route::group(['prefix' => 'karyawan'], function () {
        Route::get('/', 'Dashboard\Karyawan@index');
        Route::match(['get', 'post'], '/create', 'Dashboard\Karyawan@create');
        Route::match(['get', 'post'], '/edit', 'Dashboard\Karyawan@update');
        Route::post('/delete', 'Dashboard\Karyawan@delete');
    });

    Route::group(['prefix' => 'kontak'], function () {
        Route::get('/bukutamu', 'Dashboard\Kontak@indexBukuTamu');
        Route::get('/pengaduan', 'Dashboard\Kontak@indexPengaduan');
        Route::post('/bukutamu/delete', 'Dashboard\Kontak@deleteBukuTamu');
        Route::post('/pengaduan/delete', 'Dashboard\Kontak@deletePengaduan');
        Route::post('/pengaduan/updateStatus', 'Dashboard\Kontak@updateStatusPengaduan');
    });

    Route::group(['prefix' => 'loker'], function () {
        Route::get('/', 'Dashboard\Loker@index');
        Route::get('/kota', 'Dashboard\Loker@indexKota');
        Route::get('/jenis', 'Dashboard\Loker@indexJenis');
        Route::match(['get', 'post'], '/create', 'Dashboard\Loker@create');
        Route::match(['get', 'post'], '/edit', 'Dashboard\Loker@update');
        Route::post('/delete', 'Dashboard\Loker@delete');
    });

    Route::group(['prefix' => 'profil'], function () {
        Route::match(['get', 'post'], '/', 'Dashboard\Profil@profil');
        Route::match(['get', 'post'], '/password', 'Dashboard\Profil@password');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'Dashboard\User@index');
        Route::get('/role', 'Dashboard\User@indexRole');
        Route::match(['get', 'post'], '/create', 'Dashboard\User@create');
        Route::match(['get', 'post'], '/edit', 'Dashboard\User@update');
        Route::post('/delete', 'Dashboard\User@delete');
    });
});