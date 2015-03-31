<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );

// Increase loop count
$woocommerce_loop['loop']++; ?>

<li class="product-category <?php echo wpex_grid_class($woocommerce_loop['columns']); ?> col product<?php
	if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1)
		echo ' first';
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
		echo ' last';
	?>">
	<div class="product-category-inner clr">
		<?php do_action( 'woocommerce_before_subcategory', $category ); ?>
		<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
			<?php
				/**
				 * woocommerce_before_subcategory_title hook
				 *
				 * @hooked woocommerce_subcategory_thumbnail - 10
				 */
				do_action( 'woocommerce_before_subcategory_title', $category );
			?>
			<h3>
				<?php
					echo $category->name;

					if ( $category->count > 0 )
						echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
				?>
			</h3>
			<?php
				/**
				 * woocommerce_after_subcategory_title hook
				 */
				do_action( 'woocommerce_after_subcategory_title', $category );
			?>
		</a>
		<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
	</div>
</li>