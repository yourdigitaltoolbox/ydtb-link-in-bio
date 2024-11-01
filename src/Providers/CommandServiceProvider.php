<?php

namespace YDTBC\Providers;

use YDTBC\Commands\BusinessCardCommand;

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
