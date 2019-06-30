<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'text-block' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'text-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

if(get_field('align_class') == "center"){
  $align_class = "mx-auto";
}
?>

<!-- Text Block -->
<section id="<?php echo $id; ?>" class="<?php echo $className; ?> 	<?php
    $blocks = parse_blocks( get_the_content() );

    if ( $blocks[0]['blockName'] === 'acf/hero-nav' ) { ?>
      my-6
  <?php  }?>">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-10 <?php echo $align_class; ?>">
        <?php if(get_field('text_block_heading')); { ?>
        <h2><?php the_field('text_block_heading'); } ?></h2>

        <?php if(get_field('text_block_body')); { ?>
        <p><?php the_field('text_block_body'); } ?></p>
      </div>
    </div>
  </div>
</section>
