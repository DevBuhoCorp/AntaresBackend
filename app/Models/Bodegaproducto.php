<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Nov 2018 05:55:57 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Bodegaproducto
 * 
 * @property int $ID
 * @property int $IDBodega
 * @property int $IDProducto
 * @property float $Minimo
 * @property float $Maximo
 * 
 * @property \App\Models\Bodega $bodega
 * @property \App\Models\Producto $producto
 *
 * @package App\Models
 */
class Bodegaproducto extends Eloquent
{
	protected $table = 'bodegaproducto';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDBodega' => 'int',
		'IDProducto' => 'int',
		'Minimo' => 'float',
		'Maximo' => 'float'
	];

	protected $fillable = [
		'IDBodega',
		'IDProducto',
		'Minimo',
		'Maximo'
	];

	public function bodega()
	{
		return $this->belongsTo(\App\Models\Bodega::class, 'IDBodega');
	}

	public function producto()
	{
		return $this->belongsTo(\App\Models\Producto::class, 'IDProducto');
	}
}
