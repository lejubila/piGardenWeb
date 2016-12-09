<?php

namespace Backpack\CRUD;

use Illuminate\Support\ServiceProvider;
use Route;

class CrudServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // LOAD THE VIEWS

        // - first the published/overwritten views (in case they have any changes)
        $this->loadViewsFrom(resource_path('views/vendor/backpack/crud'), 'crud');
        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'crud');

        $this->loadTranslationsFrom(realpath(__DIR__.'/resources/lang'), 'backpack');


        // PUBLISH FILES

        // publish lang files
        $this->publishes([__DIR__.'/resources/lang' => resource_path('lang/vendor/backpack')], 'lang');

        // publish views
        $this->publishes([__DIR__.'/resources/views' => resource_path('views/vendor/backpack/crud')], 'views');

        // publish config file
        $this->publishes([__DIR__.'/config/backpack/crud.php' => resource_path('config/backpack/crud.php')], 'config');

        // publish public Backpack CRUD assets
        $this->publishes([__DIR__.'/public' => public_path('vendor/backpack')], 'public');

        // publish custom files for elFinder
        $this->publishes([
                            __DIR__.'/config/elfinder.php'      => config_path('elfinder.php'),
                            __DIR__.'/resources/views-elfinder' => resource_path('views/vendor/elfinder'),
                            ], 'elfinder');


        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(
            __DIR__.'/config/backpack/crud.php', 'backpack.crud'
        );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('CRUD', function ($app) {
            return new CRUD($app);
        });

        // register its dependencies
        $this->app->register(\Backpack\Base\BaseServiceProvider::class);
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        $this->app->register(\Barryvdh\Elfinder\ElfinderServiceProvider::class);

        // register their aliases
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('CRUD', \Backpack\CRUD\CrudServiceProvider::class);
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('Html', \Collective\Html\HtmlFacade::class);
    }

    public static function resource($name, $controller, array $options = [])
    {
        // CRUD routes
        Route::post($name.'/search', [
            'as' => 'crud.'.$name.'.search',
            'uses' => $controller.'@search',
          ]);
        Route::get($name.'/reorder', [
            'as' => 'crud.'.$name.'.reorder',
            'uses' => $controller.'@reorder',
          ]);
        Route::post($name.'/reorder', [
            'as' => 'crud.'.$name.'.save.reorder',
            'uses' => $controller.'@saveReorder',
          ]);
        Route::get($name.'/{id}/details', [
            'as' => 'crud.'.$name.'.showDetailsRow',
            'uses' => $controller.'@showDetailsRow',
          ]);
        Route::get($name.'/{id}/translate/{lang}', [
            'as' => 'crud.'.$name.'.translateItem',
            'uses' => $controller.'@translateItem',
          ]);

        $options_with_default_route_names = array_merge([
            'names' => [
                'index'     => 'crud.'.$name.'.index',
                'create'    => 'crud.'.$name.'.create',
                'store'     => 'crud.'.$name.'.store',
                'edit'      => 'crud.'.$name.'.edit',
                'update'    => 'crud.'.$name.'.update',
                'show'      => 'crud.'.$name.'.show',
                'destroy'   => 'crud.'.$name.'.destroy',
                ],
            ], $options);

        Route::resource($name, $controller, $options_with_default_route_names);
    }
}
