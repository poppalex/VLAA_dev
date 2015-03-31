<?php
/**
	Add Blog Grid Shortcode
**/
if( !function_exists( 'vcex_blog_grid_shortcode' ) ) {

	function vcex_blog_grid_shortcode($atts) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
			'unique_id'				=> '',
			'term_slug'				=> '',
			'include_categories'	=> '',
			'exclude_categories'	=> '',
			'posts_per_page'		=> '4',
			'grid_style'			=> 'fit_columns',
			'columns'				=> '3',
			'order'					=> 'DESC',
			'orderby'				=> 'date',
			'filter'				=> 'true',
			'center_filter'			=> '',
			'thumbnail_link'		=> 'post',
			'entry_media'			=> "true",
			'img_crop'				=> 'true',
			'img_width'				=> '9999',
			'img_height'			=> '9999',
			'thumb_link'			=> 'post',
			'img_filter'			=> '',
			'title'					=> 'true',
			'date'					=> 'true',
			'excerpt'				=> 'true',
			'excerpt_length'		=> '15',
			'read_more'				=> 'false',
			'read_more_text'		=> __( 'read more', 'wpex' ),
			'pagination'			=> 'false',
			'filter_content'		=> 'false',
			'offset'				=> 0,
			'taxonomy'				=> '',
			'terms'					=> '',
			'all_text'				=> __( 'All', 'wpex' ),
			'featured_video'		=> 'true',
			'url_target'			=> '_self',
		), $atts ) );

		// Turn output buffer on
		ob_start();
			
			// Get global $post var
			global $post;
				
			// Include categories
			$include_categories = ( '' != $include_categories ) ? $include_categories : $term_slug;
			$include_categories = ( 'all' == $include_categories ) ? '' : $include_categories;
			$filter_cats_include = '';
			if ( $include_categories ) {
				$include_categories = explode( ',', $include_categories );
				$filter_cats_include = array();
				foreach ( $include_categories as $key ) {
					$key = get_term_by( 'slug', $key, 'category' );
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
					$key = get_term_by( 'slug', $key, 'category' );
					$filter_cats_exclude[] = $key->term_id;
				}
				$exclude_categories = array(
					'taxonomy'	=> 'category',
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
					'taxonomy'	=> 'category',
					'field'		=> 'slug',
					'terms'		=> $include_categories,
					'operator'	=> 'IN',
				);
			} else {
				$include_categories = '';
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
					'post_type'			=> 'post',
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

			// Setup main vars
			$unique_id = $unique_id ? $unique_id : 'blog-'. rand( 1, 100 );
			$img_crop = $img_height == '9999' ? false : true;
			$read_more = $read_more == 'true' ? true : false;

			// Is Isotope var
			if ( 'true' == $filter || 'masonry' == $grid_style ) {
				$is_isotope = true;
			} else {
				$is_isotope = false;
			}

			// No need for masonry if not enough columns and filter is disabled
			if ( 'true' != $filter && 'masonry' == $grid_style ) {
				$post_count = count($vcex_query->posts);
				if ( $post_count <= $columns ) {
					$is_isotope = false;
				}
			}

			// Output script for inline JS for the Visual composer front-end builder
			if ( function_exists( 'vcex_front_end_grid_js' ) &&  $is_isotope ) {
				vcex_front_end_grid_js( 'isotope' );
			}

			// Display filter links
			if ( $filter == 'true' ) {
				$terms = get_terms( 'category', array(
					'include'	=> $filter_cats_include,
					'exclude'	=> $filter_cats_exclude,
				) );
				$terms = apply_filters( 'vcex_blog_grid_get_terms', $terms );
				if( $terms && count($terms) > '1') {
					$center_filter = 'yes' == $center_filter ? 'center' : ''; ?>
					<ul class="vcex-blog-filter filter-<?php echo $unique_id; ?> vcex-filter-links <?php echo $center_filter; ?> clr">
						<li class="active"><a href="#" data-filter="*"><span><?php echo $all_text; ?></span></a></li>
						<?php foreach ($terms as $term ) : ?>
							<li><a href="#" data-filter=".cat-<?php echo $term->term_id; ?>"><?php echo $term->name; ?></a></li>
						<?php endforeach; ?>
					</ul><!-- .vcex-blog-filter -->
				<?php } ?>
			<?php } ?>
	
			<div class="wpex-row vcex-blog-grid vcex-clearfix <?php if ( $is_isotope ) { echo 'vcex-isotope-grid'; } ?>" id="<?php echo $unique_id; ?>">
				<?php
				// Define counter var to clear floats
				$count='';
				// Loop through posts
				foreach ( $vcex_query->posts as $post ) : setup_postdata( $post );
					// Post ID var
					$post_id = $post->ID;
					// Add to counter var
					$count++;
					// Get post format
					$format = get_post_format( $post_id );
					// Get video
					if ( 'true' == $featured_video ) {
						$video_url = get_post_meta( $post_id, 'wpex_post_oembed', true );
					}
					// General Class
					$entry_classes = 'vcex-blog-entry col';
					// Counter class
					$entry_classes .= ' col-'. $count;
					// Column class
					$entry_classes .= ' span_1_of_'. $columns;
					// Isotope
					if ( $is_isotope ) {
						$entry_classes .= ' vcex-isotope-entry';
					}
					// Create a list of terms to add as classes to the entry
					$post_terms = get_the_terms( $post, 'category' ); 
					if ( $post_terms ) {
						foreach ( $post_terms as $post_term ) {
							$entry_classes .= ' cat-'. $post_term->term_id;
						}
					}
					if ( "false" == $entry_media ) {
						$entry_classes .= ' vcex-blog-no-media-entry';
					} ?>
					<article id="#post-<?php the_ID(); ?>" class="<?php echo $entry_classes; ?>">
						<?php if ( "true" == $entry_media ) { ?>
							<?php $img_filter_class = $img_filter ? 'vcex-'. $img_filter : ''; ?>
							<?php if ( "video" == $format && 'true' == $featured_video && $video_url ) { ?>
								<div class="vcex-blog-entry-media">
									<div class="vcex-video-wrap">
										<?php echo wp_oembed_get($video_url); ?>
									</div>
								</div><!-- .vcex-blog-entry-media -->
							<?php } elseif( has_post_thumbnail() ) { ?>
								<div class="vcex-blog-entry-media <?php echo $img_filter_class; ?>">
									<?php if ( $thumb_link == 'post' ||  $thumb_link == 'lightbox' ) { ?>
										<?php
										// Post links
										if ( $thumb_link == 'post' ) { ?>
											<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" target="<?php echo $url_target; ?>">
										<?php } ?>
										<?php
										// Lightbox Links
										if ( $thumb_link == 'lightbox' ) { ?>
											<?php
											// Video Lightbox
											if ( $format == 'video' ) { ?>
												<a href="<?php echo $video_url; ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="vcex-lightbox-video">
											<?php }
											// Image lightbox
											else { ?>
												<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="vcex-lightbox">
											<?php } ?>
										<?php } ?>
									<?php }
										// Get cropped image array and display image
										$cropped_img = wpex_image_resize( wp_get_attachment_url( get_post_thumbnail_id() ), intval($img_width), intval($img_height), $img_crop, 'array' ); ?>
										<img src="<?php echo $cropped_img['url']; ?>" alt="<?php the_title(); ?>" class="vcex-blog-entry-img" height="<?php echo $cropped_img['height']; ?>" width="<?php echo $cropped_img['width']; ?>" />
									<?php if ( $thumb_link == 'post' ||  $thumb_link == 'lightbox' ) { ?>
										</a>
									<?php } ?>
								</div><!-- .blog-entry-media -->
							<?php } ?>
						<?php } ?>
						<?php if ( $title == 'true' || $excerpt == 'true' ) { ?>
							<div class="vcex-blog-entry-details clr">
								<?php
								// Post Title
								if ( $title == 'true' ) { ?>
									<h2 class="vcex-blog-entry-title">
										<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" target="<?php echo $url_target; ?>"><?php the_title(); ?></a>
									</h2>
								<?php } ?>
								<?php
								// Post Date
								if ( $date == 'true' ) { ?>
									<div class="vcex-blog-entry-date"><?php echo get_the_date(); ?></div>
								<?php } ?>
								<?php
								// Excerpt
								if ('true' ==  $excerpt  || 'true' == $read_more ) {
									if ( 'true' != $excerpt ){
										$excerpt_length = '0';
									} ?>
									<div class="vcex-blog-entry-excerpt clr">
										<?php
										// Show full content
										if ( '9999' == $excerpt_length  ) {
											the_content();
										}
										// Display custom excerpt
										else {
											vcex_excerpt( $excerpt_length, false );
										}
										// Read more
										if ( $read_more ) { ?>
											<a href="<?php the_permalink(); ?>" title="<?php echo $read_more_text; ?>" rel="bookmark" class="vcex-readmore theme-button" target="<?php echo $url_target; ?>">
												<?php echo $read_more_text; ?><span class="vcex-readmore-rarr">&rarr;</span>
											</a>
										<?php } ?>
									</div>
								<?php } ?>
							</div><!-- .blog-entry-details -->
						<?php } ?>
					</article><!-- .blog-entry -->
				<?php
				// Reset counter
				if ( $count == $columns ) {
					$count = '0';
				} ?>
				<?php endforeach; ?>
			</div><!-- .vcex-blog-grid -->
			
			<?php
			// Paginate Posts
			if( $pagination == 'true' ) {
				$total = $vcex_query->max_num_pages;
				$big = 999999999; // need an unlikely integer
				if( $total > 1 )  {
					if( !$current_page = get_query_var('paged') )
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
						'prev_text'		=> '&laquo;',
						'next_text'		=> '&raquo;',
					) );
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
add_shortcode( 'vcex_blog_grid', 'vcex_blog_grid_shortcode' );




/**
	Add to Visual Composer
**/
add_action( 'init', 'vcex_blog_grid_shortcode_vcmap' );
if ( ! function_exists( 'vcex_blog_grid_shortcode_vcmap' ) ) {
	function vcex_blog_grid_shortcode_vcmap() {
		vc_map( array(
			"name"					=> __( "Blog Grid", 'wpex' ),
			"description"			=> __( "Recent blog posts grid", 'wpex' ),
			"base"					=> "vcex_blog_grid",
			"class"					=> "vcex_blog_grid",
			'category'				=> WPEX_THEME_BRANDING,
			"icon" 					=> "icon-wpb-vcex-blog_grid",
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Unique Id", 'wpex' ),
					"param_name"	=> "unique_id",
					"value"			=> "",
					"description"	=> __( "You can enter a unique ID here for styling purposes.", 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Post Link Target", 'wpex' ),
					"param_name"	=> "url_target",
					 "value"		=> array(
						__("Self", "wpex")	=> "_self",
						__("Blank", "wpex")	=> "_blank",
					),
					"description"	=> __( 'Your link target. Choose self to open the link in the same browser tab and blank to open in a new tab.', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Include Categories", 'wpex' ),
					"param_name"	=> "include_categories",
					"admin_label"	=> true,
					"value"			=> "",
					"description"	=> __('Enter the slugs of a categories (comma seperated) to pull posts from or enter "all" to pull recent posts from all categories. Example: category-1, category-2.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Exclude Categories", 'wpex' ),
					"param_name"	=> "exclude_categories",
					"admin_label"	=> true,
					"value"			=> "",
					"description"	=> __('Enter the slugs of a categories (comma seperated) to exclude. Example: category-1, category-2.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Grid Style", 'wpex' ),
					"param_name"	=> "grid_style",
					"value"			=> array(
						__( "Fit Columns", "wpex")	=> "fit-columns",
						__( "Masonry", "wpex" )		=> "masonry",
					),
					"description"	=> __( "Important: If the category filter is enabled above the grid will always be masonry style.", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Columns", 'wpex' ),
					"param_name"	=> "columns",
					"admin_label"	=> true,
					"value" 		=> array(
						__( 'Four','wpex' )		=>'4',
						__( 'Three','wpex' )	=>'3',
						__( 'Two','wpex' )		=>'2',
						__( 'One','wpex' )		=>'1',
					),
					"description"	=> __( "How many columns for your grid?", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
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
					"class"			=> "",
					"heading"		=> __( "Order", 'wpex' ),
					"param_name"	=> "order",
					"description"	=> sprintf( __( 'Designates the ascending or descending order. More at %s.', 'wpex' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
					"value"			=> array(
						__( "DESC", "wpex")	=> "DESC",
						__( "ASC", "wpex" )	=> "ASC",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Order By", 'wpex' ),
					"param_name"	=> "orderby",
					"description"	=> sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'wpex' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
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
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Pagination", 'wpex' ),
					"param_name"	=> "pagination",
					"value"			=> array(
						__( "False", "wpex")	=> "false",
						__( "True", "wpex" )	=> "true",
					),
					"description"	=> __( "Important: Pagination will not work on your homepage because of how WordPress works", "wpex" ),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Posts Per Page", 'wpex' ),
					"param_name"	=> "posts_per_page",
					"value"			=> "4",
					"description"	=> __( "How many items do you wish to show?", 'wpex' ),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Entry Media", 'wpex' ),
					"param_name"	=> "entry_media",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					"description"	=> __( "Should featured images and post videos be displayed in the grid?", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Image Width", 'wpex' ),
					"param_name"	=> "img_width",
					"value"			=> "9999",
					"description"	=> __( "Custom image cropping width. Enter 9999 for no cropping.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Image Height", 'wpex' ),
					"param_name"	=> "img_height",
					"value"			=> "9999",
					"description"	=> __( "Custom image cropping height. Enter 9999 for no cropping.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Hard Crop Images?", 'wpex' ),
					"param_name"	=> "img_crop",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					"description"	=> __( "Select to hard crop the image or not. If set true your images will be cropped in the middle based on the cropping dimensions set above.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Image Filter", 'wpex' ),
					"param_name"	=> "img_filter",
					"value"			=> vcex_image_filters(),
					"description"	=> __( "Select a custom filter style for your images.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
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
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Display Featured Videos?", 'wpex' ),
					"param_name"	=> "featured_video",
					"value"			=> array(
						__( "True", "wpex")		=> "true",
						__( "False", "wpex" )	=> "false",
					),
					"description"	=> __( "Display your featured videos on the video post format posts (this will only work if the featured media option is enabled above).", "wpex" ),
					'group'			=> __( 'Formats', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Title", 'wpex' ),
					"param_name"	=> "title",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					"description"	=> __( "Display post title?", 'wpex' ),
					'group'			=> __( 'Description', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Date", 'wpex' ),
					"param_name"	=> "date",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					"description"	=> __( "Display post date?", 'wpex' ),
					'group'			=> __( 'Description', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
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
					"class"			=> "",
					"heading"		=> __( "Excerpt Length", 'wpex' ),
					"param_name"	=> "excerpt_length",
					"value"			=> "15",
					"description"	=> __( 'Enter a custom excerpt length. Will trim the excerpt by this number of words. Enter "-1" to display the_content instead of the auto excerpt.', 'wpex' ),
					'group'			=> __( 'Description', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Read More", 'wpex' ),
					"param_name"	=> "read_more",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					"description"	=> __( "Display post readmore button after excerpt?", 'wpex' ),
					'group'			=> __( 'Description', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Read More Text", 'wpex' ),
					"param_name"	=> "read_more_text",
					"value"			=> __('view post', 'wpex' ),
					"description"	=> __("Enter your custom text for the readmore button.","wpex"),
					'group'			=> __( 'Description', 'wpex' ),
				),
			)
		) );
	}
}