<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 19:46:49 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Departamento
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $NombreCorto
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $areas
 *
 * @package App\Models
 */
class Departamento extends Eloquent
{
	protected $table = 'departamento';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Descripcion',
		'NombreCorto',
		'Estado'
	];

	public function areas()
	{
		return $this->hasMany(\App\Models\Area::class, 'IDDepartamento');
	}
}
