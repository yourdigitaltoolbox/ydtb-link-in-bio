<?php

use YDTBLIB\Utils\BuddyBossPlatformCheck;
/**
 * Plugin Name: BuddyBoss Member Link-In-Bio
 * Plugin URI:  https://yourdigitaltoolbox.com/
 * Description: Allow members to create a custom link-in-bio page with their profile links.
 * Author:      John Kraczek
 * Author URI:  https://yourdigitaltoolbox.com/
 * Version:     0.0.1
 * Text Domain: ydtb-link-in-bio
 * Domain Path: /languages/
 * License:     GPLv3 or later (license.txt)
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Require BuddyBoss Platform
 */
if (!BuddyBossPlatformCheck::check()) {
    return;
}

if (!defined('YDTBLIB_PLUGIN_FILE')) {
    define('YDTBLIB_PLUGIN_FILE', __FILE__);
}

$ydtb_lib = new YDTBLIB\Plugin();
$ydtb_lib->register();
