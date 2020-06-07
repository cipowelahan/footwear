<?php

namespace App\Http\Controllers\Dashboard\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InfoModal;
use App\Models\Transaksi\Transaksi as ModelData;
use App\Models\Master\Produk;
use App\Models\Master\Supplier;
use DB, Exception;

class Transaksi extends Controller {

    private function simpanTransaksiProduk($transaksi, $jenis, $produk) {
        foreach ($produk as $p) {
            $transaksi->tr_produk()->create($p);
            $produk = Produk::find($p['produk_id']);
            if ($jenis == 'penjualan') $produk->decrement('stok', $p['jumlah']);
            else $produk->increment('stok', $p['jumlah']);
        }
    }

    private function processTransaction($jenis, Request $req) {
        $response = [
            'message' => '1',
            'code' => 200
        ];

        if(!isset($req->produk)) {
            $response['message'] = 'Daftar Produk Kosong';
            $response['code'] = 422;
            return $response;
        }

        if ($jenis == 'pembelian') {
            $info = InfoModal::first();
            if ($req->total > $info->kas) {
                $response['message'] = 'Kas Kurang. Sisa '.$info->kas_format;
                $response['code'] = 422;
                return $response;
            }
        }

        try {
            DB::beginTransaction();
            
            $transaksi = ModelData::create([
                'jenis' => $jenis,
                'tanggal' => $req->tanggal,
                'diskon' => $req->diskon ?? 0,
                'supplier_id' => $req->supplier_id,
                'total' => $req->total,
                'total_hpp' => $req->total_hpp,
                'user' => auth()->user()->nama
            ]);

            $this->simpanTransaksiProduk($transaksi, $jenis, $req->produk);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $response['message'] = $e->getMessage();
            $response['code'] = 422;
        }

        return $response;
    }

    public function penjualan(Request $req) {
        if ($req->isMethod('get')) {
            return view('dashboard.pages.transaksi.penjualan');
        }

        $transaksi = $this->processTransaction('penjualan', $req);
        return response($transaksi['message'], $transaksi['code']);
    }

    public function pembelian(Request $req) {
        if ($req->isMethod('get')) {
            $supplier = Supplier::get();
            return view('dashboard.pages.transaksi.pembelian', compact('supplier'));
        }

        $transaksi = $this->processTransaction('pembelian', $req);
        return response($transaksi['message'], $transaksi['code']);
    }

    public function riwayat(Request $req) {
        $riwayat = ModelData::when($req->filled('search'), function($q) use ($req) {
            $q  
                ->orWhereHas('supplier', function($d) use ($req) {
                    $d->where('nama', 'like', '%'.$req->search.'%');
                })
                ->orWhere('id', 'like', '%'.$req->search.'%')
                ->orWhere('tanggal', 'like', '%'.$req->search.'%')
                ->orWhere('total', 'like', '%'.$req->search.'%')
                ->orWhere('user', 'like', '%'.$req->search.'%');
        })
        ->with('supplier')
        ->when($req->filled('jenis'), function($q) use ($req) {
            $q->where('jenis', $req->jenis);
        })
        ->when($req->filled('order_column'), function($q) use ($req) {
            $column = $req->order_column;
            $q->orderBy($column, $req->order);
        }, function($q) {
            $q->orderBy('tanggal', 'desc');
        })
        ->when($req->filled('tanggal_mulai'), function($q) use ($req) {
            $q->where('tanggal', '>=', $req->tanggal_mulai);
        })
        ->when($req->filled('tanggal_selesai'), function($q) use ($req) {
            $q->where('tanggal', '<=', $req->tanggal_selesai);
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('dashboard.pages.transaksi.riwayat', compact('riwayat'));
    }

    public function detail(Request $req) {
        $transaksi = ModelData::with(['supplier', 'tr_produk.produk'])->find($req->id);
        $lastUrl = urldecode($req->lastUrl) ?? $req->fullUrl();
        return view('dashboard.pages.transaksi.detail', compact('transaksi', 'lastUrl'));
    }
}