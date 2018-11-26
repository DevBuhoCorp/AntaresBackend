<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Nov 2018 14:58:58 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Ciudad
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Estado
 * @property int $IDPais
 * 
 * @property \App\Models\Pais $pai
 *
 * @package App\Models
 */
class Ciudad extends Eloquent
{
	protected $table = 'ciudad';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IDPais' => 'int'
	];

	protected $fillable = [
		'Descripcion',
		'Estado',
		'IDPais'
	];

	public function pai()
	{
		return $this->belongsTo(\App\Models\Pais::class, 'IDPais');
	}
}
