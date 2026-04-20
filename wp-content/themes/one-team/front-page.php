<?php
/**
 * Front page router.
 *
 * Supports either language-landing or home content structure,
 * based on selected template on the static front page.
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}

$front_template = get_page_template_slug(get_queried_object_id());
$is_language_landing = $front_template === 'template-language-landing.php';

get_header();
?>

<main id="main-content" class="main-content <?php echo $is_language_landing ? 'language-landing-main' : 'home-main'; ?>" role="main">
    <div class="container <?php echo $is_language_landing ? 'language-landing' : 'home-layout'; ?>">
        <?php
        while (have_posts()) :
            the_post();

            if ($is_language_landing) :
                ?>
                <section class="language-landing__card" aria-label="Language selection">
                    <?php
                    if (function_exists('one_team_render_gtranslate')) {
                        echo one_team_render_gtranslate(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
                    ?>
                </section>
                <?php
                continue;
            endif;

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

    <?php if (! $is_language_landing) : ?>
        <div class="language-modal" id="home-language-modal" hidden aria-hidden="true">
            <div class="language-modal__overlay" aria-hidden="true"></div>

            <div class="language-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="home-language-modal-title">
                <button type="button" class="language-modal__close" aria-label="Close language selector">
                    &times;
                </button>

                <div class="language-modal__content">
                    <h2 class="language-modal__title" id="home-language-modal-title">Choose your language</h2>
                    <p class="language-modal__subtitle">Please select your preferred language to continue.</p>

                    <div class="language-modal__grid" id="home-language-modal-grid"></div>

                    <button type="button" class="language-modal__continue" id="home-language-modal-continue">
                        Continue in current language
                    </button>
                </div>
            </div>

            <div class="language-modal__source" id="language-modal-source" hidden aria-hidden="true">
                <?php
                if (function_exists('one_team_render_gtranslate')) {
                    echo one_team_render_gtranslate(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php
get_footer();
