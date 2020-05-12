<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {
    
    protected $table = 'm_supplier';

    protected $guarded = [];

    public function transaksi() {
        return $this->hasMany('App\Models\Transaksi\Transaksi', 'supplier_id');
    }
}
