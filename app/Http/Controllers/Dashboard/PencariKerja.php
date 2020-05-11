<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PencariKerja as ModelData;
use App\Imports\PencariKerjaImport;
use App\Exports\PencariKerjaExport;
use File, DB, Exception, Excel;

class PencariKerja extends Controller {

    public function __construct() {
        $this->middleware('ajax')->except('postDownload', 'downloadSendMessage');
    }
    
    public function index(Request $req) {
        $pencarikerja = ModelData::when($req->filled('search'), function($q) use ($req) {
            $q
                ->orWhereHas('user', function($d) use ($req) {
                    $d->where('nama', 'like', '%'.$req->search.'%');
                })
                ->orWhere('id', 'like', '%'.$req->search.'%')
                ->orWhere('tanggal_pendaftaran', 'like', '%'.$req->search.'%')
                ->orWhere('no_ktp', 'like', '%'.$req->search.'%')
                ->orWhere('nama', 'like', '%'.$req->search.'%')
                ->orWhere('umur', 'like', '%'.$req->search.'%')
                ->orWhere('kontak', 'like', '%'.$req->search.'%')
                ->orWhere('pendidikan', 'like', '%'.$req->search.'%')
                ->orWhere('status_kerja', 'like', '%'.$req->search.'%');
        })
        ->when($req->filled('kelamin'), function($q) use ($req) {
            $q->where('kelamin', $req->kelamin);
        })
        ->when(auth()->user()->role_id != 1, function($q) {
            $q->where('user_id', auth()->id());
        })
        ->with('user')
        ->when($req->filled('order_column'), function($q) use ($req) {
            $q->orderBy($req->order_column, $req->order);
        })
        ->paginate(10);
        return view('dashboard.pages.pencarikerja.index', compact('pencarikerja'));
    }

    private function beforeSave($req, $imageUrl = null) {
        if ($req->hasFile('gambar')) {
            $file = $req->file('gambar');
            $extension = $file->getClientOriginalExtension(); 
            $fileName = time().'.'.$extension;
            $path = public_path().'/image/pencarikerja';
            $uplaod = $file->move($path,$fileName);
            $gambar = "image/pencarikerja/$fileName";
            if ($imageUrl) $lastImage = $imageUrl;
        }
        else {
            $gambar = $imageUrl ?? null;
        }

        $data = $req->except('_token');
        $data['gambar'] = $gambar;

        if (isset($lastImage)) $data['lastImage'] = $lastImage;
        if (!isset($req->id)) $data['user_id'] = auth()->id();

        return $data;
    }


    public function create(Request $req) {
        if ($req->isMethod('get')) {
            return view('dashboard.pages.pencarikerja.create');
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }
        
        try {
            DB::beginTransaction();
            $data = $this->beforeSave($req);
            $pencarikerja = ModelData::create($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $response = $e->getMessage();
        }

        return response($response ?? "1");
    }

    public function upload(Request $req) {
        if ($req->isMethod('get')) {
            return view('dashboard.pages.pencarikerja.upload');
        }

        Excel::import(new PencariKerjaImport, $req->file('file'));
        return response("1");
    }

    public function update(Request $req) {
        $pencarikerja = ModelData::find($req->id);

        if ($req->isMethod('get')) {
            return view('dashboard.pages.pencarikerja.edit', compact('pencarikerja'));
        }

        $validation = Validator::make($req->all(), ModelData::getRules($req->id), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }

        try {
            DB::beginTransaction();
            $data = $this->beforeSave($req, $pencarikerja->gambar);

            if (isset($data['lastImage'])) {
                unlink(public_path().'/'.$data['lastImage']);
                unset($data['lastImage']);
            }

            $pencarikerja->update($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $response = $e->getMessage();
        }

        return response($response ?? "1");
    }

    public function delete(Request $req) {
        $pencarikerja = ModelData::find($req->id);
        if ($pencarikerja->gambar) unlink(public_path()."/$pencarikerja->gambar");
        $pencarikerja->delete();
        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }

    private function collectTanggalPendaftaran() {
        $rawTanggal = ModelData::selectRaw("distinct year(tanggal_pendaftaran) as 'tahun', month(tanggal_pendaftaran) as 'bulan'")
            ->get()
            ->map(function($data) {
                $data->tanggal = $data->tahun.'-'.str_pad($data->bulan, 2, '0', STR_PAD_LEFT);
                return $data;
            });

        return collect($rawTanggal)->sortByDesc('tanggal')->values()->pluck('tanggal')->all();
    }

    public function indexDownload() {
        $tanggal_pendaftaran = $this->collectTanggalPendaftaran();
        return view('dashboard.pages.pencarikerja.download', compact('tanggal_pendaftaran'));
    }

    public function postDownload(Request $req) {
        $pencarikerja = ModelData::where('tanggal_pendaftaran', 'like', "%$req->tanggal_pendaftaran%")->orderBy('tanggal_pendaftaran')->get();

        $carbon = new \Carbon\Carbon($req->tanggal_pendaftaran);
        $bulan = $carbon->locale('id')->shortMonthName;
        $lastMonth = $carbon->daysInMonth;
        $tahun = $carbon->year;

        $nama = 'Laporan Daftar Pencaker';
        $tanggal_teks = "01 $bulan $tahun - $lastMonth $bulan $tahun";

        $datapencarikerja = [];
        $no = 1;
        foreach ($pencarikerja as $data) {
            array_push($datapencarikerja, [
                'no' => $no,
                'tanggal_pendaftaran' => $data->tanggal_pendaftaran,
                'no_ktp' => $data->no_ktp,
                'nama' => $data->nama,
                'umur' => $data->umur,
                'kelamin' => $data->kelamin,
                'status' => $data->status,
                'pendidikan' => $data->pendidikan,
                'jurusan' => $data->jurusan,
                'alamat' => $data->alamat,
                'kontak' => ($data->kontak)?$data->kontak:'00000000000',
                'status_kerja' => $data->status_kerja,
                'lokasi_kerja' => $data->lokasi_kerja,
            ]);
            $no++;
        }

        $datapencarikerja = collect($datapencarikerja)->values()->all();
        
        return Excel::download(new PencariKerjaExport($datapencarikerja, $tanggal_teks), "$nama $tanggal_teks.xlsx");
    }

    public function indexSendMessage() {
        $tanggal_pendaftaran = $this->collectTanggalPendaftaran();
        return view('dashboard.pages.pencarikerja.send-message', compact('tanggal_pendaftaran'));
    }

    public function getSendMessage(Request $req) {
        $data = ModelData::select('id', 'nama', 'kontak')
            ->where('nama', 'like', "%$req->search%")
            ->orWhere('nama', 'like', "%$req->search%")
            ->orderBy('nama', 'asc')
            ->paginate(50);
        return response()->json($data);
    }

    public function downloadSendMessage(Request $req) {
        $choices = $req->choices;

        if ($choices == 'all') {
            $kontak = ModelData::select('nama', 'kontak')
                ->where('kontak', '!=', '')
                ->get()->toArray();
        }
        else if ($choices == 'date') {
            $kontak = ModelData::select('nama', 'kontak')
                ->where('tanggal_pendaftaran', 'like', "%$req->tanggal_pendaftaran%")
                ->where('kontak', '!=', '')
                ->get()->toArray();
        }
        else if ($choices == 'one') {
            $kontak = [];
            if (!empty($req->kontak)) {
                foreach ($req->kontak as $d) {
                    $splitData = explode("|", $d);
                    array_push($kontak, [
                        'nama' => $splitData[0],
                        'kontak' => $splitData[1]
                    ]);
                }
            }
            else {
                return response('PILIHAN TIDAK BOLEH KOSONG');
            }
        }
        else {
            return response('NOPE');
        }

        $data = [
            'pesan' => $req->pesan,
            'kontak' => $kontak
        ];

        $now = \Carbon\Carbon::now()->locale('id');
        $date = "$now->year-$now->month-$now->day"."_"."$now->hour-$now->minute-$now->second";
        $filename = $date."_dinnakerind_sms.json";
        File::put(public_path($filename), json_encode($data));
        return response()->download(public_path($filename))->deleteFileAfterSend();
    }

}