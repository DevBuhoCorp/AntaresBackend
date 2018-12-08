<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 03 Dec 2018 22:07:16 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Detallecotizacion
 * 
 * @property int $ID
 * @property int $IDCotizacion
 * @property int $IDDetalleordenpedido
 * @property string $Estado
 * 
 * @property \App\Models\Cotizacion $cotizacion
 *
 * @package App\Models
 */
class Detallecotizacion extends Eloquent
{
	protected $table = 'detallecotizacion';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDCotizacion' => 'int',
		'IDDetalleordenpedido' => 'int',
		'IDProveedor' => 'int',
	];

	protected $fillable = [
		'IDCotizacion',
		'IDDetalleordenpedido',
		'IDProveedor',
		'Estado'
	];

	public function cotizacion()
	{
		return $this->belongsTo(\App\Models\Cotizacion::class, 'IDCotizacion');
	}
}
