<?php // ==== ASSETS ==== //

// Now that you have efficiently generated scripts and stylesheets for your theme, how should they be integrated?
// This file walks you through an approach I use but you are free to do this any way you like

// Load header assets; this should include the main stylesheet as well as any mission critical scripts
function divi_assets_header() {

  // Header script loading is simplistic in this starter kit but you may want to change what file is loaded based on various conditions; check out the footer asset loader for an example
  $file = 'divi-header';
//  wp_enqueue_script( 'divi-header', get_stylesheet_directory_uri() . '/js/' . $file . '.js', $deps = array('jquery'), filemtime( get_stylesheet_directory() . '/js/' . $file . '.js' ), false );

  // Register and enqueue our main stylesheet with versioning based on last modified time
  wp_register_style( 'divi-style', get_template_directory_uri() . '/style.css', $dependencies = array(), filemtime( get_template_directory() . '/style.css' ) );
  wp_enqueue_style( 'divi-style' );
//  wp_register_style( 'child-style', get_stylesheet_uri(), $dependencies = array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
//  wp_enqueue_style( 'child-style' );
}
add_action( 'wp_enqueue_scripts', 'divi_assets_header' );



// Load footer assets; a more complex example of a smooth asset-loading approach for WordPress themes
function divi_assets_footer() {

  // Initialize variables
  $name = 'divi-footer';       // This is the script handle
  $file = 'divi';              // The beginning of the filename; "x" is the namespace set in `gulpconfig.js`
  $vars = array();             // An empty array that may be populated by script variables for output with `wp_localize_script` after the footer script is enqueued

  // This approach allows for conditional loading of various script bundles based on options set in `src/functions-config-defaults.php`
  // Note: bundles require fewer HTTP requests at the expense of addition caching hits when different scripts are requested on different pages of your site
  // You could also load one main bundle on every page with supplementary scripts as needed (e.g. for commenting or a contact page); it's up to you!


  // If none of the conditons were matched (above) let's output the default script name
  if ( $file === 'divi' )
    $file .= '-footer';

  // Load theme-specific JavaScript bundles with versioning based on last modified time; http://www.ericmmartin.com/5-tips-for-using-jquery-with-wordpress/
  // The handle is the same for each bundle since we're only loading one script; if you load others be sure to provide a new handle
  wp_enqueue_script( $name, get_stylesheet_directory_uri() . '/js/' . $file . '.js', array( 'jquery' ), filemtime( get_stylesheet_directory() . '/js/' . $file . '.js' ), true ); // This last `true` is what loads the script in the footer

  // Pass variables to scripts at runtime; must be triggered after the script is enqueued; see: http://codex.wordpress.org/Function_Reference/wp_localize_script
  if ( !empty( $vars ) ) {
    foreach ( $vars as $var => $data )
      wp_localize_script( $name, $var, $data );
  }
}
//add_action( 'wp_enqueue_scripts', 'divi_assets_footer' );

// Load admin js/css
function load_custom_wp_admin_files()
{
    wp_enqueue_script('child-admin.js', get_stylesheet_directory_uri() . '/js/divi-admin.js', array('jquery'), true);
    wp_enqueue_style('child-admin.css', get_stylesheet_directory_uri() . '/admin.css', false, null);
}

add_action('admin_enqueue_scripts', 'load_custom_wp_admin_files');

