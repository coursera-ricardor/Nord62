<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_project', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('project_id');

            if (Schema::hasTable('projects')) {
                // Foreign Key
                $table->foreign('project_id')
                    ->references('id')
                    ->on('projects');
                    // ->onDelete('cascade');
            }

            if (Schema::hasTable('profiles')) {
                $table->bigInteger('profile_id');
                // Foreign Key
                $table->foreign('profile_id')
                    ->references('id')
                    ->on('profiles');
                    // ->onDelete('cascade');
            }

			/** 			 	
				Log information
                Model needs to be reviewed to achieve this behavior
				
			*/
			// if (Schema::hasTable('profiles')) {
				$table->bigInteger('created_by');
				$table->bigInteger('updated_by');
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
        Schema::dropIfExists('profile_project');
    }
}
