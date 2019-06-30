<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'staff-list-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'staff-list';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>

<!-- Design Team - About -->
<section id="<?php echo $id ?>" class="<?php echo $className ?>">
  <div class="container">
    <?php if(get_field('staff_list_title')); { ?>
      <div class="row">
        <div class="col">
          <h2><?php the_field('staff_list_title'); ?></h2>
        </div>
      </div>
    <?php }
    $args = array(
            'post_type' => 'staff',
            'category_name' => 'co-directors',
            'orderby' => 'ID',
            'order'   => 'ASC'
    ); $my_query = new WP_Query( $args );

    if ( $my_query->have_posts() ) {

        while ( $my_query->have_posts() ) {

            $my_query->the_post(); ?>

    <div class="row mt-4">
      <div class="col-xs-5 col-md-3">
        <img src="<?php if ( has_post_thumbnail() ) {
    the_post_thumbnail_url();
  } ?>" alt="" class="img-fluid">
      </div>
      <div class="col-1"></div>
      <div class="col-xs-12 col-md-8">
        <h4 class="pt-xs-3"><?php the_title(); ?></h4>
        <p><?php the_content(); ?></p>
      </div>
    </div>

  <?php }
}
// Reset the `$post` data to the current post in main query.
wp_reset_postdata();

?>
  </div>
</section>
