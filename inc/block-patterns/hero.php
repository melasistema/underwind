<?php
/**
 * Hero Block Pattern.
 *
 * @package Underwind
 */

register_block_pattern(
	'underwind/hero',
	array(
		'title'       => __( 'Hero', 'underwind' ),
		'description' => _x( 'A full-width hero section with a heading and a button.', 'Block pattern description', 'underwind' ),
		'categories'  => array( 'underwind' ),
		'content'     => sprintf(
			'<!-- wp:cover {"url":"%1$s","id":1,"dimRatio":50,"overlayColor":"slate","align":"full","className":"is-style-default"} -->
<div class="wp-block-cover alignfull is-style-default" style="background-image:url(%1$s)"><span aria-hidden="true" class="wp-block-cover__background has-slate-background-color has-background-dim-50 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","align":"wide","level":1,"textColor":"white","className":"font-bold"} -->
<h1 class="has-text-align-center alignwide has-white-color has-text-color font-bold">%2$s</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"textAlign":"center","align":"wide","textColor":"white"} -->
<p class="has-text-align-center alignwide has-white-color has-text-color">%3$s</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"slate","textColor":"white","className":"is-style-fill"} -->
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-white-color has-text-color has-slate-background-color has-background">%4$s</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover -->',
			get_template_directory_uri() . '/resources/images/underwind-feature-image.png',
			esc_html__( 'Underwind', 'underwind' ),
			esc_html__( 'A joyful WordPress starter framework built on _underscores and powered by Tailwind CSS.', 'underwind' ),
			esc_html__( 'Get Started', 'underwind' )
		),
	)
);