<?php
/**
 * Section 8: Trust.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$title  = mysalary_field( 'trust_title', false, 'Trusted by Saudi Businesses' );
$sub    = mysalary_field( 'trust_sub',   false, 'Secure. Compliant. Reliable.' );
$points = mysalary_field( 'trust_points',false, [] );

if ( empty( $points ) ) {
    $points = [
        [ 'icon' => 'shield',  'title' => 'Fully integrated with WPS and Mudad', 'line' => 'Designed to align with local payroll and employment standards.' ],
        [ 'icon' => 'shield',  'title' => 'Shariah-compliant structure',         'line' => 'No interest. No debt-based model.' ],
        [ 'icon' => 'lock',    'title' => 'Secure platform',                     'line' => 'Employee data is protected with high security standards.' ],
        [ 'icon' => 'clock',   'title' => 'Real-time tracking and reporting',    'line' => 'Full visibility for HR and management.' ],
        [ 'icon' => 'refresh', 'title' => 'Fully automated',                     'line' => 'No manual approvals or HR involvement.' ],
    ];
}
?>

<section class="ms-section ms-trust" id="trust">
    <div class="ms-container">
        <div class="ms-trust__inner ms-reveal">
            <h2><?php echo esc_html( $title ); ?></h2>
            <?php if ( $sub ) : ?>
                <p class="ms-trust__sub"><?php echo esc_html( $sub ); ?></p>
            <?php endif; ?>

            <?php if ( $points ) : ?>
                <div class="ms-trust__points">
                    <?php foreach ( $points as $p ) :
                        if ( empty( $p['title'] ) ) continue;
                        $icon = $p['icon'] ?? 'shield';
                    ?>
                        <div class="ms-trust__point">
                            <div class="ms-trust__point-icon ms-icon-<?php echo $icon; ?>">
                                <?php echo mysalary_icon( $icon, [ 'width' => 22, 'height' => 22 ] ); // phpcs:ignore ?>
                            </div>
                            <div class="ms-trust__point-title"><?php echo esc_html( $p['title'] ); ?></div>
                            <?php if ( ! empty( $p['line'] ) ) : ?>
                                <p class="ms-trust__point-line"><?php echo esc_html( $p['line'] ); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
