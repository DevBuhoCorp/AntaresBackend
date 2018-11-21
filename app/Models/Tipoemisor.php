<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 19:46:49 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Tipoemisor
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $proveedors
 *
 * @package App\Models
 */
class Tipoemisor extends Eloquent
{
	protected $table = 'tipoemisor';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Descripcion',
		'Estado'
	];

	public function proveedors()
	{
		return $this->hasMany(\App\Models\Proveedor::class, 'IDTipoEmisor');
	}
}
