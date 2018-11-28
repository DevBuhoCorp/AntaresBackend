<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 19:46:49 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Ordenpedido
 * 
 * @property int $ID
 * @property \Carbon\Carbon $FechaRegistro
 * @property string $Estado
 * @property string $Observacion
 * @property int $IDAutorizado
 * @property \Carbon\Carbon $FechaAutorizacion
 * @property int $IDAreaColab
 * 
 * @property \App\Models\Areacolab $areacolab
 * @property \Illuminate\Database\Eloquent\Collection $detalleops
 *
 * @package App\Models
 */
class Ordenpedido extends Eloquent
{
	protected $table = 'ordenpedido';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDAutorizado' => 'int',
		'IDAreaColab' => 'int'
	];

	protected $dates = [
		'FechaRegistro',
		'FechaAutorizacion'
	];

	protected $fillable = [
		'FechaRegistro',
		'Estado',
		'Observacion',
		'IDAutorizado',
		'FechaAutorizacion',
		'IDAreaColab',
		'ObservacionAutorizacion'
	];

	public function areacolab()
	{
		return $this->belongsTo(\App\Models\Areacolab::class, 'IDAreaColab');
	}

	public function detalleops()
	{
		return $this->hasMany(\App\Models\Detalleop::class, 'IdOPedido');
	}
}
