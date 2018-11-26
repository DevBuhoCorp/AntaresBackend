<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Nov 2018 16:13:59 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Item
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property float $Stock
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $detalleops
 *
 * @package App\Models
 */
class Item extends Eloquent
{
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'Stock' => 'float'
	];

	protected $fillable = [
		'Descripcion',
		'Stock',
		'Estado'
	];
}
