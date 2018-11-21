<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 15:32:37 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Tipoidentificacion
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $proveedors
 *
 * @package App\Models
 */
class Tipoidentificacion extends Eloquent
{
	protected $table = 'tipoidentificacion';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Descripcion',
		'Estado'
	];

	public function proveedors()
	{
		return $this->hasMany(\App\Models\Proveedor::class, 'IDTipoIdentificacion');
	}
}
