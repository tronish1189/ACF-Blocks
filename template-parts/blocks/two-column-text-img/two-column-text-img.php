<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'two-column-text-img-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'two-column-text-img';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>

<!--Two Column - Text Image -->
<section id="<?php echo $id ?>" class="<?php echo $className ?> my-6">
  <div class="container">
    <div class="row mx-auto">
      <div class="col-md-6 my-auto">
        <p><?php the_field('two_column_text') ; ?></p>
      </div>
      <div class="col-md-1">

      </div>
      <div class="col-md-5 my-auto">

        <?php
        $two_col_img = get_field('two_column_image');
        if( !empty($two_col_img) ): ?>

	<img src="<?php echo $two_col_img['url']; ?>" alt="<?php echo $two_col_img['alt']; ?>" class="img-fluid" />

<?php endif; ?>
      </div>
    </div>
  </div>
</section>
