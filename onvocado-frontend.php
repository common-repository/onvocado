<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Onvocado_Frontend {
    public function __construct() {
        add_action( 'wp_footer', array( $this, 'enqueue_onvocado_script' ) );
        add_filter( 'script_loader_tag', array( $this, 'add_id_to_onvocado_script' ), 10, 2 );
    }

    public function enqueue_onvocado_script() {
        $onvocado_key = get_option('onvocado_key');

        if ($onvocado_key) {
            $script_url = add_query_arg(
                array( 'key' => urlencode( $onvocado_key ) ),
                'https://on.onvocado.com/v1/api/preload/'
            );
            $script_url = esc_url( $script_url );
            $plugin_version = Onvocado_Utils::getPluginVersion(ONVOCADO_PLUGIN_PATH . 'onvocado.php');

            wp_enqueue_script('onvocado-script', $script_url, array(), $plugin_version, true);
        }
    }

    // Use the 'script_loader_tag' filter to add an id attribute to the script
    public function add_id_to_onvocado_script( $tag, $handle ) {
        if ( 'onvocado-script' === $handle ) {
            return str_replace( '<script ', '<script id="onvocadoScript" ', $tag );
        }

        return $tag;
    }
}