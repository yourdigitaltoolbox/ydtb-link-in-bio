<?php

namespace YDTBLIB;

use YDTBLIB\Interfaces\Provider;
use YDTBLIB\Providers\ApiServiceProvider;
use YDTBLIB\Providers\CommandServiceProvider;
use YDTBLIB\Providers\SettingsServiceProvider;
use YDTBLIB\Providers\Actions\ProfileTab;

class Plugin implements Provider
{

    public function __construct()
    {
        add_action('init', [$this, 'boot']);
    }

    public function boot()
    {
        //
    }

    protected function providers()
    {
        return [
            ApiServiceProvider::class,
            CommandServiceProvider::class,
            SettingsServiceProvider::class,
            ProfileTab::class,
        ];
    }

    public function register()
    {
        foreach ($this->providers() as $service) {
            (new $service)->register();
        }
    }

}
