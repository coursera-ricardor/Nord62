<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApiTokenToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('api_token', 80)->after('password')
                    ->unique()
                    ->nullable()
                    ->default(null);
                    });

        // $updateApiUsers = DB::table('users')->whereNull('api_token')->update(array('api_token' => Str::random(60)));
        // Run Seeder instead
        //  php artisan db:seed --class=UsersApiTokenTableSeeder

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the Index
            $table->dropForeign('api_token');

            $table->dropColumn('api_token');
        });
    }
}
