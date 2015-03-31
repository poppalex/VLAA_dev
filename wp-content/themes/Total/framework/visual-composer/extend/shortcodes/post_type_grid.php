<?php
/**
	Add Post Type Grid Shortcode
**/
if( !function_exists( 'vcex_post_type_grid_shortcode' ) ) {

	function vcex_post_type_grid_shortcode($atts) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
			'unique_id'			=> '',
			'post_types'		=> '',
			'posts_per_page'	=> '12',
			'grid_style'		=> 'fit_columns',
			'columns'			=> '3',
			'order'				=> 'DESC',
			'orderby'			=> 'date',
			'filter'			=> 'true',
			'center_filter'		=> '',
			'thumbnail_link'	=> 'post',
			'entry_media'		=> "true",
			'img_width'			=> '9999',
			'img_height'		=> '9999',
			'thumb_link'		=> 'post',
			'img_filter'		=> '',
			'title'				=> 'true',
			'date'				=> 'true',
			'excerpt'			=> 'true',
			'excerpt_length'	=> '15',
			'read_more'			=> 'false',
			'read_more_text'	=> __( 'read more', 'wpex' ),
			'pagination'		=> 'false',
			'filter_content'	=> 'false',
			'offset'			=> 0,
			'taxonomy'			=> '',
			'terms'				=> '',
			'all_text'			=> __( 'All', 'wpex' ),
			'featured_video'	=> 'true',
			'url_target'		=> '_self',
			'thumbnail_query'	=> 'no',
			'overlay_style'		=> '',
			'img_hover_style'	=> '',
		), $atts ) );
		
		// Turn output buffer on
		ob_start();

			// Get global $post var
			global $post;
			
			// Pagination var
			if( 'true' == $pagination ) {
				global $paged;
				$paged = get_query_var('paged') ? get_query_var('paged') : 1;
				$no_found_rows = false;
			} else {
				$paged = NULL;
				$no_found_rows = true;
			}

			// Post types
			$post_types = $post_types ? $post_types : 'post';
			$post_types = explode( ',', $post_types );
			$post_types_count = count($post_types);

			// Thumbnail meta query
			if ( 'true' == $thumbnail_query ) {
				$meta_query = array( array ( 'key' => '_thumbnail_id' ) );
			} else {
				$meta_query = NULL;
			}

			// Query args
			$args = array(
				'post_type'			=> $post_types,
				'posts_per_page'	=> $posts_per_page,
				'offset'			=> $offset,
				'order'				=> $order,
				'orderby'			=> $orderby,
				'filter_content'	=> $filter_content,
				'paged'				=> $paged,
				'meta_query'		=> $meta_query,
				'no_found_rows'		=> $no_found_rows
			);

			// Args filter
			$args = apply_filters( 'vcex_post_type_grid_args', $args );

			// Build new query
			$vcex_query = new WP_Query( $args );

			//Output posts
			if( $vcex_query->posts ) :

				// Main Vars
				$unique_id = $unique_id ? $unique_id : 'post-type-'. rand( 1, 100 );
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
					} elseif ( 'no_margins' == $grid_style ) {
						vcex_front_end_grid_js( 'masonry' );
					}
				}

				// Display filter links
				if ( 'true' == $filter && $post_types_count > '1' ) {
					$center_filter = 'yes' == $center_filter ? 'center' : ''; ?>
					<ul class="vcex-post-type-filter filter-<?php echo $unique_id; ?> vcex-filter-links <?php echo $center_filter; ?> clr">
						<li class="active"><a href="#" data-filter="*"><span><?php echo $all_text; ?></span></a></li>
						<?php foreach ( $post_types as $post_type ) {
							$obj = get_post_type_object( $post_type ); ?>
							<li><a href="#" data-filter=".post-type-<?php echo $post_type; ?>"><?php echo $obj->labels->name; ?></a></li>
						<?php } ?>
					</ul><!-- .vcex-post-type-filter -->
				<?php } ?>

				<div class="wpex-row vcex-post-type-grid vcex-clearfix <?php if ( $is_isotope ) echo 'vcex-isotope-grid'; ?>" id="<?php echo $unique_id; ?>">
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
						$entry_classes = 'vcex-post-type-entry col';
						// Counter class
						$entry_classes .= ' col-'. $count;
						// Column class
						$entry_classes .= ' span_1_of_'. $columns;
						// Post type class
						$entry_classes .= ' post-type-'. get_post_type( $post_id );
						// Isotope
						if ( $is_isotope ) {
							$entry_classes .= ' vcex-isotope-entry';
						}
						// No media entry class
						if ( "false" == $entry_media ) {
							$entry_classes .= ' vcex-post-type-no-media-entry';
						} ?>
						<article id="#post-<?php the_ID(); ?>" class="<?php echo $entry_classes; ?>">
							<?php if ( "true" == $entry_media ) { ?>
								<?php
								// Video Embed
								if ( "video" == $format && 'true' == $featured_video && $video_url ) { ?>
									<div class="vcex-post-type-entry-media">
										<div class="vcex-video-wrap">
											<?php echo wp_oembed_get($video_url); ?>
										</div>
									</div><!-- .vcex-post-type-entry-media -->
								<?php }
								// Featured Image
								elseif( has_post_thumbnail() ) {
									// Filter style
									$img_filter_class = $img_filter ? 'vcex-'. $img_filter : '';
									// Image hover styles
									$img_hover_style_class = $img_hover_style ? 'vcex-img-hover-parent vcex-img-hover-'. $img_hover_style : '';
									// Media classes
									$media_classes = $img_filter_class;
									$media_classes .= ' '. $img_hover_style_class;
									$overlay_classnames = wpex_overlay_classname( $overlay_style );
									$media_classes .= ' '. $overlay_classnames; ?>
									<div class="vcex-post-type-entry-media <?php echo $media_classes; ?>">
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
											<img src="<?php echo $cropped_img['url']; ?>" alt="<?php the_title(); ?>" class="vcex-post-type-entry-img" height="<?php echo $cropped_img['height']; ?>" width="<?php echo $cropped_img['width']; ?>" />
										<?php if ( $thumb_link == 'post' ||  $thumb_link == 'lightbox' ) { ?>
										<?php } ?>
										<?php
										// Overlay
										if ( 'post' == $thumb_link || 'lightbox' == $thumb_link ) {
											// Inner Overlay
											wpex_overlay( 'inside_link', $overlay_style ); ?>
											</a>
											<?php
											// Outside Overlay
											wpex_overlay( 'outside_link', $overlay_style );
										} ?>
									</div><!-- .post_type-entry-media -->
								<?php } ?>
							<?php } ?>
							<?php if ( $title == 'true' || $excerpt == 'true' ) { ?>
								<div class="vcex-post-type-entry-details clr">
									<?php
									// Post Title
									if ( $title == 'true' ) { ?>
										<h2 class="vcex-post-type-entry-title">
											<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" target="<?php echo $url_target; ?>"><?php the_title(); ?></a>
										</h2>
									<?php } ?>
									<?php
									// Post Date
									if ( $date == 'true' ) { ?>
										<div class="vcex-post-type-entry-date"><?php echo get_the_date(); ?></div>
									<?php } ?>
									<?php
									// Excerpt
									if ('true' ==  $excerpt  || 'true' == $read_more ) {
										if ( 'true' != $excerpt ){
											$excerpt_length = '0';
										} ?>
										<div class="vcex-post-type-entry-excerpt clr">
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
								</div><!-- .post_type-entry-details -->
							<?php } ?>
						</article><!-- .post_type-entry -->
					<?php
					// Reset counter
					if ( $count == $columns ) {
						$count = '0';
					} ?>
					<?php endforeach; ?>
				</div><!-- .vcex-post-type-grid -->
				
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
add_shortcode("vcex_post_type_grid", "vcex_post_type_grid_shortcode");


/**
	Add to Visual Composer
**/
add_action( 'init', 'vcex_post_type_grid_shortcode_vcmap' );
if ( ! function_exists( 'vcex_post_type_grid_shortcode_vcmap' ) ) {
	function vcex_post_type_grid_shortcode_vcmap() {
		vc_map( array(
			"name"					=> __( "Post Types Grid", 'wpex' ),
			"description"			=> __( "Multiple post types posts grid.", 'wpex' ),
			"base"					=> "vcex_post_type_grid",
			"class"					=> "vcex_post_type_grid",
			'category'				=> WPEX_THEME_BRANDING,
			"icon" 					=> "icon-wpb-vcex-post-type-grid",
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
					'type'			=> 'posttypes',
					'heading'		=> __( 'Post types', 'wpex' ),
					'param_name'	=> 'post_types',
					'description' 	=> __( 'Select post types to populate posts from.', 'wpex' ),
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
					"heading"		=> __( "Post Type Filter", 'wpex' ),
					"param_name"	=> "filter",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					"description"	=> __( "Do you wish to display an animated post type filter?", 'wpex' ),
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
					"description"	=> __( "Do you wish to center the filter links?", 'wpex' ),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( 'Filter "All" Text', 'wpex' ),
					"param_name"	=> "all_text",
					"value"			=> __( 'All', 'wpex' ),
					"description"	=> __( 'Custom text for the "all" button in the post type filter.', 'wpex' ),
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
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Post With Thumbnails Only", 'wpex' ),
					"param_name"	=> "thumbnail_query",
					"value"			=> array(
						__( "No", "wpex" )	=> "false",
						__( "Yes", "wpex")	=> "true",
					),
					"description"	=> __( "Select yes to display only posts that have a featured image defined.", 'wpex' ),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Posts Per Page", 'wpex' ),
					"param_name"	=> "posts_per_page",
					"value"			=> "12",
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
				vcex_overlays_array( 'post_types' ),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "CSS3 Image Hover", 'wpex' ),
					'param_name'	=> "img_hover_style",
					'value'			=> vcex_image_hovers(),
					'description'	=> __("Select your preferred image hover effect. Please note this will only work if the image links to a URL or a large version of itself. Please note these effects may not work in all browsers.", "wpex"),
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
						__( "Yes", "wpex")		=> "true",
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
						__( "No", "wpex" )	=> "false",
						__( "Yes", "wpex")	=> "true",
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