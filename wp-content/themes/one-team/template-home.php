<?php
/**
 * Template Name: Home
 * Template Post Type: page
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="main-content" class="main-content home-main" role="main">
    <div class="container home-layout">
        <?php
        while (have_posts()) :
            the_post();

            $home_top_text    = trim((string) one_team_get_field('home_top_text', get_the_ID()));
            $home_bottom_text = trim((string) one_team_get_field('home_bottom_text', get_the_ID()));
            $home_image       = one_team_resolve_image(one_team_get_field('home_main_image', get_the_ID()));
            ?>

            <?php if ($home_top_text !== '') : ?>
                <p class="home-layout__top-text"><?php echo esc_html($home_top_text); ?></p>
            <?php endif; ?>

            <?php if (! empty($home_image['url'])) : ?>
                <img
                    class="home-layout__image"
                    src="<?php echo esc_url($home_image['url']); ?>"
                    alt="<?php echo esc_attr($home_image['alt'] ?: get_the_title()); ?>"
                >
            <?php endif; ?>

            <?php if ($home_bottom_text !== '') : ?>
                <div class="home-layout__bottom-text">
                    <?php echo wp_kses_post(wpautop($home_bottom_text)); ?>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();
