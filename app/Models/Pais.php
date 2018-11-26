<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Nov 2018 14:58:58 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Pai
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $ciudads
 *
 * @package App\Models
 */
class Pais extends Eloquent
{
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Descripcion',
		'Estado'
	];

	public function ciudads()
	{
		return $this->hasMany(\App\Models\Ciudad::class, 'IDPais');
	}
}
