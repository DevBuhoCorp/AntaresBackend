<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 19:46:48 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Area
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDDepartamento
 * 
 * @property \App\Models\Departamento $departamento
 * @property \Illuminate\Database\Eloquent\Collection $areacolabs
 * @property \Illuminate\Database\Eloquent\Collection $ordenpedidos
 *
 * @package App\Models
 */
class Area extends Eloquent
{
	protected $table = 'area';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDDepartamento' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Estado',
		'IDDepartamento'
	];

	public function departamento()
	{
		return $this->belongsTo(\App\Models\Departamento::class, 'IDDepartamento');
	}

	public function areacolabs()
	{
		return $this->hasMany(\App\Models\Areacolab::class, 'IdArea');
	}

	public function ordenpedidos()
	{
		return $this->hasMany(\App\Models\Ordenpedido::class, 'IdArea');
	}
}
