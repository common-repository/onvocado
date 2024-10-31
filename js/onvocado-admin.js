jQuery(document).ready(function ($) {
    var $updateField = $("#update-success");
    var $errorField = $("#update-error");
    var $onvocadoKey = $("#onvocado-key");

    $('#settings-form').submit(function (e) {
        e.preventDefault();

        $errorField.hide();
        $updateField.hide();

        $.ajax({
            data: {
                action: 'onvocado_setting_form',
                onvocado_key: $onvocadoKey.val(),
                onvocado_setting_nonce: onvocadoData.nonce,
            },
            type: 'post',
            url: onvocadoData.ajaxurl,
            success: function (response) {
                if (response.success) {
                    $updateField.fadeIn();
                }
                if (response.error) {
                    $errorField.fadeIn();
                }
            }
        });
    });
});