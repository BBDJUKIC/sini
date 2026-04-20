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

    <a class="skip-link" href="#main-content"><?php esc_html_e('Skip to content', 'one-team'); ?></a>

    <header class="site-header" role="banner">
        <div class="site-header__inner container">
            <a class="site-header__home-link" href="<?php echo esc_url(one_team_home_link_url()); ?>">
                Home
            </a>

            <a class="site-header__logo-link" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('Language landing page', 'one-team'); ?>">
                <?php if (function_exists('has_custom_logo') && has_custom_logo() && function_exists('the_custom_logo')) : ?>
                    <span class="site-header__logo"><?php the_custom_logo(); ?></span>
                <?php else : ?>
                    <span class="site-header__logo-text"><?php bloginfo('name'); ?></span>
                <?php endif; ?>
            </a>

            <button
                class="menu-toggle"
                type="button"
                aria-expanded="false"
                aria-controls="mobile-navigation"
                aria-label="<?php esc_attr_e('Open navigation', 'one-team'); ?>">
                <span class="menu-toggle__line" aria-hidden="true"></span>
                <span class="menu-toggle__line" aria-hidden="true"></span>
                <span class="menu-toggle__line" aria-hidden="true"></span>
            </button>
        </div>

        <nav id="mobile-navigation" class="mobile-nav" aria-label="<?php esc_attr_e('Main navigation', 'one-team'); ?>" hidden>
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
                    <p class="mobile-nav__label">Language</p>
                    <?php
                    if (function_exists('one_team_render_gtranslate')) {
                        echo one_team_render_gtranslate(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>
