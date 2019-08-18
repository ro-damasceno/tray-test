<?php
namespace App\Services\Repositories\Behaviors\Create;

class CreateBehavior extends \App\Services\Repositories\Behaviors\Base implements ICreateBehavior {

	/**
	 * {@inheritdoc}
	 */
	public function create(array $attributes) {
		$this->getRepository ()->onCreating ($attributes);
		return $this->newQueryBuilder ()->create ($attributes);
	}
}