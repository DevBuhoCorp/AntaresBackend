<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 26 Dec 2018 17:38:59 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Ordencompra
 * 
 * @property int $ID
 * @property \Carbon\Carbon $FechaRegistro
 * @property string $Estado
 * @property int $IDProveedor
 * @property int $IDAreaColab
 * @property \Carbon\Carbon $FechaEntrega
 * @property string $Observacion
 * 
 * @property \App\Models\Proveedor $proveedor
 * @property \Illuminate\Database\Eloquent\Collection $detalleordencompras
 *
 * @package App\Models
 */
class Ordencompra extends Eloquent
{
	protected $table = 'ordencompra';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDProveedor' => 'int',
		'IDAreaColab' => 'int',
		'IDModoPago' => 'int',
		'IDCondicionPago' => 'int'
	];

	protected $dates = [
		'FechaRegistro',
		'FechaEntrega'
	];

	protected $fillable = [
		'FechaRegistro',
		'Estado',
		'IDProveedor',
		'IDAreaColab',
		'FechaEntrega',
		'Observacion',
		'IDModoPago',
		'IDCondicionPago'
	];

	public function proveedor()
	{
		return $this->belongsTo(\App\Models\Proveedor::class, 'IDModoPago');
	}

	public function modopago()
	{
		return $this->belongsTo(\App\Models\Modospago::class, 'IDModoPago');
	}

	public function condicionpago()
	{
		return $this->belongsTo(\App\Models\Condicionespago::class, 'IDCondicionPago');
	}

	public function detalleordencompras()
	{
		return $this->hasMany(\App\Models\Detalleordencompra::class, 'IDOrdencompra');
	}
}
