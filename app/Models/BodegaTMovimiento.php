<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class BodegaTMovimiento extends Eloquent
{
    protected $table = 'bodegatmovimiento';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'IDBodega',
        'IDTipoMovimiento'
    ];
}
