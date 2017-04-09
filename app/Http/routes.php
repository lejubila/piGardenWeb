<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['namespace' => 'PiGardenBase'], function() {
    Route::get('/', [
        'uses' => 'PiGardenPublicController@getHome',
        'as' => 'home',
    ]);

    Route::get('/jsonDashboardStatus', [
        'as' => 'get.json.dashboard.status',
        'uses' => 'PiGardenPublicController@getJsonDashboardStatus',
    ]);

});

Route::group(['prefix' => config('backpack.base.route_prefix')], function () {

    // if not otherwise configured, setup the auth routes
    if (config('backpack.base.setup_auth_routes')) {
        Route::auth();
    }

    Route::group(['namespace' => 'PiGardenBase'], function(){
        // if not otherwise configured, setup the dashboard routes
        if (config('backpack.base.setup_dashboard_routes')) {
            Route::get('dashboard', [
                'uses' => 'PiGardenAdminController@getDashboard',
                'as' => 'admin.dashboard'
            ]);
            Route::get('/', function () {
                // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
                return redirect(config('backpack.base.route_prefix').'/dashboard');
            });
        }

        Route::get('zone/edit/{zone}',[
            'uses' => 'PiGardenAdminController@getZoneEdit',
            'as' => 'zone.edit'
        ]);

        Route::get('zone/play/{zone}/{force?}', [
            'uses' => 'PiGardenAdminController@getZonePlay',
            'as' => 'zone.play'
        ])->where('force', '(^$|force)');

        Route::get('zone/pause/{zone}', [
            'uses' => 'PiGardenAdminController@getZonePause',
            'as' => 'zone.pause'
        ]);

        Route::post('cron/put/{zone}', [
            'uses' => 'PiGardenAdminController@postCronPut',
            'as' => 'cron.put'
        ]);

        Route::get('initial_setup',[
            'uses' => 'PiGardenAdminController@getInitialSetup',
            'as' => 'initial_setup.get'
        ]);

        Route::post('initial_setup/post',[
            'uses' => 'PiGardenAdminController@postInitialSetup',
            'as' => 'initial_setup.post'
        ]);


        Route::get('prova', [
            'uses' => 'PiGardenAdminController@getProva',
            'as' => 'prova.get'
        ]);
        Route::post('prova', [
            'uses' => 'PiGardenAdminController@postProva',
            'as' => 'prova.post'
        ]);


    });

});

