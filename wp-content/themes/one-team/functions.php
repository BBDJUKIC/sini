<?php
/**
 * Theme setup and helpers.
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}

define('ONE_TEAM_VERSION', '1.0.0');

/**
 * Theme setup.
 */
function one_team_setup(): void
{
    load_theme_textdomain('one-team', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 160,
        'width'       => 480,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    register_nav_menus([
        'primary' => __('Primäre Navigation', 'one-team'),
    ]);
}
add_action('after_setup_theme', 'one_team_setup');

/**
 * Enqueue theme assets.
 */
function one_team_enqueue_assets(): void
{
    wp_enqueue_style(
        'one-team-style',
        get_stylesheet_uri(),
        [],
        ONE_TEAM_VERSION
    );

    wp_enqueue_style(
        'one-team-main',
        get_template_directory_uri() . '/assets/css/main.css',
        ['one-team-style'],
        ONE_TEAM_VERSION
    );

    wp_enqueue_script(
        'one-team-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        ONE_TEAM_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'one_team_enqueue_assets');

/**
 * Safely render GTranslate shortcode output.
 *
 * Prevents fatal errors when shortcode is unavailable or throws.
 */
function one_team_render_gtranslate(): string
{
    if (! function_exists('shortcode_exists') || ! function_exists('do_shortcode')) {
        return '';
    }

    if (! shortcode_exists('gtranslate') && ! shortcode_exists('GTranslate')) {
        return '';
    }

    try {
        return (string) do_shortcode('[gtranslate]');
    } catch (Throwable $error) {
        return '';
    }
}

/**
 * Helper: return ACF field value when available, fallback to post meta.
 *
 * @param string   $field_name Field key/name.
 * @param int|null $post_id    Optional post ID.
 * @return mixed
 */
function one_team_get_field(string $field_name, ?int $post_id = null)
{
    $post_id = $post_id ?: get_the_ID();

    if (function_exists('get_field')) {
        return call_user_func('get_field', $field_name, $post_id);
    }

    return get_post_meta((int) $post_id, $field_name, true);
}

/**
 * Resolve image data from ACF image field format or attachment ID.
 *
 * @param mixed $image_field ACF image array, URL, or attachment ID.
 * @return array{url:string,alt:string,id:int}
 */
function one_team_resolve_image($image_field): array
{
    $fallback = [
        'url' => '',
        'alt' => '',
        'id'  => 0,
    ];

    if (is_array($image_field)) {
        return [
            'url' => isset($image_field['url']) ? (string) $image_field['url'] : '',
            'alt' => isset($image_field['alt']) ? (string) $image_field['alt'] : '',
            'id'  => isset($image_field['ID']) ? (int) $image_field['ID'] : 0,
        ];
    }

    if (is_numeric($image_field)) {
        $attachment_id = (int) $image_field;
        return [
            'url' => (string) wp_get_attachment_image_url($attachment_id, 'large'),
            'alt' => (string) get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
            'id'  => $attachment_id,
        ];
    }

    if (is_string($image_field) && ! empty($image_field)) {
        return [
            'url' => $image_field,
            'alt' => '',
            'id'  => 0,
        ];
    }

    return $fallback;
}

/**
 * Fallback for primary menu when no custom menu is assigned.
 */
function one_team_primary_menu_fallback(): void
{
    wp_page_menu([
        'menu_class'  => 'mobile-nav__list',
        'show_home'   => true,
        'container'   => false,
        'depth'       => 1,
        'echo'        => true,
        'link_before' => '',
        'link_after'  => '',
    ]);
}

/**
 * Keep comments open automatically on Q&A template.
 */
function one_team_force_qa_comments_open(bool $open, int $post_id): bool
{
    if (is_admin()) {
        return $open;
    }

    if (get_page_template_slug($post_id) === 'template-qa.php') {
        return true;
    }

    return $open;
}
add_filter('comments_open', 'one_team_force_qa_comments_open', 10, 2);

/**
 * Body classes for easier targeting.
 *
 * @param array<int, string> $classes Existing body classes.
 * @return array<int, string>
 */
function one_team_body_classes(array $classes): array
{
    if (is_front_page()) {
        $classes[] = 'is-home-minimal';
    }

    return $classes;
}
add_filter('body_class', 'one_team_body_classes');
