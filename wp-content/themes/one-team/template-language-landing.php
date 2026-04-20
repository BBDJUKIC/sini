<?php
/**
 * Template Name: Language Landing
 * Template Post Type: page
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="main-content" class="main-content language-landing-main" role="main">
    <div class="container language-landing">
        <section class="language-landing__card" aria-label="Language selection">
            <?php
            if (function_exists('one_team_render_gtranslate')) {
                echo one_team_render_gtranslate(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
            ?>
        </section>
    </div>
</main>

<?php
get_footer();
