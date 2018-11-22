<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 19:46:49 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Proveedor
 * 
 * @property int $ID
 * @property int $IDTipoIdentificacion
 * @property int $IDContribuyente
 * @property int $IDTipoEmisor
 * @property string $Identificacion
 * @property string $RazonSocial
 * @property string $Telefono
 * @property string $Celular
 * @property string $AutorizacionSRI
 * @property string $Email
 * @property string $Direccion
 * @property string $Estado
 * 
 * @property \App\Models\Tipoidentificacion $tipoidentificacion
 * @property \App\Models\Contribuyente $contribuyente
 * @property \App\Models\Tipoemisor $tipoemisor
 *
 * @package App\Models
 */
class Proveedor extends Eloquent
{
	protected $table = 'proveedor';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDTipoIdentificacion' => 'int',
		'IDContribuyente' => 'int',
		'IDTipoEmisor' => 'int'
	];

	protected $fillable = [
		'IDTipoIdentificacion',
		'IDContribuyente',
		'IDTipoEmisor',
		'Identificacion',
		'RazonSocial',
		'Telefono',
		'Celular',
		'AutorizacionSRI',
		'Email',
		'Direccion',
		'Estado'
	];

	public function tipoidentificacion()
	{
		return $this->belongsTo(\App\Models\Tipoidentificacion::class, 'IDTipoIdentificacion');
	}

	public function contribuyente()
	{
		return $this->belongsTo(\App\Models\Contribuyente::class, 'IDContribuyente');
	}

	public function tipoemisor()
	{
		return $this->belongsTo(\App\Models\Tipoemisor::class, 'IDTipoEmisor');
	}
}
