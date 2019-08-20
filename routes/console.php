<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('seed:sellers {quantity}', function ($quantity) {

	$quantity = intval ($quantity);
	if ($quantity > 0) {
		$this->comment("Creating $quantity sellers.");
		factory(\App\Models\Seller::class, $quantity)
			->make ()
			->each(function($seller){
				$seller->save();
			});

		$this->info("Done.");

	} else {
		$this->error('Quantity must be greater than 0');
	}
});

Artisan::command('seed:orders {quantity}', function ($quantity) {

	$quantity = intval ($quantity);
	if ($quantity > 0) {
		$this->comment("Creating $quantity orders.");

		factory(\App\Models\Order::class, $quantity)
			->make ()
			->each(function($order){
				$order->save();
			});

		$this->info("Done.");

	} else {
		$this->error('Quantity must be greater than 0');
	}
});

Artisan::command('report:daily-billing', function () {
	$repository = new \App\Services\Repositories\SellerRepository;
	$repository->sendDailyReport ();
});
