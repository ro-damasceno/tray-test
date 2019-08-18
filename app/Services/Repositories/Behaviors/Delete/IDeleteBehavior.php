<?php
namespace App\Services\Repositories\Behaviors\Delete;

interface IDeleteBehavior{

	/**
	 * Delete o item com o id fornecido.
	 *
	 * @param int $id
	 * @return bool
	 * @throws \Exception
	 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function delete($id);
}