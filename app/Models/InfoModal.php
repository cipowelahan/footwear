<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoModal extends Model {
    
    protected $table = 'info_modal';

    protected $guarded = [];

    protected $appends = [
        'modal_format',
        'kas_format'
    ];

    public $timestamps = false;

    public function getModalFormatAttribute() {
        return number_format($this->modal);
    }

    public function getKasFormatAttribute() {
        return number_format($this->kas);
    }
}
