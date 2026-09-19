<?php
/**
 * Section 1: Hero.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$eyebrow   = mysalary_field( 'hero_eyebrow',   false, 'Earned Wage Access for Saudi Companies' );
$line1     = mysalary_field( 'hero_line1',     false, 'Not a Loan. Not an Advance.' );
$highlight = mysalary_field( 'hero_highlight', false, 'Instant Salary Access for Your Employees' );
$desc      = mysalary_field( 'hero_desc',      false, 'Give your employees instant access to their earned salary — without interest or HR complexity.' );
$bullets   = mysalary_field( 'hero_bullets',   false, [] );
$banners   = mysalary_field( 'hero_banners',   false, [] );

$demo_url  = mysalary_field( 'demo_url', 'option', mysalary_get_demo_url() );

// Default bullets from the original design when the user hasn't filled them in.
if ( empty( $bullets ) ) {
    $bullets = [
        [ 'text' => 'Shariah-compliant' ],
        [ 'text' => 'Fully automated' ],
        [ 'text' => 'Aligned with WPS & Mudad' ],
    ];
}
?>

<section class="ms-hero">
    <div class="ms-container">
        <div class="ms-hero__grid">
            <div class="ms-hero__copy">
                <span class="ms-hero__eyebrow">
                    <span class="ms-hero__eyebrow-dot"></span>
                    <?php echo esc_html( $eyebrow ); ?>
                </span>

                <h1>
                    <span class="ms-hero__line1"><?php echo esc_html( $line1 ); ?></span>
                    <span class="ms-hero__highlight"><?php echo esc_html( $highlight ); ?></span>
                </h1>

                <p class="ms-hero__desc"><?php echo esc_html( $desc ); ?></p>

                <?php if ( $bullets ) : ?>
                    <ul class="ms-hero__bullets">
                        <?php foreach ( $bullets as $b ) : if ( empty( $b['text'] ) ) continue; ?>
                            <li class="ms-hero__bullet">
                                <?php echo mysalary_icon( 'check', [ 'width' => 16, 'height' => 16, 'stroke-width' => 3 ] ); // phpcs:ignore ?>
                                <?php echo esc_html( $b['text'] ); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <div class="ms-hero__cta-row">
                    <a href="<?php echo esc_url( $demo_url ); ?>" class="ms-btn ms-btn--primary">
                        <?php echo esc_html( mysalary_pll( 'request_demo', 'Request a Demo' ) ); ?>
                        <?php echo mysalary_icon( 'arrow-right', [ 'class' => 'ms-btn__arrow', 'width' => 14, 'height' => 14, 'stroke-width' => 2.5 ] ); // phpcs:ignore ?>
                    </a>
                    <span class="ms-hero__cta-note">
                        <?php echo esc_html( mysalary_pll( 'cta_note_no_credit', 'No credit checks · No paperwork' ) ); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="ms-hero__stage" id="msHeroStage">
        <?php if ( ! empty( $banners ) ) : ?>
            <?php foreach ( $banners as $i => $banner ) :
                $img = $banner['image'] ?? null;
                if ( empty( $img['url'] ) ) continue;
                $is_active = $i === 0;
            ?>
                <div class="ms-hero__state<?php echo $is_active ? ' is-active' : ''; ?>" data-state="<?php echo esc_attr( $i + 1 ); ?>">
                    <img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ?? '' ); ?>" />
                </div>
            <?php endforeach; ?>
			
			<!-- Supporting line (rotates with state) -->
			<?php foreach ( $banners as $i => $banner ) : 
			$title = $banner['title'];
			$is_active = $i === 0;
			?>
            <div class="ms-hero__support <?php echo $is_active ? ' is-active' : ''; ?>" data-support="<?php echo esc_attr( $i + 1 ); ?>"><?php echo esc_attr( $title ); ?></div>
			<?php endforeach; ?>

		
        <?php endif; ?>
    </div>
</section>
