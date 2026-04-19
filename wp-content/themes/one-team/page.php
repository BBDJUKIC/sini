<?php
/**
 * Default page template.
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
        while (have_posts()) :
            the_post();
            get_template_part('template-parts/content', 'page');
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
