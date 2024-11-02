<?php

namespace YDTBLIB\Utils;

class Config
{
    private static $instance = null;

    public $plugin_file;
    public $plugin_basename;
    public $plugin_path;
    public $plugin_url;

    private function __construct($plugin_file)
    {
        $this->plugin_file = $plugin_file;
        $this->plugin_basename = plugin_basename($plugin_file);
        $this->plugin_path = plugin_dir_path($plugin_file);
        $this->plugin_url = plugin_dir_url($plugin_file);
    }

    public static function get_config($plugin_file)
    {
        if (self::$instance === null) {
            self::$instance = new self($plugin_file);
        }
        return self::$instance;
    }
}
