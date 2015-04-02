<?php
/**
 * The Header for our theme.
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link  http://www.wpexplorer.com
 * @since Total 1.0
 */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php wpex_meta_viewport(); ?>
	<?php wpex_meta_title(); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( wpex_option('custom_favicon') ) : ?>
		<link rel="shortcut icon" href="<?php echo wpex_option('custom_favicon'); ?>" />
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<!-- Begin Body -->
<body <?php body_class(); ?>>


	<?php
	// Before wrap hook
	wpex_hook_wrap_before(); ?>

	<div id="wrap" class="clr">


		<?php
		// Top wrap hook
		wpex_hook_wrap_top(); ?>
	
		<?php
		// Display header if enabled
		// See functions/header-display.php
		if ( wpex_display_header() == true ) {
			
			// Before header hook
			wpex_hook_header_before();

			/* This is a very unique and highly customizable header.
			 * All the content for your site header is added via hooks.
			 * Please have a look in functions/hooks/hooks-defaults.php to see the default
			 * functions that are addeed to the header.
			*/ ?>
			<div class="topSocial container">
			<img src="/VLAA_dev/wp-content/uploads/2015/03/youtube7.png"><a href="https://www.facebook.com/pages/St-Louis-Volunteer-Lawyers-and-Accountants-for-the-Arts/119114161655" target="_blank"><img src="/VLAA_dev/wp-content/uploads/2015/03/facebook292.png"></a>
			</div>
			<hr>
			<header id="site-header" class="<?php wpex_header_classes(); ?>" role="banner">
				<?php wpex_hook_header_top(); ?>	
				<div id="site-header-inner" class="container">
					<?php wpex_hook_header_inner(); ?>

				</div><!-- #site-header-inner -->
				<div class="container clr"><p style="font-size:10px; margin-bottom:0px;">Serving the St. Louis Bi-state Region</p></div>
				<hr style="margin-bottom:10px;">
				<?php wpex_hook_header_bottom(); ?>

			</header><!-- #header -->

			<?php
			// After header hook
			wpex_hook_header_after();
			
		} // end if header enabled check ?>
		
	<?php
	// Main before hook
	wpex_hook_main_before(); ?>
	
	<div id="main" class="site-main clr">
	
		<?php
		// Main top hook
		// Page Header & Page Slider functions are added here by default
		wpex_hook_main_top(); ?>