<?php
/**
 * General settings page
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Terms & Conditions
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCTC' ) ) {
	exit;
} // Exit if accessed directly

return apply_filters(
	'yith_wctc_layout_settings',
	array(
		'layout' => array(

			'popup-options' => array(
				'title' => __( 'Popup Layout', 'yith-wctc' ),
				'type' => 'title',
				'desc' => '',
				'id' => 'yith_wctc_popup_options'
			),

			'popup-round-corners' => array(
				'id'        => 'yith_wctc_popup_round_corners',
				'name'      => __( 'Round Popup Corners', 'yith-wctc' ),
				'type'      => 'checkbox',
				'default'   => 'yes'
			),

			'popup-background-color' => array(
				'id'      => 'yith_wctc_popup_background_color',
				'name'    => __( 'Modal Window Background Color', 'yith-wctc' ),
				'type'    => 'color',
				'desc'    => '',
				'default' => '#ffffff'
			),

			'popup-overlay-color' => array(
				'id'      => 'yith_wctc_popup_overlay_color',
				'name'    => __( 'Modal Overlay Background Color', 'yith-wctc' ),
				'type'    => 'color',
				'desc'    => '',
				'default' => '#000000'
			),

			'popup-overlay-opacity' => array(
				'id'        => 'yith_wctc_popup_overlay_opacity',
				'name'      => __( 'Popup overlay opacity', 'yith-wctc' ),
				'type'      => 'text',
				'desc'      => __( 'Popup overlay opacity (between 0 and 1)', 'yith-wctc' ),
				'default'   => 1,
				'css'       => 'min-width:300px;'
			),

			'popup-close-button-color' => array(
				'id'      => 'yith_wctc_popup_close_button_color',
				'name'    => __( 'Modal Close Button Background Color', 'yith-wctc' ),
				'type'    => 'color',
				'desc'    => '',
				'default' => '#000000'
			),

			'popup-close-button-opacity' => array(
				'id'        => 'yith_wctc_popup_close_button_opacity',
				'name'      => __( 'Popup Close Button opacity', 'yith-wctc' ),
				'type'      => 'text',
				'desc'      => __( 'Popup Close Button opacity (between 0 and 1)', 'yith-wctc' ),
				'default'   => 1,
				'css'       => 'min-width:300px;'
			),

			'popup-close-button-style' => array(
				'id'      => 'yith_wctc_popup_close_button_style',
				'name'    => __( 'Popup close button style', 'yith-wctc' ),
				'type'    => 'select',
				'options' => array(
					'big'         => __( 'Big', 'yith-wctc' ),
					'small'       => __( 'Small', 'yith-wctc' ),
					'square'      => __( 'Square', 'yith-wctc' ),
					'round-big'   => __( 'Round big', 'yith-wctc' ),
					'round-small' => __( 'Round small', 'yith-wctc' ),
				),
				'default'   => 'big',
				'css'       => 'min-width:300px;'
			),

			'popup-loading-image' => array(
				'id'      => 'yith_wctc_popup_loading_image',
				'name'    => __( 'Loading image', 'yith-wctc' ),
				'type'    => 'select',
				'options' => array(
					'circle' => __( 'Circle', 'yith-wctc' ),
					'dots'   => __( 'Dots', 'yith-wctc' ),
					'ios'    => __( 'Ios', 'yith-wctc' ),
					'quads'  => __( 'Quads', 'yith-wctc' )
				),
				'default' => 'circle',
				'css'       => 'min-width:300px;'
			),

			'popup-effect' => array(
				'id'      => 'yith_wctc_popup_effect',
				'name'    => __( 'Popup show effect', 'yith-wctc' ),
				'type'    => 'select',
				'options' => array(
					'0' => __( 'None', 'yith-wctc' ),
					'1' => __( 'Huge Inc', 'yith-wctc' ),
					'2' => __( 'Corner', 'yith-wctc' ),
					'3' => __( 'Slide down', 'yith-wctc' ),
					'4' => __( 'Scale', 'yith-wctc' ),
					'5' => __( 'Little genie', 'yith-wctc' ),
				),
				'css'       => 'min-width:300px;',
				'default' => 0
			),

			'popup-options-end' => array(
				'type'  => 'sectionend',
				'id'    => 'yith_wctc_popup_options'
			),

			'agree-button-options' => array(
				'title' => __( '"I Agree" Button Layout', 'yith-wctc' ),
				'type' => 'title',
				'desc' => '',
				'id' => 'yith_wctc_agree_button_options'
			),

			'agree-button-alignment' => array(
				'id'      => 'yith_wctc_agree_button_alignment',
				'name'    => __( 'Button alignment', 'yith-wctc' ),
				'type'    => 'select',
				'options' => array(
					'left' => __( 'Left', 'yith-wctc' ),
					'center' => __( 'Center', 'yith-wctc' ),
					'right' => __( 'Right', 'yith-wctc' )
				),
				'default' => 'right',
				'css'       => 'min-width:300px;'
			),

			'agree-button-type' => array(
				'id'      => 'yith_wctc_agree_button_type',
				'name'    => __( '"I Agree" button type', 'yith-wctc' ),
				'type'    => 'select',
				'options' => array(
					'button' => __( 'Button', 'yith-wctc' ),
					'anchor' => __( 'Anchor', 'yith-wctc' )
				),
				'default' => 'button',
				'css'       => 'min-width:300px;'
			),

			'agree-button-style' => array(
				'id'      => 'yith_wctc_agree_button_style',
				'name'    => __( '"I Agree" button style', 'yith-wctc' ),
				'type'    => 'select',
				'options' => array(
					'woocommerce' => __( 'WooCommerce', 'yith-wctc' ),
					'custom' => __( 'Custom', 'yith-wctc' )
				),
				'default' => 'woocommerce',
				'css'       => 'min-width:300px;'
			),

			'agree-button-corners' => array(
				'id'        => 'yith_wctc_agree_button_round_corners',
				'name'      => __( 'Round Corners for "I Agree" Button', 'yith-wctc' ),
				'type'      => 'checkbox',
				'default'   => 'yes'
			),

			'agree-button-background-color' => array(
				'id'      => 'yith_wctc_agree_button_background_color',
				'name'    => __( '"I Agree" Button Background Color', 'yith-wctc' ),
				'type'    => 'color',
				'desc'    => '',
				'default' => '#ebe9eb'
			),

			'agree-button-color' => array(
				'id'      => 'yith_wctc_agree_button_color',
				'name'    => __( '"I Agree" Button Text Color', 'yith-wctc' ),
				'type'    => 'color',
				'desc'    => '',
				'default' => '#515151'
			),

			'agree-button-border-color' => array(
				'id'      => 'yith_wctc_agree_button_border_color',
				'name'    => __( '"I Agree" Button Border Color', 'yith-wctc' ),
				'type'    => 'color',
				'desc'    => '',
				'default' => '#ebe9eb'
			),

			'agree-button-background-color-hover' => array(
				'id'      => 'yith_wctc_agree_button_background_hover_color',
				'name'    => __( '"I Agree" Button Hover Background Color', 'yith-wctc' ),
				'type'    => 'color',
				'desc'    => '',
				'default' => '#dad8da'
			),

			'agree-button-color-hover' => array(
				'id'      => 'yith_wctc_agree_button_hover_color',
				'name'    => __( '"I Agree" Button Hover Text Color', 'yith-wctc' ),
				'type'    => 'color',
				'desc'    => '',
				'default' => '#515151'
			),

			'agree-button-border-color-hover' => array(
				'id'      => 'yith_wctc_agree_button_border_hover_color',
				'name'    => __( '"I Agree" Button Hover Border Color', 'yith-wctc' ),
				'type'    => 'color',
				'desc'    => '',
				'default' => '#dad8da'
			),

			'agree-button-options-end' => array(
				'type'  => 'sectionend',
				'id'    => 'yith_wctc_agree_button_options'
			),

		)
	)
);