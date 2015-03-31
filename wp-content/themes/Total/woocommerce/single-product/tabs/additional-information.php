<?php
/**
 * Additional Information tab
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post, $product;

if ( wpex_option( 'woo_product_tabs_headings' ) ) {
	$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional Information', 'woocommerce' ) ); ?>
	<h2><?php echo $heading; ?></h2>
<?php } ?>
<?php $product->list_attributes(); ?>