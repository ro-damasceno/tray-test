<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_reports', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('reportable_id');
			$table->string('reportable_name');
			$table->enum('name', ['daily_billing']);
			$table->string('ref');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_reports');
    }
}
