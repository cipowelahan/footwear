<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Loker as ModelData;
use DB, Exception;

class Loker extends Controller {

    public function __construct() {
        $this->middleware('ajax');
    }
    
    public function index(Request $req) {
        $loker = ModelData::when($req->filled('search'), function($q) use ($req) {
            $q
                ->orWhereHas('user', function($d) use ($req) {
                    $d->where('nama', 'like', '%'.$req->search.'%');
                })
                ->orWhere('id', 'like', '%'.$req->search.'%')
                ->orWhere('judul', 'like', '%'.$req->search.'%')
                ->orWhere('kota', 'like', '%'.$req->search.'%')
                ->orWhere('jenis', 'like', '%'.$req->search.'%');
        })->when(auth()->user()->role_id != 1, function($q) {
            $q->where('user_id', auth()->id());
        })->with('user')->paginate(10);
        return view('dashboard.pages.loker.index', compact('loker'));
    }

    public function indexKota(Request $req) {
        $kota = $this->collectKota();
        return view('dashboard.pages.loker.index-kota', compact('kota'));
    }

    public function indexJenis() {
        $jenis = $this->collectJenis();
        return view('dashboard.pages.loker.index-jenis', compact('jenis'));
    }

    private function convertJenisToString(array $data) {
        $result = [];
        foreach ($data as $d) {
            array_push($result, ucwords($d));
        }
        return implode('|', collect($result)->sort()->values()->all());
    }

    private function collectKota() {
        $kota =  ModelData::selectRaw("distinct kota")->get()->pluck('kota');
        return collect($kota)->sort()->values()->all();
    }

    private function collectJenis() {
        $dataJenis = ModelData::selectRaw("distinct jenis")->get()->pluck('jenis');
        $mergeJenis = [];
        foreach ($dataJenis as $jenis) {
            $splitJenis = explode('|', $jenis);
            $mergeJenis = array_merge($mergeJenis, $splitJenis);
        }
        $uniqueJenis = array_unique($mergeJenis);
        return collect($uniqueJenis)->sort()->values()->all();
    }

    private function beforeSave($req, $imageUrl = null) {
        if ($req->hasFile('gambar')) {
            $file = $req->file('gambar');
            $extension = $file->getClientOriginalExtension(); 
            $fileName = time().'.'.$extension;
            $path = public_path().'/image/loker';
            $uplaod = $file->move($path,$fileName);
            $gambar = "image/loker/$fileName";
            if ($imageUrl) $lastImage = $imageUrl;
        }
        else {
            $gambar = $imageUrl ?? null;
        }
        
        $slug = Str::slug(time().'-'.$req->judul, '-');

        $data = [
            'judul' => $req->judul,
            'judul_slug' => $slug,
            'kota' => ucwords($req->kota),
            'jenis' => $this->convertJenisToString($req->jenis),
            'gambar' => $gambar,
            'deskripsi' => $req->deskripsi
        ];

        if (isset($lastImage)) $data['lastImage'] = $lastImage;
        if (!isset($req->id)) $data['user_id'] = auth()->id();

        return $data;
    }

    public function create(Request $req) {
        if ($req->isMethod('get')) {
            return view('dashboard.pages.loker.create', [
                'kota' => $this->collectKota(),
                'jenis' => $this->collectJenis()
            ]);
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }

        try {
            DB::beginTransaction();
            $data = $this->beforeSave($req);
            $loker = ModelData::create($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $response = $e->getMessage();
        }
        
        return response($response ?? "1");
        
    }

    public function update(Request $req) {
        $loker = ModelData::find($req->id);

        if ($req->isMethod('get')) {
            $kota = $this->collectKota();
            $jenis = $this->collectJenis();
            return view('dashboard.pages.loker.edit', compact('loker', 'kota', 'jenis'));
        }

        $validation = Validator::make($req->all(), ModelData::getRules(), ModelData::getMessages());
        if ($validation->fails()) {
            return response($validation->errors()->first() ,422);
        }

        try {
            DB::beginTransaction();
            $data = $this->beforeSave($req, $loker->gambar);
            
            if (isset($data['lastImage'])) {
                unlink(public_path().'/'.$data['lastImage']);
                unset($data['lastImage']);
            }
            
            unset($data['judul_slug']);
            $loker->update($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $response = $e->getMessage();
        }
        
        return response($response ?? "1");
    }

    public function delete(Request $req) {
        $loker = ModelData::find($req->id);
        if ($loker->gambar) unlink(public_path()."/$loker->gambar");
        $loker->delete();
        return response()->json([
            'succes' => true,
            'lastUrl' => $req->lastUrl
        ]);
    }

}