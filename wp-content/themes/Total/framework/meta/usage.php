<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'wpex_metaboxes' );



/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function wpex_metaboxes( array $meta_boxes ) {
	
	// Meta prefix to prevent conflicts
	$prefix = 'wpex_';
		
	// Site Layouts
	$site_layout = array(
		array(
			'name'	=> __( 'Default', 'wpex' ),
			'value'	=> '',
		),
		array(
			'name'	=> __( 'Full-Width', 'wpex' ),
			'value'	=> 'full-width',
		),
		array(
			'name'	=> __( 'Boxed', 'wpex' ),
			'value'	=> 'boxed',
		),
	);
	
	
	// Page Layouts
	$page_layout = array(
		array(
			'name'	=> __( 'Default', 'wpex' ),
			'value'	=> '',
		),
		array(
			'name'	=> __( 'Right Sidebar', 'wpex' ),
			'value'	=> 'right-sidebar',
		),
		array(
			'name'	=> __( 'Left Sidebar', 'wpex' ),
			'value'	=> 'left-sidebar',
		),
		array(
			'name'	=> __( 'No Sidebar', 'wpex' ),
			'value'	=> 'full-width',
		),
		array(
			'name'	=> __( 'Full Screen', 'wpex' ),
			'value'	=> 'full-screen',
		),
	);
	
	// Background Styles
	$bg_styles = array(
		array(
			'name'	=> __( 'Repeat', 'wpex' ),
			'value'	=> 'repeat',
		),
		array(
			'name'	=> __( 'Fixed', 'wpex' ),
			'value'	=> 'fixed',
		),
		array(
			'name'	=> __( 'Streched', 'wpex' ),
			'value'	=> 'stretched',
		),
	);

	// Header Styles
	$page_header_styles = array(
		array(
			'name'	=> __( 'Default', 'wpex' ),
			'value'	=> '',
		),
		array(
			'name'	=> __( 'Fixed Over Slider or Featured Image', 'wpex' ),
			'value'	=> 'fixed',
		),
	);
	
	// Title Styles
	$title_styles = array(
		array(
			'name'	=> __( 'Default', 'wpex' ),
			'value'	=> '',
		),
		array(
			'name'	=> __( 'Centered', 'wpex' ),
			'value'	=> 'centered',
		),
		array(
			'name'	=> __( 'Centered Minimal', 'wpex' ),
			'value'	=> 'centered-minimal',
		),
		array(
			'name'	=> __( 'Background Image', 'wpex' ),
			'value'	=> 'background-image',
		),
		array(
			'name'	=> __( 'Solid Color & White Text', 'wpex' ),
			'value'	=> 'solid-color',
		),
	);

	// Menus
	$menus_array = array();
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
	$menus_array[] = array (
		'name'	=> __( 'Default', 'wpex' ),
		'value'	=> '',
	);
	foreach ( $menus as $menu) {
		$menus_array[] = array (
			'name'	=> $menu->name,
			'value'	=> $menu->term_id
		);
	}
	
	/**
		Meta => Pages
	**/
	$meta_boxes[] = array(
		'id'			=> 'wpex-page-meta',
		'title'			=> __( 'Page Settings', 'wpex' ),
		'pages'			=> array( 'page' ),
		'context'		=> 'normal',
		'priority'		=> 'high',
		'show_names'	=> true,
		'fields'		=> array(
			array(
				'name'		=> __( 'Site Layout', 'wpex' ),
				'id'		=> $prefix . 'main_layout',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $site_layout,
			),
			array(
				'name'		=> __( 'Page Layout', 'wpex' ),
				'id'		=> $prefix . 'post_layout',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $page_layout,
			),
			array(
				'name'		=> __( 'Custom Menu', 'wpex' ),
				'id'		=> $prefix . 'custom_menu',
				'type'		=> 'select',
				'options'	=> $menus_array,
			),
			array(
				'name'	=> __( 'Disable Toggle Bar', 'wpex' ),
				'desc'	=> __( 'Check to disable the toggle bar if enabled.', 'wpex' ),
				'id'	=> $prefix . 'disable_toggle_bar',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Header', 'wpex' ),
				'desc'	=> __( 'Check to disable the main header.', 'wpex' ),
				'id'	=> $prefix . 'disable_header',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Title', 'wpex' ),
				'desc'	=> __( 'Check to disable the main title.', 'wpex' ),
				'id'	=> $prefix . 'disable_title',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Title Margin', 'wpex' ),
				'desc'	=> __( 'Check to disable the bottom margin on the main page header.', 'wpex' ),
				'id'	=> $prefix . 'disable_header_margin',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Breadcrumbs', 'wpex' ),
				'desc'	=> __( 'Check to disable the breadcrumbs navigation.', 'wpex' ),
				'id'	=> $prefix . 'disable_breadcrumbs',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Social Share', 'wpex' ),
				'desc'	=> __( 'Check to disable the social sharing icons if enabled.', 'wpex' ),
				'id'	=> $prefix . 'disable_social',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Footer Callout', 'wpex' ),
				'desc'	=> __( 'Check to disable the footer callout area if active.', 'wpex' ),
				'id'	=> $prefix . 'disable_footer_callout',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Footer', 'wpex' ),
				'desc'	=> __( 'Check to disable the main footer area. This will also include the callout and copyright.', 'wpex' ),
				'id'	=> $prefix . 'disable_footer',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Page Subheading', 'wpex' ),
				'desc'	=> __( 'Enter your page subheading. Shortcodes & HTML is allowed.', 'wpex' ),
				'id'	=> $prefix . 'post_subheading',
				'type'	=> 'text',
			),
			array(
				'name'	=> __( 'Slider Shortcode', 'wpex' ),
				'desc'	=> __( 'Enter a slider shortcode here to display a slider at the top of the page.', 'wpex' ),
				'id'	=> $prefix . 'post_slider_shortcode',
				'type'	=> 'textarea_code',
			),
			array(
				'name'	=> __( 'Slider Bottom Margin', 'wpex' ),
				'desc'	=> __( 'Enter a bottom margin for your slider in pixels', 'wpex' ),
				'id'	=> $prefix . 'post_slider_bottom_margin',
				'type'	=> 'text',
			),
			array(
				'name' 		=> __( 'Title: Style', 'wpex' ),
				'id'		=> $prefix . 'post_title_style',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $title_styles,
			),
			array(
				'name'	=> __( 'Title: Background Color', 'wpex' ),
				'desc'	=> __( 'Select a custom background color for your main title.', 'wpex' ),
				'id'	=> $prefix . 'post_title_background_color',
				'type'	=> 'colorpicker',
			),
			array(
				'name'	=> __( 'Title: Background Image', 'wpex' ),
				'desc'	=> __( 'Select a custom header image for your main title.', 'wpex' ),
				'id'	=> $prefix . 'post_title_background',
				'type'	=> 'file',
			),
			array(
				'name'	=> __( 'Title: Background Height', 'wpex' ),
				'desc'	=> __( 'Select your custom height for your title background. Default is 400px.', 'wpex' ),
				'id'	=> $prefix . 'post_title_height',
				'type'	=> 'text_small',
			),
			array(
				'name'	=> __( 'Page: Background Color', 'wpex' ),
				'desc'	=> __( 'Select a custom background color for this page.', 'wpex' ),
				'id'	=> $prefix . 'page_background_color',
				'type'	=> 'colorpicker',
			),
			array(
				'name'	=> __( 'Page: Background Image', 'wpex' ),
				'desc'	=> __( 'Select a custom background image for this page.', 'wpex' ),
				'id'	=> $prefix . 'page_background_image',
				'type'	=> 'file',
			),
			array(
				'name' 		=> __( 'Page: Background Style', 'wpex' ),
				'id'		=> $prefix . 'page_background_image_style',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $bg_styles
			),
		),
	);
	
	
	/**
		Meta => Posts
	**/
	$meta_boxes[] = array(
		'id'			=> 'wpex-post-metabox',
		'title'			=> __( 'Post Settings', 'wpex' ),
		'pages'			=> array( 'post' ),
		'context'		=> 'normal',
		'priority'		=> 'high',
		'show_names'	=> true,
		'fields'		=> array(
			array(
				'name'	=> __( 'oEmbed URL', 'wpex' ),
				'desc'	=>  __( 'Enter a URL that is compatible with WP\'s built-in oEmbed feature. This setting is used for your video and audio post formats.', 'wpex' ) .'<br /><a href="http://codex.wordpress.org/Embeds" target="_blank">'. __( 'Learn More', 'wpex' ) .' &rarr;</a>',
				'id'	=> $prefix . 'post_oembed',
				'type'	=> 'text',
				'std'	=> ''
			),
			array(
				'name'	=> __( 'Self Hosted', 'wpex' ),
				'desc'	=>  __( 'Insert your self hosted video or audio url here.', 'wpex' ) .'<br /><a href="http://make.wordpress.org/core/2013/04/08/audio-video-support-in-core/" target="_blank">'. __( 'Learn More', 'wpex' ) .' &rarr;</a>',
				'id'	=> $prefix . 'post_self_hosted_shortcode',
				'type'	=> 'file',
				'std'	=> ''
			),
			array(
				'name' 		=> __( 'Site Layout', 'wpex' ),
				'id'		=> $prefix . 'main_layout',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $site_layout,
			),
			array(
				'name' 		=> __( 'Post Layout', 'wpex' ),
				'id'		=> $prefix . 'post_layout',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $page_layout,
			),
			array(
				'name' 		=> __( 'Media Display/Position', 'wpex' ),
				'id'		=> $prefix . 'post_media_position',
				'desc'		=> '',
				'type'		=> 'select',
				'desc'	=> __( 'Select your preferred position for your post\'s media (featured image or video).', 'wpex' ),
				'options'	=> array(
					array(
						'name'	=> __( 'Default', 'wpex' ),
						'value'	=> '',
					),
					array(
						'name'	=> __( 'Full-Width Above Content', 'wpex' ),
						'value'	=> 'above',
					),
					array(
						'name'	=> __( 'None (Do Not Display Featured Image/Video)', 'wpex' ),
						'value'	=> 'hidden',
					),
				),
			),
			array(
				'name'	=> __( 'Disable Header', 'wpex' ),
				'desc'	=> __( 'Check to disable the main header.', 'wpex' ),
				'id'	=> $prefix . 'disable_header',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Title', 'wpex' ),
				'desc'	=> __( 'Check to disable the main title.', 'wpex' ),
				'id'	=> $prefix . 'disable_title',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Title Margin', 'wpex' ),
				'desc'	=> __( 'Check to disable the bottom margin on the main page header.', 'wpex' ),
				'id'	=> $prefix . 'disable_header_margin',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Breadcrumbs', 'wpex' ),
				'desc'	=> __( 'Check to disable the breadcrumbs navigation.', 'wpex' ),
				'id'	=> $prefix . 'disable_breadcrumbs',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Footer Callout', 'wpex' ),
				'desc'	=> __( 'Check to disable the footer callout area if active.', 'wpex' ),
				'id'	=> $prefix . 'disable_footer_callout',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Footer', 'wpex' ),
				'desc'	=> __( 'Check to disable the main footer area. This will also include the callout and copyright.', 'wpex' ),
				'id'	=> $prefix . 'disable_footer',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Slider Shortcode', 'wpex' ),
				'desc'	=> __( 'Enter a slider shortcode here to display a slider at the top of the page.', 'wpex' ),
				'id'	=> $prefix . 'post_slider_shortcode',
				'type'	=> 'textarea_code',
			),
			array(
				'name'	=> __( 'Slider Bottom Margin', 'wpex' ),
				'desc'	=> __( 'Enter a bottom margin for your slider in pixels', 'wpex' ),
				'id'	=> $prefix . 'post_slider_bottom_margin',
				'type'	=> 'text',
			),
			array(
				'name' 		=> __( 'Title: Style', 'wpex' ),
				'id'		=> $prefix . 'post_title_style',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> array(
					array(
						'name'	=> __( 'Default', 'wpex' ),
						'value'	=> '',
					),
					array(
						'name'	=> __( 'Centered', 'wpex' ),
						'value'	=> 'centered',
					),
					array(
						'name'	=> __( 'Centered Minimal', 'wpex' ),
						'value'	=> 'centered-minimal',
					),
					array(
						'name'	=> __( 'Background Image', 'wpex' ),
						'value'	=> 'background-image',
					),
					array(
						'name'	=> __( 'Solid Color & White Text', 'wpex' ),
						'value'	=> 'solid-color',
					),
				),
			),
			array(
				'name'	=> __( 'Title: Background Color', 'wpex' ),
				'desc'	=> __( 'Select a custom background color for your main title.', 'wpex' ),
				'id'	=> $prefix . 'post_title_background_color',
				'type'	=> 'colorpicker',
			),
			array(
				'name'	=> __( 'Title: Background Image', 'wpex' ),
				'desc'	=> __( 'Select a custom header image for your main title.', 'wpex' ),
				'id'	=> $prefix . 'post_title_background',
				'type'	=> 'file',
			),
			array(
				'name'	=> __( 'Title: Background Height', 'wpex' ),
				'desc'	=> __( 'Select your custom height for your title background. Default is 400px.', 'wpex' ),
				'id'	=> $prefix . 'post_title_height',
				'type'	=> 'text_small',
			),
			array(
				'name'	=> __( 'Page: Background Color', 'wpex' ),
				'desc'	=> __( 'Select a custom background color for this page.', 'wpex' ),
				'id'	=> $prefix . 'page_background_color',
				'type'	=> 'colorpicker',
			),
			array(
				'name'	=> __( 'Page: Background Image', 'wpex' ),
				'desc'	=> __( 'Select a custom background image for this page.', 'wpex' ),
				'id'	=> $prefix . 'page_background_image',
				'type'	=> 'file',
			),
			array(
				'name' 		=> __( 'Page: Background Style', 'wpex' ),
				'id'		=> $prefix . 'page_background_image_style',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> array(
					array(
						'name'	=> __( 'Repeat', 'wpex' ),
						'value'	=> 'repeat',
					),
					array(
						'name'	=> __( 'Fixed', 'wpex' ),
						'value'	=> 'fixed',
					),
					array(
						'name'	=> __( 'Streched', 'wpex' ),
						'value'	=> 'streched',
					),
				),
			),
		)
	);
	
	/**
		Meta => Testimonials
	**/
	$meta_boxes[] = array(
		'id'			=> 'wpex_testimonials_metabox',
		'title'			=> __( 'Post Settings', 'wpex' ),
		'pages'			=> array( 'testimonials' ),
		'context'		=> 'normal',
		'priority'		=> 'high',
		'show_names'	=> true,
		'fields'		=> array(

			array(
				'name'		=> __( 'Author', 'wpex' ),
				'desc'		=> __( 'Enter the name of the author for this testimonial.', 'wpex' ),
				'id'		=> $prefix .'testimonial_author',
				'type'		=> 'text',
				'std'		=> '',
			),
			
			array(
				'name'		=> __( 'Company', 'wpex' ),
				'desc'		=> __( 'Enter the name of the company for this testimonial.', 'wpex' ),
				'id'		=> $prefix .'testimonial_company',
				'type'		=> 'text',
				'std'		=> '',
			),
			
			array(
				'name'		=> __( 'Company URL', 'wpex' ),
				'desc'		=> __( 'Enter the url for the company for this testimonial.', 'wpex' ),
				'id'		=> $prefix .'testimonial_url',
				'type'		=> 'text',
				'std'		=> '',
			),
			
		)
	);
	
	// Staff
	$meta_boxes[] = array(
		'id'      	=> 'wpex_staff_metabox',
		'title'   	=> __( 'Post Settings', 'wpex' ),
		'pages'   	=> array( 'staff' ),
		'context' 	=> 'normal',
		'priority'	=> 'high',
		'show_names'	=> true,
		'fields'  	=> array(
			array(
				'name'		=> __( 'Position', 'wpex' ),
				'id'		=> $prefix .'staff_position',
				'type'		=> 'text',
				'std'		=> '',
			),
			array(
				'name'		=> __( 'Twitter URL', 'wpex' ),
				'id'		=> $prefix .'staff_twitter',
				'type'		=> 'text',
				'std'		=> '',
			),
			array(
				'name'		=> __( 'Facebook URL', 'wpex' ),
				'id'		=> $prefix .'staff_facebook',
				'type'		=> 'text',
				'std'		=> '',
			),
			array(
				'name'		=> __( 'Google Plus URL', 'wpex' ),
				'id'		=> $prefix .'staff_google-plus',
				'type'		=> 'text',
				'std'		=> '',
			),
			array(
				'name'		=> __( 'Dribbble URL', 'wpex' ),
				'id'		=> $prefix .'staff_dribbble',
				'type'		=> 'text',
				'std'		=> '',
			),
			array(
				'name'		=> __( 'LinkedIn URL', 'wpex' ),
				'id'		=> $prefix .'staff_linkedin',
				'type'		=> 'text',
				'std'		=> '',
			),
			array(
				'name'		=> __( 'Skype URL', 'wpex' ),
				'id'		=> $prefix .'staff_skype',
				'type'		=> 'text',
				'std'		=> '',
			),
			array(
				'name'		=> __( 'Email URL', 'wpex' ),
				'id'		=> $prefix .'staff_email',
				'type'		=> 'text',
				'std'		=> '',
			),
			array(
				'name' 		=> __( 'Site Layout', 'wpex' ),
				'id'		=> $prefix . 'main_layout',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $site_layout,
			),
			array(
				'name' 		=> __( 'Page Layout', 'wpex' ),
				'id'		=> $prefix . 'post_layout',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $page_layout,
			),
			array(
				'name'	=> __( 'Disable Header', 'wpex' ),
				'desc'	=> __( 'Check to disable the main header.', 'wpex' ),
				'id'	=> $prefix . 'disable_header',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Title', 'wpex' ),
				'desc'	=> __( 'Check to disable the main title.', 'wpex' ),
				'id'	=> $prefix . 'disable_title',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Title Margin', 'wpex' ),
				'desc'	=> __( 'Check to disable the bottom margin on the main page header.', 'wpex' ),
				'id'	=> $prefix . 'disable_header_margin',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Breadcrumbs', 'wpex' ),
				'desc'	=> __( 'Check to disable the breadcrumbs navigation.', 'wpex' ),
				'id'	=> $prefix . 'disable_breadcrumbs',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Footer Callout', 'wpex' ),
				'desc'	=> __( 'Check to disable the footer callout area if active.', 'wpex' ),
				'id'	=> $prefix . 'disable_footer_callout',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Footer', 'wpex' ),
				'desc'	=> __( 'Check to disable the main footer area. This will also include the callout and copyright.', 'wpex' ),
				'id'	=> $prefix . 'disable_footer',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Related Items', 'wpex' ),
				'desc'	=> __( 'Check to disable the the related items.', 'wpex' ),
				'id'	=> $prefix . 'disable_related_items',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Page Subheading', 'wpex' ),
				'desc'	=> __( 'Enter your page subheading. Shortcodes & HTML is allowed.', 'wpex' ),
				'id'	=> $prefix . 'post_subheading',
				'type'	=> 'text',
			),
			array(
				'name'	=> __( 'Slider Shortcode', 'wpex' ),
				'desc'	=> __( 'Enter a slider shortcode here to display a slider at the top of the page.', 'wpex' ),
				'id'	=> $prefix . 'post_slider_shortcode',
				'type'	=> 'textarea_code',
			),
			array(
				'name'	=> __( 'Slider Bottom Margin', 'wpex' ),
				'desc'	=> __( 'Enter a bottom margin for your slider in pixels', 'wpex' ),
				'id'	=> $prefix . 'post_slider_bottom_margin',
				'type'	=> 'text',
			),
			array(
				'name' 		=> __( 'Title: Style', 'wpex' ),
				'id'		=> $prefix . 'post_title_style',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $title_styles,
			),
			array(
				'name'	=> __( 'Title: Background Color', 'wpex' ),
				'desc'	=> __( 'Select a custom background color for your main title.', 'wpex' ),
				'id'	=> $prefix . 'post_title_background_color',
				'type'	=> 'colorpicker',
			),
			array(
				'name'	=> __( 'Title: Background Image', 'wpex' ),
				'desc'	=> __( 'Select a custom header image for your main title.', 'wpex' ),
				'id'	=> $prefix . 'post_title_background',
				'type'	=> 'file',
			),
			array(
				'name'	=> __( 'Title: Background Height', 'wpex' ),
				'desc'	=> __( 'Select your custom height for your title background. Default is 400px.', 'wpex' ),
				'id'	=> $prefix . 'post_title_height',
				'type'	=> 'text_small',
			),
			array(
				'name'	=> __( 'Page: Background Color', 'wpex' ),
				'desc'	=> __( 'Select a custom background color for this page.', 'wpex' ),
				'id'	=> $prefix . 'page_background_color',
				'type'	=> 'colorpicker',
			),
			array(
				'name'	=> __( 'Page: Background Image', 'wpex' ),
				'desc'	=> __( 'Select a custom background image for this page.', 'wpex' ),
				'id'	=> $prefix . 'page_background_image',
				'type'	=> 'file',
			),
			array(
				'name' 		=> __( 'Page: Background Style', 'wpex' ),
				'id'		=> $prefix . 'page_background_image_style',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $bg_styles
			),
		)
	);

	/**
		Meta => Portfolio
	**/
	$meta_boxes[] = array(
		'id'			=> 'wpex-portfolio',
		'title'			=> __( 'Post Settings', 'wpex' ),
		'pages'			=> array( 'portfolio' ),
		'context'		=> 'normal',
		'priority'		=> 'high',
		'show_names'	=> true,
		'fields'		=> array(
			array(
				'name'		=> __( 'Site Layout', 'wpex' ),
				'id'		=> $prefix . 'main_layout',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $site_layout,
			),
			array(
				'name' 		=> __( 'Page Layout', 'wpex' ),
				'id'		=> $prefix . 'post_layout',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $page_layout,
			),
			array(
				'name'	=> __( 'Disable Header', 'wpex' ),
				'desc'	=> __( 'Check to disable the main header.', 'wpex' ),
				'id'	=> $prefix . 'disable_header',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Title', 'wpex' ),
				'desc'	=> __( 'Check to disable the main title.', 'wpex' ),
				'id'	=> $prefix . 'disable_title',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Title Margin', 'wpex' ),
				'desc'	=> __( 'Check to disable the bottom margin on the main page header.', 'wpex' ),
				'id'	=> $prefix . 'disable_header_margin',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Breadcrumbs', 'wpex' ),
				'desc'	=> __( 'Check to disable the breadcrumbs navigation.', 'wpex' ),
				'id'	=> $prefix . 'disable_breadcrumbs',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Footer Callout', 'wpex' ),
				'desc'	=> __( 'Check to disable the footer callout area if active.', 'wpex' ),
				'id'	=> $prefix . 'disable_footer_callout',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Footer', 'wpex' ),
				'desc'	=> __( 'Check to disable the main footer area. This will also include the callout and copyright.', 'wpex' ),
				'id'	=> $prefix . 'disable_footer',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Disable Related Items', 'wpex' ),
				'desc'	=> __( 'Check to disable the the related items.', 'wpex' ),
				'id'	=> $prefix . 'disable_related_items',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> __( 'Page Subheading', 'wpex' ),
				'desc'	=> __( 'Enter your page subheading. Shortcodes & HTML is allowed.', 'wpex' ),
				'id'	=> $prefix . 'post_subheading',
				'type'	=> 'text',
			),
			array(
				'name'	=> __( 'Slider Shortcode', 'wpex' ),
				'desc'	=> __( 'Enter a slider shortcode here to display a slider at the top of the page.', 'wpex' ),
				'id'	=> $prefix . 'post_slider_shortcode',
				'type'	=> 'textarea_code',
			),
			array(
				'name'	=> __( 'Featured Video', 'wpex' ),
				'desc'	=> __( 'Define a featured video URL for this portfolio post.', 'wpex' ),
				'id'	=> $prefix . 'post_video',
				'type'	=> 'textarea_code',
			),
			array(
				'name'	=> __( 'Slider Bottom Margin', 'wpex' ),
				'desc'	=> __( 'Enter a bottom margin for your slider in pixels', 'wpex' ),
				'id'	=> $prefix . 'post_slider_bottom_margin',
				'type'	=> 'text',
			),
			array(
				'name'		=> __( 'Title: Style', 'wpex' ),
				'id'		=> $prefix . 'post_title_style',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $title_styles,
			),
			array(
				'name'	=> __( 'Title: Background Color', 'wpex' ),
				'desc'	=> __( 'Select a custom background color for your main title.', 'wpex' ),
				'id'	=> $prefix . 'post_title_background_color',
				'type'	=> 'colorpicker',
			),
			array(
				'name'	=> __( 'Title: Background Image', 'wpex' ),
				'desc'	=> __( 'Select a custom header image for your main title.', 'wpex' ),
				'id'	=> $prefix . 'post_title_background',
				'type'	=> 'file',
			),
			array(
				'name'	=> __( 'Title: Background Height', 'wpex' ),
				'desc'	=> __( 'Select your custom height for your title background. Default is 400px.', 'wpex' ),
				'id'	=> $prefix . 'post_title_height',
				'type'	=> 'text_small',
			),
			array(
				'name'	=> __( 'Page: Background Color', 'wpex' ),
				'desc'	=> __( 'Select a custom background color for this page.', 'wpex' ),
				'id'	=> $prefix . 'page_background_color',
				'type'	=> 'colorpicker',
			),
			array(
				'name'	=> __( 'Page: Background Image', 'wpex' ),
				'desc'	=> __( 'Select a custom background image for this page.', 'wpex' ),
				'id'	=> $prefix . 'page_background_image',
				'type'	=> 'file',
			),
			array(
				'name' 		=> __( 'Page: Background Style', 'wpex' ),
				'id'		=> $prefix . 'page_background_image_style',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> $bg_styles
			),
		),
	);

	/**
		Meta => Products
	**/
	if ( class_exists('Woocommerce') ) {
		$meta_boxes[] = array(
			'id'			=> 'wpex-page-meta',
			'title'			=> __( 'Page Settings', 'wpex' ),
			'pages'			=> array( 'product' ),
			'context'		=> 'normal',
			'priority'		=> 'high',
			'show_names'	=> true,
			'fields'		=> array(
				array(
					'name'		=> __( 'Page Layout', 'wpex' ),
					'id'		=> $prefix . 'post_layout',
					'desc'		=> '',
					'type'		=> 'select',
					'options'	=> array(
						array(
							'name'	=> __( 'Default', 'wpex' ),
							'value'	=> '',
						),
						array(
							'name'	=> __( 'Right Sidebar', 'wpex' ),
							'value'	=> 'right-sidebar',
						),
						array(
							'name'	=> __( 'Left Sidebar', 'wpex' ),
							'value'	=> 'left-sidebar',
						),
						array(
							'name'	=> __( 'No Sidebar', 'wpex' ),
							'value'	=> 'full-width',
						),
					),
				),
				array(
					'name'	=> __( 'Disable Breadcrumbs', 'wpex' ),
					'desc'	=> __( 'Check to disable the breadcrumbs navigation.', 'wpex' ),
					'id'	=> $prefix . 'disable_breadcrumbs',
					'type'	=> 'checkbox',
				),
				array(
					'name'	=> __( 'Disable Social Share', 'wpex' ),
					'desc'	=> __( 'Check to disable the social sharing icons if enabled.', 'wpex' ),
					'id'	=> $prefix . 'disable_social',
					'type'	=> 'checkbox',
				),
				array(
					'name'	=> __( 'Disable Footer Callout', 'wpex' ),
					'desc'	=> __( 'Check to disable the footer callout area if active.', 'wpex' ),
					'id'	=> $prefix . 'disable_footer_callout',
					'type'	=> 'checkbox',
				),
			),
		);
	}
	
	

	return $meta_boxes;
}

// Initialize the metabox class
add_action( 'init', 'wpex_init_metaboxes', 9999 );
if ( ! function_exists( 'wpex_init_metaboxes' ) ) {
	function wpex_init_metaboxes() {
		if ( ! class_exists( 'cmb_Meta_Box' ) ) {
			require_once( WPEX_FRAMEWORK_DIR .'/meta/init.php' );
		}
	}
}