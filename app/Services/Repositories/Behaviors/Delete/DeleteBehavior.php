<?php
namespace App\Services\Repositories\Behaviors\Delete;

class DeleteBehavior extends \App\Services\Repositories\Behaviors\Base implements IDeleteBehavior {

	/**
	 * {@inheritdoc}
	 */
	public function delete($id) {
		return $this->newQueryBuilder ()->findOrFail ($id)->delete();
	}
}