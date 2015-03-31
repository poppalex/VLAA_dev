<?php
/**
 * The Template for displaying standard post type content
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.4
 */
?>

<div id="content-wrap" class="container clr <?php echo wpex_get_post_layout_class(); ?>">
	<?php if ( !post_password_required() && get_post_meta( get_the_ID(), 'wpex_post_media_position', true ) == 'above' ) { ?>
		<?php get_template_part('content', get_post_format() ); ?>
	<?php } ?>
	<section id="primary" class="content-area clr">
		<div id="content" class="site-content clr" role="main"> 
			<?php
			// Display post meta info
			wpex_post_meta(); ?>
			<article class="entry clr">
				<?php if ( !post_password_required() && get_post_meta( get_the_ID(), 'wpex_post_media_position', true ) == '' ) { ?>
					<?php
					// Get post media depending on it's post format - content.php is the fallback.
					get_template_part('content', get_post_format() ); ?>
				<?php } ?>
					<?php
					// Displays list of all post in the series if available
					wpex_post_series( get_the_ID() ); ?>
					<?php
					// Get post content for all formats except quote && link
					if ( get_post_format() !== 'quote' && get_post_format() !== 'link' ) {
						the_content();
					} ?>
					<?php
					// Post Tags
					if ( '1' == wpex_option('blog_tags','1') ) { ?>
						<?php the_tags('<div class="post-tags clr">','','</div>'); ?>
					<?php } ?>
			</article><!-- .entry -->
			<?php
			// Link pages when using <!--nextpage-->
			wp_link_pages( array( 'before' => '<div class="page-links clr">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
			
			<?php
			// Display author bio, related posts and comments if post isn't password protected
			if ( ! post_password_required() ) : ?>
			
				<?php
				// Social sharing links
				if ( '1' == wpex_option( 'blog_social_share', '1' ) ) {
					wpex_social_share();
				} ?>
			
				<?php
				// Author bio
				if ( '1' == wpex_option( 'blog_bio', '1' )  && get_the_author_meta( 'description' ) && 'hide' != get_post_meta( get_the_ID(), 'wpex_post_author', true ) ) {
					get_template_part('author-bio');
				} ?>
				
				<?php
				// Displays related posts
				// See functions/blog/blog-related.php
				wpex_blog_related(); ?>
				
				<?php
				// Get the post comments & comment_form
				comments_template(); ?>
			<?php
			//end password protection check 
			endif; ?>
		</div><!-- #content -->
	</section><!-- #primary -->
	
	<?php
	// Get site sidebar
	get_sidebar(); ?>
	
	<?php
	// Display next/prev links if enabled - see functions/commons.php
	if ( '1' == wpex_option( 'blog_next_prev', '1' ) ) wpex_next_prev(); ?>
</div><!-- .container -->