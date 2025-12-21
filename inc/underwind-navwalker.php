<?php
/**
 * Underwind Theme Customizer
 *
 * @package Underwind
 */

/**
 * Custom Walker Class to implement a Tailwind CSS-powered navigation menu with Alpine.js dropdowns.
 */
class Underwind_Navwalker extends Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent    = str_repeat( "\t", $depth );
		$classes   = 'absolute left-0 mt-2 w-48 bg-white shadow-lg rounded-md py-2 z-50';
		$is_mobile = str_contains( $args->menu_class, 'flex-col' );

		// For mobile menu, sub-menus are not absolute, they are inline.
		if ( $is_mobile ) {
			$classes = 'pl-4 py-2 space-y-2';
		}

		$alpine_directives = 'x-show="open" @click.away="open = false" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95"';

		$output .= "\n$indent<ul class=\"$classes\" $alpine_directives>\n";
	}

	/**
	 * Starts the element output.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent       = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$has_children = in_array( 'menu-item-has-children', $item->classes, true );

		// Li element.
		$li_attributes = '';
		$li_classes    = 'relative';
		if ( $has_children ) {
			$li_attributes .= ' x-data="{ open: false }"';
		}
		$output .= $indent . '<li class="' . esc_attr( $li_classes ) . '"' . $li_attributes . '>';

		// Link element.
		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '#';

		// Link classes.
		$link_classes = 'block px-4 py-2';
		if ( $depth > 0 ) {
			$link_classes .= ' hover:bg-gray-100'; // Sub-menu item.
		} else {
			$link_classes .= ' font-medium'; // Top-level item.
		}

		// Add active item styling.
		if ( in_array( 'current-menu-item', $item->classes, true ) || in_array( 'current-menu-ancestor', $item->classes, true ) ) {
			$link_classes .= ' text-indigo-600'; // Active link color.
		}

		$atts['class'] = $link_classes;

		// Handle items with children.
		if ( $has_children ) {
			$atts['@click.prevent'] = 'open = !open';
			$atts['aria-haspopup']  = 'true';
			$atts[':aria-expanded'] = 'open.toString()';
			// Add chevron icon that rotates.
			$item->title .= ' <span class="ml-1 inline-block transition-transform" :class="{\'transform rotate-180\': open}">▾</span>';
		}

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = sprintf( '%s<a%s>%s%s%s</a>%s', $args->before, $attributes, $args->link_before, apply_filters( 'the_title', $item->title, $item->ID ), $args->link_after, $args->after );

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= "</li>\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}
}