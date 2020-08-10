<?php
/**
 * Main LifterLMS Micro Course plugin file
 *
 * @package LifterLMS_Lite_LMS/Main
 *
 * @since [version]
 * @version [version]
 *
 * Plugin Name: Lite LMS by LifterLMS
 * Plugin URI: https://lifterlms.com/
 * Description: Easily track progress through simple online courses and other types of public or membership-protected content on your WordPress website.
 * Version: [version]
 * Author: LifterLMS
 * Author URI: https://lifterlms.com/
 * Text Domain: lifterlms-lite-lms
 * Domain Path: /languages
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 5.4
 * Tested up to: 5.5
 *
 * * * * * * * * * * * * * * * * * * * * * *
 *                                         *
 * Reporting a Security Vulnerability      *
 *                                         *
 * Please disclose any security issues or  *
 * vulnerabilities to team@lifterlms.com   *
 *                                         *
 * See our full Security Policy at         *
 * https://lifterlms.com/security          *
 *                                         *
 * * * * * * * * * * * * * * * * * * * * * *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Initialize
 *
 * @since [version]
 *
 * @return void
 */
function llms_lite_lms() {
	llms_lite_lms_scripts();
	llms_lite_lms_i18n();
}
add_action( 'init', 'llms_lite_lms' );

/**
 * Register & Enqueue scripts.
 *
 * @since [version]
 *
 * @return void
 */
function llms_lite_lms_scripts() {

	$dir    = dirname( __FILE__ );
	$url    = plugin_dir_url( __FILE__ );
	$slug   = is_admin() ? 'editor' : 'client';
	$handle = sprintf( 'llms-lite-%s', $slug );

	$asset = include $dir . '/assets/js/llms-lite-' . $slug . '.asset.php';

	wp_enqueue_script(
		$handle,
		$url . 'assets/js/llms-lite-' . $slug . '.js',
		$asset['dependencies'],
		$asset['version'],
		true
	);

	wp_enqueue_style(
		'llms-lite-editor',
		$url . 'assets/css/llms-lite-' . $slug . '.css',
		array( 'wp-edit-blocks' ),
		$asset['version']
	);

	// JS translations.
	if ( 'editor' === $slug ) {
		wp_set_script_translations( $handle, 'lifterlms-lite-lms' );
	}

}

/**
 * Load textdomain
 *
 * @since [version]
 *
 * @return void
 */
function llms_lite_lms_i18n() {

	$locale = apply_filters( 'plugin_locale', determine_locale(), 'lifterlms' );

	unload_textdomain( 'lifterlms-lite-lms' );
	load_textdomain( 'lifterlms-lite-lms', WP_LANG_DIR . '/lifterlms/lifterlms-' . $locale . '.mo' );
	load_plugin_textdomain( 'lifterlms', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n' );

}
