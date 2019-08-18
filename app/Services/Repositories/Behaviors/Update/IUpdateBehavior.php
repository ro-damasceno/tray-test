<?php
namespace App\Services\Repositories\Behaviors\Update;

interface IUpdateBehavior {

	/**
	 * Atualiza o item com o id fornecido.
	 *
	 * @param string | int $id
	 * @param array $attributes
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function update($id, array $attributes);
}