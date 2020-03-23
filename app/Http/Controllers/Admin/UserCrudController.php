<?php
/**
 * Created by PhpStorm.
 * User: david.bigagli
 * Date: 28/03/2019
 * Time: 18.33
 */

namespace App\Http\Controllers\Admin;

use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BackpackUserCrudController;


class UserCrudController extends BackpackUserCrudController
{

    public function setup() {

        parent::setup();

        if (
            !config('backpack.permissionmanager.allow_manage_user') &&
            !backpack_user()->hasPermissionTo('manage users')
        ) {

            $this->crud->denyAccess(['list', 'create', 'update', 'delete', 'view']);
        }

    }

}