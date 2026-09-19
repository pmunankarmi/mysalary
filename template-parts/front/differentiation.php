<?php
/**
 * Section 7: Differentiation.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$title = mysalary_field( 'diff_title', false, 'Simple. Transparent. Compliant.' );
$items = mysalary_field( 'diff_items', false, [] );

if ( empty( $items ) ) {
    $items = [
        [ 'icon' => 'shield-check', 'title' => 'Not a loan',                'line' => 'Employees access what they have already earned — no borrowing involved.' ],
        [ 'icon' => 'no-percent',   'title' => 'No interest',               'line' => 'Fully aligned with Shariah principles.' ],
        [ 'icon' => 'eye',          'title' => 'No hidden fees',            'line' => 'Clear and transparent pricing structure.' ],
        [ 'icon' => 'tag',          'title' => 'Fixed pricing model',       'line' => 'Predictable and easy to understand.' ],
        [ 'icon' => 'refresh',      'title' => 'Fully automated',           'line' => 'No manual approvals or HR involvement.' ],
        [ 'icon' => 'pin',          'title' => 'Built for Saudi businesses','line' => 'Designed to meet local regulations and business needs.' ],
    ];
}

// Render the title with terminal full-stops styled. e.g. "Simple. Transparent. Compliant."
$rendered_title = preg_replace( '/(\w)(\.)/', '$1<span class="ms-stop">$2</span>', esc_html( $title ) );
?>

<section class="ms-section ms-diff">
    <div class="ms-container">
        <div class="ms-diff__head ms-reveal">
            <h2><?php echo $rendered_title; // phpcs:ignore — already escaped before regex ?></h2>
        </div>

        <?php if ( $items ) : ?>
            <div class="ms-diff__grid ms-reveal">
                <?php foreach ( $items as $d ) :
                    if ( empty( $d['title'] ) ) continue;
                    $icon = $d['icon'] ?? 'shield-check';
                ?>
                    <div class="ms-diff__item">
                        <div class="ms-diff__icon">
                            <?php echo mysalary_icon( $icon, [ 'width' => 22, 'height' => 22 ] ); // phpcs:ignore ?>
                        </div>
                        <div class="ms-diff__title"><?php echo esc_html( $d['title'] ); ?></div>
                        <?php if ( ! empty( $d['line'] ) ) : ?>
                            <p class="ms-diff__line"><?php echo esc_html( $d['line'] ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
