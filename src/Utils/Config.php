<?php

namespace YDTBLIB\Utils;
class Config
{
    public static function get($key = ''): string
    {
        return Config::get_all()[$key];
    }

    public static function get_all(): array
    {
        $plugin_folder = trailingslashit(dirname(path: __FILE__, levels: 3));
        $plugin_file = $plugin_folder . 'ydtb-link-in-bio.php';
        $config = [
            'update_url' => 'https://yourdigitaltoolbox.github.io/ydtb-link-in-bio/manifest.json',
            'plugin_file' => $plugin_file,
            'plugin_path' => $plugin_folder,
            'plugin_slug' => plugin_basename(file: $plugin_folder),
            'plugin_url' => plugin_dir_url(file: $plugin_file),
            'version' => get_file_data($plugin_file, default_headers: array('Version'), context: 'plugin')[0]
        ];
        return $config;
    }
}