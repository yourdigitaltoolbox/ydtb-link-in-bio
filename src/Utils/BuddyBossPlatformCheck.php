<?php
namespace YDTBLIB\Utils;

class BuddyBossPlatformCheck
{
    public static function check()
    {
        if (!defined('BP_PLATFORM_VERSION')) {
            add_action('admin_notices', [self::class, 'installNotice']);
            add_action('network_admin_notices', [self::class, 'installNotice']);
            return false;
        }
        return true;
    }

    public static function installNotice()
    {
        echo '<div class="error fade"><p>';
        _e('<strong>YDTB Member Link-In-Bio</strong></a> requires the BuddyBoss Platform plugin to work. Please <a href="https://buddyboss.com/platform/" target="_blank">install BuddyBoss Platform</a> first.', 'ydtb-link-in-bio');
        echo '</p></div>';
    }
}
