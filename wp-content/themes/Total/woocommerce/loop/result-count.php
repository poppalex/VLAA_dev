<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Return if disabled in theme options
if ( ! wpex_option( 'woo_shop_result_count', '1' ) ) return;

global $woocommerce, $wp_query;

if ( ! woocommerce_products_will_display() )
	return;
?>
<p class="woocommerce-result-count">
	<?php
	$paged = max( 1, $wp_query->get( 'paged' ) );
	$per_page = $wp_query->get( 'posts_per_page' );
	$total = $wp_query->found_posts;
	$first = ( $per_page * $paged ) - $per_page + 1;
	$last = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );
	if ( 1 == $total ) {
		_e( 'Showing the single result', 'wpex' );
	} elseif ( $total <= $per_page || -1 == $per_page ) {
		printf( __( 'Showing all %d results', 'wpex' ), $total );
	} else {
		printf( _x( 'Showing %1$d–%2$d of %3$d results', '%1$d = first, %2$d = last, %3$d = total', 'wpex' ), $first, $last, $total );
	} ?>
</p>