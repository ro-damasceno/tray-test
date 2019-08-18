<?php
namespace App\Services\Repositories;

use App\Models\Seller;
use App\Services\Validators\SellerValidator;

class SellerRepository extends BaseRepository {

	/**
	 * @var SellerValidator $validator
	*/
	private $validator;

	/**
	 * SellerRepository constructor.
	 */
	public function __construct () {
		parent::__construct ();

		$this->getReader ()
			->setFindableAttributes ('name', 'email')
			->setSortableAttributes ('name', 'email');

		$this->validator = new SellerValidator();
	}

	/**
	 * {@inheritdoc}
	 */
	function newQueryBuilder () {
		return Seller::query ();
	}

	/**
	 * {@inheritdoc}
	 */
	function onFinding ($query, $options) {
		$query
			->select (['*'])
			->selectSub ("SELECT SUM(commission) FROM orders WHERE orders.seller_id = sellers.id", 'commissions');
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