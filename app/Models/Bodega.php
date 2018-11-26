<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Nov 2018 16:48:16 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Bodega
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Direccion
 * @property string $Latitud
 * @property string $Longitud
 * @property string $Observacion
 * @property string $Estado
 * @property int $IDCiudad
 * 
 * @property \App\Models\Ciudad $ciudad
 *
 * @package App\Models
 */
class Bodega extends Eloquent
{
	protected $table = 'bodega';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDCiudad' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Direccion',
		'Latitud',
		'Longitud',
		'Observacion',
		'Estado',
		'IDCiudad'
	];

	public function ciudad()
	{
		return $this->belongsTo(\App\Models\Ciudad::class, 'IDCiudad');
	}
}
