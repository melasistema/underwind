<?php
/**
 * The header for Underwind theme
 *
 * Displays <head> section, body open, and primary navigation
 *
 * @package Underwind
 */

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site min-h-screen flex flex-col">

	<!-- Skip link for accessibility -->
	<a class="skip-link sr-only focus:not-sr-only p-2 bg-gray-800 text-white" href="#primary">
		<?php esc_html_e( 'Skip to content', 'underwind' ); ?>
	</a>

	<!-- Header -->
	<header id="masthead" class="bg-gray-100 shadow-md">
		<div
				x-data="menu()"
				class="container mx-auto p-4"
		>
			<div class="flex items-center justify-between">

				<!-- Site branding -->
				<div class="site-branding flex items-center space-x-4">
					<?php the_custom_logo(); ?>

					<div>
						<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="text-2xl font-bold">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<?php bloginfo( 'name' ); ?>
								</a>
							</h1>
						<?php else : ?>
							<p class="text-xl font-semibold">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<?php bloginfo( 'name' ); ?>
								</a>
							</p>
						<?php endif; ?>
					</div>
				</div>

				<!-- Mobile toggle -->
				<button
						@click="toggle"
						class="md:hidden p-2 rounded bg-gray-200"
						aria-label="Toggle menu"
				>
					<span x-show="!open">☰</span>
					<span x-show="open" x-cloak>✕</span>
				</button>

				<!-- Desktop menu -->
				<nav class="hidden md:flex space-x-6">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_class'     => 'flex space-x-6',
							'container'      => false,
                            'walker'         => new Underwind_Navwalker(),
						)
					);
					?>
				</nav>
			</div>

			<!-- Mobile menu -->
			<nav
					x-show="open"
					x-transition
					x-cloak
					class="md:hidden mt-4 border-t pt-4"
			>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_class'     => 'flex flex-col space-y-2',
						'container'      => false,
                        'walker'         => new Underwind_Navwalker(),
					)
				);
				?>
			</nav>
		</div>
	</header>

	<main id="primary" class="flex-1">
