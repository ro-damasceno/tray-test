<?php
namespace App\Services\Repositories\Behaviors\Create;

interface ICreateBehavior {

	/**
	 * Cria um novo item.
	 *
	 * @param array $attributes
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function create(array $attributes);
}