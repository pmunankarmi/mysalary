<?php
/**
 * Front page — composes the eight active marketing sections.
 *
 * Uses the static front page (Settings → Reading) as the host for all
 * the ACF section fields. To translate the entire homepage, translate
 * the page in Polylang — each translation gets its own ACF values.
 *
 * @package MySalary
 */

get_header();

// Sections are ordered to match the original landing page.
$sections = [
    'hero',
    'solution',
    'how-it-works',
    'benefits',
    'differentiation',
    'trust',
    'faq',
    'final-cta',
];

foreach ( $sections as $section ) {
    get_template_part( 'template-parts/front/' . $section );
}

get_footer();
