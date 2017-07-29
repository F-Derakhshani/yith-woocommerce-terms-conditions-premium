<?php
/**
 * Terms & Conditions custom template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Terms & Condtions Popup
 * @version 1.0.0
 */

if ( $show_line ) : ?>
	<div class="terms-privacy-conditions">

		<?php if( $terms_type == 'both' && $terms_fields == 'together' ): ?>
			<p class="form-row terms">
				<input <?php echo ( $hide_checkbox ) ? 'style="display:none;"' : '' ?> type="checkbox" class="input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_privacy_is_checked_default', isset( $_POST['terms'] ) || $checked ), true ); ?> id="terms_checkbox" />
				<label for="privacy" class="checkbox">
					<?php echo $line ?>
				</label>
			</p>
		<?php endif;?>

		<?php if( ( $terms_type == 'both' && $terms_fields == 'apart' ) || $terms_type == 'terms' ): ?>
			<p class="form-row terms">
				<input <?php echo ( $hide_checkbox ) ? 'style="display:none;"' : '' ?> type="checkbox" class="input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) || $terms_checked ), true ); ?> id="terms_checkbox" />
				<label for="terms" class="checkbox">
					<?php echo $line_terms ?>
				</label>
			</p>
		<?php endif; ?>

		<?php if( ( $terms_type == 'both' && $terms_fields == 'apart' ) || $terms_type == 'privacy' ): ?>
			<p class="form-row terms">
				<input <?php echo ( $hide_checkbox ) ? 'style="display:none;"' : '' ?> type="checkbox" class="input-checkbox" name="<?php echo ( $terms_type == 'privacy' ) ? 'terms' : 'privacy'?>" <?php checked( apply_filters( 'woocommerce_privacy_is_checked_default', isset( $_POST['privacy'] ) || $privacy_checked ), true ); ?> id="privacy_checkbox" />
				<label for="privacy" class="checkbox">
					<?php echo $line_privacy ?>
				</label>
			</p>
		<?php endif;?>

	</div>
<?php endif; ?>