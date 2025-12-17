<?php
/**
 * Template part for displaying posts
 *
 * @package Underwind
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-8 p-6 bg-white rounded-lg shadow' ); ?>>

	<!-- Post Header -->
	<header class="entry-header mb-4">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="text-3xl font-bold text-gray-800 mb-2">', '</h1>' );
		else :
			the_title( '<h2 class="text-2xl font-semibold text-gray-800 mb-2"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="hover:text-indigo-600">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta text-sm text-gray-500">
				<?php
				underwind_posted_on();
				echo ' | ';
				underwind_posted_by();
				?>
			</div>
		<?php endif; ?>
	</header>

	<!-- Post Thumbnail -->
	<?php underwind_post_thumbnail(); ?>

	<!-- Post Content -->
	<div class="entry-content text-gray-700 leading-relaxed">
		<?php
		the_content(
			sprintf(
				wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="sr-only"> "%s"</span>', 'underwind' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links mt-4 text-sm text-gray-500">' . esc_html__( 'Pages:', 'underwind' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<!-- Post Footer -->
	<footer class="entry-footer mt-6 text-sm text-gray-500 border-t pt-4">
		<?php underwind_entry_footer(); ?>
	</footer>
</article>
