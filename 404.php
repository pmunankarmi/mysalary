<?php
/**
 * 404 page.
 *
 * @package MySalary
 */

get_header();
?>

<section class="ms-section" style="text-align: center; padding-top: 120px; padding-bottom: 120px;">
    <div class="ms-container">
        <h1 style="font-size: 96px; margin: 0 0 24px; color: var(--ms-purple);">404</h1>
        <p class="ms-section__lead" style="margin-bottom: 32px;">
            <?php esc_html_e( "The page you're looking for can't be found.", 'mysalary' ); ?>
        </p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ms-btn ms-btn--primary">
            <?php esc_html_e( 'Back to home', 'mysalary' ); ?>
            <?php echo mysalary_icon( 'arrow-right', [ 'class' => 'ms-btn__arrow', 'width' => 14, 'height' => 14, 'stroke-width' => 2.5 ] ); // phpcs:ignore ?>
        </a>
    </div>
</section>

<?php get_footer(); ?>
