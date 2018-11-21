<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 19:46:49 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Cargo
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property bool $Autorizar
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $areacolabs
 *
 * @package App\Models
 */
class Cargo extends Eloquent
{
	protected $table = 'cargo';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'Autorizar' => 'bool'
	];

	protected $fillable = [
		'Descripcion',
		'Autorizar',
		'Estado'
	];

	public function areacolabs()
	{
		return $this->hasMany(\App\Models\Areacolab::class, 'IdCargo');
	}
}
