<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 28 Dec 2018 15:11:05 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Modospago
 * 
 * @property int $ID
 * @property string $Etiqueta
 * @property string $Estado
 *
 * @package App\Models
 */
class Modospago extends Eloquent
{
	protected $table = 'modospago';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'Etiqueta',
		'Estado'
	];
}
