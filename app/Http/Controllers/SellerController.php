<?php

namespace App\Http\Controllers;

use App\Services\Repositories\SellerRepository;

class SellerController extends Controller {

	/**
	 * @var SellerRepository $repository
	 */
	private $repository;

	/**
	 * OrderController constructor.
	 */
	public function __construct () {
		$this->repository = new SellerRepository();
	}

	function index () {
		$sellers = $this->repository->find ($this->getQueries (), true, $this->getPaginationOptions ());
		return response($sellers);
	}

	function show ($id) {
		try {
			$seller = $this->repository->findOrFail ($id);
			return response($seller);

		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			return response(['error' => 'Vendedor não encontrado'], 404);

		} catch (\Exception $exception) {
			return response(['error' => $this->getErrorMessage($exception)], 500);
		}
	}

	function store () {

		try {
			$seller = $this->repository->create (request ()->all ());
			return response($seller, 201);

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
			$seller = $this->repository->update ($id, request ()->all ());
			return response($seller);

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
			return response(['error' => 'Vendedor não encontrado'], 404);

		} catch (\Exception $exception) {
			return response(['error' => $this->getErrorMessage($exception)], 500);
		}
	}
}