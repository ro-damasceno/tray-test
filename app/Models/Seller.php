<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Illuminate\Support\Collection $orders
*/
class Seller extends Model {

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
