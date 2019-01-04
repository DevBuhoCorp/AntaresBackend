<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 29 Nov 2018 05:55:57 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
/**
 * Class Producto
 * 
 * @property int $ID
 * @property string $Nombre
 * @property string $NombreCorto
 * @property int $Stock
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $bodegas
 * @property \Illuminate\Database\Eloquent\Collection $detallemovimientos
 * @property \Illuminate\Database\Eloquent\Collection $kardexes
 * @property \Illuminate\Database\Eloquent\Collection $stocks
 * @property \Illuminate\Database\Eloquent\Collection $transferencia
 *
 * @package App\Models
 */
class Producto extends Eloquent
{
	protected $table = 'producto';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'Stock' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'NombreCorto',
		'Stock',
		'Estado'
	];

	public function bodegas()
	{
		return $this->belongsToMany(\App\Models\Bodega::class, 'bodegaproducto', 'IDProducto', 'IDBodega')
					->withPivot('ID', 'Minimo', 'Maximo');
	}

	public function detallemovimientos()
	{
		return $this->hasMany(\App\Models\Detallemovimiento::class, 'IDProducto');
	}

	public function kardexes()
	{
		return $this->hasMany(\App\Models\Kardex::class, 'IDProducto');
	}

	public function stocks()
	{
		return $this->hasMany(\App\Models\Stock::class, 'IDProducto');
	}

	public function transferencia()
	{
		return $this->hasMany(\App\Models\Transferencium::class, 'IDProducto');
	}
}
