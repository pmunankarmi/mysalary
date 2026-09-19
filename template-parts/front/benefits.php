<?php
/**
 * Section 5: Benefits.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$title = mysalary_field( 'benefits_title', false, 'Why employers choose MySalary' );
$items = mysalary_field( 'benefits_items', false, [] );

if ( empty( $items ) ) {
    $items = [
        [ 'icon' => 'document',  'title' => 'Reduce manual salary requests', 'desc' => 'Employees access their earnings without involving HR in manual requests.' ],
        [ 'icon' => 'no-circle', 'title' => 'Zero HR workload',              'desc' => 'No approvals, no paperwork, no manual tracking.' ],
        [ 'icon' => 'heart',     'title' => 'Improve employee satisfaction','desc' => 'Give your team more financial flexibility and support.' ],
        [ 'icon' => 'lightning', 'title' => 'Increase productivity',         'desc' => 'Reduce financial stress and keep employees focused.' ],
        [ 'icon' => 'link',      'title' => 'Seamless integration',          'desc' => 'Connect once and automate everything.' ],
    ];
}
?>

<section class="ms-section ms-benefits" id="benefits">
    <div class="ms-container">
        <div class="ms-benefits__head ms-reveal">
            <h2><?php echo esc_html( $title ); ?></h2>
        </div>

        <?php if ( $items ) : ?>
            <div class="ms-benefits__grid ms-reveal">
                <?php foreach ( $items as $b ) :
                    if ( empty( $b['title'] ) ) continue;
                    $icon = $b['icon'] ?? 'document';
                ?>
                    <article class="ms-benefit">
                        <div class="ms-benefit__icon">
                            <?php echo mysalary_icon( $icon, [ 'width' => 28, 'height' => 28 ] ); // phpcs:ignore ?>
                        </div>
                        <h3><?php echo esc_html( $b['title'] ); ?></h3>
                        <?php if ( ! empty( $b['desc'] ) ) : ?>
                            <p><?php echo esc_html( $b['desc'] ); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
