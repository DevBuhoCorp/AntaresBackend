<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 22 Nov 2018 15:07:14 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Presupuesto
 * 
 * @property int $ID
 * @property int $IDDepartamento
 * @property float $PresupuestoInicial
 * @property float $Compras
 * @property float $OPedido
 * @property float $OCompra
 * @property \Carbon\Carbon $Anio
 * @property string $Meses
 * 
 * @property \App\Models\Departamento $departamento
 *
 * @package App\Models
 */
class Presupuesto extends Eloquent
{
	protected $table = 'presupuesto';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDDepartamento' => 'int',
		'Anio' => 'int',
		'PresupuestoInicial' => 'float',
		'Compras' => 'float',
		'OPedido' => 'float',
		'OCompra' => 'float'
	];


	protected $fillable = [
		'IDDepartamento',
		'PresupuestoInicial',
		'Compras',
		'OPedido',
		'OCompra',
		'Anio',
		'Meses'
	];

	public function departamento()
	{
		return $this->belongsTo(\App\Models\Departamento::class, 'IDDepartamento');
	}
}
