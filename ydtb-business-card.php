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

$ydtbbc = new YDTBC\Providers\BusinessCardServiceProvider;
$ydtbbc->register();

add_action('init', [$ydtbbc, 'boot']);
