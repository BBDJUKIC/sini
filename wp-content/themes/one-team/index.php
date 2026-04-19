<?php
/**
 * Fallback template.
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="main-content" class="main-content page-main" role="main">
    <div class="container text-container">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', 'page');
            endwhile;
        else :
            ?>
            <article class="content-page">
                <h1 class="content-page__title"><?php esc_html_e('Content not found', 'one-team'); ?></h1>
            </article>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
