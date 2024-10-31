<?php
/*
 * Plugin Name:       Onvocado: No-Code Personalized Pop-Ups & A/B Testing
 * Description:       Grab more leads, boost sales, and drive conversions with Onvocado’s easy-to-use popup builder. Get set up fast and start growing your business today!
 * Version:           1.0.0
 * Requires at least: 5.2
 * Author:            Onvocado
 * Author URI:        https://onvocado.com/
 * License:           GPL v2 or later
 * Text Domain:       onvocado-non_invasive_popups
 * Domain Path:       /lang
 */

if (!defined('ABSPATH')) {
    exit;
}

define("ONVOCADO_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("ONVOCADO_PLUGIN_URL", plugin_dir_url(__FILE__));
define("ONVOCADO_PLUGIN_SLUG", "onvocado-plugin");

require_once ONVOCADO_PLUGIN_PATH . "onvocado-utils.php";
require_once ONVOCADO_PLUGIN_PATH . "onvocado-admin.php";
require_once ONVOCADO_PLUGIN_PATH . "onvocado-frontend.php";

register_activation_hook(__FILE__, array('OnvocadoAdmin', 'activate'));

$onvocadoAdmin = new OnvocadoAdmin(__FILE__);
$onvocadoFront = new Onvocado_Frontend();