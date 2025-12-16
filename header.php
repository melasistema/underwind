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
        <div class="container mx-auto flex items-center justify-between p-4">

            <!-- Site branding -->
            <div class="site-branding flex items-center space-x-4">
                <?php the_custom_logo(); ?>

                <div>
                    <?php if ( is_front_page() && is_home() ) : ?>
                        <h1 class="site-title text-2xl font-bold text-gray-800">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
                    <?php else : ?>
                        <p class="site-title text-xl font-semibold text-gray-800">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </p>
                    <?php endif; ?>

                    <?php $underwind_description = get_bloginfo( 'description', 'display' );
                    if ( $underwind_description || is_customize_preview() ) : ?>
                        <p class="site-description text-gray-600 text-sm"><?php echo $underwind_description; ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mobile menu toggle (Alpine) -->
            <button x-data="menu()" @click="toggle()" class="md:hidden p-2 rounded-md bg-gray-200" aria-label="Toggle menu">
                <span x-show="!open">☰</span>
                <span x-show="open">✕</span>
            </button>

            <!-- Navigation -->
            <nav class="hidden md:flex space-x-6 items-center">
                <?php
                wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_class'     => 'flex space-x-6',
                        'container'      => false,
                ]);
                ?>
            </nav>

        </div>

        <!-- Mobile navigation -->
        <nav x-show="open" x-transition class="md:hidden bg-gray-100 border-t border-gray-200">
            <div class="p-4 space-y-2">
                <?php
                wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_class'     => 'flex flex-col space-y-2',
                        'container'      => false,
                ]);
                ?>
            </div>
        </nav>
    </header>

    <main id="primary" class="flex-1">
