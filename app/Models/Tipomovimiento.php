<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Nov 2018 19:33:33 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Tipomovimiento
 * 
 * @property int $ID
 * @property string $Descripcion
 * @property string $Observacion
 * @property string $Estado
 * @property string $Tipo
 *
 * @package App\Models
 */
class Tipomovimiento extends Eloquent
{
	protected $table = 'tipomovimiento';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Descripcion',
		'Observacion',
		'Estado',
		'Tipo'
	];
}
