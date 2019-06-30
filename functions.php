<?php
/**
 * tpf functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tpf
 */

// *Register new Block category
function tpf_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				//*Blog slug
				'slug' => 'tpf',
				//*Blog Title displayed in Gutenburg
				'title' => __( 'TPF', 'tpf' ),
			),
		)
	);
}
add_filter( 'block_categories', 'tpf_block_category', 10, 2);


/*Register blocks*/
function register_acf_block_types() {

  acf_register_block_type(array(
    'name'              => 'two-col-img-img',
    'title'             => __('2 Column - Image Image'),
    'description'       => __('A two column component with two images'),
    'render_template'   => 'template-parts/blocks/two-column-img-img/two-column-img-img.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'list' ),
  ));


  acf_register_block_type(array(
    'name'              => 'two-col-text-img',
    'title'             => __('2 Column - Text Image'),
    'description'       => __('A two column component with text and an image'),
    'render_template'   => 'template-parts/blocks/two-column-text-img/two-column-text-img.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'list' ),
  ));


  acf_register_block_type(array(
    'name'              => 'staff-list',
    'title'             => __('Staff List'),
    'description'       => __('A list of staff members, their photos, and bios'),
    'render_template'   => 'template-parts/blocks/staff-list/staff-list.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'list' ),
  ));

  acf_register_block_type(array(
    'name'              => 'text-block',
    'title'             => __('Text Block'),
    'description'       => __('A block of text with an optional heading'),
    'render_template'   => 'template-parts/blocks/text-block-1/text-block.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'tiles' ),
  ));

  acf_register_block_type(array(
    'name'              => 'accordion',
    'title'             => __('Accordion'),
    'description'       => __('A an accordion block'),
    'render_template'   => 'template-parts/blocks/accordion/accordion.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'tiles' ),
  ));

  acf_register_block_type(array(
    'name'              => 'contact-block',
    'title'             => __('Contact Block'),
    'description'       => __('A 2-column block with text intended to display contact info'),
    'render_template'   => 'template-parts/blocks/contact-block/contact-block.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'tiles' ),
  ));
  acf_register_block_type(array(
    'name'              => 'staff-tiles',
    'title'             => __('Staff Tiles'),
    'description'       => __('A collection of staff members'),
    'render_template'   => 'template-parts/blocks/staff-tiles/staff-tiles.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'tiles' ),
  ));
    acf_register_block_type(array(
      'name'              => 'blog-tiles',
      'title'             => __('Blog Tiles'),
      'description'       => __('A collection of blog posts in tiles'),
      'render_template'   => 'template-parts/blocks/blog-tiles/blog-tiles.php',
      'category'          => 'tpf',
      'icon'              => 'admin-comments',
		'mode' => 'edit',
      'keywords'          => array( 'blog', 'tiles' ),
    ));

    acf_register_block_type(array(
        'name'              => 'hero-nav',
        'title'             => __('Hero Nav'),
        'description'       => __('A hero image alongside navigation for a page'),
        'render_template'   => 'template-parts/blocks/hero-nav/hero-nav.php',
        'category'          => 'tpf',
        'icon'              => 'admin-comments',
		'mode' => 'edit',
        'keywords'          => array( 'hero', 'nav' ),
    ));

    acf_register_block_type(array(
        'name'              => 'hero-featured',
        'title'             => __('Hero Featured'),
        'description'       => __('A hero image with text spanning the full width of the page'),
        'render_template'   => 'template-parts/blocks/hero-featured/hero-featured.php',
        'category'          => 'tpf',
        'icon'              => 'admin-comments',
		'mode' => 'edit',
        'keywords'          => array( 'hero', 'featured' ),
    ));
}

// Hook the above blocks into Gutenburg
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'register_acf_block_types');
}
