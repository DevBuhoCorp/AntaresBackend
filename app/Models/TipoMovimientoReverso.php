<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TipoMovimientoReverso extends Eloquent
{
    protected $table = 'tmovimientoreverso';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'IDTipoMovimiento',
        'IDTipoMovimientoReverso',
    ];
}
