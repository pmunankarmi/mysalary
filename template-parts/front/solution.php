<?php
/**
 * Section 3: Solution.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$image   = mysalary_field( 'solution_image',   false, null );
$title   = mysalary_field( 'solution_title',   false, 'Give your employees salary access — without the complexity' );
$column_header_one 		= mysalary_field( 'field_ms_compare_col_label' );
$column_compare_before	= mysalary_field( 'field_ms_compare_col_before' );
$column_compare_after	= mysalary_field( 'field_ms_compare_col_after' );
$compare_rows			= mysalary_field( 'field_ms_compare_rows' );

$support = mysalary_field( 'solution_support', false, 'No manual work. No disruption. Just a seamless process.' );
?>

<section class="ms-section ms-compare" id="solution">
      <div class="ms-container">

        <div class="ms-compare__head ms-reveal">
          <h2><?php echo esc_html( $title ); ?></h2>
        </div>

        <div class="ms-compare__table ms-reveal">

          <div class="ms-compare__row ms-compare__row--head">
            <div class="ms-compare__cell ms-compare__cell--label"><?php echo esc_html( $column_header_one ); ?></div>
            <div class="ms-compare__cell ms-compare__cell--before"><?php echo esc_html( $column_compare_before ); ?></div>
            <div class="ms-compare__cell ms-compare__cell--after"><?php echo esc_html( $column_compare_after ); ?></div>
          </div>
		<?php foreach ( $compare_rows as $compare ) : ?>
          <div class="ms-compare__row">
            <div class="ms-compare__cell ms-compare__cell--label"><?php echo esc_html( $compare['row_label'] ); ?></div>
            <div class="ms-compare__cell ms-compare__cell--before">
              <span class="ms-compare__mark ms-compare__mark--x"><svg viewBox="0 0 24 24" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></span>
              <?php echo esc_html( $compare['before_text'] ); ?>
            </div>
            <div class="ms-compare__cell ms-compare__cell--after">
              <span class="ms-compare__mark ms-compare__mark--check"><svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg></span>
              <?php echo esc_html( $compare['after_text'] ); ?>
            </div>
          </div>
			<?php endforeach; ?>
          


        </div>
		<?php if ( $support ) : ?>
        <p class="ms-compare__foot ms-reveal">
          <span class="ms-hero__eyebrow-dot"></span>
          <?php echo esc_html( $support ); ?>
        </p>
		<?php endif; ?>
      </div>
    </section>