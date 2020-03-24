<?php

namespace Backpack\CRUD;

use Route;

class CrudRouter
{
    protected $extraRoutes = [];

    protected $name = null;
    protected $options = null;
    protected $controller = null;

    public function __construct($name, $controller, $options)
    {
        $this->name = $name;
        $this->controller = $controller;
        $this->options = $options;

        // CRUD routes for core features
        Route::post($this->name.'/search', [
            'as' => 'crud.'.$this->name.'.search',
            'uses' => $this->controller.'@search',
        ]);

        Route::delete($this->name.'/bulk-delete', [
            'as' => 'crud.'.$this->name.'.bulkDelete',
            'uses' => $this->controller.'@bulkDelete',
        ]);

        Route::get($this->name.'/reorder', [
            'as' => 'crud.'.$this->name.'.reorder',
            'uses' => $this->controller.'@reorder',
        ]);

        Route::post($this->name.'/reorder', [
            'as' => 'crud.'.$this->name.'.save.reorder',
            'uses' => $this->controller.'@saveReorder',
        ]);

        Route::get($this->name.'/{id}/details', [
            'as' => 'crud.'.$this->name.'.showDetailsRow',
            'uses' => $this->controller.'@showDetailsRow',
        ]);

        Route::get($this->name.'/{id}/translate/{lang}', [
            'as' => 'crud.'.$this->name.'.translateItem',
            'uses' => $this->controller.'@translateItem',
        ]);

        Route::get($this->name.'/{id}/revisions', [
            'as' => 'crud.'.$this->name.'.listRevisions',
            'uses' => $this->controller.'@listRevisions',
        ]);

        Route::post($this->name.'/{id}/revisions/{revisionId}/restore', [
            'as' => 'crud.'.$this->name.'.restoreRevision',
            'uses' => $this->controller.'@restoreRevision',
        ]);

        Route::post($this->name.'/{id}/clone', [
            'as' => 'crud.'.$this->name.'.clone',
            'uses' => $this->controller.'@clone',
        ]);

        Route::post($this->name.'/bulk-clone', [
            'as' => 'crud.'.$this->name.'.bulkClone',
            'uses' => $this->controller.'@bulkClone',
        ]);
    }

    /**
     * The CRUD resource needs to be registered after all the other routes.
     */
    public function __destruct()
    {
        $options_with_default_route_names = array_merge([
            'names' => [
                'index'     => 'crud.'.$this->name.'.index',
                'create'    => 'crud.'.$this->name.'.create',
                'store'     => 'crud.'.$this->name.'.store',
                'edit'      => 'crud.'.$this->name.'.edit',
                'update'    => 'crud.'.$this->name.'.update',
                'show'      => 'crud.'.$this->name.'.show',
                'destroy'   => 'crud.'.$this->name.'.destroy',
            ],
        ], $this->options);

        Route::resource($this->name, $this->controller, $options_with_default_route_names);
    }

    /**
     * Call other methods in this class, that register extra routes.
     *
     * @param  [type] $injectables [description]
     * @return [type]              [description]
     */
    public function with($injectables)
    {
        if (is_string($injectables)) {
            $this->extraRoutes[] = 'with'.ucwords($injectables);
        } elseif (is_array($injectables)) {
            foreach ($injectables as $injectable) {
                $this->extraRoutes[] = 'with'.ucwords($injectable);
            }
        } else {
            $reflection = new \ReflectionFunction($injectables);

            if ($reflection->isClosure()) {
                $this->extraRoutes[] = $injectables;
            }
        }

        return $this->registerExtraRoutes();
    }

    /**
     * TODO
     * Give developers the ability to unregister a route.
     */
    // public function without($injectables) {}

    /**
     * Register the routes that were passed using the "with" syntax.
     */
    private function registerExtraRoutes()
    {
        foreach ($this->extraRoutes as $route) {
            if (is_string($route)) {
                $this->{$route}();
            } else {
                $route();
            }
        }
    }

    public function __call($method, $parameters = null)
    {
        if (method_exists($this, $method)) {
            $this->{$method}($parameters);
        }
    }
}
