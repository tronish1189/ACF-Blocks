<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'two-column-img-img-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'two-column-img-img';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$two_col_img_1 = get_field('two_col_img_1');
$two_col_img_2 = get_field('two_col_img_2');

?>

<!--Two Column - Image Image -->
<section id="<?php echo $id ?>" class="<?php echo $className ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <a href="<?php echo $two_col_img_1['link']; ?>"> <img src="<?php echo $two_col_img_1['image']['url']; ?>" class="img-fluid" alt="">
          <h4><?php echo $two_col_img_1['title']; ?></h4>
        </a>
      </div>
      <div class="col-md-6">
        <a href="<?php echo $two_col_img_2['link']; ?>"> <img src="<?php echo $two_col_img_2['image']['url']; ?>" class="img-fluid" alt="">
          <h4><?php echo $two_col_img_2['title']; ?></h4>
        </a>
      </div>
    </div>
  </div>
</section>
