<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Nov 2018 05:55:57 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Movimiento
 * 
 * @property int $ID
 * @property int $IDUsers
 * @property int $IDTipoMovimiento
 * @property int $IDTipoDocumento
 * @property int $IDCompra
 * @property \Carbon\Carbon $Fecha
 * @property string $Observacion
 * @property string $NDocumento
 * 
 * @property \App\Models\Tipomovimiento $tipomovimiento
 * @property \App\Models\Tipodocumento $tipodocumento
 * @property \Illuminate\Database\Eloquent\Collection $detallemovimientos
 *
 * @package App\Models
 */
class Movimiento extends Eloquent
{
	protected $table = 'movimiento';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDUsers' => 'int',
		'IDTipoMovimiento' => 'int',
		'IDTipoDocumento' => 'int',
		'IDCompra' => 'int'
	];

	protected $dates = [
		'Fecha'
	];

	protected $fillable = [
		'IDUsers',
		'IDTipoMovimiento',
		'IDTipoDocumento',
		'IDCompra',
		'Fecha',
		'Observacion',
		'NDocumento'
	];

	public function tipomovimiento()
	{
		return $this->belongsTo(\App\Models\Tipomovimiento::class, 'IDTipoMovimiento');
	}

	public function tipodocumento()
	{
		return $this->belongsTo(\App\Models\Tipodocumento::class, 'IDTipoDocumento');
	}

	public function detallemovimientos()
	{
		return $this->hasMany(\App\Models\Detallemovimiento::class, 'IDMovimiento');
	}
}
