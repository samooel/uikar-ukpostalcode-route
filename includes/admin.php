<?php

/**
 * Register a custom menu page.
 */
function uikar_ukpostalcode_add_custom_page() {
    add_submenu_page(
            'options-general.php',__('UIKAR uk route map', 'uikar-ukpostalcode'), __('UIKAR uk route map', 'uikar-ukpostalcode'), 'manage_options', 'uikaruk', 'uikar_ukpostalcode_custom_menu', plugins_url('uikar-form-builder/assets/img/icon.png'), 73
    );
}

add_action('admin_menu', 'uikar_ukpostalcode_add_custom_page');



/**
 * Display a custom menu page
 */
function uikar_ukpostalcode_custom_menu() {
    ?>
    <form method="post" action="options.php">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e('Google Map API Code', 'uikar-ukpostalcode'); ?></th>
                <td><input type="text" name="googleMapAPI" value="<?php echo get_option('googleMapAPI'); ?>" size="50" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e('Destination Latitude and longitude', 'uikar-ukpostalcode'); ?></th>
                <td><input type="text" name="destiantionLocation" placeholder="51.88973,-0.441597" value="<?php echo get_option('destiantionLocation'); ?>" size="50" /></td>
            </tr>
        </table>
        <p><?php _e('For showing google map and route box use this shortcode','uikar-ukpostalcode');?>: [uikar-ukpostalcode]</p>
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="googleMapAPI,destiantionLocation" />
        <div class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Settings', 'uikar-ukpostalcode') ?>" />
        </div>
    </form>
    <?php
}



