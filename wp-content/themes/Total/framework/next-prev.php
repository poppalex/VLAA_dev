<?php
/**
 * Used for next and previous post links
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/


// Check if a post has categories
if ( ! function_exists( 'wpex_post_has_terms' ) ) {
	function wpex_post_has_terms() {
		global $post;
		$post_id = $post->ID;
		$post_type = get_post_type($post_id);

		// Standard Posts
		if ( $post_type == 'post' ) {
			$terms = wp_get_post_terms($post_id, 'category');
			if ( !empty($terms) ) {
				if ( '1' == count($terms) ) {
					if ( $terms[0]->count > '1' ) return true;
				} else {
					return true;
				}
			}
		}

		// Portfolio
		if ( $post_type == 'portfolio' ) {
			$terms = wp_get_post_terms($post_id, 'portfolio_category');
			if ( !empty($terms) ) {
				if ( '1' == count($terms) ) {
					if ( $terms[0]->count > '1' ) return true;
				} else {
					return true;
				}
			}
		}

		// Staff
		if ( $post_type == 'staff' ) {
			$terms = wp_get_post_terms($post_id, 'staff_category');
			if ( !empty($terms) ) {
				if ( '1' == count($terms) ) {
					if ( $terms[0]->count > '1' ) return true;
				} else {
					return true;
				}
			}
		}

		// Testimonials
		if ( $post_type == 'testimonials' ) {
			$terms = wp_get_post_terms($post_id, 'testimonials_category');
			if ( !empty($terms) ) {
				if ( '1' == count($terms) ) {
					if ( $terms[0]->count > '1' ) return true;
				} else {
					return true;
				}
			}
		}

		// Return false
		return false;
	}
}

// Display next/previous links
if ( ! function_exists( 'wpex_next_prev' ) ) {
	function wpex_next_prev() {
		// Get post data
		global $post;
		// Not singular so bye bye!
		if ( !is_singular() ) {
			return;
		}
		// Get post ID
		$post_id = $post->ID;
		// Get current post post type
		$post_type = get_post_type($post_id);
		// Set default same category + taxonomy vars
		$taxonomy = '';
		// Check if post has terms - see function above
		$has_terms = wpex_post_has_terms();
		// Loop through each post type that is part of the theme
		// Based on if the post has terms or not choose to display
		// Items from the same term or not
		if ( $post_type == 'post' ) {
			$taxonomy = 'category';
			$same_cat = $has_terms;
		}
		if ( $post_type == 'portfolio' ) {
			$taxonomy = 'portfolio_category';
			$same_cat = $has_terms;
		}
		if ( $post_type == 'staff' ) {
			$taxonomy = 'staff_category';
			$same_cat = $has_terms;
		}
		if ( $post_type == 'testimonials' ) {
			$taxonomy = 'testimonials_category';
			$same_cat = $has_terms;
		} ?>
		<?php
		// Output the next/previous links ?>
		<div class="clr"></div>
		<ul class="post-pagination clr">
			<?php if ( $has_terms ) { ?>
				<?php previous_post_link( '<li class="post-next">%link<span>&rarr;</span></li>', '%title', $same_cat, '', $taxonomy ); ?><?php next_post_link( '<li class="post-prev"><span>&larr;</span>%link</li>', '%title', $same_cat, '', $taxonomy ); ?>
			<?php } else { ?>
				<?php previous_post_link( '<li class="post-next">%link<span>&rarr;</span></li>', '%title' ); ?><?php next_post_link( '<li class="post-prev"><span>&larr;</span>%link</li>', '%title' ); ?>
			<?php } ?>
		</ul><!-- .post-post-pagination -->
	<?php }
}