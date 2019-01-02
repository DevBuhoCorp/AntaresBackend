<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 26 Dec 2018 17:38:58 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Compra
 * 
 * @property int $ID
 * @property \Carbon\Carbon $Fecha
 * @property int $IDAreaColab
 * @property int $IDProveedor
 * @property string $Estado
 * @property string $DetalleFactura
 * 
 * @property \App\Models\Proveedor $proveedor
 * @property \Illuminate\Database\Eloquent\Collection $detallecompras
 *
 * @package App\Models
 */
class Compra extends Eloquent
{
	protected $table = 'compra';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDAreaColab' => 'int',
		'IDProveedor' => 'int'
	];

	protected $dates = [
		'Fecha'
	];

	protected $fillable = [
		'Fecha',
		'IDAreaColab',
		'IDProveedor',
		'Estado',
		'DetalleFactura'
	];

	public function proveedor()
	{
		return $this->belongsTo(\App\Models\Proveedor::class, 'IDProveedor');
	}

	public function detallecompras()
	{
		return $this->hasMany(\App\Models\Detallecompra::class, 'IDCompra');
	}
}
