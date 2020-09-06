<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    CRUD::resource('icon', 'IconCrudController');
    CRUD::resource('log', 'LogCrudController');

}); // this should be the absolute last line of this file

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Auth',
], function () { // custom admin routes

    Route::get('account-api-token', 'MyAccountController@getApiTokenForm')->name('backpack.account.api_token');
    Route::post('account-api-token', 'MyAccountController@postApiTokenForm');

}); // this should be the absolute last line of this file


Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\PiGardenBase',
], function () { // custom admin routes

    Route::get('dashboard', [
        'uses' => 'PiGardenAdminController@getDashboard',
        'as' => 'admin.dashboard'
    ]);
    Route::get('/', function () {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(config('backpack.base.route_prefix').'/dashboard');
    });

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

    Route::get('zone/all_enable_cron', [
        'uses' => 'PiGardenAdminController@getZoneAllCronEnable',
        'as' => 'zone.all_enable_cron'
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


}); // this should be the absolute last line of this file
