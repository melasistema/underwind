<?php
/**
 * Helper functions.
 *
 * @package Underwind
 */

defined( 'ABSPATH' ) || exit;

/**
 * Log debug messages safely.
 *
 * @param string $message Debug message.
 */
function underwind_debug_log( $message ) {
	if (
		defined( 'WP_DEBUG' ) && WP_DEBUG &&
		defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG
	) {
		error_log( $message ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
	}
}
