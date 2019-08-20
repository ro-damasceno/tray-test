<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SoftDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('sellers', function (Blueprint $table) {
			$table->dateTime('deleted_at')->nullable ();
		});

		Schema::table('orders', function (Blueprint $table) {
			$table->dateTime('deleted_at')->nullable ();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

		Schema::table('orders', function (Blueprint $table) {
			$table->dropColumn('deleted_at');
		});

		Schema::table('orders', function (Blueprint $table) {
			$table->dropColumn('deleted_at');
		});
    }
}
