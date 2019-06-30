<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tpf
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!--Hero-->
	<style>
		section#hero-news-single{
			background-image: url("<?php if ( has_post_thumbnail() ) {
	the_post_thumbnail_url();
} ?> ");
		}
	</style>
	<section id="hero-news-single" class="page-hero w-100 mt-xd-0 mt-lg-5 d-block d-md-flex">
		<div class="dark-overlay">
			<div class="row w-100 h-100">
				<div class="col my-auto">
					<h1 class="text-center"><?php the_title(); ?></h1>
				</div>
			</div>
		</div>
	</section>

	<!--Blog Content-->
	<section id="content-news-single">
		<div class="container">
			<div class="row">
				<div class="col-10 mx-auto my-6">
										<small><?php the_time('F jS Y'); ?></small>
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</section>
</article><!-- #post-<?php the_ID(); ?> -->
