<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package Underwind
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( '' ); ?>>

	<!-- Page Header -->
	<header class="entry-header mb-6">
		<?php the_title( '<h1 class="text-3xl font-bold text-gray-800 mb-2">', '</h1>' ); ?>
	</header>

	<!-- Page Thumbnail -->
	<?php underwind_post_thumbnail(); ?>

	<!-- Page Content -->
	<div class="entry-content prose prose-lg max-w-none">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links mt-4 text-sm text-gray-500">' . esc_html__( 'Pages:', 'underwind' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<!-- Edit Link -->
	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer mt-6 text-sm text-gray-500 border-t pt-4">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
							/* translators: %s: Name of current page */
						__( 'Edit <span class="sr-only">%s</span>', 'underwind' ),
						array( 'span' => array( 'class' => array() ) )
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link text-indigo-600 hover:underline">',
				'</span>'
			);
			?>
		</footer>
	<?php endif; ?>

</article>
