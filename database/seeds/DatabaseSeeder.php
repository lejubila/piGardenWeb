<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Backpack\PermissionManager\app\Models\Permission;
use Backpack\PermissionManager\app\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $roleAdmin = Role::findOrCreate('admin', backpack_guard_name());

        $permissionManageUsers = Permission::findOrCreate('manage users', backpack_guard_name());
        $permissionStartStopZones = Permission::findOrCreate('start stop zones', backpack_guard_name());
        $permissionManageCronZone = Permission::findOrCreate('manage cron zones', backpack_guard_name());
        $permissionManageSetup = Permission::findOrCreate('manage setup', backpack_guard_name());
        $permissionShutdownRestart = Permission::findOrCreate('shutdown restart', backpack_guard_name());
        $permissionApiLog = Permission::findOrCreate('api log', backpack_guard_name());

        $roleAdmin->givePermissionTo([
            $permissionManageUsers,
            $permissionStartStopZones,
            $permissionManageCronZone,
            $permissionManageSetup,
            $permissionShutdownRestart,
            $permissionApiLog,
        ]);

    }

}
