<?php
/**
 * Comments template.
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();

            if ($comment_count === 1) {
                esc_html_e('1 Question', 'one-team');
            } else {
                printf(
                    /* translators: %s: number of comments */
                    esc_html(_n('%s Question', '%s Questions', $comment_count, 'one-team')),
                    esc_html(number_format_i18n($comment_count))
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments([
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size'=> 40,
            ]);
            ?>
        </ol>

        <?php the_comments_pagination([
            'prev_text' => __('Previous', 'one-team'),
            'next_text' => __('Next', 'one-team'),
        ]); ?>
    <?php endif; ?>

    <?php
    comment_form([
        'title_reply'          => __('Ask a Question', 'one-team'),
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after'    => '</h3>',
        'label_submit'         => __('Submit', 'one-team'),
        'comment_notes_before' => '<p class="comment-notes">' . esc_html__('Your email address will not be published.', 'one-team') . '</p>',
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html__('Question', 'one-team') . '</label><textarea id="comment" name="comment" cols="45" rows="6" maxlength="65525" required></textarea></p>',
    ]);
    ?>
</div>
