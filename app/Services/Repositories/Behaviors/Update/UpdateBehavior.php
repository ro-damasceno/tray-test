<?php
namespace App\Services\Repositories\Behaviors\Update;

class UpdateBehavior extends \App\Services\Repositories\Behaviors\Base implements IUpdateBehavior {

	/**
	 * {@inheritdoc}
	 */
	public function update($id, array $attributes) {

		$model = $this->newQueryBuilder()->findOrFail ($id);

		$this->getRepository ()->onUpdating ($model, $attributes);
		$model->update ($attributes);

		return $model;
	}
}