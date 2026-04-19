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
?>

<main id="main-content" class="main-content home-main" role="main">
    <?php
    while (have_posts()) :
        the_post();

        $home_page_id = (int) get_the_ID();
        $home_image   = [
            'url' => '',
            'alt' => '',
            'id'  => 0,
        ];

        if (function_exists('one_team_get_field') && function_exists('one_team_resolve_image')) {
            $home_image = one_team_resolve_image(one_team_get_field('home_logo_image', $home_page_id));
        }

        $raw_content = trim((string) get_post_field('post_content', $home_page_id));
        $has_content = $raw_content !== '';
        ?>

         <?php if ($has_content) : ?>
            <section class="home-intro entry-content" aria-label="<?php esc_attr_e('Startseiteninhalt', 'one-team'); ?>">
                <?php the_content(); ?>
            </section>
        <?php endif; ?>

        <?php if (! empty($home_image['url'])) : ?>
            <img
                class="home-logo"
                src="<?php echo esc_url($home_image['url']); ?>"
                alt="<?php echo esc_attr($home_image['alt'] ?: get_the_title()); ?>"
            >
        <?php elseif (function_exists('has_custom_logo') && has_custom_logo() && function_exists('the_custom_logo')) : ?>
            <div class="home-logo home-logo--custom"><?php the_custom_logo(); ?></div>
        <?php else : ?>
            <h1 class="home-title"><?php the_title(); ?></h1>
        <?php endif; ?>

       

    <?php endwhile; ?>
</main>

<?php
get_footer();
