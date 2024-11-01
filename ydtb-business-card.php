<?php
/**
 * Plugin Name:     BuddyBoss Profile Business Card
 * Plugin URI:      https://yourdigitaltoolbox.com/
 * Description:     A plugin to add a linktree style business card to the BuddyBoss profile.
 * Version:         0.0.1
 * Author:          John Kraczek
 * Author URI:      https://yourdigitaltoolbox.com/
 * License:         MIT License
 * Text Domain:     ydtb-business-card
 * Domain Path:     /resources/lang
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Require BuddyBoss Platform
 */
if (!defined('BP_PLATFORM_VERSION')) {
    add_action('admin_notices', 'YDTBC_Platform_install_bb_platform_notice');
    add_action('network_admin_notices', 'YDTBC_Platform_install_bb_platform_notice');
    return;
}

function YDTBC_Platform_install_bb_platform_notice()
{
    echo '<div class="error fade"><p>';
    _e('<strong>YDTB Business Card</strong></a> requires the BuddyBoss Platform plugin to work. Please <a href="https://buddyboss.com/platform/" target="_blank">install BuddyBoss Platform</a> first.', 'ydtb');
    echo '</p></div>';
}

$ydtbbc = new YDTBC\Providers\BusinessCardServiceProvider;
$ydtbbc->register();

add_action('init', [$ydtbbc, 'boot']);
