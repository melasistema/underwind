<?php
/**
 * Block Pattern Categories.
 *
 * @package Underwind
 */

if ( function_exists( 'register_block_pattern_category' ) ) {
	register_block_pattern_category(
		'underwind',
		array( 'label' => __( 'Underwind', 'underwind' ) )
	);
}
