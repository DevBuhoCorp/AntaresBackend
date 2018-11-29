<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Nov 2018 05:55:57 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Stock
 * 
 * @property int $ID
 * @property int $IDBodega
 * @property int $IDProducto
 * @property float $Cantidad
 * @property int $CantComprometida
 * @property float $Costo
 * 
 * @property \App\Models\Bodega $bodega
 * @property \App\Models\Producto $producto
 *
 * @package App\Models
 */
class Stock extends Eloquent
{
	protected $table = 'stock';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDBodega' => 'int',
		'IDProducto' => 'int',
		'Cantidad' => 'float',
		'CantComprometida' => 'int',
		'Costo' => 'float'
	];

	protected $fillable = [
		'IDBodega',
		'IDProducto',
		'Cantidad',
		'CantComprometida',
		'Costo'
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
