<?php
/**
	Add Staff Grid Shortcode
**/
if( !function_exists( 'vcex_staff_grid_shortcode' ) ) {

	function vcex_staff_grid_shortcode($atts) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
			'unique_id'				=> '',
			'term_slug'				=> '',
			'include_categories'	=> '',
			'exclude_categories'	=> '',
			'posts_per_page'		=> '',
			'grid_style'			=> 'fit_columns',
			'columns'				=> '',
			'order'					=> 'DESC',
			'orderby'				=> 'date',
			'filter'				=> 'true',
			'center_filter'			=> '',
			'thumbnail_link'		=> 'post',
			'img_crop'				=> 'true',
			'img_width'				=> '9999',
			'img_height'			=> '9999',
			'thumb_link'			=> 'post',
			'img_filter'			=> '',
			'title'					=> 'true',
			'title_link'			=> 'post',
			'excerpt'				=> 'true',
			'excerpt_length'		=> '15',
			'read_more'				=> 'false',
			'read_more_text'		=> __( 'read more', 'wpex' ),
			'pagination'			=> 'false',
			'filter_content'		=> 'false',
			'social_links'			=> 'true',
			'offset'				=> 0,
			'taxonomy'				=> '',
			'terms'					=> '',
			'img_hover_style'		=> '',
			'img_rendering'			=> '',
			'all_text'				=> __( 'All', 'wpex' ),
			'overlay_style'			=> '',
		), $atts ) );
		
		// Turn output buffer on
		ob_start();

			// Get global $post var
			global $post;

			// Don't create custom tax if tax doesn't exist
			if ( taxonomy_exists( 'staff_category' ) ) {
				
				// Include categories
				$include_categories = ( '' != $include_categories ) ? $include_categories : $term_slug;
				$include_categories = ( 'all' == $include_categories ) ? '' : $include_categories;
				$filter_cats_include = '';
				if ( $include_categories ) {
					$include_categories = explode( ',', $include_categories );
					$filter_cats_include = array();
					foreach ( $include_categories as $key ) {
						$key = get_term_by( 'slug', $key, 'staff_category' );
						$filter_cats_include[] = $key->term_id;
					}
				}

				// Exclude categories
				$filter_cats_exclude = '';
				if ( $exclude_categories ) {
					$exclude_categories = explode( ',', $exclude_categories );
					if( ! empty( $exclude_categories ) && is_array( $exclude_categories ) ) {
					$filter_cats_exclude = array();
					foreach ( $exclude_categories as $key ) {
						$key = get_term_by( 'slug', $key, 'staff_category' );
						$filter_cats_exclude[] = $key->term_id;
					}
					$exclude_categories = array(
							'taxonomy'	=> 'staff_category',
							'field'		=> 'slug',
							'terms'		=> $exclude_categories,
							'operator'	=> 'NOT IN',
						);
					} else {
						$exclude_categories = '';
					}
				}

				// Start Tax Query
				if( ! empty( $include_categories ) && is_array( $include_categories ) ) {
					$include_categories = array(
						'taxonomy'	=> 'staff_category',
						'field'		=> 'slug',
						'terms'		=> $include_categories,
						'operator'	=> 'IN',
					);
				} else {
					$include_categories = '';
				}

			}

			// Pagination var
			if( 'true' == $pagination ) {
				global $paged;
				$paged = get_query_var('paged') ? get_query_var('paged') : 1;
				$no_found_rows = false;
			} else {
				$paged = NULL;
				$no_found_rows = true;
			}
			
			// The Query
			$vcex_query = new WP_Query(
				array(
					'post_type'			=> 'staff',
					'posts_per_page'	=> $posts_per_page,
					'offset'			=> $offset,
					'order'				=> $order,
					'orderby'			=> $orderby,
					'filter_content'	=> $filter_content,
					'paged'				=> $paged,
					'tax_query'			=> array(
						'relation'		=> 'AND',
						$include_categories,
						$exclude_categories,
					),
					'no_found_rows'		=> $no_found_rows
				)
			);

			//Output posts
			if( $vcex_query->posts ) :
			
				// Main Vars
				$rand_num = rand(1, 100);
				$unique_id = $unique_id ? $unique_id : 'staff-'. rand( 1, 100 );
				$img_crop = $img_height == '9999' ? false : true;
				$read_more = $read_more == 'true' ? true : false;

				// Is Isotope var
				if ( 'true' == $filter  || 'masonry' == $grid_style ) {
					$is_isotope = true;
				} else {
					$is_isotope = false;
				}

				// No need for masonry if not enough columns and filter is disabled
				if ( 'true' != $filter && 'masonry' == $grid_style ) {
					$post_count = count( $vcex_query->posts );
					if ( $post_count <= $columns ) {
						$is_isotope = false;
					}
				}

				// Output script for inline JS for the Visual composer front-end builder
				if ( function_exists( 'vcex_front_end_grid_js' ) ) {
					if ( $is_isotope ) {
						vcex_front_end_grid_js( 'isotope' );
					}
				}

				// Display filter links
				if ( $filter == 'true' && taxonomy_exists( 'staff_category' ) ) {
					$terms = get_terms( 'staff_category', array(
						'include'	=> $filter_cats_include,
						'exclude'	=> $filter_cats_exclude,
					) );
					$terms = apply_filters( 'vcex_staff_grid_get_terms', $terms );
					if( $terms && count($terms) > '1') {
						$center_filter = 'yes' == $center_filter ? 'center' : ''; ?>
						<ul class="vcex-staff-filter filter-<?php echo $unique_id; ?> vcex-filter-links <?php echo $center_filter; ?> clr">
							<li class="active"><a href="#" data-filter="*"><span><?php echo $all_text; ?></span></a></li>
							<?php foreach ($terms as $term ) : ?>
								<li><a href="#" data-filter=".cat-<?php echo $term->term_id; ?>"><?php echo $term->name; ?></a></li>
							<?php endforeach; ?>
						</ul><!-- .vcex-staff-filter -->
					<?php } ?>
				<?php } ?>
		
				<div class="wpex-row vcex-staff-grid vcex-clearfix <?php if ( $is_isotope ) echo 'vcex-isotope-grid'; ?>" id="<?php echo $unique_id; ?>">
					<?php
					// Define counter var to clear floats
					$count='';
					// Start loop
					foreach ( $vcex_query->posts as $post ) : setup_postdata( $post );
						// Define post ID var
						$post_id = $post->ID;
						// Add to the counter var
						$count++;
						// Add classes to the entries
						$entry_classes = 'staff-entry col';
						// Column class
						$entry_classes .= ' span_1_of_'. $columns;
						// Counter
						$entry_classes .= ' col-'. $count;
						// Isotope
						if ( $is_isotope ) {
							$entry_classes .= ' vcex-isotope-entry';
						}
						// Image rendering
						if ( $img_rendering ) {
							$entry_classes .= ' vcex-image-rendering-'. $img_rendering;
						}
						// Categories
						if ( taxonomy_exists( 'staff_category' ) ) {
							$post_terms = get_the_terms( $post, 'staff_category' );
							if ( $post_terms ) {
								foreach ( $post_terms as $post_term ) {
									$entry_classes .= ' cat-'. $post_term->term_id;
								}
							}
						} ?>
						<article id="#post-<?php the_ID(); ?>" class="<?php echo $entry_classes; ?>">
							<?php
								//Featured Image
								if( has_post_thumbnail() ) {
									// Image rendering
									if ( $img_rendering ) {
										$entry_classes .= ' vcex-image-rendering-'. $img_rendering;
									}
									// Categories
									if ( taxonomy_exists( 'staff_category' ) ) {
										$post_terms = get_the_terms( $post, 'staff_category' );
										if ( $post_terms ) {
											foreach ( $post_terms as $post_term ) {
												$entry_classes .= ' cat-'. $post_term->term_id;
											}
										}
									}
									// Overlays
									if ( function_exists( 'wpex_overlay_classname' ) ) {
										$overlay_classnames = wpex_overlay_classname( $overlay_style );
									} else {
										$overlay_classnames = '';
									}
									// Image Filter class
									$img_filter_class = $img_filter ? 'vcex-'. $img_filter : '';
									// Image hover styles
									$img_hover_style_class = $img_hover_style ? 'vcex-img-hover-parent vcex-img-hover-'. $img_hover_style : ''; ?>
									<div class="staff-entry-media <?php echo $img_filter_class; ?> <?php echo $img_hover_style_class; ?> <?php echo $overlay_classnames; ?>">
										<?php if ( 'post' == $thumb_link || 'lightbox' == $thumb_link ) { ?>
											<?php if ( 'post' == $thumb_link ) { ?>
												<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="staff-entry-media-link">
											<?php } ?>
											<?php if ( $thumb_link == 'lightbox' ) { ?>
												<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="staff-entry-media-link vcex-lightbox">
											<?php } ?>
										<?php }
											// Get cropped image array and display image
											$cropped_img = wpex_image_resize( wp_get_attachment_url( get_post_thumbnail_id() ), intval($img_width), intval($img_height), $img_crop, 'array' ); ?>
											<img src="<?php echo $cropped_img['url']; ?>" alt="<?php the_title(); ?>" class="staff-entry-img" height="<?php echo $cropped_img['height']; ?>" width="<?php echo $cropped_img['width']; ?>" />
										<?php if ( 'post' == $thumb_link || 'lightbox' == $thumb_link ) { ?>
											<?php
											// Inner Overlay
											if ( function_exists( 'wpex_overlay' ) ) {
												wpex_overlay( 'inside_link', $overlay_style );
											} ?>
											</a>
										<?php } ?>
										<?php
										// Outside Overlay
										if ( function_exists( 'wpex_overlay' ) ) {
											wpex_overlay( 'outside_link', $overlay_style );
										} ?>
									</div><!-- .staff-media -->
								<?php } ?>
								<?php if ( 'true' == $title || 'true' == $excerpt || 'true' == $read_more ) { ?>
									<div class="staff-entry-details clr">
										<?php if ( $title == 'true' ) { ?>
											<h2 class="staff-entry-title">
												<?php if ( 'post' == $title_link ) { ?>
													<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a>
												<?php } else { ?>
													<?php the_title(); ?>
												<?php } ?>
											</h2>
										<?php } ?>
										<?php if ('true' ==  $excerpt ) {
											if ( 'true' != $excerpt ){
												$excerpt_length = '0';
											} ?>
											<div class="clr"></div>
											<div class="staff-entry-excerpt clr">
												<?php if ( '9999' == $excerpt_length ) {
													the_content();
												} else {
													vcex_excerpt( $excerpt_length, false );
												} ?>
											</div>
										<?php } ?>
										<?php
										// Display social links
										if ( function_exists( 'wpex_get_staff_social' ) && 'true' == $social_links ) {
											echo wpex_get_staff_social();
										}
										// Read more button
										if ( 'true' == $read_more ) { ?>
												<a href="<?php echo get_permalink(); ?>" title="<?php $read_more_text; ?>" rel="bookmark" class="vcex-readmore theme-button">
													<?php echo $read_more_text; ?> <span class="vcex-readmore-rarr">&rarr;</span>
												</a>
										<?php } ?>
									</div><!-- .staff-entry-details -->
								<?php } ?>
							</article><!-- .staff-entry -->
							<?php
							// Reset counter
							if ( $count == $columns ) {
								$count = '';
							} ?>
						<?php endforeach; ?>
					</div><!-- .vcex-staff-grid -->
					
					<?php
					// Paginate Posts
					if( $pagination == 'true' ) {
						$total = $vcex_query->max_num_pages;
						$big = 999999999; // need an unlikely integer
						if( $total > 1 ) {
							if( !$current_page = get_query_var( 'paged' ) )
								$current_page = 1;
							if( get_option('permalink_structure') ) {
								$format = 'page/%#%/';
							} else {
								$format = '&paged=%#%';
							}
							echo paginate_links(array(
								'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format'		=> $format,
								'current'		=> max( 1, get_query_var('paged') ),
								'total'			=> $total,
								'mid_size'		=> 2,
								'type'			=> 'list',
								'prev_text'		=> '<i class="fa fa-angle-left"></i>',
								'next_text'		=> '<i class="fa fa-angle-right"></i>',
							));
						}
					}
			
			// End has posts check
			endif;

			// Reset the WP query
			wp_reset_postdata();

		// Return outbut buffer
		return ob_get_clean();

	}

}
add_shortcode( "vcex_staff_grid", "vcex_staff_grid_shortcode" );




/**
	Add to Visual Composer
**/
add_action( 'init', 'vcex_staff_grid_shortcode_vc_map' );
if ( ! function_exists( 'vcex_staff_grid_shortcode_vc_map' ) ) {
	function vcex_staff_grid_shortcode_vc_map() {
		$vc_img_rendering_url = 'https://developer.mozilla.org/en-US/docs/Web/CSS/image-rendering';
		vc_map( array(
			"name"					=> __( "Staff Grid", 'wpex' ),
			"description"			=> __( "Recent staff posts grid", 'wpex' ),
			"base"					=> "vcex_staff_grid",
			"class"					=> "vcex_staff_grid",
			'category'				=> WPEX_THEME_BRANDING,
			"icon" 					=> "icon-wpb-vcex-staff_grid",
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Unique Id", 'wpex' ),
					"param_name"	=> "unique_id",
					"value"			=> "",
					"description"	=> __( "You can enter a unique ID here for styling purposes.", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Include Categories", 'wpex' ),
					"param_name"	=> "include_categories",
					"admin_label"	=> true,
					"value"			=> "",
					"description"	=> __('Enter the slugs of a categories (comma seperated) to pull posts from or enter "all" to pull recent posts from all categories. Example: category-1, category-2.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Exclude Categories", 'wpex' ),
					"param_name"	=> "exclude_categories",
					"admin_label"	=> true,
					"value"			=> "",
					"description"	=> __('Enter the slugs of a categories (comma seperated) to exclude. Example: category-1, category-2.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Order", 'wpex' ),
					"param_name"	=> "order",
					"value"			=> array(
						__( "DESC", "wpex")	=> "DESC",
						__( "ASC", "wpex" )	=> "ASC",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Order By", 'wpex' ),
					"param_name"	=> "orderby",
					"value"			=> array(
						__( "Date", "wpex")				=> "date",
						__( "Name", "wpex" )			=> "name",
						__( "Modified", "wpex")			=> "modified",
						__( "Author", "wpex" )			=> "author",
						__( "Random", "wpex")			=> "rand",
						__( "Comment Count", "wpex" )	=> "comment_count",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Posts Per Page", 'wpex' ),
					"param_name"	=> "posts_per_page",
					"value"			=> "12",
					"description"	=> __( "How many posts do you wish to show?", 'wpex' ),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Pagination", 'wpex' ),
					"param_name"	=> "pagination",
					"value"			=> array(
						__( "No", "wpex" )	=> "false",
						__( "Yes", "wpex")	=> "true",
					),
					"description"	=> __("Paginate posts? Important: Pagination will not work on your homepage because of how WordPress works","wpex"),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Columns", 'wpex' ),
					"param_name"	=> "columns",
					"value" 		=> array(
						__( 'Four','wpex' )		=>'4',
						__( 'Three','wpex' )	=>'3',
						__( 'Two','wpex' )		=>'2',
						__( 'One','wpex' )		=>'1',
					),
					"description"	=> __('Select how many columns for the grid.','wpex'),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Grid Style", 'wpex' ),
					"param_name"	=> "grid_style",
					"value"			=> array(
						__( "Fit Columns", "wpex")	=> "fit-columns",
						__( "Masonry", "wpex" )		=> "masonry",
					),
					"description"	=> __( 'Select a grid style. If you select no margins be sure to crop your featured images to the same dimensions.', 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Category Filter", 'wpex' ),
					"param_name"	=> "filter",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					"description"	=> __( "Do you wish to display an animated category filter?", 'wpex' ),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Center Filter Links", 'wpex' ),
					"param_name"	=> "center_filter",
					"value"			=> array(
						__( 'No', 'wpex' )	=> 'no',
						__( 'Yes', 'wpex' )	=> 'yes',
					),
					"description"	=> __( "Do you wish to center the filter category links?", 'wpex' ),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( 'Custom Category Filter "All" Text', 'wpex' ),
					"param_name"	=> "all_text",
					"value"			=> __( 'All', 'wpex' ),
					"description"	=> __( 'Custom text for the "all" button in the category filter.', 'wpex' ),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Image Links To", 'wpex' ),
					"param_name"	=> "thumb_link",
					"value"			=> array(
						__( "Post", "wpex")			=> "post",
						__( "Lightbox", "wpex" )	=> "lightbox",
						__( "Nowhere", "wpex" )		=> "nowhere",
					),
					"description"	=> __( "Default link behaviour on the images.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				vcex_overlays_array(),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Image Crop Width", 'wpex' ),
					"param_name"	=> "img_width",
					"value"			=> "9999",
					"description"	=> __( "Custom image cropping width. Enter 9999 for no cropping.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Image Crop Height", 'wpex' ),
					"param_name"	=> "img_height",
					"value"			=> "9999",
					"description"	=> __( "Custom image cropping height. Enter 9999 for no cropping.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Image Filter", 'wpex' ),
					"param_name"	=> "img_filter",
					"value"			=> vcex_image_filters(),
					"description"	=> __( "Select a custom filter style for your images.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "CSS3 Image Hover", 'wpex' ),
					"param_name"	=> "img_hover_style",
					"value"			=> vcex_image_hovers(),
					"description"	=> __("Select your preferred image hover effect. Please note this will only work if the image links to a URL or a large version of itself. Please note these effects may not work in all browsers.", "wpex"),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Image Rendering", 'wpex' ),
					"param_name"	=> "img_rendering",
					"value"			=> vcex_image_rendering(),
					"description"	=> sprintf( __( 'Image-rendering CSS property provides a hint to the user agent about how to handle its image rendering. For example when scaling down images they tend to look a bit fuzzy in Firefox, setting image-rendering to crisp-edges can help make the images look better. <a href="%s">Learn more</a>.', 'wpex' ), esc_url( $vc_img_rendering_url ) ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Title", 'wpex' ),
					"param_name"	=> "title",
					"value"			=> array(
						__( "Yes", "wpex" )	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					"description"	=> __( "Display post title?", 'wpex' ),
					'group'			=> __( 'Description', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Title Links To", 'wpex' ),
					"param_name"	=> "title_link",
					"value"			=> array(
						__( "Post", "wpex")		=> "post",
						__( "Lightbox", "wpex")	=> "lightbox",
						__( "Nowhere", "wpex" )	=> "nowhere",
					),
					"description"	=> __( "Default link behaviour on the titles.", 'wpex' ),
					'group'			=> __( 'Description', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Excerpt", 'wpex' ),
					"param_name"	=> "excerpt",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					"description"	=> __( "Display post excerpt?", 'wpex' ),
					'group'			=> __( 'Description', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Excerpt Length", 'wpex' ),
					"param_name"	=> "excerpt_length",
					"value"			=> "30",
					"description"	=> __( 'Enter a custom excerpt length. Will trim the excerpt by this number of words. Enter "-1" to display the_content instead of the auto excerpt.', 'wpex' ),
					'group'			=> __( 'Description', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Read More", 'wpex' ),
					"param_name"	=> "read_more",
					"value"			=> array(
						__( "No", "wpex" )		=> "false",
						__( "Yes", "wpex")		=> "true",
					),
					"description"	=> __( "Display post readmore button after excerpt?", 'wpex' ),
					'group'			=> __( 'Description', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Read More Text", 'wpex' ),
					"param_name"	=> "read_more_text",
					"value"			=> __('view post', 'wpex' ),
					"description"	=> __("Enter your custom text for the readmore button.","wpex"),
					'group'			=> __( 'Description', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Social Links", 'wpex' ),
					"param_name"	=> "social_links",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					"description"	=> __( 'Display social links?', 'wpex' ),
					'group'			=> __( 'Description', 'wpex' ),
				),
			)
		) );
	}
}