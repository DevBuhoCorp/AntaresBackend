<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Nov 2018 05:55:57 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Tipodocumento
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Observacion
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $movimientos
 *
 * @package App\Models
 */
class Tipodocumento extends Eloquent
{
	protected $table = 'tipodocumento';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Descripcion',
		'Observacion',
		'Estado'
	];

	public function movimientos()
	{
		return $this->hasMany(\App\Models\Movimiento::class, 'IDTipoDocumento');
	}
}
