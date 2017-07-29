<?php
/**
 * General settings page
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Terms & Conditions Popup
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCTC' ) ) {
	exit;
} // Exit if accessed directly

return apply_filters(
	'yith_wctc_general_settings',
	array(
		'settings' => array(

			'popup-options' => array(
				'title' => __( 'Popup Options', 'yith-wctc' ),
				'type' => 'title',
				'desc' => '',
				'id' => 'yith_wctc_popup_options'
			),

			'enable-popup' => array(
				'id'        => 'yith_wctc_enable_popup',
				'name'      => __( 'Enable Terms & Conditions Popup', 'yith-wctc' ),
				'type'      => 'checkbox',
				'desc'      => __( 'Enable popup for Terms and Conditions section on Checkout page', 'yith-wctc' ),
				'default'   => 'yes'
			),

			'popup-width' => array(
				'id'        => 'yith_wctc_popup_width',
				'name'      => __( 'Popup width', 'yith-wctc' ),
				'type'      => 'number',
				'min'       => 0,
				'max'       => 1200,
				'desc'      => __( 'Popup width (in pixel)', 'yith-wctc' ),
				'default'   => 1000,
				'css'       => 'min-width:300px;'
			),

			'popup-height' => array(
				'id'        => 'yith_wctc_popup_height',
				'name'      => __( 'Popup height', 'yith-wctc' ),
				'type'      => 'number',
				'min'       => 0,
				'max'       => 800,
				'desc'      => __( 'Popup height (in pixel)', 'yith-wctc' ),
				'default'   => 800,
				'css'       => 'min-width:300px;'
			),

			'popup-title' => array(
				'id'        => 'yith_wctc_popup_title',
				'name'      => __( 'Popup title', 'yith-wctc' ),
				'type'      => 'checkbox',
				'desc'      => __( 'Show page title in popup header', 'yith-wctc' ),
				'default'   => 'yes',
				'css'       => 'min-width:300px;'
			),

			'popup-button' => array(
				'id'        => 'yith_wctc_popup_button',
				'name'      => __( 'Popup button', 'yith-wctc' ),
				'type'      => 'checkbox',
				'desc'      => __( 'Show "I Agree" button in popup footer', 'yith-wctc' ),
				'default'   => 'yes',
				'css'       => 'min-width:300px;'
			),

			'popup-button-text' => array(
				'id'        => 'yith_wctc_popup_button_text',
				'name'      => __( '"I Agree" button text', 'yith-wctc' ),
				'type'      => 'text',
				'desc'      => __( '"I Agree" button text in popup footer', 'yith-wctc' ),
				'default'   => __( 'I agree', 'yith-wctc' ),
				'css'       => 'min-width:300px;'
			),

			'scroll-till-end-to-accept' => array(
				'id'        => 'yith_wctc_scroll_till_end',
				'name'      => __( 'Scroll till end of the document to accept', 'yith-wctc' ),
				'type'      => 'checkbox',
				'desc'      => __( 'Force the user to scroll popup till the end to accept terms and conditions', 'yith-wctc' ),
				'default'   => 'no',
				'css'       => 'min-width:300px;'
			),

			'scroll-till-end-to-accept-message' => array(
				'id'        => 'yith_wctc_scroll_till_end_message',
				'name'      => __( '"Please, read terms" message', 'yith-wctc' ),
				'type'      => 'text',
				'desc'      => __( 'Error message shown when a user tries to accept terms without scrolling popup window till the end', 'yith-wctc' ),
				'default'   => __( 'Please, read carefully ALL terms and conditions', 'yith-wctc' ),
				'css'       => 'min-width:300px;'
			),

			'popup-options-end' => array(
				'type'  => 'sectionend',
				'id'    => 'yith_wctc_popup_options'
			),

			'checkbox-options' => array(
				'title' => __( 'Terms/Privacy Options', 'yith-wctc' ),
				'type' => 'title',
				'desc' => '',
				'id' => 'yith_wctc_checkbox_options'
			),

			'hide-checkboxes' => array(
				'id'        => 'yith_wctc_hide_checkboxes',
				'name'      => __( 'Hide checkboxes', 'yith-wctc' ),
				'type'      => 'checkbox',
				'desc'      => __( 'Hide checkboxes in checkout page', 'yith-wctc' ),
				'default'   => 'no',
				'css'       => 'min-width:300px;'
			),

			'terms-type' => array(
				'id'        => 'yith_wctc_terms_type',
				'name'      => __( 'Terms and Conditions / Privacy', 'yith-wctc' ),
				'type'      => 'select',
				'desc'      => __( 'Select pages of conditions that you want to show on checkout', 'yith-wctc' ),
				'options'   => array(
					'terms'   => __( 'Only Terms and Conditions', 'yith-wctc' ),
					'privacy' => __( 'Only Privacy', 'yith-wctc' ),
					'both'    => __( 'Both Terms and Privacy', 'yith-wctc' )
				),
				'default' => 'terms',
				'css'       => 'min-width:300px;'
			),

			'terms-fields' => array(
				'id'        => 'yith_wctc_terms_fields',
				'name'      => __( 'Show terms together or apart', 'yith-wctc' ),
				'type'      => 'select',
				'desc'      => __( 'Decide whether to show privacy and conditions as a single checkbox or as two different checkbox.', 'yith-wctc' ),
				'options'   => array(
					'together' => __( 'Together', 'yith-wctc' ),
					'apart'    => __( 'Apart', 'yith-wctc' )
				),
				'default'   => 'togheter',
				'css'       => 'min-width:300px;'
			),

			'terms-page-id' => array(
				'title'    => __( 'Terms and Conditions', 'woocommerce' ),
				'desc'     => __( 'If you define a "Terms" page, customers will be asked to accept them when checking out.', 'woocommerce' ),
				'id'       => 'woocommerce_terms_page_id',
				'default'  => '',
				'class'    => 'wc-enhanced-select-nostd',
				'css'      => 'width:300px;',
				'type'     => 'single_select_page',
				'desc_tip' => true,
				'autoload' => false
			),

			'terms-text' => array(
				'id'        => 'yith_wctc_terms_text',
				'name'      => __( '"Terms and Conditions" text', 'yith-wctc' ),
				'type'      => 'text',
				'desc'      => __( 'Select text that contains "Terms and Conditions" link; use "%TERMS AND CONDITIONS%" where you want the link to be printed', 'yith-wctc' ),
				'default'   => __( 'I&rsquo;ve read and accept the %TERMS AND CONDITIONS%', 'yith-wctc' ),
				'css'       => 'min-width:300px;'
			),

			'terms-label' => array(
				'id'        => 'yith_wctc_terms_label',
				'name'      => __( '"Terms and Conditions" label', 'yith-wctc' ),
				'type'      => 'text',
				'desc'      => __( 'Select label for "Terms and Conditions" link', 'yith-wctc' ),
				'default'   => __( 'terms &amp; conditions', 'yith-wctc' ),
				'css'       => 'min-width:300px;'
			),

			'terms-checked' => array(
				'id'        => 'yith_wctc_terms_checked',
				'name'      => __( 'Terms and Conditions checked', 'yith-wctc' ),
				'type'      => 'checkbox',
				'desc'      => __( 'Terms and Conditions checkbox will be printed as checked', 'yith-wctc' ),
				'default'   => 'no'
			),

			'privacy-page-id' => array(
				'title'    => __( 'Privacy', 'yith-wctc' ),
				'desc'     => __( 'If you define a "Privacy" page, customers will be asked to accept them when checking out.', 'yith-wctc' ),
				'id'       => 'yith_wctc_privacy_page_id',
				'default'  => '',
				'class'    => 'wc-enhanced-select-nostd',
				'css'      => 'width:300px',
				'type'     => 'single_select_page',
				'desc_tip' => true,
				'autoload' => false
			),

			'privacy-text' => array(
				'id'        => 'yith_wctc_privacy_text',
				'name'      => __( '"Privacy" text', 'yith-wctc' ),
				'type'      => 'text',
				'desc'      => __( 'Select text that contains "Privacy" link; use "%PRIVACY%" where you want the link to be printed', 'yith-wctc' ),
				'default'   => __( 'I&rsquo;ve read and accept the %PRIVACY%', 'yith-wctc' ),
				'css'       => 'min-width:300px;'
			),

			'privacy-label' => array(
				'id'        => 'yith_wctc_privacy_label',
				'name'      => __( '"Privacy" label', 'yith-wctc' ),
				'type'      => 'text',
				'desc'      => __( 'Select label for "Privacy" link', 'yith-wctc' ),
				'default'   => __( 'privacy conditions', 'yith-wctc' ),
				'css'       => 'min-width:300px;'
			),

			'privacy-checked' => array(
				'id'        => 'yith_wctc_privacy_checked',
				'name'      => __( 'Privacy checked', 'yith-wctc' ),
				'type'      => 'checkbox',
				'desc'      => __( 'Privacy checkbox will be printed as checked', 'yith-wctc' ),
				'default'   => 'no'
			),

			'common-text' => array(
				'id'        => 'yith_wctc_common_text',
				'name'      => __( 'Unique option text', 'yith-wctc' ),
				'type'      => 'text',
				'desc'      => __( 'Select text that contains "Privacy" and "Terms and Conditions" links; use "%PRIVACY%" and "%TERMS AND CONDITIONS%" where you want links to be printed', 'yith-wctc' ),
				'default'   => __( 'I&rsquo;ve read and accept the %TERMS AND CONDITIONS% and %PRIVACY%', 'yith-wctc' ),
				'css'       => 'min-width:300px;'
			),

			'common-checked' => array(
				'id'        => 'yith_wctc_common_checked',
				'name'      => __( 'Unique option checked', 'yith-wctc' ),
				'type'      => 'checkbox',
				'desc'      => __( 'The checkbox will be printed as checked', 'yith-wctc' ),
				'default'   => 'no'
			),

			'checkbox-options-end' => array(
				'type'  => 'sectionend',
				'id'    => 'yith_wctc_checkbox_options'
			),

		)
	)
);