<?php

namespace YDTBLIB\Views;

use YDTBLIB\Utils\Config;

class ProfileTab
{

    public function __construct()
    {
        add_action('bp_setup_nav', [$this, 'add_profile_tab']);
    }

    public function register()
    {

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

    /**
     * The purpose of this function is to name the asset to something more readable/maintainable in the browser.
     * If we can seem to do that with the asset name, we will use the path.
     * @param mixed $path
     * @return mixed
     */
    public function getFileName($path)
    {
        if (preg_match(pattern: '/\/([a-zA-Z0-9]+)\./', subject: $path, matches: $matches)) {
            $script_name = "ydtblib-" . $matches[1];
        } else {
            $script_name = $path;
        }
        return $script_name;
    }

    /**
     * retrieve the assets from the entrypoints.json file and load them into the front-end. 
     * @throws \Exception
     * @return void
     */
    public function load_assets(): void
    {
        $entrypoints_manifest = Config::get(key: 'plugin_path') . "dist/entrypoints.json";

        if (!$entrypoints_manifest) {
            throw new \Exception('Example: you must run `yarn build` before using this plugin.');
        }

        $entrypoints = json_decode(file_get_contents($entrypoints_manifest));

        foreach ($entrypoints->client->js as $js) {
            wp_enqueue_script(
                $this->getFileName(path: $js),
                // $js,
                Config::get(key: 'plugin_url') . "dist/{$js}",
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
            if (isset($css)) {
                $cssURL = trailingslashit(Config::get(key: 'plugin_url')) . "dist/{$css}";
                wp_enqueue_style(
                    'plugin-tools-server',
                    $cssURL,
                    array(),
                    $hash,
                    'all',
                );
            }
        }

        foreach ($entrypoints->client->js as $js) {
            if ($js === "js/client.js" || preg_match("/^js\/client\.[a-zA-Z0-9]+\.js$/", $js)) {
                wp_localize_script($this->getFileName(path: $js), 'ydtblib_link_in_bio_global', [
                    'nonce' => wp_create_nonce('wp_rest'),
                    'root' => esc_url_raw(Config::get(key: 'plugin_url')),
                    'rest' => esc_url_raw(rest_url()),
                    "cssURL" => $cssURL,
                    "memberId" => bp_displayed_user_id(),
                    "loggedInMemberId" => bp_loggedin_user_id(),
                ]);
            }
        }
    }
}
