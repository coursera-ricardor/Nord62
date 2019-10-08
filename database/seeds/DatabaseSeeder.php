<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Spatie/Permissions
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);

        // make:auth
        $this->call(UsersTableSeeder::class);

        // Tests
        $this->call(ProfilesTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);

        // Many to Many relationships
        $this->call(ProfilesProjectsTableSeeder::class);

    }
}
