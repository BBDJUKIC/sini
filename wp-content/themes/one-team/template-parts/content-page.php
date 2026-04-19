<?php
/**
 * Reusable content renderer for standard pages.
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}

$top_image  = one_team_resolve_image(one_team_get_field('page_top_image'));
$intro_text = one_team_get_field('page_intro_text');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-page'); ?>>
    <header class="content-page__header">
        <h1 class="content-page__title"><?php the_title(); ?></h1>

        <?php if (! empty($intro_text)) : ?>
            <p class="content-page__intro"><?php echo esc_html($intro_text); ?></p>
        <?php endif; ?>

        <?php if (! empty($top_image['url'])) : ?>
            <div class="content-page__image-wrap">
                <img
                    class="content-page__image"
                    src="<?php echo esc_url($top_image['url']); ?>"
                    alt="<?php echo esc_attr($top_image['alt'] ?: get_the_title()); ?>"
                >
            </div>
        <?php endif; ?>
    </header>

    <div class="content-page__body entry-content">
        <?php
        the_content();

        wp_link_pages([
            'before' => '<nav class="page-links" aria-label="' . esc_attr__('Seiten', 'one-team') . '">',
            'after'  => '</nav>',
        ]);
        ?>
    </div>
</article>
