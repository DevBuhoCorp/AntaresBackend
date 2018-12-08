<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 03 Dec 2018 22:07:16 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Cotizacion
 * 
 * @property int $ID
 * @property \Carbon\Carbon $FechaIni
 * @property \Carbon\Carbon $FechaFin
 * @property string $Observacion
 * @property string $Estado
 * @property string $Detalleregistro
 * 
 * @property \Illuminate\Database\Eloquent\Collection $detallecotizacions
 *
 * @package App\Models
 */
class Cotizacion extends Eloquent
{
	protected $table = 'cotizacion';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $dates = [
		'FechaIni',
		'FechaFin',
		'FechaReg',
	];

	protected $fillable = [
		'FechaIni',
		'FechaFin',
		'FechaReg',
		'Observacion',
		'Estado',
		'Detalleregistro',
		'IDAreaColab'
	];

	public function detallecotizacions()
	{
		return $this->hasMany(\App\Models\Detallecotizacion::class, 'IDCotizacion');
	}
}
