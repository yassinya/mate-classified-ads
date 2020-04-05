<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['guard_name' => 'web', 'name' => 'user']);
        Role::create(['guard_name' => 'web', 'name' => 'admin']);
    }
}
