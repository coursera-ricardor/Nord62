<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');

		    $table->string('ccn3', 3)->unique();
		    $table->string('cca2', 2)->default('');
		    $table->string('cca3', 3)->default('');

		    $table->string('name', 255)->default('');
		    $table->string('full_name', 255)->nullable();
		    $table->string('capital', 255)->nullable();

		    $table->string('region_code', 3)->default('');
		    $table->string('region', 255)->default('');
		    $table->string('subregion_code', 3)->default('');
		    $table->string('subregion', 255)->default('');

		    $table->string('currency', 255)->nullable();
		    $table->string('currency_code', 5)->nullable();
		    $table->string('currency_sub_unit', 25)->nullable();
            $table->string('currency_symbol', 3)->nullable();
            $table->integer('currency_decimals')->nullable();
						
			/** 			 	
				Log information				
			*/
			$table->unsignedInteger('created_by');
			$table->unsignedInteger('last_update_by');

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
        Schema::dropIfExists('countries');
    }
}
