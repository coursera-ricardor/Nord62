<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /*
         * Projects
        */
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            /*
                General Project Information
            */
			$table->string('name');

            /*
                Geolocation information
            */
            $table->unsignedInteger('country_id')->nullable()->default(0); // Imported from table ISO (Location of the Profile)
			$table->string('country_code')->nullable()->default(''); // Imported from table ISO (Location of the Profile)
			$table->string('country')->nullable()->default(''); // Imported from table ISO (Location of the Profile)

			/** 			 	
				Log information
                Model needs to be reviewed to achieve this behavior
				
			*/
			// if (Schema::hasTable('profiles')) {
				$table->bigInteger('owner_id');
				$table->bigInteger('updated_id');
			// }

            // Status
            //  A-ctive P-rotected  B-locked R-estricted F-inished ...
            //  @todo: Create the Project Administration Module and define the Status of the Projects
			$table->string('status',1);

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

        if (Schema::hasTable('profile_project')) {
            /*
                SqLite does NOT allow to remove the Foreign Keys
            */
            switch(config('database.default')) {
                case 'sqlite' :
                    break;
                default:
                    Schema::table('profile_project', function( Blueprint $table){
                        $table->dropForeign(['project_id']);
                    });        
                    break;
            }
        }

        /*
            SqLite does NOT allow to remove the Foreign Keys.
            If Projects are related to foreign Keys the DROP will Fail
        */
        try {        
            Schema::dropIfExists('projects');
        } catch (Illuminate\Database\QueryException $ex) {
              echo $ex->getMessage() . "\n";
        }

    }
}
