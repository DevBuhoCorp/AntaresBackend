<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 19:46:48 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Areacolab
 * 
 * @property int $ID
 * @property \Carbon\Carbon $FechaInicio
 * @property \Carbon\Carbon $FechaFin
 * @property int $IdColaborador
 * @property int $IdArea
 * @property int $IdCargo
 * @property string $Estado
 * 
 * @property \App\Models\Area $area
 * @property \App\Models\Colaborador $colaborador
 * @property \App\Models\Cargo $cargo
 *
 * @package App\Models
 */
class Areacolab extends Eloquent
{
	protected $table = 'areacolab';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IdColaborador' => 'int',
		'IdArea' => 'int',
		'IdCargo' => 'int'
	];

	protected $dates = [
		'FechaInicio',
		'FechaFin'
	];

	protected $fillable = [
		'FechaInicio',
		'FechaFin',
		'IdColaborador',
		'IdArea',
		'IdCargo',
		'Estado'
	];

	public function area()
	{
		return $this->belongsTo(\App\Models\Area::class, 'IdArea');
	}

	public function colaborador()
	{
		return $this->belongsTo(\App\Models\Colaborador::class, 'IdColaborador');
	}

	public function cargo()
	{
		return $this->belongsTo(\App\Models\Cargo::class, 'IdCargo');
	}
}
