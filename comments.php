<?php
/**
 * The template for displaying comments
 *
 * @package Underwind
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area mt-8">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title text-2xl font-semibold text-gray-800 mb-4">
            <?php
            $underwind_comment_count = get_comments_number();
            if ( '1' === $underwind_comment_count ) {
                printf(
                        esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'underwind' ),
                        '<span class="font-normal">' . wp_kses_post( get_the_title() ) . '</span>'
                );
            } else {
                printf(
                        esc_html( _nx(
                                '%1$s thought on &ldquo;%2$s&rdquo;',
                                '%1$s thoughts on &ldquo;%2$s&rdquo;',
                                $underwind_comment_count,
                                'comments title',
                                'underwind'
                        ) ),
                        number_format_i18n( $underwind_comment_count ),
                        '<span class="font-normal">' . wp_kses_post( get_the_title() ) . '</span>'
                );
            }
            ?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list space-y-6">
            <?php
            wp_list_comments([
                    'style'      => 'ol',
                    'short_ping' => true,
                    'avatar_size'=> 48,
                    'reply_text' => '<span class="text-indigo-600 hover:underline">' . esc_html__( 'Reply', 'underwind' ) . '</span>',
            ]);
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

        <?php if ( ! comments_open() ) : ?>
            <p class="no-comments text-gray-500 mt-4"><?php esc_html_e( 'Comments are closed.', 'underwind' ); ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <!-- Comment form -->
    <div class="comment-form mt-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <?php
        comment_form([
                'title_reply_before' => '<h3 class="text-xl font-semibold mb-4">',
                'title_reply_after'  => '</h3>',
                'class_submit'       => 'bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition',
                'comment_field'      => '<p class="comment-form-comment"><textarea id="comment" name="comment" rows="5" class="w-full p-3 border border-gray-300 rounded" placeholder="' . esc_attr__( 'Write your comment...', 'underwind' ) . '" required></textarea></p>',
                'fields' => [
                        'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" class="w-full p-3 border border-gray-300 rounded mb-2" placeholder="' . esc_attr__( 'Name', 'underwind' ) . '" required></p>',
                        'email'  => '<p class="comment-form-email"><input id="email" name="email" type="email" class="w-full p-3 border border-gray-300 rounded mb-2" placeholder="' . esc_attr__( 'Email', 'underwind' ) . '" required></p>',
                        'url'    => '<p class="comment-form-url"><input id="url" name="url" type="url" class="w-full p-3 border border-gray-300 rounded mb-2" placeholder="' . esc_attr__( 'Website', 'underwind' ) . '"></p>',
                ],
        ]);
        ?>
    </div>

</div>
