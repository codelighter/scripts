//START============================================================================================
// Structured Data Markup
function ewtech_structured_data_keyword() {
  if ( is_single() ) {
    $tags   = '"keywords" : [' . strip_tags(get_the_tag_list('"','", "','"')) . '],';
    echo $tags."\r\n";
  }
}
function ewtech_structured_data_output() {
  if ( is_single() ) {
    $article_author_name    =   get_the_author_meta( 'display_name', $author_id );
    $article_published_date =   get_the_time('c');
    $thumb_id = get_post_thumbnail_id();
    $thumb_url = wp_get_attachment_image_src($thumb_id,'large', true);
    $article_logo = "URL";
?>
    <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "Article",
        "headline": "<?php the_title(); ?>",
        "image": {
          "@type": "ImageObject",
          "url": "<?php echo $thumb_url[0]; ?>",
          "width": 1024,
          "height": 1024
        },
          <?php if(function_exists('ewtech_structured_data_keyword')) ewtech_structured_data_keyword(); ?>
          "datePublished": "<?php echo $article_published_date ?>",
          "dateModified": "<?php echo $article_published_date ?>",
          "articleSection": "<?php $categories = get_the_category(); foreach($categories as $category) { $cat_name = $category->name;  echo  $cat_name ; } ?>",
          "publisher":{
            "@type": "Organization",
            "name": "<?php echo $article_author_name ?>",
            "logo": {
              "@type": "ImageObject",
              "url": "<?php echo $article_logo; ?>",
              "width": 600,
              "height": 60
            }
          },
          "author": {
            "@type": "Person",
            "name": "<?php echo $article_author_name ?>"
          },
          "articleBody": "<?php $excerpt = strip_tags(get_the_excerpt()); echo $excerpt; ?>",
        "mainEntityOfPage": "True"
      }
    </script>
<?php
  }
}
add_action('wp_footer','ewtech_structured_data_output');
//END==============================================================================================
