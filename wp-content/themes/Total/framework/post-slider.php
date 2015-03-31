<?php
/**
 * Display page slider based on meta option
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/


if ( ! function_exists('wpex_post_slider') ) {

	function wpex_post_slider() {

		// Not singular, bye!
		if ( ! is_singular() && ! is_post_type_archive( 'product' ) ) {
			return;
		}
		
		// Vars
		global $post;
		$post_id = $post->ID;
		if ( class_exists( 'Woocommerce' ) && function_exists( 'wc_get_page_id' ) ) {
			$shop_id = wc_get_page_id( 'shop' );
			if ( is_post_type_archive( 'product' ) && isset($shop_id) ) {
				$post_id = $shop_id;
			}
		}
		$legacy_slider = get_post_meta( $post_id, 'wpex_post_slider_shortcode', true );
		$slider = get_post_meta( $post_id, 'wpex_post_slider_shortcode', true );
		$slider = ( ! empty( $legacy_slider ) ) ? $legacy_slider : $slider;
		$main_title = get_post_meta( $post_id, 'wpex_disable_title', true );
		$margin = get_post_meta( $post_id, 'wpex_post_slider_bottom_margin', true );
		$margin = intval($margin);
		
		// Display Slider
		if ( $slider  !== '' ) { ?>
			<div class="page-slider clr">
				<?php echo apply_filters( 'the_content', $slider ); ?>
			</div><!-- .page-slider -->
			<?php if ( $margin ) { ?>
				<div style="height:<?php echo $margin; ?>px;"></div>
			<?php } ?>
		<?php }

	}

}