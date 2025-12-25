<?php
/**
 * Underwind functions and definitions
 *
 * @package Underwind
 */

// Autoload dependencies.
require_once __DIR__ . '/vendor/autoload.php';

defined( 'ABSPATH' ) || exit;

/**
 * Define theme version.
 */
if ( ! defined( 'UNDERWIND_VERSION' ) ) {
	define( 'UNDERWIND_VERSION', wp_get_theme()->get( 'Version' ) );
}

/**
 * Theme setup.
 */
function underwind_setup() {
	load_theme_textdomain( 'underwind', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'underwind' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for wide alignment.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );
}
add_action( 'after_setup_theme', 'underwind_setup' );

/**
 * Load theme includes.
 */
require_once get_template_directory() . '/inc/helper.php';
require_once get_template_directory() . '/inc/class-underwind-navwalker.php';
require_once get_template_directory() . '/inc/template-functions.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/custom-header.php';
/*require_once get_template_directory() . '/inc/woocommerce.php';*/ // phpcs:ignore Squiz.PHP.CommentedOutCode.Found
require_once get_template_directory() . '/inc/vite.php';

/**
 * Block patterns.
 */
function underwind_block_patterns_init() {
	require_once get_template_directory() . '/inc/block-pattern-categories.php';

	$block_patterns = array(
		'hero',
	);

	foreach ( $block_patterns as $block_pattern ) {
		require_once get_template_directory() . '/inc/block-patterns/' . $block_pattern . '.php';
	}
}
add_action( 'init', 'underwind_block_patterns_init' );


function underwind_header_text_color_css() {
    $color = get_header_textcolor();

    // Bail if default color or hidden
    if (
        empty( $color ) ||
        'blank' === $color ||
        get_theme_support( 'custom-header', 'default-text-color' ) === $color
    ) {
        return;
    }

    $css = "
        .site-title a,
        .site-description {
            color: #{$color};
        }
    ";

    wp_add_inline_style( 'underwind-app-style', $css );
}
add_action( 'wp_enqueue_scripts', 'underwind_header_text_color_css' );

