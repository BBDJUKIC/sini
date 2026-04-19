<?php
/**
 * Site footer.
 *
 * @package one-team
 */

if (! defined('ABSPATH')) {
    exit;
}
?>

<footer class="site-footer" role="contentinfo">
    <div class="container site-footer__inner">
        <p class="site-footer__text">
            &copy; <?php echo esc_html(wp_date('Y')); ?> <?php bloginfo('name'); ?>
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
