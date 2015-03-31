<?php
/*
 * Used to show/hide metaboxes
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
*/


add_action( 'admin_print_scripts', 'wpex_display_metaboxes', 1000 );
if ( ! function_exists( 'wpex_display_metaboxes' ) ) {
	function wpex_display_metaboxes() {
	global $metaboxes, $pagenow;
	if( 'post.php' != $pagenow && 'post-new.php' != $pagenow ) return; // Not editing a page, bye!
	if ( get_post_type() == "post" ) { ?>
		<script type="text/javascript">// <![CDATA[
		jQuery( function($) {
			$ = jQuery;
			function displayMetaboxes() {
				$('#easy_image_gallery, .cmb_id_wpex_post_oembed, .cmb_id_wpex_post_self_hosted_shortcode').hide();
				var selectedElt = $("input[name='post_format']:checked").val();
				if ( selectedElt ) {
					if ( selectedElt == 'audio' || selectedElt == 'video' ) {
						$("#wpex-post-format-0-metabox-portfolio, #wpex-post-format-video-audio-metabox").fadeIn();
					}
					if ( selectedElt == 'gallery' ) {
						$('#easy_image_gallery').fadeIn();
					}
					if ( selectedElt == 'video' || selectedElt == 'audio' ) {
						$('.cmb_id_wpex_post_oembed, .cmb_id_wpex_post_self_hosted_shortcode').fadeIn();
					}
				}		
			}
			$(function() {
				displayMetaboxes();
				$("input[name='post_format']").change(function() {
					displayMetaboxes();
				});
			});
		 });
		// ]]></script>
		<?php
		} // End if post
		if ( get_post_type() == "page" || get_post_type() == "portfolio" || get_post_type() == "staff" ) { ?>
			<script type="text/javascript">// <![CDATA[
			jQuery( function($) {
				$ = jQuery;
				function displayWpexMeta() {
					var hideSliderMarginSetting = $('.cmb_id_wpex_post_slider_bottom_margin');
					var hiddenBGOptions = $('.cmb_id_wpex_post_title_background, .cmb_id_wpex_post_title_height');
					var hiddenBGSolidOps = $('.cmb_id_wpex_post_title_background_color');
					hideSliderMarginSetting.hide();
					hiddenBGOptions.hide();
					hiddenBGSolidOps.hide();
					var sliderShortcodeInput = $("#wpex_post_slider_shortcode");
					var selectedTitleStyle = $("#wpex_post_title_style").val();
					if ( sliderShortcodeInput ) {
						if ( sliderShortcodeInput.val().length !== 0 ) {
							hideSliderMarginSetting.show();
						}
					}
					if ( selectedTitleStyle ) {
						if ( selectedTitleStyle == 'background-image' ) {
							hiddenBGOptions.show();
							hiddenBGSolidOps.show();
						}
					}
					if ( selectedTitleStyle ) {
						if ( selectedTitleStyle == 'solid-color' ) {
							hiddenBGSolidOps.show();
						}
					}
				}
				$(function() {
					displayWpexMeta();
					$("#wpex_post_title_style").change(function() {
						displayWpexMeta();
					});
					$('#wpex_post_slider_shortcode').blur(function() {
						displayWpexMeta();
					});
				});
			 });
			// ]]></script>
		<?php } // End if page
	}
}