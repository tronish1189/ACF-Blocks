<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'contact-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'contact-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>

<section id="<?php echo $id ?>" class="<?php echo $className ?> my-6">
  <div class="container">
    <div class="row h-100">
      <div class="col-lg-4 my-auto">
        <h2>contact us</h2>
      </div>
      <div class="col-md-1"></div>
      <div class="col-xs-12 col-lg-7 contact-info">
        <p>Do you have any questions or want to join us in our organizing?
          <br><br>
          Please email us at <a href="mailto:info@transformingpowerfund.org">info@transformingpowerfund.org</a>
        </p>
      </div>
    </div>
  </div>
</section>
