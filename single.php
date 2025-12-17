<?php
/**
 * The template for displaying all single posts
 *
 * @package Underwind
 */

get_header();
?>

    <main id="primary" class="site-main container mx-auto px-4 py-8 flex-1">

        <?php
        while ( have_posts() ) :
            the_post();

            // Use the Tailwind-styled content template
            get_template_part( 'template-parts/content', get_post_type() );

            // Post navigation
            the_post_navigation([
                    'prev_text' => '<span class="nav-subtitle text-gray-500 text-sm">' . esc_html__( 'Previous:', 'underwind' ) . '</span> <span class="nav-title text-indigo-600 hover:underline">%title</span>',
                    'next_text' => '<span class="nav-subtitle text-gray-500 text-sm">' . esc_html__( 'Next:', 'underwind' ) . '</span> <span class="nav-title text-indigo-600 hover:underline">%title</span>',
                    'class'     => 'flex justify-between my-8',
            ]);

            // Comments
            if ( comments_open() || get_comments_number() ) :
                echo '<div class="mt-8">';
                comments_template();
                echo '</div>';
            endif;

        endwhile; // End of the loop.
        ?>

    </main><!-- #primary -->

<?php
get_sidebar();
get_footer();
