<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class AssetKategori extends Model {
    
    protected $table = 'm_asset_kategori';

    protected $guarded = [];

    public $timestamps = false;

    public function asset() {
        return $this->hasMany('App\Models\Master\Asset', 'kategori_id');
    }
}
