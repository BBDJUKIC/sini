<?php

/**
 * Site header.
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <a class="skip-link" href="#main-content"><?php esc_html_e('Zum Inhalt springen', 'one-team'); ?></a>

    <header class="site-header" role="banner">
        <div class="site-header__inner container">
            <a class="site-header__brand" href="<?php echo esc_url(home_url('/')); ?>">
                <?php bloginfo('name'); ?>
            </a>

            <button
                class="menu-toggle"
                type="button"
                aria-expanded="false"
                aria-controls="mobile-navigation"
                aria-label="<?php esc_attr_e('Navigation öffnen', 'one-team'); ?>">
                <span class="menu-toggle__line" aria-hidden="true"></span>
                <span class="menu-toggle__line" aria-hidden="true"></span>
                <span class="menu-toggle__line" aria-hidden="true"></span>
            </button>
        </div>

        <nav id="mobile-navigation" class="mobile-nav" aria-label="<?php esc_attr_e('Hauptnavigation', 'one-team'); ?>" hidden>
            <div class="mobile-nav__inner container">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'mobile-nav__list',
                    'depth'          => 1,
                    'fallback_cb'    => 'one_team_primary_menu_fallback',
                ]);
                ?>

                <div class="mobile-nav__language">
                    <p class="mobile-nav__label"><?php esc_html_e('Sprache', 'one-team'); ?></p>
                    <?php
                    if (function_exists('one_team_render_gtranslate')) {
                        echo one_team_render_gtranslate(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>
