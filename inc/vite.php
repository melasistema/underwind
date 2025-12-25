<?php
/**
 * Vite Asset Enqueueing
 *
 * @package Underwind
 */

defined( 'ABSPATH' ) || exit;

// --- Vite & Tailwind Enqueue ---
define( 'UNDERWIND_VITE_DEV_SERVER_URL', 'http://localhost:5173' );
define( 'UNDERWIND_VITE_ENTRY_POINT', 'src/js/app.js' );
define( 'UNDERWIND_VITE_APP_ENTRY_POINT_CSS', 'src/css/app.css' );
define( 'UNDERWIND_VITE_EDITOR_ENTRY_POINT', 'src/css/editor.css' );

/**
 * Enqueue scripts and styles for the editor.
 *
 * @return void
 */
function underwind_enqueue_editor_assets() {
	// Check if the 'hot' file exists to determine if we are in development mode.
	$is_dev_mode = file_exists( get_template_directory() . '/dist/hot' );

	if ( $is_dev_mode ) {
		// Development mode: load assets from the local generated file.
		add_editor_style( 'dist/editor.css' );
	} else {
		// Production mode: load assets from the generated manifest.
		$manifest_path = get_template_directory() . '/dist/.vite/manifest.json';

		if ( ! file_exists( $manifest_path ) ) {
			return;
		}

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$manifest_content = file_get_contents( $manifest_path );
		if ( empty( $manifest_content ) ) {
			return;
		}

		$manifest = json_decode( $manifest_content, true );

		$editor_entry = isset( $manifest[ UNDERWIND_VITE_EDITOR_ENTRY_POINT ] )
				? $manifest[ UNDERWIND_VITE_EDITOR_ENTRY_POINT ]
				: null;
		$app_entry    = isset( $manifest[ UNDERWIND_VITE_APP_ENTRY_POINT_CSS ] )
				? $manifest[ UNDERWIND_VITE_APP_ENTRY_POINT_CSS ]
				: null;

		if ( $editor_entry && isset( $editor_entry['file'] ) ) {
			add_editor_style( 'dist/' . $editor_entry['file'] );
		}
		if ( $app_entry && isset( $app_entry['file'] ) ) {
			add_editor_style( 'dist/' . $app_entry['file'] );
		}
	}
}
add_action( 'after_setup_theme', 'underwind_enqueue_editor_assets' );


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

		// Enqueue the main CSS entry point for app.css
		wp_enqueue_style(
			'underwind-app-style',
			UNDERWIND_VITE_DEV_SERVER_URL . '/' . UNDERWIND_VITE_APP_ENTRY_POINT_CSS,
			array(),
			null
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
