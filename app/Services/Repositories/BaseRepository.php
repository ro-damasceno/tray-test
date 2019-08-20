<?php
namespace App\Services\Repositories;

abstract class BaseRepository {

	/**
	 * @var Behaviors\Read\IReadBehavior $reader
	 */
	protected $reader;

	/**
	 * @var Behaviors\Create\ICreateBehavior $creator
	 */
	protected $creator;

	/**
	 * @var Behaviors\Update\IUpdateBehavior $updater
	 */
	protected $updater;

	/**
	 * @var Behaviors\Delete\IDeleteBehavior $deleter
	 */
	protected $deleter;

	/**
	 * BaseRepository constructor.
	 */
	public function __construct () {
		$this
			->registerReader ()
			->registerCreator ()
			->registerUpdater ()
			->registerDeleter ();
	}

	/**
	 * Retorna a construtor de queries do repositório.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	abstract function newQueryBuilder();

	/**
	 * Callback para manipular a busca.
	 *
	 * @param \Illuminate\Database\Query\Builder $query
	 * @param array $options
	 * @return void
	 */
	function onFinding ($query, $options) {}

	/**
	 * Callback para manipular a busca.
	 *
	 * @param \Illuminate\Database\Query\Builder $query
	 * @param array $options
	 * @return void
	 */
	function onFindingOne ($query, $options) {}

	/**
	 * Callback para manipular os atributos antes de criar um novo registro.
	 *
	 * @param array $attributes
	 * @return void
	 */
	function onCreating (&$attributes) {}

	/**
	 * Callback para manipular os atributos antes de atualizar uma model.
	 *
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @param array $attributes
	 * @return void
	 */
	function onUpdating ($model, &$attributes) {}

	/**
	 * Define o objeto responsável pela leitura de dados.
	 *
	 * @return static
	*/
	protected function registerReader() {
		$this->reader = new Behaviors\Read\ReadBehavior($this);
		return $this;
	}

	/**
	 * Define o objeto responsável pela criação de dados.
	 *
	 * @return static
	 */
	protected function registerCreator() {
		$this->creator = new Behaviors\Create\CreateBehavior($this);
		return $this;
	}

	/**
	 * Define o objeto responsável pela atualização de dados.
	 *
	 * @return static
	 */
	protected function registerUpdater() {
		$this->updater = new Behaviors\Update\UpdateBehavior($this);
		return $this;
	}

	/**
	 * Define o objeto responsável pela exclusão de dados.
	 *
	 * @return static
	 */
	protected function registerDeleter() {
		$this->deleter = new Behaviors\Delete\DeleteBehavior($this);
		return $this;
	}

	/**
	 * @return Behaviors\Read\IReadBehavior
	 */
	public function getReader (): Behaviors\Read\IReadBehavior {
		return $this->reader;
	}

	/**
	 * @return Behaviors\Create\ICreateBehavior
	 */
	public function getCreator (): Behaviors\Create\ICreateBehavior {
		return $this->creator;
	}

	/**
	 * @return Behaviors\Update\IUpdateBehavior
	 */
	public function getUpdater (): Behaviors\Update\IUpdateBehavior {
		return $this->updater;
	}

	/**
	 * @return Behaviors\Delete\IDeleteBehavior
	 */
	public function getDeleter (): Behaviors\Delete\IDeleteBehavior {
		return $this->deleter;
	}

	/**
	 * {@inheritdoc}
	 */
	function find ($queries = null, $paginate = false, $paginationOptions = []) {
		return $this->getReader ()->find ($queries, $paginate, $paginationOptions);
	}

	/**
	 * {@inheritdoc}
	 */
	function findOne ($id, array $options = []) {
		return $this->getReader ()->findOne ($id, $options);
	}

	/**
	 * {@inheritdoc}
	 */
	function findOrFail ($id, array $options = []) {
		return $this->getReader ()->findOrFail ($id, $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function create (array $attributes) {
		return $this->getCreator ()->create ($attributes);
	}

	/**
	 * {@inheritdoc}
	 */
	public function update ($id, array $attributes) {
		return $this->getUpdater ()->update ($id, $attributes);
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete ($id) {
		return $this->getDeleter ()->delete ($id);
	}
}