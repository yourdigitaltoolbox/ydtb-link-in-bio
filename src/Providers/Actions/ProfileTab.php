<?php

namespace YDTBLIB\Providers\Actions;

use YDTBLIB\Utils\Config;
use YDTBLIB\Interfaces\Provider;

class ProfileTab implements Provider
{
    private $config;

    public function __construct()
    {
        $this->config = Config::get_config(YDTBLIB_PLUGIN_FILE);
    }

    public function register()
    {
        add_action('bp_setup_nav', [$this, 'add_profile_tab']);
    }

    public function add_profile_tab()
    {
        global $bp;

        bp_core_new_nav_item(array(
            'name' => 'Business Cards',
            'slug' => 'business-cards',
            'screen_function' => [$this, 'business_card_screen'],
            'position' => 40,
            'parent_url' => bp_loggedin_user_domain() . '/cards/',
            'parent_slug' => $bp->profile->slug,
            'default_subnav_slug' => 'cards',
        ));
    }

    public function business_card_screen()
    {
        // Add title and content here - last is to call the members plugin.php template.
        add_action('bp_template_content', [$this, 'business_card_content']);
        bp_core_load_template('buddypress/members/single/plugins');
        add_action('wp_enqueue_scripts', [$this, 'load_assets']);
    }

    public function business_card_content()
    {
        echo ('<div id="ydtblib-link-in-bio-root" group-separator-block"></div>');
    }

    public function load_assets()
    {
        $entrypoints_manifest = $this->config->plugin_path . "dist/entrypoints.json";

        if (!$entrypoints_manifest) {
            throw new \Exception('Example: you must run `yarn build` before using this plugin.');
        }

        $entrypoints = json_decode(file_get_contents($entrypoints_manifest));

        foreach ($entrypoints->client->js as $js) {
            wp_enqueue_script(
                $js,
                $this->config->plugin_url . "dist/{$js}",
                $entrypoints->client->dependencies,
                false,
                true,
            );
        }
        foreach ($entrypoints->client->css as $css) {

            if (preg_match('/client\.([a-z0-9]*?)\./', $css, $matches)) {
                $hash = $matches[1];
            } else {
                $hash = false;
            }

            wp_enqueue_style(
                'plugin-tools-server',
                trailingslashit($this->config->plugin_url) . "dist/{$css}",
                array(),
                $hash,
                'all',
            );
        }
        foreach ($entrypoints->client->js as $js) {
            if ($js === "js/client.js" || preg_match("/^js\/client\.[a-zA-Z0-9]+\.js$/", $js)) {
                wp_localize_script($js, 'ydtblib_link_in_bio_global', [
                    'nonce' => wp_create_nonce('wp_rest'),
                    'root' => esc_url_raw($this->config->plugin_url),
                    'rest' => esc_url_raw(rest_url()),
                    "cssHash" => $hash,
                    "memberId" => bp_displayed_user_id(),
                    "loggedInMemberId" => bp_loggedin_user_id(),
                ]);
            }
        }
    }
}
