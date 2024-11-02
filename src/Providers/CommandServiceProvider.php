<?php

namespace YDTBLIB\Providers;

use YDTBLIB\Commands\BusinessCardCommand;
use YDTBLIB\Interfaces\Provider;

class CommandServiceProvider implements Provider
{
    public function register()
    {
        if (!defined('WP_CLI') || !WP_CLI) {
            return;
        }

        \WP_CLI::add_command('plugin-name', BusinessCardCommand::class);
    }
}
