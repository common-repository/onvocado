<?php

class OnvocadoAdmin
{
    protected static $pluginLink = 'options-general.php?page=onvocado-settings';
    protected static $basePath;

    public function __construct($pluginBasePath)
    {
        self::$basePath = $pluginBasePath;
        add_filter('plugin_action_links_' . plugin_basename(self::$basePath), array($this, 'addSettingsPageLink'));
        add_action('admin_enqueue_scripts', array($this, 'initScripts'));
        add_action('admin_enqueue_scripts', array($this, 'initStyleSheet'));
        add_action('admin_init', array($this, 'initSettings'));
        add_action('admin_menu', array($this, 'addMenu'));
        add_action('admin_post_onvocado_settings', array($this, 'postHandler'));
        add_action('wp_ajax_onvocado_setting_form', array($this, 'postHandler'));
    }

    public static function activate()
    {
        add_option('onvocadoDoActivationRedirect', true);
    }

    public function addSettingsPageLink($links)
    {
        $settings_link = '<a href="' . esc_url(admin_url(self::$pluginLink)) . '">' . __('Settings', 'onvocado') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public function initSettings()
    {
        register_setting('onvocado_settings_group', 'onvocado_key', 'sanitize_text_field');
    }

    public function initScripts($hook)
    {
        if ( 'settings_page_onvocado-settings' !== $hook ) {
            return;
        }

        $plugin_version = Onvocado_Utils::getPluginVersion(self::$basePath);

        wp_enqueue_script('jquery');
        wp_enqueue_script(
            'onvocado-admin-script',
            ONVOCADO_PLUGIN_URL . 'js/onvocado-admin.js',
            array('jquery'),
            $plugin_version,
            true
        );

         wp_localize_script('onvocado-admin-script', 'onvocadoData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('onvocado_setting'),
        ));
    }

    public function initStyleSheet($hook)
    {
        if ( 'settings_page_onvocado-settings' !== $hook ) {
            return;
        }

        if (is_admin()) {
            $plugin_version = Onvocado_Utils::getPluginVersion(self::$basePath);
            wp_enqueue_style('onvocado-style', ONVOCADO_PLUGIN_URL . 'css/onvocado-styles.css', array(), $plugin_version);
        }
    }

    public function addMenu()
    {
        add_options_page(
            esc_html__('Onvocado Settings', 'onvocado'),
            esc_html__('Onvocado', 'onvocado'),
            'manage_options',
            'onvocado-settings',
            array($this, 'settings')
        );
    }

    public function settings()
    {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'onvocado'));
        }

        include plugin_dir_path( __FILE__ ) . 'template/settings.php';
    }

    public function postHandler()
    {
        if ( ! isset( $_POST['onvocado_setting_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['onvocado_setting_nonce'] ) ), 'onvocado_setting' ) ) {
            wp_die( esc_html__( 'Security check failed', 'onvocado' ), esc_html__( 'Security Error', 'onvocado' ), array( 'response' => 403 ) );
        }

        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'onvocado'));
        }

        $return = array();

        if (!isset($_POST['onvocado_key'])) {
            $return['error'] = '1';
        } else {
            $onvocado_key = sanitize_text_field(wp_unslash($_POST['onvocado_key']));
            $return['success'] = '1';
            update_option('onvocado_key', $onvocado_key);
        }

        wp_send_json($return);
    }
}
