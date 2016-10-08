<?php





//================================ START ====================================//
/* modified single-project.php allows direct download of featured post image
 * this version created 2016-10-08 by EWTech for the Divi Theme Users FB Group
 *
 * INSTRUCTIONS: drop file into child theme folder. you are done.
 *
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 *
 * ORIGINALLY ADAPTED (with love) FROM THE FOLLOWING PLUGIN
 * Plugin Name: WP-Force Images Download
 * Plugin URI: https://wordpress.org/plugins/wp-force-image-download/
 * Description: Put wp_fid(); template tag or [wpfid] shortcode where you want to appear download button. For more details see description.
 * Author: Nazakat ALi
 * Author URI: https://profiles.wordpress.org/nazakatali32
 * Version: 1.5
 * License: GPL2
 */

//skips this section if post data not found
if (!empty($_POST)):

//get filedata
$file_url = $_POST['pic_url'];
$file_new_name = $_POST['new_name'];

//clean the fileurl
$file_url  = stripslashes(trim($file_url ));

//get filename
$file_name = basename($file_url );

//get fileextension
#$file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
$file_extension = pathinfo($file_name);

//security check
$fileName = strtolower($file_url);
$whitelist = array('png', 'gif', 'tiff', 'jpeg', 'jpg','bmp','svg');
if(!in_array(end(explode('.', $fileName)), $whitelist)) {
    exit('Invalid file!');
}
if(strpos( $file_url , '.php' ) == true) {
    die("Invalid file!");
}

//check if file exist
if(file_exists( $file_url  ) == false) {
    #exit("File Not Found!");
}

//rename (since 1.4)
if(isset($file_new_name) and !empty($file_new_name)) {
    $file_new_name = $file_new_name.".".$file_extension['extension'];
} else{
    $file_new_name = $file_name;
}

//check filetype
switch( $file_extension['extension'] ) {
        case "png": $content_type="image/png"; break;
        case "gif": $content_type="image/gif"; break;
        case "tiff": $content_type="image/tiff"; break;
        case "jpeg":
        case "jpg": $content_type="image/jpg"; break;
        default: $content_type="application/force-download";
}
header("Expires: 0");
header("Cache-Control: no-cache, no-store, must-revalidate");
header('Cache-Control: pre-check=0, post-check=0, max-age=0', false);
header("Pragma: no-cache");   
header("Content-type: {$content_type}");
header("Content-Disposition:attachment; filename={$file_new_name}");
header("Content-Type: application/force-download");
#header("Content-Type: application/download");
#header( "Content-Length: ". filesize($file_name) );
readfile("{$file_url}");
exit();

// resumes normal page operations if post data not found
else:
//================================ END ====================================//





get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

$show_navigation = get_post_meta( get_the_ID(), '_et_pb_project_nav', true );

?>

<div id="main-content">

<?php if ( ! $is_page_builder_used ) : ?>

    <div class="container">
        <div id="content-area" class="clearfix">
            <div id="left-area">

<?php endif; ?>

            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <?php if ( ! $is_page_builder_used ) : ?>

                    <div class="et_main_title">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <span class="et_project_categories"><?php echo get_the_term_list( get_the_ID(), 'project_category', '', ', ' ); ?></span>
                    </div>





<?php //================================ START ====================================// ?>
<style type="text/css">
#imgdl .et_overlay { cursor:pointer; }
#imgdl .et_overlay:before { content:"\e092"; }
</style>
<span class="et_portfolio_image">
<?php //================================ END ====================================// ?>





                <?php
                    $thumb = '';

                    $width = (int) apply_filters( 'et_pb_portfolio_single_image_width', 1080 );
                    $height = (int) apply_filters( 'et_pb_portfolio_single_image_height', 9999 );
                    $classtext = 'et_featured_image';
                    $titletext = get_the_title();
                    $thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Projectimage' );
                    $thumb = $thumbnail["thumb"];

                    $page_layout = get_post_meta( get_the_ID(), '_et_pb_page_layout', true );

                    if ( '' !== $thumb )
                        print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
                ?>





<?php //================================ START ====================================// ?>
<form id="imgdl" name="imgdl" method="post" action="<?php echo htmlspecialchars(get_stylesheet_directory_uri().'/single-project.php'); ?>">
  <input name="new_name" type="hidden" value="<?php //whatever you put here renames the files upon download ?>" />
  <input name="pic_url" type="hidden" value="<?php echo the_post_thumbnail_url( 'full' ); ?>" />
  <span class="et_overlay" onclick="imgdl.submit()"></span>
</form>
</span>
<?php //================================ END ====================================// ?>





                <?php endif; ?>

                    <div class="entry-content">
                    <?php
                        the_content();

                        if ( ! $is_page_builder_used )
                            wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
                    ?>
                    </div> <!-- .entry-content -->

                <?php if ( ! $is_page_builder_used ) : ?>

                    <?php if ( 'et_full_width_page' !== $page_layout ) et_pb_portfolio_meta_box(); ?>

                <?php endif; ?>

                <?php if ( ! $is_page_builder_used || ( $is_page_builder_used && 'on' === $show_navigation ) ) : ?>

                    <div class="nav-single clearfix">
                        <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . et_get_safe_localization( _x( '&larr;', 'Previous post link', 'Divi' ) ) . '</span> %title' ); ?></span>
                        <span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . et_get_safe_localization( _x( '&rarr;', 'Next post link', 'Divi' ) ) . '</span>' ); ?></span>
                    </div><!-- .nav-single -->

                <?php endif; ?>

                </article> <!-- .et_pb_post -->

            <?php
                if ( ! $is_page_builder_used && comments_open() && 'on' == et_get_option( 'divi_show_postcomments', 'on' ) )
                    comments_template( '', true );
            ?>
            <?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

            </div> <!-- #left-area -->

            <?php if ( 'et_full_width_page' === $page_layout ) et_pb_portfolio_meta_box(); ?>

            <?php get_sidebar(); ?>
        </div> <!-- #content-area -->
    </div> <!-- .container -->

<?php endif; ?>

</div> <!-- #main-content -->

<?php get_footer(); ?>





//================================ START ====================================//
// close the post evaluation if statement
<?php endif; ?>
//================================ END ====================================//
