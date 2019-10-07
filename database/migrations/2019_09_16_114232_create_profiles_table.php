<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');

			/*
                Link field to users Table
                It is important to create the migration of the Users table before the Profile
                to be able to create the link.
                The Model needs to be reviewed
            */
			$table->bigInteger('user_id')->unique();
			if (Schema::hasTable('users')) {
                // Foreign Key
				$table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade'); // If the user is Deleted the Profile Record Needs to be Deleted
			}

            /*
                Personal information
            */
			$table->string('name');
			$table->string('first_name')->nullable()->default('');
			$table->string('last_name')->nullable()->default('');
			$table->string('email'); // Imported from users
			
            /*
                Personal configuration
            */
            $table->unsignedInteger('language_id')->nullable()->default(0); // Preferred language code to display texts
			$table->string('language_code',2)->nullable()->default('en'); // Preferred language code to display texts
			$table->string('language',80)->nullable()->default('English'); // Preferred language code to display texts

            /*
                Geolocation information
            */
            $table->unsignedInteger('country_id')->nullable()->default(0); // Imported from table ISO (Location of the Profile)
			$table->string('country_code')->nullable()->default(''); // Imported from table ISO (Location of the Profile)
			$table->string('country')->nullable()->default(''); // Imported from table ISO (Location of the Profile)

			// TODO: Address generic
			// if (Schema::hasTable('states')) {  // for future implementation
				$table->string('state_id')->nullable()->default(0);
				$table->string('state_code')->nullable()->default('');
			// }			
			$table->string('state')->nullable()->default('');
			$table->string('zip_code',12)->nullable()->default('');
			$table->string('street')->nullable()->default(''); 
			$table->string('street_number',25)->nullable()->default(''); 
			$table->string('city')->nullable()->default('');

            $table->double('latitude')->nullable()->default(0);  // Used with longitude to specify a precise geolocation
            $table->double('longitude')->nullable()->default(0); // Used with llatitude to specify a precise geolocation


			/** 
			 	
				Log information
                Model needs to be reviewed to achieve this behavior
				
			*/
			if (Schema::hasTable('users')) {
				$table->bigInteger('owner_id');
				$table->bigInteger('updated_id');
			}

            // Status
            //  A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
            //  @todo: sync with users table
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
        /*
            SqLite does NOT allow to remove the Foreign Keys
        */
        switch(config('database.default')) {
            case 'sqlite' :
                break;
            default:
                Schema::table('profiles', function( Blueprint $table){
                    $table->dropForeign(['user_id']);
                });        
                break;
        }

        Schema::dropIfExists('profiles');
    }
}
