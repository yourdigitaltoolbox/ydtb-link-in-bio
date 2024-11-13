<?php

namespace YDTBLIB\Providers;

use YDTBLIB\Interfaces\Provider;
use YDTBLIB\Views\Components\Tabs\BuddyBossIntegration;

class SettingsServiceProvider implements Provider
{
    public function register()
    {
        add_action('bp_setup_integrations', [$this, 'register_integration']);
    }

    public function register_integration()
    {
        buddypress()->integrations['addon'] = new BuddyBossIntegration();
    }
}
