<?php
namespace App\Services\Repositories;

use App\Models\Order;
use App\Services\Validators\OrderValidator;

class OrderRepository extends BaseRepository {

	/**
	 * @var OrderValidator $validator
	 */
	private $validator;

	/**
	 * @var \App\Models\Seller $seller
	*/
	private static $seller;

	/**
	 * SellerRepository constructor.
	 */
	public function __construct () {
		parent::__construct ();

		$this->validator = new OrderValidator();

		$this->getReader ()
			->setSortableAttributes ('total', 'updated_at', 'created_at');
	}

	/**
	 * @param $seller
	 * @param \Closure $fn
	 * @return mixed
	 */
	static function ofSeller ($seller, \Closure $fn) {

		try {
			static::$seller = $seller;
			$res = $fn();

		} finally {
			static::$seller = null;
		}

		return $res;
	}

	/**
	 * {@inheritdoc}
	 */
	function newQueryBuilder () {
		return Order::query ();
	}

	/**
	 * {@inheritdoc}
	 * @throws \Illuminate\Validation\ValidationException
	 */
	function onCreating (&$attributes) {
		$this->validator->validate ($attributes);
	}

	/**
	 * {@inheritdoc}
	 * @throws \Illuminate\Validation\ValidationException
	 */
	function onUpdating ($model, &$attributes) {
		$this->validator->validate ($attributes, $model);
	}

	function onFinding ($query, $options) {
		if ($seller_id = $options['seller_id']??null) {
			$query->where('seller_id', $seller_id);
		}
	}
}