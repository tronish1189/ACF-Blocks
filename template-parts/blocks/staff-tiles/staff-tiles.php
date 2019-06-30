<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'staff-tiles-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'staff-tiles';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>

<!-- Design Team - About -->
<section id="design-team">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-10">
        <h2><?php the_field('staff_tile_title'); ?></h2>
        <p><?php the_field('staff_tile_text'); ?></p>
      </div>
    </div>
    <div class="row design-team-photos">

          <?php

      $args = array(
              'post_type' => 'staff',
              'category_name' => 'design-team',
              'orderby' => 'ID',
              'order'   => 'ASC'
      ); $my_query = new WP_Query( $args );
$a = 1;
      if ( $my_query->have_posts() ) {

          while ( $my_query->have_posts() ) {
              $my_query->the_post(); $a++  ?>
              <div class="col-xs-12 col-md-4 my-2">
                <a data-toggle="modal" data-target="#design-team-modal-<?php echo $a; ?>" class="design-team-link">
                  <img src="<?php if ( has_post_thumbnail() ) {
              the_post_thumbnail_url();
            } ?>" alt="" class="img-fluid">
                  <h4><?php the_title(); ?></h4></a>
                </div>

                <div class="modal" id="design-team-modal-<?php echo $a; ?>" <?php $a++; ?> tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">

                          <div class="modal-content">
                            <div class="container">
                              <div class="row">
                                <div class="col-10 mx-auto">
                            <div class="modal-header">
                              <h5 class="modal-title"><?php the_title(); ?></h5>

                            </div>
                            <div class="modal-body">
                              <p><?php the_content(); ?></p>
                              <button type="button" class="close d-block mx-auto" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>

                          </div>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>


<?php   }

}

// Reset the `$post` data to the current post in main query.
wp_reset_postdata();

?>
    </div>

</section>
