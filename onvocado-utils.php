<?php

class Onvocado_Utils {
    public static function getPluginVersion($basePath) {
        if (!function_exists('get_plugin_data')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        $plugin_data = get_plugin_data($basePath);
        return $plugin_data['Version'];
    }
}