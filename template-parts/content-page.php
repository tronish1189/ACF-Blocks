<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tpf
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php     $blocks = parse_blocks( get_the_content() ); if ( $blocks[0]['blockName'] === 'acf/hero-nav' ) {
} else { ?>
			<header class="entry-header">
				<div class="container">
						<?php the_title( '<h1 class="entry-title my-5">', '</h1>' ); ?>
				</div>
<?php } ?>
		</header><!-- .entry-header -- >


	<?php tpf_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tpf' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->


	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<div class="container">
				<?php
				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'tpf' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
				?>
			</div>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
