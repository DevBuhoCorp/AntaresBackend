<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 15:32:37 +0000.
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
 * @property \Illuminate\Database\Eloquent\Collection $colaboradors
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

	public function colaboradors()
	{
		return $this->hasMany(\App\Models\Colaborador::class, 'IDCargo');
	}
}
