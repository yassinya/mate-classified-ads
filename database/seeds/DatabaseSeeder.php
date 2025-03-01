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
        $this->call(PermissionTablesSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
        // $this->call(RegionsTableSeeder::class);
        // $this->call(CitiesTableSeeder::class);
        $this->call(AdTypesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
    }
}
