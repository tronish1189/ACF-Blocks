<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'blog-tiles-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'blog-tiles';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>

<!-- Blog Tiles -->
<section id="blog" class="my-6">
  <div class="container">
    <?php if(get_field('blog_tiles_title')):?>
    <h2><?php the_field('blog_tiles_title'); endif; ?></h2>
    <p><?php if(get_field('blog_tiles_intro')): the_field('blog_tiles_intro'); endif; ?></p>
        <div class="row">
    <?php

$args = array(
        'post_type' => 'post'
);

$my_query = new WP_Query( $args );

if ( $my_query->have_posts() ) {

    while ( $my_query->have_posts() ) {

        $my_query->the_post(); ?>

          <div class="col-md-4">
            <a href="<?php the_permalink(); ?>">
              <div class="card mb-3 blog-entry">
                <img src="<?php if ( has_post_thumbnail() ) {
            the_post_thumbnail_url();
          } ?>" class="card-img-top" alt="">
                <div class="card-body">
                  <h5 class="card-title"><?php the_title(); ?></h5>
                  <p class="card-text"><?php the_excerpt(); ?></p>
                  <p class="card-text"><small class="text-muted">Posted on <?php the_time('F jS Y') ?></small></p>
                </div>
              </div>
            </a>
          </div>


<?php    }

}

// Reset the `$post` data to the current post in main query.
wp_reset_postdata();

?>
    </div>

</section>
