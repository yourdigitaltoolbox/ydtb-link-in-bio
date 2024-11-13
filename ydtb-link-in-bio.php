<?php

/**
 * Plugin Name: BuddyBoss Member Link-In-Bio
 * Plugin URI:  https://yourdigitaltoolbox.com/
 * Description: Allow members to create a custom link-in-bio page with their profile links.
 * Author:      John Kraczek
 * Author URI:  https://yourdigitaltoolbox.com/
 * Version:     0.0.3
 * Text Domain: ydtb-link-in-bio
 * Domain Path: /languages/
 * License:     GPLv3 or later (license.txt)
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// check if the vendor directory exists, and load it if it does
// This is the only check that must be done outside of the composer autoloaded classes.

$autoload = __DIR__ . '/vendor/autoload.php';

if (!file_exists(filename: $autoload)) {
    add_action(hook_name: 'admin_notices', callback: function (): void {
        $message = __(text: 'Link In Bio was downloaded from source and has not been built. Please run `composer install` inside the plugin directory <br> OR <br> install a released version of the plugin which will have already been built.', domain: 'ydtb-link-in-bio');
        echo '<div class="notice notice-error">';
        echo '<p>' . $message . '</p>';
        echo '</div>';
    });
    return false;
}

require_once $autoload;

use YDTBLIB\Plugin;

// Load the plugin
new Plugin();