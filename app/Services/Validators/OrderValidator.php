<?php
namespace App\Services\Validators;

class OrderValidator extends ValidatorType {

	/**
	 * {@inheritdoc}
	 */
	function rules ($model = null, $attributes) {
		$rules = [
			'total' => 'required|numeric|gt:0'
		];

		if (!$model || isset($attributes['seller_id'])) {
			$rules['seller_id'] = 'required|exists:sellers,id';
		}

		return $rules;
	}
}