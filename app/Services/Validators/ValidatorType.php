<?php
namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;

abstract class ValidatorType {
	/**
	 * @param \Illuminate\Database\Eloquent\Model|null $model
	 * @param array $attributes
	 * @return mixed
	 */
	abstract function rules ($model = null, $attributes);

	/**
	 * @return array
	 */
	function messages () {
		return [
			'required' 	=> 'O atributo :attribute é obrigatório.',
			'email'    	=> 'O e-mail fornecido é inválido.',
			'unique'   	=> 'O :attribute :input já está em uso.',
			'gt'  	 	=> 'O atributo :attribute deve ser maior que :value',
			'numeric'	=> 'O atributo :attribute deve ser numérico'
		];
	}

	/**
	 * @return array
	 */
	function attributes () {
		return [
			'email' 	 => 'e-mail',
			'name'  	 => 'nome',
			'commission' => 'comissão'
		];
	}

	/**
	 * Valida os atributos fornecidos.
	 *
	 * @param array $attributes
	 * @param \Illuminate\Database\Eloquent\Model|null $model
	 * @return void
	 * @throws \Illuminate\Validation\ValidationException
	 */
	function validate ($attributes, $model = null) {

		/**
		 * @var \Illuminate\Validation\Validator $validator
		 */
		$validator = Validator::make($attributes, $this->rules ($model, $attributes), $this->messages (), $this->attributes ());
		$validator->validate();
	}
}