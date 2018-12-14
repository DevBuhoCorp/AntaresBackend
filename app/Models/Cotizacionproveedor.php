<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 14 Dec 2018 19:57:36 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Cotizacionproveedor
 * 
 * @property int $ID
 * @property int $IDAreaColab
 * @property int $IDCotizacion
 * @property int $IDProveedor
 * @property \Carbon\Carbon $FechaReg
 * @property string $Archivo
 *
 * @package App\Models
 */
class Cotizacionproveedor extends Eloquent
{
	protected $table = 'cotizacionproveedor';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDAreaColab' => 'int',
		'IDCotizacion' => 'int',
		'IDProveedor' => 'int'
	];

	protected $dates = [
		'FechaReg'
	];

	protected $fillable = [
		'IDAreaColab',
		'IDCotizacion',
		'IDProveedor',
		'FechaReg',
		'Archivo'
	];
}
