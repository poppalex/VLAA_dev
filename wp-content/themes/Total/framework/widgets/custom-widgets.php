<?php
/**
 * This file registers the theme's widget regions
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

// Don't load custom widgets unless needed
if ( is_admin() ) {
	global $wp_customize, $pagenow;
	if ( $pagenow != "widgets.php" && !isset( $wp_customize ) ) {
		return;
	}
}

// Get custom widget files
require_once( WPEX_FRAMEWORK_DIR .'widgets/custom-widgets/widget-simple-menu.php' );
require_once( WPEX_FRAMEWORK_DIR .'widgets/custom-widgets/widget-social-fontawesome.php' );
require_once( WPEX_FRAMEWORK_DIR .'widgets/custom-widgets/widget-social.php' );
require_once( WPEX_FRAMEWORK_DIR .'widgets/custom-widgets/widget-flickr.php' );
require_once( WPEX_FRAMEWORK_DIR .'widgets/custom-widgets/widget-video.php' );
require_once( WPEX_FRAMEWORK_DIR .'widgets/custom-widgets/widget-posts-thumbnails.php' );
require_once( WPEX_FRAMEWORK_DIR .'widgets/custom-widgets/widget-recent-posts-thumb-grid.php' );
require_once( WPEX_FRAMEWORK_DIR .'widgets/custom-widgets/widget-posts-icons.php' );
require_once( WPEX_FRAMEWORK_DIR .'widgets/custom-widgets/widget-comments-avatar.php' );