<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 27 Dec 2018 15:35:11 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Condicionespago
 * 
 * @property int $ID
 * @property string $Etiqueta
 * @property int $NDias
 * @property string $Estado
 *
 * @package App\Models
 */
class Condicionespago extends Eloquent
{
	protected $table = 'condicionespago';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'NDias' => 'int'
	];

	protected $fillable = [
		'Etiqueta',
		'NDias',
		'Estado'
	];
}
