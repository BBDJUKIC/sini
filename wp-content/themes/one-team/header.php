<?php
/**
 * Site header.
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}

$nav_items = one_team_get_core_navigation_items();
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
            aria-label="<?php esc_attr_e('Navigation öffnen', 'one-team'); ?>"
        >
            <span class="menu-toggle__line" aria-hidden="true"></span>
            <span class="menu-toggle__line" aria-hidden="true"></span>
            <span class="menu-toggle__line" aria-hidden="true"></span>
        </button>
    </div>

    <nav id="mobile-navigation" class="mobile-nav" aria-label="<?php esc_attr_e('Hauptnavigation', 'one-team'); ?>" hidden>
        <div class="mobile-nav__inner container">
            <ul class="mobile-nav__list">
                <?php foreach ($nav_items as $item) : ?>
                    <li class="mobile-nav__item">
                        <a href="<?php echo esc_url($item['url']); ?>" class="mobile-nav__link">
                            <?php echo esc_html($item['label']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="mobile-nav__language">
                <p class="mobile-nav__label"><?php esc_html_e('Sprache', 'one-team'); ?></p>
                <div class="gtranslate_wrapper"></div>
            </div>
        </div>
    </nav>
</header>
