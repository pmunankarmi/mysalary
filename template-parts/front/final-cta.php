<?php
/**
 * Section 10: Final CTA.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$title    = mysalary_field( 'finalcta_title', false, 'Ready to offer your employees smarter salary access?' );
$desc     = mysalary_field( 'finalcta_desc',  false, 'Book a demo and see how MySalary works for your company — Quick setup · Fully automated · No HR workload' );
$demo_url = mysalary_field( 'demo_url', 'option', '#' );
?>

<section class="ms-section ms-finalcta" id="cta">
    <div class="ms-container">
        <div class="ms-finalcta__inner ms-reveal">
            <h2><?php echo esc_html( $title ); ?></h2>
            <?php if ( $desc ) : ?>
                <p><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
            <div class="ms-finalcta__cta-row">
                <a href="<?php echo esc_url( $demo_url ); ?>" class="ms-btn ms-btn--cyan">
                    <?php echo esc_html( mysalary_pll( 'request_demo', 'Request a Demo' ) ); ?>
                    <?php echo mysalary_icon( 'arrow-right', [ 'class' => 'ms-btn__arrow', 'width' => 14, 'height' => 14, 'stroke-width' => 2.5 ] ); // phpcs:ignore ?>
                </a>
            </div>
            <span class="ms-finalcta__note">
                <?php echo mysalary_icon( 'check', [ 'width' => 14, 'height' => 14, 'stroke-width' => 2.5 ] ); // phpcs:ignore ?>
                <?php echo esc_html( mysalary_pll( 'cta_setup_days', 'Setup in days · No credit checks · Full HR support' ) ); ?>
            </span>
        </div>
    </div>
</section>
