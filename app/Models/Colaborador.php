<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Nov 2018 16:06:40 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Colaborador
 * 
 * @property int $ID
 * @property string $NombrePrimero
 * @property string $NombreSegundo
 * @property string $ApellidoPaterno
 * @property string $ApellidoMaterno
 * @property string $Cedula
 * @property string $Estado
 * @property int $IDUsers
 * 
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $areacolabs
 *
 * @package App\Models
 */
class Colaborador extends Eloquent
{
	protected $table = 'colaborador';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDUsers' => 'int'
	];

	protected $fillable = [
		'NombrePrimero',
		'NombreSegundo',
		'ApellidoPaterno',
		'ApellidoMaterno',
		'Cedula',
		'Estado',
		'IDUsers'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'IDUsers');
	}

	public function areacolabs()
	{
		return $this->hasMany(\App\Models\Areacolab::class, 'IdColaborador');
	}
}
