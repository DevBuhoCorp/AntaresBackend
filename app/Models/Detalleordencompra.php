<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 26 Dec 2018 17:38:59 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Detalleordencompra
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property int $Cantidad
 * @property float $Precio
 * @property int $IDOrdencompra
 * @property int $IDDetalleordenpedido
 * @property int $Cantidadfacturada
 * 
 * @property \App\Models\Ordencompra $ordencompra
 *
 * @package App\Models
 */
class Detalleordencompra extends Eloquent
{
	protected $table = 'detalleordencompra';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'Cantidad' => 'int',
		'Precio' => 'float',
		'IDOrdencompra' => 'int',
		'IDDetalleordenpedido' => 'int',
		'Cantidadfacturada' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Cantidad',
		'Precio',
		'IDOrdencompra',
		'IDDetalleordenpedido',
		'Cantidadfacturada'
	];

	public function ordencompra()
	{
		return $this->belongsTo(\App\Models\Ordencompra::class, 'IDOrdencompra');
	}
}
