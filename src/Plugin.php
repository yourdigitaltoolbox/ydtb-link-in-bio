<?php

namespace YDTBLIB;

use YDTBLIB\Interfaces\Provider;
use YDTBLIB\Providers\ApiServiceProvider;
use YDTBLIB\Providers\CommandServiceProvider;
use YDTBLIB\Providers\SettingsServiceProvider;
use YDTBLIB\Views\ProfileTab;

use YDTBLIB\Utils\BuddyBossPlatformCheck;
use YDTBLIB\Utils\Updater;

class Plugin implements Provider
{

    public function __construct()
    {
        if (!$this->plugin_checks()) {
            return;
        }
        $this->register();
    }

    public function plugin_checks()
    {
        return BuddyBossPlatformCheck::check();
    }

    protected function providers()
    {
        return [
            ApiServiceProvider::class,
            CommandServiceProvider::class,
            SettingsServiceProvider::class,
            ProfileTab::class,
            Updater::class
        ];
    }

    public function register()
    {
        foreach ($this->providers() as $service) {
            (new $service)->register();
        }
    }

}
