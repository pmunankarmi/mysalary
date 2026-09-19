<?php
/**
 * Section 4: How it works.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$title = mysalary_field( 'how_title', false, 'How it works' );
$lead  = mysalary_field( 'how_lead',  false, 'Simple for your company. Easy for your employees.' );
$steps = mysalary_field( 'how_steps', false, [] );

if ( empty( $steps ) ) {
    $steps = [
        [ 'num' => '01', 'title' => 'Connect once',          'desc' => 'Your company integrates once with MySalary — no ongoing setup.', 'image' => null ],
        [ 'num' => '02', 'title' => 'Employees access anytime', 'desc' => 'Your team can withdraw part of their earned salary whenever they need.', 'image' => null ],
        [ 'num' => '03', 'title' => 'Automatic settlement',  'desc' => 'All transactions are automatically settled during payroll.', 'image' => null ],
    ];
}
?>

<section class="ms-section ms-how" id="how">
    <div class="ms-container">
        <div class="ms-how__head ms-reveal">
            <h2><?php echo esc_html( $title ); ?></h2>
            <?php if ( $lead ) : ?>
                <p class="ms-section__lead"><?php echo esc_html( $lead ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( $steps ) : ?>
            <div class="ms-how__steps ms-reveal">
                <?php foreach ( $steps as $step ) :
                    $num   = $step['num']   ?? '';
                    $img   = $step['image'] ?? null;
                    $stitle= $step['title'] ?? '';
                    $sdesc = $step['desc']  ?? '';
                ?>
                    <div class="ms-how__step">
                        <div class="ms-how__step-num" data-num="<?php echo esc_attr( $num ); ?>">
                            <?php if ( ! empty( $img['url'] ) ) : ?>
                                <img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ?? '' ); ?>" />
                            <?php else : ?>
                                <span class="ms-how__step-num-fallback"><?php echo esc_html( $num ); ?></span>
                            <?php endif; ?>
                        </div>
                        <h3><?php echo esc_html( $stitle ); ?></h3>
                        <?php if ( $sdesc ) : ?>
                            <p><?php echo esc_html( $sdesc ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
