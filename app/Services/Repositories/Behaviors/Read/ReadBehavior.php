<?php
namespace App\Services\Repositories\Behaviors\Read;


class ReadBehavior extends \App\Services\Repositories\Behaviors\Base implements IReadBehavior {

	use Concerns\HasPagination,
		Concerns\HasQueries;

	/**
	 * {@inheritdoc}
	 */
	function find($queries = null, $paginate = false, $paginationOptions = []) {

		$query = $this->newQueryBuilder();

		$this->applyQueries ($query, $queries);
		$this->getRepository ()->onFinding ($query, $queries);

		if ($paginate) {
			return $this->paginate ($query, $paginationOptions);
		}

		return $query->get ();
	}

	/**
	 * {@inheritdoc}
	 */
	function findOne($id, array $options = []) {
		return $this->newQueryBuilder ()->find ($id);
	}

	/**
	 * {@inheritdoc}
	 */
	function findOrFail($id, array $options = []) {
		return $this->newQueryBuilder ()->findOrFail ($id);
	}
}