<?php
namespace YDTBLIB\Interfaces;

interface SettingsFieldInterface
{
    public function render();
    public function sanitize($value);
    public function get_value();
}
