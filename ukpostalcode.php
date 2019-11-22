<?php 
/*
 * Plugin Name:  uikar UK Postal Code Route
 * Plugin URI: http://uikar.com
 * Description: Wordpress User Registration and login form
 * Version: 1.0
 * Author: Saman Tohidian
 * Author URI: http://uikar.com
 * Text Domain: uikar-ukpostalcode
 * Domain Path: /languages/
 *
 */
define('UIKAR_POSTALCODE_BUILDER_DIR', plugin_dir_path(__FILE__));
define('UIKAR_POSTALCODE_BUILDER_URL', plugin_dir_url(__FILE__));

require_once(UIKAR_POSTALCODE_BUILDER_DIR.'includes/functions.php');

register_activation_hook(__FILE__, 'uikar_ukpostalcode_builder_activation');
//register_deactivation_hook(__FILE__, 'uikar_form_builder_deactivation');
 
function uikar_ukpostalcode_load() {

    if (is_admin()) { //load admin files only in admin
        require_once(UIKAR_POSTALCODE_BUILDER_DIR . 'includes/admin.php');
    }
}

uikar_ukpostalcode_load();

add_action('plugins_loaded', 'uikar_ukpostalcode_load_textdomain');
function uikar_ukpostalcode_load_textdomain() {
	load_plugin_textdomain( 'uikar_ukpostalcode', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

// Register a new shortcode: [uikar-ukpostalcode]
add_shortcode( 'uikar-ukpostalcode', 'uikar_ukpostalcode_shortcode' );

// The callback function that will replace [book]
function uikar_ukpostalcode_shortcode() {
    ob_start();
    uikar_ukpostalcode_main();
    return ob_get_clean();
}

function uikar_ukpostalcode_builder_activation() {
//    uirg_addRegisterPage();
}



?>