<?php

namespace App\Http\Controllers\Admin;

use App\Models\Log;
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
class LogCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Log');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/log');
        $this->crud->setEntityNameStrings('log', 'logs');

        $this->crud->denyAccess(['create', 'update']);

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addClause('orderBy', 'datetime_log', 'desc');

        $this->crud->enableBulkActions();
        $this->crud->addBulkDeleteButton();

        $this->crud->addButtonFromView('top', 'table_refresh', 'table_refresh', 'beginning');
        $this->crud->removeButton('delete');

        $this->crud->disableResponsiveTable();


        // Filtro per data
        $this->crud->addFilter([
            'type' => 'date_range',
            'name' => 'datetime_log',
            'label'=> __("Log date time"),
            'date_range_options' => [ // options sent to daterangepicker.js
                'locale' => ['format' => 'DD/MM/YYYY HH:mm']
            ]
        ],
            false,
            function($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'datetime_log', '>=', $dates->from);
                $this->crud->addClause('where', 'datetime_log', '<=', $dates->to.' 23:59:59');
            }
        );

        $this->crud->addFilter([ // select2_multiple filter
            'name' => 'status',
            'type' => 'select2_multiple',
            'label'=> __("Type"),
        ], function() {
            return Log::pluck('type', 'type')->toArray();
        }, function($values) { // if the filter is active
            $in = [];
            foreach (json_decode($values) as $key => $value) {
                $in[] = $value;
            }
            $this->crud->addClause('whereIn', 'type', $in);
        });

        $this->crud->addFilter([ // select2_multiple filter
            'name' => 'level',
            'type' => 'select2_multiple',
            'label'=> __("Level"),
        ], function() {
            return Log::pluck('level', 'level')->toArray();
        }, function($values) { // if the filter is active
            $in = [];
            foreach (json_decode($values) as $key => $value) {
                $in[] = $value;
            }
            $this->crud->addClause('whereIn', 'level', $in);
        });

        $this->crud->addFilter([ // select2_multiple filter
            'name' => 'client_ip',
            'type' => 'select2_multiple',
            'label'=> __("Client ip"),
        ], function() {
            return Log::pluck('client_ip', 'client_ip')->toArray();
        }, function($values) { // if the filter is active
            $in = [];
            foreach (json_decode($values) as $key => $value) {
                $in[] = $value;
            }
            $this->crud->addClause('whereIn', 'client_ip', $in);
        });


        $this->crud->addColumns([
            [
                'name' => 'message',
                'label' => "Log",
                'type' => 'textarea',
            ],
            [
                'name' => 'type',
                'label' => __("Type"),
                'type' => 'text',
            ],
            [
                'name' => 'level',
                'label' => __("Level"),
                'type' => 'text',
            ],
            [
                'name' => 'datetime_log',
                'label' => __("Log date time"),
                'type' => 'text',
            ],
            [
                'name' => 'client_ip',
                'label' => __('Client ip'),
                'type' => 'text',
            ],

        ]);

    }

}
