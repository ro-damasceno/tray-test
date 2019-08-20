<?php

namespace App\Http\Controllers;

use App\Services\Repositories\OrderRepository;

class OrderController extends Controller {

	/**
	 * @var OrderRepository $repository
	*/
	private $repository;

	/**
	 * OrderController constructor.
	 */
	public function __construct () {
		$this->repository = new OrderRepository;
	}

	function index () {
		$orders = $this->repository->find ($this->getQueries (['seller_id']), true, $this->getPaginationOptions ());
		return response($orders);
	}

	function show ($id) {
		try {
			$order = $this->repository->findOrFail ($id);
			return response($order);

		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			return response(['error' => 'Pedido não encontrado'], 404);

		} catch (\Exception $exception) {
			return response(['error' => $this->getErrorMessage($exception)], 500);
		}
	}

	function store () {

		try {
			$order = $this->repository->create (request ()->all ());
			return response($order, 201);

		} catch (\Illuminate\Validation\ValidationException $exception) {
			return response([
				'error' => 'Os dados fornecidos contém erros',
				'fails' => $exception->errors ()
			], 400);

		} catch (\Exception $exception) {
			return response(['error' => $this->getErrorMessage($exception)], 500);
		}
	}

	function update ($id) {

		try {
			$order = $this->repository->update ($id, request ()->all ());
			return response($order);

		} catch (\Illuminate\Validation\ValidationException $exception) {

			return response([
				'error' => 'Os dados fornecidos contém erros',
				'fails' => $exception->errors ()
			], 400);

		} catch (\Exception $exception) {
			return response(['error' => $this->getErrorMessage($exception)], 500);
		}

	}

	function destroy ($id) {

		try {
			$this->repository->delete ($id);
			return response([], 204);

		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			return response(['error' => 'Pedido não encontrado'], 404);

		} catch (\Exception $exception) {
			return response(['error' => $this->getErrorMessage($exception)], 500);
		}
	}
}