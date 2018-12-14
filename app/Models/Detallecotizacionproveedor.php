<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 12 Dec 2018 14:36:36 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Detallecotizacionproveedor
 * 
 * @property int $ID
 * @property int $IDDetallecotizacion
 * @property int $IDProveedor
 * @property float $Cantidad
 * @property float $Precio
 * @property string $Estado
 * 
 * @property \App\Models\Detallecotizacion $detallecotizacion
 * @property \App\Models\Proveedor $proveedor
 *
 * @package App\Models
 */
class Detallecotizacionproveedor extends Eloquent
{
	protected $table = 'detallecotizacionproveedor';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDDetallecotizacion' => 'int',
		'IDProveedor' => 'int',
		'Cantidad' => 'float',
		'Precio' => 'float'
	];

	protected $fillable = [
		'IDDetallecotizacion',
		'IDProveedor',
		'Cantidad',
		'Precio',
		'Estado'
	];

	public function detallecotizacion()
	{
		return $this->belongsTo(\App\Models\Detallecotizacion::class, 'IDDetallecotizacion');
	}

	public function proveedor()
	{
		return $this->belongsTo(\App\Models\Proveedor::class, 'IDProveedor');
	}
}
