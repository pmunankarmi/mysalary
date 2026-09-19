<?php
/**
 * Section 9: FAQ.
 *
 * Splits items into two columns to match the original two-list layout.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$title = mysalary_field( 'faq_title', false, 'Frequently asked questions' );
$items = mysalary_field( 'faq_items', false, [] );

if ( empty( $items ) ) {
    $items = [
        [ 'question' => 'What is MySalary?',                       'answer' => 'MySalary is an Earned Wage Access platform that allows employees to access part of their earned salary before payday.' ],
        [ 'question' => 'Is it a loan?',                           'answer' => 'No. It is not a loan, and no interest is charged.' ],
        [ 'question' => 'How does it work?',                       'answer' => 'Employees can withdraw a portion of their earned salary, and the amount is automatically settled during payroll.' ],
        [ 'question' => 'Does HR need to approve each request?',   'answer' => 'No. The process is fully automated after setup.' ],
        [ 'question' => 'Is it compliant with Saudi regulations?', 'answer' => 'Yes. MySalary is designed to align with Saudi labor laws and Shariah principles.' ],
    ];
}

// Split into 2 columns roughly evenly.
$count   = count( $items );
$mid     = (int) ceil( $count / 2 );
$col1    = array_slice( $items, 0, $mid );
$col2    = array_slice( $items, $mid );

$render_item = function ( $item ) {
    if ( empty( $item['question'] ) ) return;
    ?>
    <details class="ms-faq__item">
        <summary class="ms-faq__q">
            <?php echo esc_html( $item['question'] ); ?>
            <span class="ms-faq__plus">
                <?php echo mysalary_icon( 'plus', [ 'width' => 14, 'height' => 14, 'stroke-width' => 3 ] ); // phpcs:ignore ?>
            </span>
        </summary>
        <div class="ms-faq__a">
            <?php echo esc_html( $item['answer'] ?? '' ); ?>
        </div>
    </details>
    <?php
};
?>

<section class="ms-section ms-faq" id="faq">
    <div class="ms-container">
        <div class="ms-faq__inner">
            <div class="ms-faq__head ms-reveal">
                <h2><?php echo esc_html( $title ); ?></h2>
            </div>

            <div class="ms-faq__grid">
                <div class="ms-faq__list ms-reveal">
                    <?php foreach ( $col1 as $item ) { $render_item( $item ); } ?>
                </div>
                <?php if ( ! empty( $col2 ) ) : ?>
                    <div class="ms-faq__list ms-reveal">
                        <?php foreach ( $col2 as $item ) { $render_item( $item ); } ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
