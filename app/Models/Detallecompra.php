<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 26 Dec 2018 17:38:58 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Detallecompra
 * 
 * @property int $ID
 * @property int $IDDetalleordencompra
 * @property string $Descripcion
 * @property float $Precio
 * @property int $Cantidad
 * @property int $Saldo
 * @property int $IDCompra
 * 
 * @property \App\Models\Compra $compra
 *
 * @package App\Models
 */
class Detallecompra extends Eloquent
{
	protected $table = 'detallecompra';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDDetalleordencompra' => 'int',
		'Precio' => 'float',
		'Cantidad' => 'int',
		'Saldo' => 'int',
		'IDCompra' => 'int'
	];

	protected $fillable = [
		'IDDetalleordencompra',
		'Descripcion',
		'Precio',
		'Cantidad',
		'Saldo',
		'IDCompra'
	];

	public function compra()
	{
		return $this->belongsTo(\App\Models\Compra::class, 'IDCompra');
	}
}
