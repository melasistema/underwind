<?php
/**
 * The template for displaying the footer
 *
 * @package Underwind
 */
?>

<footer id="colophon" class="bg-gray-800 text-gray-200 text-sm py-4 mt-auto">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center px-4">
        <div class="mb-2 md:mb-0">
            <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'underwind' ) ); ?>" class="hover:text-white">
                <?php
                /* translators: %s: CMS name, i.e. WordPress. */
                printf( esc_html__( 'Proudly powered by %s', 'underwind' ), 'WordPress' );
                ?>
            </a>
        </div>

        <div>
            <?php
            /* translators: 1: Theme name, 2: Theme author. */
            printf(
                    esc_html__( 'Theme: %1$s by %2$s.', 'underwind' ),
                    'Underwind',
                    '<a href="https://github.com/melasistema" class="hover:text-white">Melasistema</a>'
            );
            ?>
        </div>
    </div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
