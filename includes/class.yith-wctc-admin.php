<?php
/**
 * Admin class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Terms and Condtions Popup
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCTC' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCTC_Admin' ) ) {
	/**
	 * WooCommerce Terms and Conditions Popup Admin
	 *
	 * @since 1.0.0
	 */
	class YITH_WCTC_Admin {
		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCTC_Admin
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * @var string official documentation url
		 */
		protected $_official_documentation = 'http://yithemes.com/docs-plugins/yith-woocommerce-terms-conditions-popup/';

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCTC_Admin
		 * @since 1.0.0
		 */
		public static function get_instance(){
			if( is_null( self::$instance ) ){
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor.
		 *
		 * @param array $details
		 * @return \YITH_WCTC_Admin
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->available_tabs = apply_filters( 'yith_wctc_available_admin_tabs', array(
				'settings' => __( 'Settings', 'yit' ),
				'layout'   => __( 'Layout', 'yit' )
			) );

			// register plugin panel
			add_action( 'admin_menu', array( $this, 'register_panel' ), 5 );

			// enqueue admin scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

			// register plugin to licence/update system
			add_action( 'wp_loaded', array( $this, 'register_plugin_for_activation' ), 99 );
			add_action( 'admin_init', array( $this, 'register_plugin_for_updates' ) );

			// register pointer
			add_action( 'admin_init', array( $this, 'register_pointer' ) );

			// register plugin row meta
			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );
		}

		/* === INIT PLUGIN PANEL === */

		/**
		 * Enqueue scripts and stuff for admin panel
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function enqueue() {
			global $pagenow;

			$path = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? 'unminified/' : '';
			$suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';

			wp_register_script( 'yith-wctc', YITH_WCTC_URL . 'assets/js/admin/' . $path . 'yith-wctc' . $suffix . '.js', array( 'jquery' ), YITH_WCTC_VERSION, true );

			if( $pagenow == 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] == 'yith_wctc_panel' ){
				wp_enqueue_script( 'yith-wctc' );
			}
		}

		/**
		 * Register panel for "Terms & Conditions" settings
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_panel() {
			$args = array(
				'create_menu_page' => true,
				'parent_slug'   => '',
				'page_title'    => __( 'Terms and Conditions Popup', 'yith-wctc' ),
				'menu_title'    => __( 'Terms and Conditions Popup', 'yith-wctc' ),
				'capability'    => 'manage_options',
				'parent'        => '',
				'parent_page'   => 'yit_plugin_panel',
				'page'          => 'yith_wctc_panel',
				'admin-tabs'    => $this->available_tabs,
				'options-path'  => YITH_WCTC_DIR . 'plugin-options'
			);

			/* === Fixed: not updated theme  === */
			if( ! class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {
				require_once( YITH_WCTC_DIR . 'plugin-fw/lib/yit-plugin-panel-wc.php' );
			}

			$this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
		}

		/* === LICENCE HANDLING === */

		/**
		 * Register plugins for activation tab
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_plugin_for_activation() {
			if( ! class_exists( 'YIT_Plugin_Licence' ) ){
				require_once YITH_WCTC_DIR . 'plugin-fw/licence/lib/yit-licence.php';
				require_once YITH_WCTC_DIR . 'plugin-fw/licence/lib/yit-plugin-licence.php';
			}

			YIT_Plugin_Licence()->register( YITH_WCTC_INIT, YITH_WCTC_SECRET_KEY, YITH_WCTC_SLUG );
		}

		/**
		 * Register plugins for update tab
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_plugin_for_updates() {
			if( ! class_exists( 'YIT_Plugin_Licence' ) ){
				require_once( YITH_WCTC_DIR . 'plugin-fw/lib/yit-upgrade.php' );
			}

			YIT_Upgrade()->register( YITH_WCTC_SLUG, YITH_WCTC_INIT );
		}

		/* === POINTER SECTION === */

		/**
		 * Register pointers for notify plugin updates to user
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_pointer(){

			if( ! class_exists( 'YIT_Pointers' ) ){
				include_once( '../plugin-fw/lib/yit-pointers.php' );
			}

			$args[] = array(
				'screen_id'     => 'plugins',
				'pointer_id' => 'yith_wctc_panel',
				'target'     => '#toplevel_page_yit_plugin_panel',
				'content'    => sprintf( '<h3> %s </h3> <p> %s </p>',
					__( 'YITH WooCommerce Terms & Conditions Popup', 'yith-wctc' ),
					__( 'In YIT Plugins tab you can find YITH WooCommerce Terms & Conditions Popup options. From this menu you can access all settings of YITH plugins activated.', 'yith-wctc' )
				),
				'position'   => array( 'edge' => 'left', 'align' => 'center' ),
				'init'  => YITH_WCTC_INIT
			);

			YIT_Pointers()->register( $args );
		}

		/* === PLUGIN LINK SECTION === */

		/**
		 * plugin_row_meta
		 *
		 * add the action links to plugin admin page
		 *
		 * @param $plugin_meta
		 * @param $plugin_file
		 * @param $plugin_data
		 * @param $status
		 *
		 * @return   Array
		 * @since    1.0
		 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
		 * @use plugin_row_meta
		 */
		public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
			if ( $plugin_file == plugin_basename( YITH_WCTC_DIR . 'init.php' ) ) {
				$plugin_meta[] = '<a href="' . $this->_official_documentation . '" target="_blank">' . __( 'Plugin Documentation', 'yith-wctc' ) . '</a>';
			}

			return $plugin_meta;
		}
	}
}

/**
 * Unique access to instance of YITH_WCTC_Admin class
 *
 * @return \YITH_WCTC_Admin
 * @since 1.0.0
 */
function YITH_WCTC_Admin(){
	return YITH_WCTC_Admin::get_instance();
}

YITH_WCTC_Admin();