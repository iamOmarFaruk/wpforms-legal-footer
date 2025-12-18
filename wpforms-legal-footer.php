<?php
/**
 * Plugin Name: WPForms Legal Footer
 * Plugin URI:  https://omarfaruk.dev/
 * Description: Add a professional "Terms and Conditions" or custom link validation footer under your WPForms submit buttons.
 * Version:     1.0.0
 * Author:      Omar Faruk
 * Author URI:  https://omarfaruk.dev/
 * Text Domain: wpforms-legal-footer
 * Domain Path: /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants.
define( 'WPFORMS_LEGAL_FOOTER_VERSION', '1.0.0' );
define( 'WPFORMS_LEGAL_FOOTER_FILE', __FILE__ );
define( 'WPFORMS_LEGAL_FOOTER_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPFORMS_LEGAL_FOOTER_URL', plugin_dir_url( __FILE__ ) );

// Include the main plugin class.
require_once WPFORMS_LEGAL_FOOTER_PATH . 'includes/class-plugin.php';

/**
 * Main instance of the plugin.
 *
 * @since 1.0.0
 * @return WPForms_Legal_Footer
 */
function wpforms_legal_footer() {
	return WPForms_Legal_Footer::instance();
}

// Initialize the plugin.
wpforms_legal_footer();
