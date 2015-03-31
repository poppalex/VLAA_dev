<?php
/**
 * Single Product Thumbnails
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $post, $product, $woocommerce;
	$post_id = $post->ID;
	$featured_image_id = get_post_thumbnail_id($post_id);
	$attachment_ids = $product->get_gallery_attachment_ids();
	$featured_image_id = get_post_thumbnail_id($post->ID);
	$attachment_ids = array_unique( array_merge( array( $featured_image_id ), $attachment_ids ) );
	if ( count( $attachment_ids ) > '1' ) { ?>

		<div class="thumbnails"><?php
			$loop = 0;
			$columns = '5';
			
			// Loop through attachments
			foreach ( $attachment_ids as $attachment_id ) {
				
				// Column Classes
				if ( $attachment_id != $featured_image_id ) {
					$classes = array( 'woo-lightbox' );
				}

				if ( $loop == 0 || $loop % $columns == 0 )
					$classes[] = 'first';
				if ( ( $loop + 1 ) % $columns == 0 )
					$classes[] = 'last';
					
				// Image id
				$attachment_url = wp_get_attachment_url( $attachment_id );
					
				// Create link that goes to cropped post image
				$width = wpex_option( 'woo_post_image_width', '9999' );
				$height = wpex_option( 'woo_post_image_height', '9999' );
				$crop = ( $height == '9999' ) ? false : true;
				$image_link = wpex_image_resize( $attachment_url, $width,  $height,  $crop);
				if ( ! $image_link ) continue;
				
				// Add active class to image if its the same as featured image
				if ( $featured_image_id == $attachment_id ) {
					$classes[] = ' active-thumb';
				}
				
				// Display small thumb
				$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
				$resized_image = wpex_image_resize( $attachment_url, 100, 100, true);
				$image = '<img src="'. $resized_image .'" alt="'. $alt .'">';
				$image_class = esc_attr( implode( ' ', $classes ) );
				$image_title = '';
				
				if ( $resized_image ) {
					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-mfp-src="%s">%s</a>', $image_link, $image_class, $image_title, $attachment_url, $image ), $attachment_id, $post->ID, $image_class );
				}
				$loop++;
			} ?></div>
			
		<?php
	} // End if