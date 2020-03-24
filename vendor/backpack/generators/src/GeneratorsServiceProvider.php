<?php

namespace Backpack\Generators;

use Illuminate\Support\ServiceProvider;
use Backpack\Generators\Console\Commands\CrudBackpackCommand;
use Backpack\Generators\Console\Commands\ViewBackpackCommand;
use Backpack\Generators\Console\Commands\ModelBackpackCommand;
use Backpack\Generators\Console\Commands\ConfigBackpackCommand;
use Backpack\Generators\Console\Commands\RequestBackpackCommand;
use Backpack\Generators\Console\Commands\CrudModelBackpackCommand;
use Backpack\Generators\Console\Commands\CrudRequestBackpackCommand;
use Backpack\Generators\Console\Commands\CrudControllerBackpackCommand;

class GeneratorsServiceProvider extends ServiceProvider
{
    protected $commands = [
        ConfigBackpackCommand::class,
        CrudModelBackpackCommand::class,
        CrudControllerBackpackCommand::class,
        CrudRequestBackpackCommand::class,
        CrudBackpackCommand::class,
        ModelBackpackCommand::class,
        RequestBackpackCommand::class,
        ViewBackpackCommand::class,
    ];

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
