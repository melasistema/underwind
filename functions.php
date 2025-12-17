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
}
add_action( 'after_setup_theme', 'underwind_setup' );

/**
 * Dev / Prod helpers.
 */
function underwind_is_dev() {
	return defined( 'WP_DEBUG' ) && WP_DEBUG;
}

/**
 * Get the URL for a given asset.
 *
 * @param string $entry The asset entry point (e.g., 'src/js/app.js').
 * @return string|null The URL of the asset, or null if not found.
 */
function underwind_get_asset_url( $entry ) {
	if ( underwind_is_dev() ) {
		return "http://localhost:5173/{$entry}";
	}

	$manifest_path = get_template_directory() . '/release/underwind/dist/manifest.json';
	$manifest_uri  = get_template_directory_uri() . '/release/underwind/dist';

	if ( ! file_exists( $manifest_path ) ) {
		return null;
	}

	global $wp_filesystem;
	// Initialize WP_Filesystem if not already available.
	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}

	$manifest = array();
	if ( $wp_filesystem ) {
		$manifest_content = $wp_filesystem->get_contents( $manifest_path );
		if ( $manifest_content ) {
			$manifest = json_decode( $manifest_content, true );
		}
	} else {
		// Fallback for when WP_Filesystem is not available.
		global $wp_filesystem;
		// Initialize WP_Filesystem if not already available.
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$manifest = array();
		if ( $wp_filesystem ) {
			$manifest_content = $wp_filesystem->get_contents( $manifest_path );
			if ( $manifest_content ) {
				$manifest = json_decode( $manifest_content, true );
			}
		} else {
			// Fallback for when WP_Filesystem is not available.
			$manifest = json_decode( wp_remote_get( $manifest_path ), true );
		}
	}
	return isset( $manifest[ $entry ] )
		? $manifest_uri . '/' . $manifest[ $entry ]['file']
		: null;
}

/**
 * Enqueue scripts and styles.
 */
function underwind_enqueue_assets() {

	// Vite dev HMR client.
	if ( underwind_is_dev() ) {
		wp_enqueue_script(
			'underwind-vite-client',
			'http://localhost:5173/@vite/client',
			array(),
			UNDERWIND_VERSION,
			true
		);
	}

	// Main JS bundle.
	$js_url = underwind_get_asset_url( 'src/js/app.js' );
	if ( $js_url ) {
		wp_enqueue_script(
			'underwind-app',
			$js_url,
			array(),
			UNDERWIND_VERSION,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'underwind_enqueue_assets' );

/**
 * Add type="module" to Vite scripts.
 */
add_filter(
	'script_loader_tag',
	function ( $tag, $handle ) {
		$module_scripts = array( 'underwind-vite-client', 'underwind-app' );
		if ( in_array( $handle, $module_scripts, true ) ) {
			return str_replace( ' src', ' type="module" src', $tag );
		}
		return $tag;
	},
	10,
	2
);


/**
 * Template tags.
 */
function underwind_posted_on() {
	$time_string = '<time class="published" datetime="%1$s">%2$s</time>';
	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);
	echo '<span class="posted-on">Posted on ' . wp_kses_post( $time_string ) . '</span>';
}

/**
 * Posted by.
 */
function underwind_posted_by() {
	$byline = sprintf(
	/* translators: %s: post author */
		esc_html__( 'by %s', 'underwind' ),
		'<span class="author vcard"><a class="text-indigo-600 hover:underline" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo wp_kses_post( $byline );
}

/**
 * Post thumbnail.
 */
function underwind_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}
	?>
	<div class="post-thumbnail mb-4">
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'large', array( 'class' => 'rounded-lg' ) ); ?>
		</a>
	</div>
	<?php
}

/**
 * Entry footer.
 */
function underwind_entry_footer() {
	// Categories.
	$categories_list = get_the_category_list( ', ' );
	if ( $categories_list ) {
		echo '<span class="cat-links">Categories: ' . wp_kses_post( $categories_list ) . '</span>';
	}

	// Tags.
	$tags_list = get_the_tag_list( '', ', ' );
	if ( $tags_list ) {
		echo '<span class="tags-links ml-2">Tags: ' . wp_kses_post( $tags_list ) . '</span>';
	}

	// Edit link.
	edit_post_link(
		sprintf(
			/* translators: %s: post title */
			esc_html__( 'Edit %s', 'underwind' ),
			'<span class="sr-only">' . get_the_title() . '</span>'
		),
		'<span class="edit-link ml-2">',
		'</span>'
	);
}

