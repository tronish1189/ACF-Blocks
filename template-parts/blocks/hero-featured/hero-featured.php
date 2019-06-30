<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'hero-featured-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'hero-featured';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>

<!--Featured - About-->
<section id="featured-about" class="geo-focus">
  <style>
  section.geo-focus{
    background-image: url('<?php if( get_field('hero_featured_img') ): the_field('hero_featured_img'); ?>'
          <?php endif; ?>);
  }
  </style>
  <div class="dark-overlay">
    <div class="container">
      <div class="row mx-auto">
        <div class="col text-center">
          <p><?php if(get_field('hero_featured_text')) : the_field('hero_featured_text'); endif;?></p>
        </div>
      </div>
    </div>
  </div>
</section>
