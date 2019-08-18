<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * Retorna as opções de filtro e ordenação.
	 *
	 * @param array $inputs
	 * @return array
	 */
	protected function getQueries($inputs = []) {

		$fields = ['q', 'sort', 'sort_direction', 'columns'];

		if (is_array ($inputs) && count ($inputs)) {
			$fields = array_merge ($fields, $inputs);
		}

		return request ()->only($fields);
	}

	/**
	 * Retorna as opções de paginação.
	 *
	 * @return array
	 */
	protected function getPaginationOptions () {
		return request ()->only(['page', 'per_page']);
	}

	protected function getErrorMessage (\Throwable $exception) {
		return App::environment('production') ? 'Ops! Ocorreu um erro inesperado' : $exception->getMessage ();
	}
}
