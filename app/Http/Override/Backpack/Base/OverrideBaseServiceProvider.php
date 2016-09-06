<?php

namespace App\Http\Override\Backpack\Base;

use Backpack\Base;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Route;

class OverrideBaseServiceProvider extends \Backpack\Base\BaseServiceProvider
{

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // register the 'admin' middleware
        $router->middleware('admin', \Backpack\Base\app\Http\Middleware\Admin::class);

        $router->group(['namespace' => 'Backpack\Base\app\Http\Controllers'], function ($router) {
            Route::group(['middleware' => 'web', 'prefix' => config('backpack.base.route_prefix')], function () {

                // if not otherwise configured, setup the auth routes
                if (config('backpack.base.setup_auth_routes')) {
                    Route::auth();
                }

                // if not otherwise configured, setup the dashboard routes
                /*
                if (config('backpack.base.setup_dashboard_routes')) {
                    Route::get('dashboard', 'AdminController@dashboard');
                    Route::get('/', function () {
                        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
                        return redirect(config('backpack.base.route_prefix').'/dashboard');
                    });
                }
                */
            });
        });
    }

}
