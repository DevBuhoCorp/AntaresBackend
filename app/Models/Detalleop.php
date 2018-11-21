<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 21 Nov 2018 19:46:49 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Detalleop
 * 
 * @property int $ID
 * @property int $IdItem
 * @property int $IdOPedido
 * @property string $Etiqueta
 * @property float $PrecioRef
 * @property float $Cantidad
 * @property float $Saldo
 * 
 * @property \App\Models\Ordenpedido $ordenpedido
 *
 * @package App\Models
 */
class Detalleop extends Eloquent
{
	protected $table = 'detalleop';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IdItem' => 'int',
		'IdOPedido' => 'int',
		'PrecioRef' => 'float',
		'Cantidad' => 'float',
		'Saldo' => 'float'
	];

	protected $fillable = [
		'IdItem',
		'IdOPedido',
		'Etiqueta',
		'PrecioRef',
		'Cantidad',
		'Saldo'
	];

	public function ordenpedido()
	{
		return $this->belongsTo(\App\Models\Ordenpedido::class, 'IdOPedido');
	}
}
