<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 15:32:37 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Ordenpedido
 * 
 * @property int $ID
 * @property \Carbon\Carbon $FechaRegistro
 * @property int $IdArea
 * @property int $IdUsers
 * @property string $Estado
 * @property string $Observacion
 * @property int $IDAutorizado
 * @property \Carbon\Carbon $FechaAutorizacion
 * 
 * @property \App\Models\Area $area
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
		'IdArea' => 'int',
		'IdUsers' => 'int',
		'IDAutorizado' => 'int'
	];

	protected $dates = [
		'FechaRegistro',
		'FechaAutorizacion'
	];

	protected $fillable = [
		'FechaRegistro',
		'IdArea',
		'IdUsers',
		'Estado',
		'Observacion',
		'IDAutorizado',
		'FechaAutorizacion'
	];

	public function area()
	{
		return $this->belongsTo(\App\Models\Area::class, 'IdArea');
	}

	public function detalleops()
	{
		return $this->hasMany(\App\Models\Detalleop::class, 'IdOPedido');
	}
}
