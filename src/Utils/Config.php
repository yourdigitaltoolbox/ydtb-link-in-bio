<?php

namespace YDTBLIB\Utils;
class Config
{
    /**
     * 
     * @param string $key
     * @return string
     * 
     * possible strings for $key and return values:
     * - update_url - URL to the update manifest
     * - plugin_file - path to the main plugin file plugin/plugin.php
     * - plugin_path - path to the plugin folder /var/www/.../plugins/ydtb-link-in-bio/
     * - plugin_slug - slug only: ydtb-link-in-bio
     * - plugin_url - URL to the plugin folder https://example.com/.../plugins/ydtb-link-in-bio/
     * - version - version of the plugin: 0.0.1
     */
    public static function get($key = ''): string
    {
        return Config::get_all()[$key];
    }

    public static function get_all(): array
    {
        $plugin_folder = trailingslashit(dirname(path: __FILE__, levels: 3));
        $loader_file = "ydtb-link-in-bio.php";
        $plugin_file = $plugin_folder . $loader_file;
        $plugin_slug = plugin_basename(file: $plugin_folder);
        $config = [
            'update_url' => 'https://yourdigitaltoolbox.github.io/ydtb-link-in-bio/manifest.json',
            'plugin_file' => $plugin_file,
            'plugin_path' => $plugin_folder,
            'plugin_slug' => $plugin_slug,
            'full_slug' => $plugin_slug . '/' . $loader_file,
            'plugin_url' => plugin_dir_url(file: $plugin_file),
            'version' => get_file_data($plugin_file, default_headers: array('Version'), context: 'plugin')[0]
        ];
        return $config;
    }
}