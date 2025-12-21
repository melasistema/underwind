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

// --- Vite & Tailwind Enqueue ---
define( 'UNDERWIND_VITE_DEV_SERVER_URL', 'http://localhost:5173' );
define( 'UNDERWIND_VITE_ENTRY_POINT', 'src/js/app.js' );

require_once get_template_directory() . '/inc/helper.php';
require_once get_template_directory() . '/inc/class-underwind-navwalker.php';


/**
 * Enqueue scripts and styles for the front end.
 *
 * @return void
 */
function underwind_enqueue_vite_assets() {

	// Check if the 'hot' file exists to determine if we are in development mode.
	$is_dev_mode = file_exists( get_template_directory() . '/dist/hot' );

	if ( $is_dev_mode ) {
		// Development mode: load assets from the Vite development server.

		// Enqueue the Vite client to enable Hot Module Replacement (HMR).
		wp_enqueue_script(
			'vite-client',
			UNDERWIND_VITE_DEV_SERVER_URL . '/@vite/client',
			array(),
			null, // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			true  // Load in footer.
		);

		// Enqueue the main JavaScript entry point.
		wp_enqueue_script(
			'underwind-app',
			UNDERWIND_VITE_DEV_SERVER_URL . '/' . UNDERWIND_VITE_ENTRY_POINT,
			array(),
			null, // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			true  // Load in footer.
		);

		error_log( '[Vite Debug] Development mode active. Loading assets from: ' . UNDERWIND_VITE_DEV_SERVER_URL ); // phpcs:ignore
	} else {
		// Production mode: load assets from the generated manifest.
		$manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
		$manifest_uri  = get_template_directory_uri() . '/dist/';

		error_log( '[Vite Debug] Production mode active.' ); // phpcs:ignore
		error_log( '[Vite Debug] Manifest Path: ' . $manifest_path ); // phpcs:ignore
		error_log( '[Vite Debug] Manifest URI: ' . $manifest_uri ); // phpcs:ignore

		if ( ! file_exists( $manifest_path ) ) {
			if ( is_admin() ) {
				error_log( 'Vite manifest file not found at: ' . $manifest_path ); // phpcs:ignore
			}
			return;
		}

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$manifest_content = file_get_contents( $manifest_path );
		if ( empty( $manifest_content ) ) {
			if ( is_admin() ) {
				error_log( 'Vite manifest file is empty at: ' . $manifest_path ); // phpcs:ignore
			}
			return;
		}

		$manifest = json_decode( $manifest_content, true );
		error_log( '[Vite Debug] Manifest Content (decoded): ' . print_r( $manifest, true ) ); // phpcs:ignore

		$entry = isset( $manifest[ UNDERWIND_VITE_ENTRY_POINT ] )
				? $manifest[ UNDERWIND_VITE_ENTRY_POINT ]
				: null;

		if ( ! $entry ) {
			if ( is_admin() ) {
				error_log( '[Vite Debug] Entry point "' . UNDERWIND_VITE_ENTRY_POINT . '" not found in manifest.' ); // phpcs:ignore
			}
			return;
		}

		// Enqueue the main JavaScript file.
		if ( isset( $entry['file'] ) ) {
			$js_url = $manifest_uri . $entry['file'];
			wp_enqueue_script(
				'underwind-app',
				$js_url,
				array(), // Add script dependencies here.
				UNDERWIND_VERSION,
				true // Load in footer.
			);
			error_log( '[Vite Debug] Enqueuing JS: ' . $js_url ); // phpcs:ignore
		}

		// Enqueue associated CSS files.
		if ( isset( $entry['css'] ) && is_array( $entry['css'] ) ) {
			foreach ( $entry['css'] as $css_file ) {
				$css_url = $manifest_uri . $css_file;
				wp_enqueue_style(
					'underwind-style-' . pathinfo( $css_file, PATHINFO_FILENAME ),
					$css_url,
					array(), // Add style dependencies here.
					UNDERWIND_VERSION
				);
				error_log( '[Vite Debug] Enqueuing CSS: ' . $css_url ); // phpcs:ignore
			}
		}

		// Preload imported modules for the entry point for better performance.
		if ( ! empty( $entry['imports'] ) ) {
			foreach ( $entry['imports'] as $import_key ) {
				if ( isset( $manifest[ $import_key ]['file'] ) ) {
					$import_file = $manifest[ $import_key ]['file'];
					$preload_url = $manifest_uri . $import_file;
					add_action(
						'wp_head',
						function () use ( $preload_url ) {
							echo '<link rel="modulepreload" href="' . esc_url( $preload_url ) . '">';
						},
						1
					);
					error_log( '[Vite Debug] Preloading module: ' . $preload_url ); // phpcs:ignore
				}
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'underwind_enqueue_vite_assets' );


/**
 * Add type="module" to scripts loaded from Vite.
 *
 * @param string $tag    The <script> tag for the enqueued script.
 * @param string $handle The script's handle.
 *
 * @return string The modified script tag.
 */
function underwind_vite_script_loader_tag( $tag, $handle ) {
	// The handles for the Vite client and the main app script.
	$script_handles = array( 'vite-client', 'underwind-app' );

	if ( in_array( $handle, $script_handles, true ) ) {
		// Add type="module" to the script tag. ES modules are deferred by default.
		if ( false === strpos( $tag, 'type="module"' ) ) {
			$tag = str_replace( '<script ', '<script type="module" ', $tag );
		}
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'underwind_vite_script_loader_tag', 10, 2 );

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
