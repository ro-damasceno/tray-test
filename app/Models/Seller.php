<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property \Illuminate\Support\Collection $orders
*/
class Seller extends Model {

	use SoftDeletes;

	protected $fillable = ['name', 'email'];

	/**
	 * Relacionamento entre o vendedor e seus pedidos.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	*/
	function orders () {
		return $this->hasMany (Order::class);
	}
}
