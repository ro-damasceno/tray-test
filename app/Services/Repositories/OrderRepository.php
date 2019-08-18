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
	 * SellerRepository constructor.
	 */
	public function __construct () {
		parent::__construct ();

		$this->validator = new OrderValidator();
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
}