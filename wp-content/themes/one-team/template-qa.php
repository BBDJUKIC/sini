<?php
/**
 * Template Name: Q&A
 * Template Post Type: page
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="main-content" class="main-content page-main" role="main">
    <div class="container text-container qa-page">
        <?php
        while (have_posts()) :
            the_post();

            $qa_intro = one_team_get_field('qa_intro_text');
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('content-page'); ?>>
                <header class="content-page__header">
                    <h1 class="content-page__title"><?php the_title(); ?></h1>

                    <?php if (! empty($qa_intro)) : ?>
                        <p class="content-page__intro"><?php echo esc_html($qa_intro); ?></p>
                    <?php endif; ?>
                </header>

                <div class="content-page__body entry-content">
                    <?php the_content(); ?>
                </div>
            </article>

            <section class="qa-comments" aria-label="<?php esc_attr_e('Fragen und Antworten', 'one-team'); ?>">
                <?php comments_template(); ?>
            </section>
            <?php
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
