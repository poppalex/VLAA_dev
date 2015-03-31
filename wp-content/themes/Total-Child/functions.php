<?php
// Start adding some code here, don't be shy!
// If you want to override core theme functions you can.
// Open the parent "Total" theme and inside the "functions" folder you'll find all the main functions.
// Pretty much any function from the parent theme can be copied and pasted here and then tweaked to your liking.
// You can obviously delete all this, just make sure you leave the <?php at the top!


function register_my_menu() {
  register_nav_menu('upper-menu',__( 'Upper Menu' ));
}
add_action( 'init', 'register_my_menu' );
?>

