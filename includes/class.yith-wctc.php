<?php
/**
 * Main class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Terms & Condtions Popup
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCTC' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCTC' ) ) {
	/**
	 * WooCommerce Terms and Conditions Popup
	 *
	 * @since 1.0.0
	 */
	class YITH_WCTC {
		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCTC
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCTC
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
		 * @return \YITH_WCTC
		 * @since 1.0.0
		 */
		public function __construct() {
			// include plugin-fw
			add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );

			// removes default Terms And Condition row
			add_filter( 'woocommerce_checkout_show_terms', '__return_false' );

			// add custom plugin style
			add_action( 'woocommerce_review_order_after_submit', array( $this, 'print_terms_template' ) );

			// handle ajax request
			add_action( 'wp_ajax_terms_content', array( $this, 'print_terms_page_content' ) );
			add_action( 'wp_ajax_nopriv_terms_content', array( $this, 'print_terms_page_content' ) );
			add_action( 'wp_ajax_privacy_content', array( $this, 'print_privacy_page_content' ) );
			add_action( 'wp_ajax_nopriv_privacy_content', array( $this, 'print_privacy_page_content' ) );

			// check privacy checked
			add_action( 'woocommerce_after_checkout_validation', array( $this, 'check_terms' ) );
			add_action( 'woocommerce_after_checkout_validation', array( $this, 'check_privacy' ) );

			// enqueue styles and stuff
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		}

		/* === PLUGIN FW LOADER === */

		/**
		 * Loads plugin fw, if not yet created
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function plugin_fw_loader() {
			if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
				global $plugin_fw_data;
				if( ! empty( $plugin_fw_data ) ){
					$plugin_fw_file = array_shift( $plugin_fw_data );
					require_once( $plugin_fw_file );
				}
			}
		}

		/* === PRINT TEMPLATE === */

		/**
		 * Enqueue scripts and stuff for admin panel
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function enqueue() {
			$terms_page = get_option( 'woocommerce_terms_page_id' );
			$terms_page = function_exists( 'icl_object_id' ) ? icl_object_id( $terms_page, 'page', true ) : $terms_page;
			$path = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? 'unminified/' : '';
			$suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';

			wp_register_script( 'jquery-venobox', YITH_WCTC_URL . 'assets/js/' . $path . 'jquery.venobox' . $suffix . '.js', array( 'jquery' ), '1.5.2', true );
			wp_register_script( 'jquery-scrollbar', YITH_WCTC_URL . 'assets/js/' . $path . 'jquery.scrollbar' . $suffix . '.js', array( 'jquery' ), '0.2.10', true );
			wp_register_script( 'yith-wctc', YITH_WCTC_URL . 'assets/js/' . $path . 'yith-wctc' . $suffix . '.js', array( 'jquery', 'jquery-venobox', 'jquery-scrollbar' ), YITH_WCTC_VERSION, true );
			wp_register_style( 'jquery-venobox', YITH_WCTC_URL . 'assets/css/venobox.css', array(), '1.5.2' );
			wp_register_style( 'jquery-scrollbar', YITH_WCTC_URL . 'assets/css/scrollbar.css', array(), '0.2.10' );
			wp_register_style( 'yith-wctc', YITH_WCTC_URL . 'assets/css/yith-wctc.css', array(), YITH_WCTC_VERSION );

			$width = get_option( 'yith_wctc_popup_width' );
			$height = get_option( 'yith_wctc_popup_height' );
			$effect = get_option( 'yith_wctc_popup_effect' );

			wp_localize_script( 'jquery-venobox', 'yith_wctc_params', apply_filters( 'yith_wctc_script_localize', array(
				'popup_init' => array_merge(
					array(
			            'border' => '10px',
			            'bgcolor' => get_option( 'yith_wctc_popup_background_color', '#ffffff' ),
			            'titleattr' => 'data-title',
			            'numeratio' => false,
			            'infinigall' => false
					),
					! empty( $width ) ? array( 'framewidth' => $width . 'px' ) : array(),
					! empty( $height ) ? array( 'frameheight' => $height . 'px' ) : array()
				),
				'terms' => get_option( 'yith_wctc_terms_type' ),
				'fields' => get_option( 'yith_wctc_terms_fields' ),
				'force_to_read' => ( 'yes' == get_option( 'yith_wctc_scroll_till_end', false ) ),
				'force_to_read_message' => get_option( 'yith_wctc_scroll_till_end_message', false )
			) ) );

			if( is_checkout() && ! empty( $terms_page ) && get_option( 'yith_wctc_enable_popup' ) == 'yes' ){
				wp_enqueue_script( 'jquery-venobox' );
				wp_enqueue_script( 'jquery-scrollbar' );
				wp_enqueue_script( 'yith-wctc' );
				wp_enqueue_style( 'jquery-venobox' );
				wp_enqueue_style( 'jquery-scrollbar' );
				wp_enqueue_style( 'yith-wctc' );

				if( $effect > 0 ) {
					wp_enqueue_style( 'yith-wctc-effect', YITH_WCTC_URL . 'assets/css/effects/effect-' . $effect . '.css' );
				}

				$this->print_custom_css();
			}
		}

		/**
		 * Print custom CSS for plugin forntend
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function print_custom_css() {
			$popup_round_corners = ( get_option( 'yith_wctc_popup_round_corners' ) == 'yes' );
			$popup_loading_image = get_option( 'yith_wctc_popup_loading_image' );
			$popup_close_button_color = get_option( 'yith_wctc_popup_close_button_color' );
			$popup_close_button_opacity = get_option( 'yith_wctc_popup_close_button_opacity' );
			$popup_close_button_rgba = 'rgba(' . hexdec( substr( $popup_close_button_color, 1, 2 ) ) . ', ' . hexdec( substr( $popup_close_button_color, 3, 2 ) ) . ', ' . hexdec( substr( $popup_close_button_color, 5, 2 ) ) . ', ' . $popup_close_button_opacity . ')';
			$popup_close_button_style = get_option( 'yith_wctc_popup_close_button_style' );
			$agree_button_alignment = get_option( 'yith_wctc_agree_button_alignment' );
			$agree_button_type = get_option( 'yith_wctc_agree_button_type' );
			$agree_button_style = get_option( 'yith_wctc_agree_button_style' );
			$agree_button_round_corners = ( get_option( 'yith_wctc_agree_button_round_corners' ) == 'yes' );
			$agree_button_background_color = get_option( 'yith_wctc_agree_button_background_color' );
			$agree_button_color = get_option( 'yith_wctc_agree_button_color' );
			$agree_button_border_color = get_option( 'yith_wctc_agree_button_border_color' );
			$agree_button_background_hover_color = get_option( 'yith_wctc_agree_button_background_hover_color' );
			$agree_button_hover_color = get_option( 'yith_wctc_agree_button_hover_color' );
			$agree_button_border_hover_color = get_option( 'yith_wctc_agree_button_border_hover_color' );
			?>
			<style>
				/* YITH WCTC POPUP CONTENT */
				<?php if( $popup_round_corners ):?>
				.vbox-inline {
					border-radius: 10px;
				}
				<?php endif; ?>

				/* YITH WCTC POPUP CONTENT */
				.vbox-close{
					background: <?php echo $popup_close_button_rgba ?>!important;
					background-image: url(<?php echo YITH_WCTC_URL ?>assets/images/venobox/close-<?php echo $popup_close_button_style ?>.gif)!important;
				}

				/* YITH WCTC PRELOADER */
				<?php if( $popup_loading_image == 'dots' ): ?>
				.vbox-preloader{
					position:fixed;
					width:32px;
					height:11px!important;
					left:50%;
					top:50%;
					margin-left:-16px;
					margin-top:-16px;
					background-image: url(<?php echo YITH_WCTC_URL ?>assets/images/venobox/preload-dots.png)!important;
					text-indent: -100px;
					overflow: hidden;
					-webkit-animation: playload 1.4s steps(24) infinite;
					-moz-animation: playload 1.4s steps(24) infinite;
					-ms-animation: playload 1.4s steps(24) infinite;
					-o-animation: playload 1.4s steps(24) infinite;
					animation: playload 1.4s steps(24) infinite;
				}

				@-webkit-keyframes playload {
					from { background-position:    0px; }
					to { background-position: -768px; }
				}
				@-moz-keyframes playload {
					from { background-position:    0px; }
					to { background-position: -768px; }
				}
				@-ms-keyframes playload {
					from { background-position:    0px; }
					to { background-position: -768px; }
				}
				@-o-keyframes playload {
					from { background-position:    0px; }
					to { background-position: -768px; }
				}
				@keyframes playload {
					from { background-position:    0px; }
					to { background-position: -768px; }
				}
				<?php elseif( $popup_loading_image == 'ios' ): ?>
				.vbox-preloader{
					position:fixed;
					width:32px;
					height:32px;
					left:50%;
					top:50%;
					margin-left:-16px;
					margin-top:-16px;
					background-image: url(<?php echo YITH_WCTC_URL ?>assets/images/venobox/preload-ios.png)!important;
					text-indent: -100px;
					overflow: hidden;
					-webkit-animation: playload 1.4s steps(12) infinite;
					-moz-animation: playload 1.4s steps(12) infinite;
					-ms-animation: playload 1.4s steps(12) infinite;
					-o-animation: playload 1.4s steps(12) infinite;
					animation: playload 1.4s steps(12) infinite;
				}

				@-webkit-keyframes playload {
					from { background-position:    0px; }
					to { background-position: -384px; }
				}
				@-moz-keyframes playload {
					from { background-position:    0px; }
					to { background-position: -384px; }
				}
				@-ms-keyframes playload {
					from { background-position:    0px; }
					to { background-position: -384px; }
				}
				@-o-keyframes playload {
					from { background-position:    0px; }
					to { background-position: -384px; }
				}
				@keyframes playload {
					from { background-position:    0px; }
					to { background-position: -384px; }
				}
				<?php elseif( $popup_loading_image == 'quads' ): ?>
				.vbox-preloader{
					position:fixed;
					width:32px;
					height:10px!important;
					left:50%;
					top:50%;
					margin-left:-16px;
					margin-top:-16px;
					background-image: url(<?php echo YITH_WCTC_URL ?>assets/images/venobox/preload-quads.png)!important;
					text-indent: -100px;
					overflow: hidden;
					-webkit-animation: playload 1.4s steps(12) infinite;
					-moz-animation: playload 1.4s steps(12) infinite;
					-ms-animation: playload 1.4s steps(12) infinite;
					-o-animation: playload 1.4s steps(12) infinite;
					animation: playload 1.4s steps(12) infinite;
				}
				@-webkit-keyframes playload {
					from { background-position:    0px; }
					to { background-position: -384px; }
				}
				@-moz-keyframes playload {
					from { background-position:    0px; }
					to { background-position: -384px; }
				}
				@-ms-keyframes playload {
					from { background-position:    0px; }
					to { background-position: -384px; }
				}
				@-o-keyframes playload {
					from { background-position:    0px; }
					to { background-position: -384px; }
				}
				@keyframes playload {
					from { background-position:    0px; }
					to { background-position: -384px; }
				}
				<?php endif; ?>

				/* YITH WCTC POPUP FOOTER */
				.vbox-inline .popup-footer{
					text-align: <?php echo $agree_button_alignment ?>;
				}

				/* YITH WCTC "I AGREE" BUTTON */
				<?php if( $agree_button_type == 'button' && $agree_button_style == 'custom' ): ?>
				.agree-button {
					color: <?php echo $agree_button_color ?>!important;
					background: <?php echo $agree_button_background_color ?>!important;
					border: 1px solid <?php echo $agree_button_border_color ?>!important;
					border-radius: <?php echo ( $agree_button_round_corners ) ? '3' : '0' ?>px!important;
				}

				.agree-button:hover {
					color: <?php echo $agree_button_hover_color ?>!important;
					background: <?php echo $agree_button_background_hover_color ?>!important;
					border: 1px solid <?php echo $agree_button_border_hover_color ?>!important;
				}
				<?php endif; ?>
			</style>
			<?php
		}

		/**
		 * If privacy checkbox is added, ensure it is checked during checkout
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function check_privacy() {
			$terms_type = get_option( 'yith_wctc_terms_type', false );
			$terms_fields = get_option( 'yith_wctc_terms_fields', false );

			if( ( ( 'both' == $terms_type && 'apart' == $terms_fields ) || 'privacy' == $terms_type ) && ! isset( $_POST['privacy'] ) ){
				wc_add_notice( __( 'You must accept our Privacy conditions.', 'yith-wctc' ), 'error' );
			}
		}

		/**
		 * If terms checkbox is added, ensure it is checked during checkout
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function check_terms() {
			$terms_type = get_option( 'yith_wctc_terms_type', false );
			$terms_fields = get_option( 'yith_wctc_terms_fields', false );

			if( ( 'both' == $terms_type || 'terms' == $terms_type ) && ! isset( $_POST['terms'] ) ){
				wc_add_notice( __( 'You must accept our Terms &amp; Conditions.', 'yith-wctc' ), 'error' );
			}
		}

		/**
		 * Print custom template for "Terms and Conditions" row on checkout
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function print_terms_template() {
			// define variable needed in the template
			$enable_popup = ( get_option( 'yith_wctc_enable_popup' ) == 'yes' );
			$term_page_id = wc_get_page_id( 'terms' );
			$term_page_id = function_exists( 'icl_object_id' ) ? icl_object_id( $term_page_id , 'page' , true ) : $term_page_id;
			$hide_checkbox = ( get_option( 'yith_wctc_hide_checkboxes' ) == 'yes' );
			$terms_type = get_option( 'yith_wctc_terms_type', false );
			$terms_fields = get_option( 'yith_wctc_terms_fields', false );
			$terms_text = get_option( 'yith_wctc_terms_text', false );
			$terms_label = get_option( 'yith_wctc_terms_label', false );
			$terms_checked = ( get_option( 'yith_wctc_terms_checked', false ) == 'yes' );
			$privacy_page_id = get_option( 'yith_wctc_privacy_page_id' );
			$privacy_page_id = function_exists( 'icl_object_id' ) ? icl_object_id( $privacy_page_id, 'page', true ) : $privacy_page_id;
			$privacy_text = get_option( 'yith_wctc_privacy_text', false );
			$privacy_label = get_option( 'yith_wctc_privacy_label', false );
			$privacy_checked = ( get_option( 'yith_wctc_privacy_checked', false ) == 'yes' );
			$common_text = get_option( 'yith_wctc_common_text', false );
			$common_checked = ( get_option( 'yith_wctc_common_checked', false ) == 'yes' );
			$popup_overlay_color = get_option( 'yith_wctc_popup_overlay_color', '#000000' );
			$popup_overlay_opacity = get_option( 'yith_wctc_popup_overlay_opacity', 0.85 );
			$force_to_read = get_option( 'yith_wctc_scroll_till_end', false );
			$popup_overlay_data = 'rgba(' . hexdec( substr( $popup_overlay_color, 1, 2 ) ) . ', ' . hexdec( substr( $popup_overlay_color, 3, 2 ) ) . ', ' . hexdec( substr( $popup_overlay_color, 5, 2 ) ) . ', ' . $popup_overlay_opacity . ')';
			$show_line = false;

			if( 'terms' == $terms_type ){
				$show_line = ( $term_page_id > 0 ) && ! empty( $terms_text ) && ! empty( $terms_label );
				$terms_url = ( $enable_popup ) ? esc_url( add_query_arg( 'action', 'terms_content', admin_url( 'admin-ajax.php' ) ) ) : get_permalink( $term_page_id );
				$terms_link = sprintf( '<a id="terms_and_conditions" class="wctc-terms-and-conditions" data-type="ajax" data-overlay="%s" href="%s" target="_blank">%s</a>', $popup_overlay_data, $terms_url, $terms_label );
				$line_terms = str_replace( '%TERMS AND CONDITIONS%', $terms_link, esc_html( $terms_text ) );
				$terms_checked = ( $hide_checkbox && ( ! $enable_popup || ! $force_to_read ) ) ? true : $terms_checked;
			}
			elseif( 'privacy' == $terms_type ){
				$show_line = ( $privacy_page_id > 0 ) && ! empty( $privacy_text ) && ! empty( $privacy_label );
				$privacy_url = ( $enable_popup ) ? esc_url( add_query_arg( 'action', 'privacy_content', admin_url( 'admin-ajax.php' ) ) ) : get_permalink( $privacy_page_id );
				$privacy_link = sprintf( '<a id="privacy" class="wctc-privacy" data-type="ajax" data-overlay="%s" href="%s" target="_blank">%s</a>', $popup_overlay_data, $privacy_url, $privacy_label  );
				$line_privacy = str_replace( '%PRIVACY%', $privacy_link, esc_html( $privacy_text ) );
				$privacy_checked = ( $hide_checkbox && ( ! $enable_popup || ! $force_to_read ) ) ? true : $privacy_checked;
			}
			else{
				if( 'together' == $terms_fields ){
					$show_line = ( $privacy_page_id > 0 ) && ! empty( $privacy_text ) && ! empty( $privacy_label ) && ( $term_page_id > 0 ) && ! empty( $terms_text ) && ! empty( $terms_label );
					$terms_url = ( $enable_popup ) ? esc_url( add_query_arg( 'action', 'terms_content', admin_url( 'admin-ajax.php' ) ) ) : get_permalink( $term_page_id );
					$terms_link = sprintf( '<a id="terms_and_conditions" class="wctc-terms-and-conditions" data-type="ajax" data-overlay="%s" href="%s" target="_blank">%s</a>', $popup_overlay_data, $terms_url, $terms_label );
					$privacy_url = ( $enable_popup ) ? esc_url( add_query_arg( 'action', 'privacy_content', admin_url( 'admin-ajax.php' ) ) ) : get_permalink( $privacy_page_id );
					$privacy_link = sprintf( '<a id="privacy" class="wctc-privacy" data-type="ajax" data-overlay="%s" href="%s" target="_blank">%s</a>', $popup_overlay_data, $privacy_url, $privacy_label  );
					$line = str_replace( '%TERMS AND CONDITIONS%', $terms_link, esc_html( $common_text ) );
					$line = str_replace( '%PRIVACY%', $privacy_link, $line );
					$checked = ( $hide_checkbox && ( ! $enable_popup || ! $force_to_read ) ) ? true : $common_checked;
				}
				else{
					$show_line = ( $term_page_id > 0 ) && ! empty( $terms_text ) && ! empty( $terms_label );

					$terms_url = ( $enable_popup ) ? esc_url( add_query_arg( 'action', 'terms_content', admin_url( 'admin-ajax.php' ) ) ) : get_permalink( $term_page_id );
					$terms_link = sprintf( '<a id="terms_and_conditions" class="wctc-terms-and-conditions" data-type="ajax" data-overlay="%s" href="%s" target="_blank">%s</a>', $popup_overlay_data, $terms_url, $terms_label );
					$line_terms = str_replace( '%TERMS AND CONDITIONS%', $terms_link, esc_html( $terms_text ) );
					$terms_checked = ( $hide_checkbox && ( ! $enable_popup || ! $force_to_read ) ) ? true : $terms_checked;

					$privacy_url = ( $enable_popup ) ? esc_url( add_query_arg( 'action', 'privacy_content', admin_url( 'admin-ajax.php' ) ) ) : get_permalink( $privacy_page_id );
					$privacy_link = sprintf( '<a id="privacy" class="wctc-privacy" data-type="ajax" data-overlay="%s" href="%s" target="_blank">%s</a>', $popup_overlay_data, $privacy_url, $privacy_label  );
					$line_privacy = str_replace( '%PRIVACY%', $privacy_link, esc_html( $privacy_text ) );
					$privacy_checked = ( $hide_checkbox && ( ! $enable_popup || ! $force_to_read ) ) ? true : $privacy_checked;
				}
			}

			// include payment form template
			$template_name = 'terms-and-conditions.php';
			$locations = array(
				trailingslashit( WC()->template_path() ) . $template_name,
				$template_name
			);

			$template = locate_template( $locations );

			if( ! $template ){
				$template = YITH_WCTC_DIR . 'templates/' . $template_name;
			}

			include( $template );
		}

		/**
		 * Return contents of terms page
		 *
		 * @return array An array of content, in this format:
		 * [
		 *     'content' => (string) Post content
		 *     'title' => (string) Post title
		 * ]
		 * @since 1.0.0
		 */
		public function return_terms_page_content() {
			$content = array(
				'content' => '',
				'title' => ''
			);

			if( wc_get_page_id( 'terms' ) > 0 ){
				$page_id = wc_get_page_id( 'terms' );

				if( function_exists( 'icl_object_id' ) ){
					$page_id = icl_object_id( $page_id, 'page', true );
				}

				$terms_page = get_post( $page_id );
				$content['title'] = $terms_page->post_title;
				$content['content'] = apply_filters( 'the_content', do_shortcode( $terms_page->post_content ) );
			}

			return apply_filters( 'yith_wctc_terms_page_content', $content );
		}

		/**
		 * Print content for "Terms and Conditions" modal
		 *
		 * @use YITH_WCTC::print_popup_content()
		 * @return void
		 * @since 1.0.0
		 */
		public function print_terms_page_content() {
			$contents = $this->return_terms_page_content();
			$this->print_popup_content( $contents, 'terms' );
		}

		/**
		 * Return contents of privacy page
		 *
		 * @return array An array of content, in this format:
		 * [
		 *     'content' => (string) Post content
		 *     'title' => (string) Post title
		 * ]
		 * @since 1.0.0
		 */
		public function return_privacy_page_content() {
			$content = array(
				'content' => '',
				'title' => ''
			);

			$privacy_page_id = get_option( 'yith_wctc_privacy_page_id', false );

			if( function_exists( 'icl_object_id' ) ){
				$privacy_page_id = icl_object_id( $privacy_page_id, 'page', true );
			}

			if( $privacy_page_id > 0 ){
				$terms_page = get_post( $privacy_page_id );
				$content['content'] = apply_filters( 'the_content', do_shortcode( $terms_page->post_content ) );
				$content['title'] = $terms_page->post_title;
			}

			return apply_filters( 'yith_wctc_privacy_page_content', $content );
		}

		/**
		 * Print content for "Privacy" modal
		 *
		 * @use YITH_WCTC::print_popup_content()
		 * @return void
		 * @since 1.0.0
		 */
		public function print_privacy_page_content() {
			$contents = $this->return_privacy_page_content();
			$this->print_popup_content( $contents, 'privacy' );
		}

		/**
		 * Print modal content
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function print_popup_content( $contents, $type = "terms" ) {
			$show_title = ( get_option( 'yith_wctc_popup_title', false ) == 'yes' );
			$popup_button = ( get_option( 'yith_wctc_popup_button', false ) == 'yes' );
			$popup_button_text = ( get_option( 'yith_wctc_popup_button_text', false ) );
			$content_height = 80 + ( ! $show_title ? 10 : 0 )  + ( ! $popup_button ? 10 : 0 );
			$content_style = "style='height:{$content_height}%'";
			$button_style = get_option( 'yith_wctc_agree_button_type', 'button' );

			// include payment form template
			$template_name = 'terms-and-conditions-popup.php';
			$locations = array(
				trailingslashit( WC()->template_path() ) . $template_name,
				$template_name
			);

			$template = locate_template( $locations );

			if( ! $template ){
				$template = YITH_WCTC_DIR . 'templates/' . $template_name;
			}

			include( $template );
			die();
		}
	}
}

/**
 * Unique access to instance of YITH_WCTC class
 *
 * @return \YITH_WCTC
 * @since 1.0.0
 */
function YITH_WCTC(){
	return YITH_WCTC::get_instance();
}

// let's start the game
YITH_WCTC();