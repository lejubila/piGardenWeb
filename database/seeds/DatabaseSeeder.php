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
        /*
        $records = [
            [
                'name' => 'manage users'
            ],
            [
                'name' => 'manage articles'
            ],
            [
                'name' => 'manage customers'
            ],
        ];

        foreach($records as $r) {
            $p = new Permission($r);
            $p->save();
        }
        */


        $permissionManageUsers = new Permission(['name' => 'manage users']);
        $permissionManageUsers->save();
        /*
        $permissionManageArticles = new Permission(['name' => 'manage articles']);
        $permissionManageArticles->save();
        $permissionCustomers = new Permission(['name' => 'manage customers']);
        $permissionCustomers->save();
        */

        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo([
            $permissionManageUsers,
            //$permissionManageArticles,
            //$permissionCustomers,
        ]);

        /*
        $roleProduzione = Role::create(['name' => 'produzione']);
        $roleProduzione->givePermissionTo(
            $permissionManageArticles
        );

        $roleCommerciale = Role::create(['name' => 'commerciale']);
        $roleCommerciale->givePermissionTo(
            $permissionCustomers
        );
        */

    }

}
