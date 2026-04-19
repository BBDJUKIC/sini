<?php
/**
 * Front page template.
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();

$home_image = one_team_resolve_image(one_team_get_field('home_logo_image'));
?>

<main id="main-content" class="main-content home-main" role="main">
    <div class="home-logo-wrap container">
        <?php if (! empty($home_image['url'])) : ?>
            <img
                class="home-logo"
                src="<?php echo esc_url($home_image['url']); ?>"
                alt="<?php echo esc_attr($home_image['alt'] ?: get_bloginfo('name')); ?>"
            >
        <?php elseif (has_custom_logo()) : ?>
            <div class="home-logo home-logo--custom"><?php the_custom_logo(); ?></div>
        <?php else : ?>
            <h1 class="home-title"><?php bloginfo('name'); ?></h1>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
