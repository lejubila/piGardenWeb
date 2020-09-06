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
            !backpack_user()->hasPermissionTo('manage users', backpack_guard_name())
        ) {

            $this->crud->denyAccess(['list', 'create', 'update', 'delete', 'view']);
        }

        $this->crud->addField([
            'name' => 'api_token',
            'type' => 'text',
            'attributes' => [
                'readonly' => 'readonly'
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ])->afterField('password_confirmation');

        $this->crud->addField([
            'name' => 'action_api_token',
            'type' => 'select_from_array',
            'options' => [
                '' => '',
                'remove_token' => __('Remove token'),
                'regenerate_token' => __('Generate new token'),
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ])->afterField('api_token');

    }

}
