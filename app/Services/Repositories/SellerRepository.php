<?php
namespace App\Services\Repositories;

use App\Mail\DailyBillingReport;
use App\Models\Seller;
use App\Services\Validators\SellerValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SellerRepository extends BaseRepository {

	/**
	 * @var SellerValidator $validator
	*/
	private $validator;

	/**
	 * SellerRepository constructor.
	 */
	public function __construct () {
		parent::__construct ();

		$this->getReader ()
			->setFindableAttributes ('name', 'email')
			->setSortableAttributes ('name', 'email', 'updated_at', 'created_at');

		$this->validator = new SellerValidator();
	}

	/**
	 * {@inheritdoc}
	 */
	function newQueryBuilder () {
		return Seller::query ();
	}

	/**
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param array|null $range
	 */
	private function withCommission ($query, $range = null){

		$subQuery = DB::table ('orders')
			->selectRaw ('SUM(commission)')
			->whereNull ('deleted_at')
			->whereRaw('orders.seller_id = sellers.id');

		if (is_array ($range)) {
			if ($init = $range['init']) {
				$subQuery->whereRaw ("created_at >= '$init'");
			}
			if ($end = $range['end']) {
				$subQuery->whereRaw ("created_at <= '$end'");
			}
		}

		$query->selectSub ($subQuery->toSql (), 'commission');
	}

	/**
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param array|null $range
	 */
	private function withTotal ($query, $range = null){

		$subQuery = DB::table ('orders')
			->selectRaw ('SUM(total)')
			->whereNull ('deleted_at')
			->whereRaw('orders.seller_id = sellers.id');

		if (is_array ($range)) {
			if ($init = $range['init']) {
				$subQuery->whereRaw ("created_at >= '$init'");
			}
			if ($end = $range['end']) {
				$subQuery->whereRaw ("created_at <= '$end'");
			}
		}

		$query->selectSub ($subQuery->toSql (), 'total');
	}

	/**
	 * {@inheritdoc}
	 */
	function onFinding ($query, $options) {
		$query->select (['*']);
		$this->withCommission ($query);
	}

	/**
	 * {@inheritdoc}
	 */
	function onFindingOne ($query, $options) {
		$query->select (['*']);
		$this->withCommission ($query);
	}

	/**
	 * {@inheritdoc}
	 * @throws \Illuminate\Validation\ValidationException
	 */
	function onCreating (&$attributes) {
		$this->validator->validate ($attributes);
	}

	/**
	 * {@inheritdoc}
	 * @throws \Illuminate\Validation\ValidationException
	 */
	function onUpdating ($model, &$attributes) {
		$this->validator->validate ($attributes, $model);
	}

	/**
	 * Envia o relatório de faturamente diário aos vendedores.
	 *
	 * @return void
	 */
	function sendDailyReport () {

		$query = Seller::query ()
			->select (['*']);

		$today = now()->format ('Y-m-d');
		$range = [
			'init' => "$today 00:00:00",
			'end' => "$today 23:59:59",
		];

		$this->withCommission ($query, $range);
		$this->withTotal ($query, $range);

		$sellers = $query
			->whereNotExists(function($query) use($today){
				$query->select(DB::raw(1))
					->from('process_reports')
					->whereRaw('process_reports.reportable_id = sellers.id')
					->whereRaw('process_reports.reportable_name = "sellers"')
					->whereRaw('process_reports.name = "daily_billing"')
					->whereRaw('process_reports.ref = "'.$today.'"');
			})
			->get ();

		foreach ($sellers as $seller) {
			Mail::to($seller->email)
				->cc('r27.damasceno@gmail.com')
				->queue(new DailyBillingReport($seller->toArray()));
		}

		$arr = $sellers
			->pluck ('id')
			->map(function($id) use($today){
				return [
					'reportable_id'   => $id,
					'reportable_name' => 'sellers',
					'name' 		      => 'daily_billing',
					'ref'  			  => $today
				];
			})
			->toArray ();

		DB::table ('process_reports')->insert ($arr);
	}
}