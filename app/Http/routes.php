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

    Route::get('/jsonDashboardStatus/{extra_parameter?}', [
        'as' => 'get.json.dashboard.status',
        'uses' => 'PiGardenPublicController@getJsonDashboardStatus',
        'extra_parameter' => '(^$|get_cron_open_in)'
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

        Route::get('zone/play_in/{zone}/{start}/{length}/{force?}', [
            'uses' => 'PiGardenAdminController@getZonePlayIn',
            'as' => 'zone.play_in'
        ])->where([
            'start' => '[0-9]+',
            'length' => '[0-9]+',
            'force' => '(^$|force)'
        ]);

        Route::get('zone/play_in_cancel/{zone}', [
            'uses' => 'PiGardenAdminController@getZonePlayInCancel',
            'as' => 'zone.play_in_cancel'
        ]);

        Route::get('zone/pause/{zone}', [
            'uses' => 'PiGardenAdminController@getZonePause',
            'as' => 'zone.pause'
        ]);

        Route::get('zone/all_stop/{disable_scheduling?}', [
            'uses' => 'PiGardenAdminController@getZoneAllStop',
            'as' => 'zone.all_stop'
        ])->where([
            'disable_scheduling' => '(^$|disable_scheduling)'
        ]);

        Route::get('reboot', [
            'uses' => 'PiGardenAdminController@getReboot',
            'as' => 'reboot'
        ]);
        Route::get('poweroff', [
            'uses' => 'PiGardenAdminController@getPoweroff',
            'as' => 'poweroff'
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

