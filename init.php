<?php
/**
 * Plugin Name: YITH WooCommerce Terms & Conditions Popup
 * Plugin URI: http://yithemes.com/themes/plugins/yith-woocommerce-terms-conditions-popup/
 * Description: YITH WooCommerce Terms & Conditions Popup allow you to open "Terms and Coditions" section in a popup.
 * Version: 1.1.0
 * Author: Yithemes
 * Author URI: http://yithemes.com/
 * Text Domain: yith-wctc
 * Domain Path: /languages/
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Terms & Conditions Popup
 * @version 1.0.0
 */

/*  Copyright 2013  Your Inspiration Themes  (email : plugins@yithemes.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( !defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! defined( 'YITH_WCTC' ) ) {
	define( 'YITH_WCTC', true );
}

if( ! defined( 'YITH_WCTC_VERSION' ) ) {
	define( 'YITH_WCTC_VERSION', '1.1.0' );
}

if ( ! defined( 'YITH_WCTC_URL' ) ) {
	define( 'YITH_WCTC_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YITH_WCTC_DIR' ) ) {
	define( 'YITH_WCTC_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'YITH_WCTC_INC' ) ) {
	define( 'YITH_WCTC_INC', YITH_WCTC_DIR . 'includes/' );
}

if ( ! defined( 'YITH_WCTC_INIT' ) ) {
	define( 'YITH_WCTC_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_WCTC_SLUG' ) ) {
	define( 'YITH_WCTC_SLUG', 'yith-woocommerce-terms-conditions-popup' );
}

if ( ! defined( 'YITH_WCTC_SECRET_KEY' ) ) {
	define( 'YITH_WCTC_SECRET_KEY', 'GZ5fDmwX2pJjef5piSZL' );
}

if ( ! defined( 'YITH_WCTC_PREMIUM' ) ) {
	define( 'YITH_WCTC_PREMIUM', '1' );
}

/* Plugin Framework Version Check */
if( ! function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( YITH_WCTC_DIR . 'plugin-fw/init.php' ) ) {
	require_once( YITH_WCTC_DIR . 'plugin-fw/init.php' );
}
yit_maybe_plugin_fw_loader( YITH_WCTC_DIR  );

if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

if( ! function_exists( 'yith_wctc_constructor' ) ) {
	function yith_wctc_constructor() {

		load_plugin_textdomain( 'yith-wctc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// Load required classes and functions
		require_once( YITH_WCTC_INC . 'class.yith-wctc.php' );

		if( is_admin() ) {
			require_once( YITH_WCTC_INC . 'class.yith-wctc-admin.php' );
		}
	}
}
add_action( 'yith_wctc_init', 'yith_wctc_constructor' );

if( ! function_exists( 'yith_wctc_install' ) ) {
	function yith_wctc_install() {

		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		if ( ! function_exists( 'WC' ) ) {
			add_action( 'admin_notices', 'yith_wctc_install_woocommerce_admin_notice' );
		}
		else {
			do_action( 'yith_wctc_init' );
		}
	}
}
add_action( 'plugins_loaded', 'yith_wctc_install', 11 );

if( ! function_exists( 'yith_wctc_install_woocommerce_admin_notice' ) ) {
	function yith_wctc_install_woocommerce_admin_notice() {
		?>
		<div class="error">
			<p><?php _e( 'YITH WooCommerce Terms & Conditions Popup is enabled but not effective. It requires WooCommerce in order to work.', 'yith-wctc' ); ?></p>
		</div>
	<?php
	}
}