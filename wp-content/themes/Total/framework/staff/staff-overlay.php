<?php
/**
 * Staff entry thumbnail overlay
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/

if ( ! function_exists( 'wpex_get_staff_overlay' ) ) {
	function wpex_get_staff_overlay($id=NULL) {
		$post_id = $id ? $id : get_the_ID();
		$position = get_post_meta( get_the_ID(), 'wpex_staff_position', true );
		$output='';
		if ( empty($position) || $position == '' ) return;
		$output.='<div class="staff-entry-position">';
			$output.='<span>'. $position .'</span>';
		$output.='</div><!-- .staff-entry-position -->';
		return $output;
	}
}