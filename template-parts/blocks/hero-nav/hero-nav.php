<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'hero-nav-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'hero-nav';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>

<!--Hero-->
<section id="<?php echo $id ?>" class="page-hero w-100 mt-xd-0 mt-lg-5 d-block d-md-flex">
  <div class="row w-100 no-gutters">
    <div class="col-12 col-md-5 hero-nav">
      <div class="container">
        <div class="row mt-4">
          <div class="col-xs-8 col-md-7 mx-auto pt-3 hero-nav-inner">
            <h1><?php the_title(); ?></h1>
            <ul class="pl-0">
            <?php  // check if the repeater field has rows of data
              if( have_rows('hero_navigation') ):

               	// loop through the rows of data
                  while ( have_rows('hero_navigation') ) : the_row(); ?>
                  <li>
                    <a href="<?php if (get_sub_field('hero_nav_link_type') == "link"){ the_sub_field('hero_nav_item_link'); } else { echo chr(043) . get_sub_field('hero_nav_item_anchor');  }?>"><?php the_sub_field('hero_nav_item_text'); ?></a>
                  </li>
                  <?php

                  endwhile;

              else :

                  // no rows found

              endif;

              ?>
            </ul>
          </div>
        </div>
      </div>


    </div>
    <div class="d-none d-md-block col-sm-7">
      <?php if( get_field('hero_nav_img') ): ?>
        <img src="<?php the_field('hero_nav_img'); ?>" alt=""
      <?php endif; ?>" class="hero-img img-fluid">
    </div>

  </div>


</section>
