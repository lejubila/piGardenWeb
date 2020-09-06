<?php

namespace App\Http\Controllers\Admin;

use App\PiGardenSocketClient;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\IconRequest as StoreRequest;
use App\Http\Requests\IconRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Prologue\Alerts\Facades\Alert;

/**
 * Class IconCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class IconCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Icon');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/icon');
        $this->crud->setEntityNameStrings('icon', 'icons');

        if (!backpack_user()->hasPermissionTo('manage setup', backpack_guard_name()))
            $this->crud->denyAccess(['list', 'create', 'update', 'delete', 'view']);

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();
        $this->crud->addColumns([
            [
                'name' => 'zone',
                'label' => trans('pigarden.zone'),
                'type' => 'text',
            ],
            [
                'name' => 'enabled',
                'label' => trans('pigarden.enabled'),
                'type' => 'check',
            ],
            [
                'name' => 'icon_close',
                'label' => trans('pigarden.icon.close'),
                'type' => 'image',
                'prefix' => asset('/'),
                'width' => '100px',
                'height' => 'auto',
            ],
            [
                'name' => 'icon_open',
                'label' => trans('pigarden.icon.open'),
                'type' => 'image',
                'prefix' => asset('/'),
                'width' => '100px',
                'height' => 'auto',
            ],

        ]);

        $aliases = [];
        try {
            $client = new PiGardenSocketClient();
            $status = $client->getStatus();
            foreach ($status->zones as $z) {
                $aliases[$z->name] = $z->name;
            }
            //dd($status);
        } catch (\Exception $e) {
            Alert::error($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
            //$this->data['error'] = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }

        $this->crud->addFields([
            [
                'name' => 'zone',
                'label' => trans('pigarden.zone'),
                'type' => 'select_from_array',
                'allow_null' => true,
                'options' => $aliases,
                'default' => '',
            ],
            [
                'name' => 'enabled',
                'label' => trans('pigarden.enabled'),
                'type' => 'checkbox',
            ],
            [
                'name' => 'icon_close',
                'label' => trans('pigarden.icon.close'),
                'type' => 'browse',
            ],
            [
                'name' => 'icon_open',
                'label' => trans('pigarden.icon.open'),
                'type' => 'browse',
            ],

        ]);

        // add asterisk for fields that are required in IconRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
