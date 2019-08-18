<?php
namespace App\Services\Repositories\Behaviors;



abstract class Base {

	/**
	 * @var \App\Services\Repositories\BaseRepository $repository
	 */
	protected $repository;

	/**
	 * Base constructor.
	 *
	 * @param \App\Services\Repositories\BaseRepository $repository
	 */
	public function __construct (\App\Services\Repositories\BaseRepository $repository) {
		$this->repository = $repository;
	}

	/**
	 * @return \App\Services\Repositories\BaseRepository
	 */
	public function getRepository (): \App\Services\Repositories\BaseRepository {
		return $this->repository;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	function newQueryBuilder () {
		return $this->getRepository ()->newQueryBuilder ();
	}
}