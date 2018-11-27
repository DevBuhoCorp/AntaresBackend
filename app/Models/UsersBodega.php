<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersBodega extends Model
{
    protected $table = 'bodegausuario';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'IDUsers',
        'IDBodega'
    ];
}
