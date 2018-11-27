<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UsersTMovimiento extends Eloquent
{
    protected $table = 'usuariotmovimiento';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'IDUsers',
        'IDTipoMovimiento'
    ];
}
