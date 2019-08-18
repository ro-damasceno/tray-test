<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Seller $seller
 */
class Order extends Model {

	protected $fillable = ['total', 'commission', 'seller_id'];

	protected static function boot () {
		parent::boot ();

		static::saving (function(Order $order){
			//Calcula o valor da comissão
			$order->commission = $order->total * 0.085;
		});
	}

	/**
	 * Relacionamento entre a ordem e seu vendedor.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	function seller () {
		return $this->belongsTo (Seller::class);
	}

	/**
	 * Normaliza o valor total.
	 *
	 * @param $value
	 */
	function setTotalAttribute ($value) {
		$this->attributes['total'] = is_numeric ($value) ? number_format ($value, 2, '.', '') : 0;
	}

	/**
	 * Normaliza o valor da comissão.
	 *
	 * @param $value
	 */
	function setCommissionAttribute ($value) {
		$this->attributes['commission'] = is_numeric ($value) ? number_format ($value, 2, '.', '') : 0;
	}
}
