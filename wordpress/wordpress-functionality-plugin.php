<?php
/**
 * 	Plugin Name: 	WordPress Functionality Plugin
 * 	Plugin URI: 	http://rickrduncan.com/wordpress/functionality-plugin
 * 	Description: 	Core WordPress customizations that are theme independent.
 * 	Author: 		  Rick R. Duncan - B3Marketing, LLC
 * 	Author URI: 	http://rickrduncan.com
 *
 *
 * 	Version: 		1.0.0
 * 	License: 		GPLv2
 *
 *
 *  WordPress Functionality Plugin is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 2 of the License, or
 *  any later version.
 *
 *  WordPress Functionality Plugin is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with WP Functional Plugin. If not, see <http://www.gnu.org/licenses/>.
 */

//* Remove 'Editor' from 'Appearance' Menu. 
//* This stops users and hackers from being able to edit files from within WordPress.  
define( 'DISALLOW_FILE_EDIT', true );

//* Add the ability to use shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );

//* Prevent WordPress from compressing images
add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );

//* Disable any and all mention of emoji's
//* Source code credit: http://ottopress.com/
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );   
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );     
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

//* Remove items from the <head> section
remove_action( 'wp_head', 'wp_generator' );							//* Remove WP Version number
remove_action( 'wp_head', 'wlwmanifest_link' );						//* Remove wlwmanifest_link
remove_action( 'wp_head', 'rsd_link' );								//* Remove rsd_link
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );			//* Remove shortlink
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );	//* Remove previous/next post links

//* Limit the number of post revisions to keep
add_filter( 'wp_revisions_to_keep', 'b3m_set_revision_max', 10, 2 );
function b3m_set_revision_max( $num, $post ) {     
    $num = 5; //change 5 to match your preferred number of revisions to keep
    return $num; 
}

/** ---:[ place your custom code below this line ]:--- */