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

Route::get('/migrate123', function() {
    Artisan::call('migrate:refresh', [
        '--seed' => true,
    ]);
    return redirect()->route('login');
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
    Route::get('/reset', 'Dashboard\Dashboard@resetData')->name('reset');
    Route::match(['get', 'post'], '/modal', 'Dashboard\Dashboard@modal')->name('dashboard.modal');

    Route::group(['prefix' => 'master'], function () {

        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/', 'Dashboard\Master\Supplier@index');
            Route::match(['get', 'post'], '/create', 'Dashboard\Master\Supplier@create');
            Route::match(['get', 'post'], '/edit', 'Dashboard\Master\Supplier@update');
            Route::post('/delete', 'Dashboard\Master\Supplier@delete');
        });

        Route::group(['prefix' => 'produk'], function () {
            Route::get('/', 'Dashboard\Master\Produk@index');
            Route::match(['get', 'post'], '/create', 'Dashboard\Master\Produk@create');
            Route::match(['get', 'post'], '/edit', 'Dashboard\Master\Produk@update');
            Route::post('/delete', 'Dashboard\Master\Produk@delete');
            Route::get('/ajax', 'Dashboard\Master\Produk@api')->name('produk.ajax');
        });

        Route::group(['prefix' => 'produkkategori'], function () {
            Route::get('/', 'Dashboard\Master\ProdukKategori@index');
            Route::match(['get', 'post'], '/create', 'Dashboard\Master\ProdukKategori@create');
            Route::match(['get', 'post'], '/edit', 'Dashboard\Master\ProdukKategori@update');
            Route::post('/delete', 'Dashboard\Master\ProdukKategori@delete');
        });

        Route::group(['prefix' => 'kaskategori'], function () {
            Route::get('/', 'Dashboard\Master\KasKategori@index');
            Route::match(['get', 'post'], '/create', 'Dashboard\Master\KasKategori@create');
            Route::match(['get', 'post'], '/edit', 'Dashboard\Master\KasKategori@update');
            Route::post('/delete', 'Dashboard\Master\KasKategori@delete');
        });

        Route::group(['prefix' => 'assetkategori'], function () {
            Route::get('/', 'Dashboard\Master\AssetKategori@index');
            Route::match(['get', 'post'], '/create', 'Dashboard\Master\AssetKategori@create');
            Route::match(['get', 'post'], '/edit', 'Dashboard\Master\AssetKategori@update');
            Route::post('/delete', 'Dashboard\Master\AssetKategori@delete');
        });
    });

    Route::group(['prefix' => 'transaksi'], function () {
            Route::match(['get', 'post'], '/penjualan', 'Dashboard\Transaksi\Transaksi@penjualan');
            Route::match(['get', 'post'], '/pembelian', 'Dashboard\Transaksi\Transaksi@pembelian');
            Route::get('/riwayat', 'Dashboard\Transaksi\Transaksi@riwayat');
            Route::get('/riwayat/detail', 'Dashboard\Transaksi\Transaksi@detail')->name('transaksi.detail');
    });

    Route::group(['prefix' => 'kas'], function() {

        Route::group(['prefix' => 'asset'], function () {
            Route::get('/', 'Dashboard\Kas\Asset@index');
            Route::match(['get', 'post'], '/create', 'Dashboard\Kas\Asset@create');
            Route::match(['get', 'post'], '/edit', 'Dashboard\Kas\Asset@update');
            Route::post('/delete', 'Dashboard\Kas\Asset@delete');
        });

        Route::group(['prefix' => 'kas'], function () {
            Route::get('/', 'Dashboard\Kas\Kas@index');
            Route::match(['get', 'post'], '/create', 'Dashboard\Kas\Kas@create');
            Route::match(['get', 'post'], '/edit', 'Dashboard\Kas\Kas@update');
            Route::post('/delete', 'Dashboard\Kas\Kas@delete');
        });
        
        Route::group(['prefix' => 'keuangan'], function () {
            Route::get('/', 'Dashboard\Kas\Keuangan@index');
        });

    });

    Route::group(['prefix' => 'laporan'], function () {
        Route::get('/buku-besar', 'Dashboard\Laporan\Laporan@bukubesar');
        Route::match(['get', 'post'], '/laba-rugi', 'Dashboard\Laporan\Laporan@labarugi');
        Route::match(['get', 'post'], '/perubahan-ekuitas', 'Dashboard\Laporan\Laporan@perubahanekuitas');
        Route::match(['get', 'post'], '/neraca', 'Dashboard\Laporan\Laporan@neraca');
    });

    Route::group(['prefix' => 'profil'], function () {
        Route::match(['get', 'post'], '/', 'Dashboard\Profil@profil');
        Route::match(['get', 'post'], '/password', 'Dashboard\Profil@password');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'Dashboard\User@index');
        Route::match(['get', 'post'], '/create', 'Dashboard\User@create');
        Route::match(['get', 'post'], '/edit', 'Dashboard\User@update');
        Route::post('/delete', 'Dashboard\User@delete');
    });
});