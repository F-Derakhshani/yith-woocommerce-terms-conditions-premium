<?php
/**
 * Terms & Conditions pupup template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Terms & Condtions Popup
 * @version 1.0.0
 */
?>

<div class="woocommerce" data-type="<?php echo $type?>">
	<?php if( $show_title ): ?>
		<h2 class="popup-title"><?php echo $contents['title']?></h2>
	<?php endif; ?>
		<div class="popup-content" <?php echo $content_style?> >
			<div class="scrollbar-outer">
				<?php echo wpautop( do_shortcode( $contents['content'] ) )?>
			</div>
		</div>
	<?php if( $popup_button ): ?>
		<div class="popup-footer">
			<a id="agree_<?php echo $type?>_button" href="#" class="agree-button <?php echo ( $button_style == 'button' ) ? 'btn button' : '' ?>"><?php echo $popup_button_text ?></a>
		</div>
	<?php endif; ?>
</div>