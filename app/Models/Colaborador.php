<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 19:46:49 +0000.
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
 * 
 * @property \Illuminate\Database\Eloquent\Collection $areacolabs
 *
 * @package App\Models
 */
class Colaborador extends Eloquent
{
	protected $table = 'colaborador';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'NombrePrimero',
		'NombreSegundo',
		'ApellidoPaterno',
		'ApellidoMaterno',
		'Cedula',
		'Estado'
	];

	public function areacolabs()
	{
		return $this->hasMany(\App\Models\Areacolab::class, 'IdColaborador');
	}
}
