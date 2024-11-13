<?php

namespace YDTBLIB\Views\Components\Tabs;

use YDTBLIB\Utils\Config;
use YDTBLIB\Views\Components\Tabs\BuddyBossAdminTab;

/**
 * BuddyBoss Compatibility Integration Class.
 *
 * @since BuddyBoss 1.1.5
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Setup the bp compatibility class.
 *
 * @since BuddyBoss 1.1.5
 */
class BuddyBossIntegration extends \BP_Integration
{

    public function __construct()
    {
        $this->start(
            'member-link-in-bio',
            __('Member Link In Bio', 'ydtb-link-in-bio'),
            'member-link-in-bio',
            array(
                'required_plugin' => array(),
            )
        );
        // Add link to settings page.
        add_filter('plugin_action_links', array($this, 'action_links'), 10, 2);
        add_filter('network_admin_plugin_action_links', array($this, 'action_links'), 10, 2);

        // Enqueue admin script
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_script'));
    }

    /**
     * Enqueue admin script
     */
    public function enqueue_admin_script()
    {
        // echo 'Enqueue admin script';
        // echo Config::get(key: 'plugin_url') . 'public/images/';
        // die();

        wp_enqueue_style('ydtblib-addon-admin-css', Config::get(key: 'plugin_url') . 'public/style.css');
    }

    /**
     * Register admin integration tab
     */
    public function setup_admin_integration_tab()
    {
        new BuddyBossAdminTab(
            "bp-{$this->id}",
            $this->name,
            array(
                'root_path' => Config::get(key: 'plugin_path') . '/integration',
                'root_url' => Config::get(key: 'plugin_url') . '/integration',
                'required_plugin' => $this->required_plugin,
            )
        );
    }

    /**
     * Add settings link to BuddyPress plugin page.
     *
     * @param array $links
     * @param string $file
     *
     * @return array
     */
    public function action_links($links, $file)
    {
        // Return normal links if not BuddyPress.
        if ($this->config->plugin_basename != $file) {
            return $links;
        }

        // Add a few links to the existing links array.
        return array_merge(
            $links,
            array(
                'settings' => '<a href="' . esc_url(bp_get_admin_url('admin.php?page=bp-integrations&tab=bp-member-link-in-bio')) . '">' . __('Settings', 'ydtb-link-in-bio') . '</a>',
            )
        );
    }
}
