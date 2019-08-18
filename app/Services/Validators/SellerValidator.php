<?php
namespace App\Services\Validators;

use Illuminate\Validation\Rule;

class SellerValidator extends ValidatorType {

	/**
	 * {@inheritdoc}
	 */
	function rules ($model = null, $attributes) {

		$unique = Rule::unique ('sellers');

		if (!empty($model)){
			$unique->ignore($model->getKey());
		}

		return [
			'email' => ['required', 'email', $unique],
			'name'  => 'required|min:4'
		];
	}
}