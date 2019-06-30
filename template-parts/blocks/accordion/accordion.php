<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'accordion-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'accordion';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>


<!--Accordion-->
<section id="<?php echo $id ?>">
  <div class="container">
    <div class="<?php echo $className ?>" id="accordion">
      <?php
      $count = count(get_field('accordion_item'));
      $a = 0;

      if( have_rows('accordion_item') ):
        while ( have_rows('accordion_item') ) : the_row(); ?>
      <div class="card">
        <div class="card-header" id="heading-<?php echo $a ?>">
          <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-<?php echo $a ?>" aria-expanded="true" aria-controls="accordion-<?php echo $a ?>">
              <?php the_sub_field('accordion_title'); ?>
            </button>
          </h5>
        </div>
        <div id="accordion-<?php echo $a ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
          <div class="card-body col-md-11 mx-auto">
            <?php the_sub_field('accordion_body'); ?>
          </div>
        </div>
      </div>
      <?php $a++;
    endwhile;
  endif; ?>
