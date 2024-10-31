<?php if (!defined('ABSPATH')) exit; ?>

<?php
$pluginDirUrl = plugin_dir_url(__FILE__);
$domain = "https://app.onvocado.com";
$setupUrl = "https://onvocado.com/support/wordpress-onvocado-installation-guide";
$registerUrl = $domain . "/register";
$reviewUrl = "https://wordpress.org/support/plugin/onvocado/reviews/#new-post";
$registerText = "Don't have an account? <a href='$registerUrl' class='onv-link' target='_blank'>Register here</a>";
$reviewText = "Enjoying the plugin? <a href='$reviewUrl' class='onv-link' target='_blank'>Leave a review</a>";
?>

<div class="onv-wrapper">
    <h2>
        <a href="<?php echo esc_url($domain); ?>" title="Onvocado" target="_blank">
            <img src="<?php echo esc_url($pluginDirUrl); ?>assets/logo.png" width="150px" alt="Onvocado">
        </a>
    </h2>
    <div class="onv-register"><?php echo wp_kses_post($registerText); ?></div>
    <form method="post" action="options.php" id="settings-form">
        <?php settings_fields('onvocado_settings_group'); ?>
        <?php do_settings_sections('onvocado_settings_group'); ?>
        <div class="form-group">
            <div class="onv-label">
            <label for="onvocado-key"><?php echo esc_html( 'Onvocado Key' ); ?></label>
                <a class="onv-link" href="<?php echo esc_url($setupUrl); ?>" title="Onvocado" target="_blank">
                    <svg width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" />  <line x1="12" y1="8" x2="12.01" y2="8" />  <polyline points="11 12 12 12 12 16 13 16" /></svg>
                </a>
            </div>
            <input type="text" name="onvocado_key" id="onvocado-key" value="<?php echo esc_attr( get_option( 'onvocado_key' ) ); ?>" placeholder="<?php echo esc_attr( 'Enter your Onvocado Key', 'onvocado' ); ?>" maxlength="100" />
        </div>
        <div id="update-success" class="notice notice-success" style="display:none;">Your settings have been updated.</div>
        <div id="update-error" class="notice notice-error" style="display:none;">There was an error updating your settings.</div>
        <?php wp_nonce_field('onvocado_setting', 'onvocado_setting_nonce'); ?>
        <?php submit_button(); ?>
    </form>
<div class="onv-review"><?php echo wp_kses_post($reviewText); ?></div>
</div>
