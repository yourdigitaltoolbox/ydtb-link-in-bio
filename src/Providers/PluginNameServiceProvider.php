<?php

namespace YDTBC\Providers;

class BusinessCardServiceProvider implements Provider
{
    protected function providers()
    {
        return [
            ApiServiceProvider::class,
            BlockServiceProvider::class,
            CommandServiceProvider::class,
        ];
    }

    public function register()
    {
        foreach ($this->providers() as $service) {
            (new $service)->register();
        }
    }

    public function boot()
    {
        //
    }
}
