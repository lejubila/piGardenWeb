<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Models used in the User, Role and Permission CRUDs.
    |
    */

    'models' => [
        'user'       => App\Models\BackpackUser::class,
        'permission' => Backpack\PermissionManager\app\Models\Permission::class,
        'role'       => Backpack\PermissionManager\app\Models\Role::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Disallow the user interface for creating/updating permissions or roles.
    |--------------------------------------------------------------------------
    | Roles and permissions are used in code by their name
    | - ex: $user->hasPermissionTo('edit articles');
    |
    | So after the developer has entered all permissions and roles, the administrator should either:
    | - not have access to the panels
    | or
    | - creating and updating should be disabled
    */

    'allow_permission_create' => env('ALLOW_MANAGE_ROLE_AND_PERMISSION', false),
    'allow_permission_update' => env('ALLOW_MANAGE_ROLE_AND_PERMISSION', false),
    'allow_permission_delete' => env('ALLOW_MANAGE_ROLE_AND_PERMISSION', false),
    'allow_role_create'       => env('ALLOW_MANAGE_ROLE_AND_PERMISSION', false),
    'allow_role_update'       => env('ALLOW_MANAGE_ROLE_AND_PERMISSION', false),
    'allow_role_delete'       => env('ALLOW_MANAGE_ROLE_AND_PERMISSION', false),

    'allow_manage_user'       => env('ALLOW_MANAGE_USER', false),

    /*
    |--------------------------------------------------------------------------
    | Multiple-guards functionality
    |--------------------------------------------------------------------------
    |
    */
    'multiple_guards' => false,

];
