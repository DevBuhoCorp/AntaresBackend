<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Nov 2018 05:55:57 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Detallemovimiento
 * 
 * @property int $ID
 * @property int $IDMovimiento
 * @property int $IDBodega
 * @property int $IDProducto
 * @property float $Cantidad
 * @property float $CantPendiente
 * @property float $Costo
 * @property string $Tipo
 * 
 * @property \App\Models\Movimiento $movimiento
 * @property \App\Models\Bodega $bodega
 * @property \App\Models\Producto $producto
 *
 * @package App\Models
 */
class Detallemovimiento extends Eloquent
{
	protected $table = 'detallemovimiento';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDMovimiento' => 'int',
		'IDBodega' => 'int',
		'IDProducto' => 'int',
		'Cantidad' => 'float',
		'CantPendiente' => 'float',
		'Costo' => 'float'
	];

	protected $fillable = [
		'IDMovimiento',
		'IDBodega',
		'IDProducto',
		'Cantidad',
		'CantPendiente',
		'Costo',
		'Tipo'
	];

	public function movimiento()
	{
		return $this->belongsTo(\App\Models\Movimiento::class, 'IDMovimiento');
	}

	public function bodega()
	{
		return $this->belongsTo(\App\Models\Bodega::class, 'IDBodega');
	}

	public function producto()
	{
		return $this->belongsTo(\App\Models\Producto::class, 'IDProducto');
	}
}
