<?php
/**
 * Simple page content layout: title, optional image, content.
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}

$page_image = [
    'url' => '',
    'alt' => '',
    'id'  => 0,
];

if (function_exists('one_team_get_field') && function_exists('one_team_resolve_image')) {
    $page_image = one_team_resolve_image(one_team_get_field('page_top_image', get_the_ID()));
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-page'); ?>>
    <header class="content-page__header">
        <h1 class="content-page__title"><?php the_title(); ?></h1>

        <?php if (! empty($page_image['url'])) : ?>
            <div class="content-page__image-wrap">
                <img
                    class="content-page__image"
                    src="<?php echo esc_url($page_image['url']); ?>"
                    alt="<?php echo esc_attr($page_image['alt'] ?: get_the_title()); ?>"
                >
            </div>
        <?php endif; ?>
    </header>

    <div class="content-page__body entry-content">
        <?php the_content(); ?>
    </div>
</article>
