<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Underwind
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function underwind_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'underwind_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function underwind_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'underwind_pingback_header' );

/**
 * Add a custom class to the header image tag.
 *
 * @param array $attr Attributes for the header image tag.
 * @return array
 */
function underwind_add_header_image_class( $attr ) {
    $tailwind_classes = 'w-full h-full object-cover'; // Tailwind classes for cover effect
    $attr['class'] = isset( $attr['class'] ) ? $attr['class'] . ' ' . $tailwind_classes : $tailwind_classes;
    return $attr;
}
add_filter( 'get_header_image_tag_attributes', 'underwind_add_header_image_class' );

/**
 * Fix mixed content issues on SSL.
 */
function underwind_ssl_output_buffer_start() {
	if ( is_ssl() ) {
		ob_start( 'underwind_ssl_output_buffer_callback' );
	}
}

function underwind_ssl_output_buffer_callback( $buffer ) {
	$site_url        = get_option( 'siteurl' );
	$site_url_parsed = wp_parse_url( $site_url );
	$site_domain     = $site_url_parsed['host'];

	return str_replace( 'http://' . $site_domain, 'https://' . $site_domain, $buffer );
}

function underwind_ssl_output_buffer_end() {
	if ( is_ssl() && ob_get_length() > 0 ) {
		ob_end_flush();
	}
}

add_action( 'init', 'underwind_ssl_output_buffer_start' );
add_action( 'shutdown', 'underwind_ssl_output_buffer_end' );
