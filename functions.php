<?php
/**
 * MySalary — theme bootstrap.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'MYSALARY_VERSION', '1.4.3' );
define( 'MYSALARY_DIR',     get_template_directory() );
define( 'MYSALARY_URI',     get_template_directory_uri() );

/**
 * Tiny helper: tells you whether a plugin we care about is active.
 *
 * @param string $name 'acf' or 'polylang'
 */
function mysalary_has( $name ) {
    switch ( $name ) {
        case 'acf':      return class_exists( 'ACF' ) || function_exists( 'get_field' );
        case 'polylang': return defined( 'POLYLANG_VERSION' ) || function_exists( 'pll__' );
    }
    return false;
}

/* ---- Includes ---- */
require_once MYSALARY_DIR . '/inc/setup.php';
require_once MYSALARY_DIR . '/inc/enqueue.php';
require_once MYSALARY_DIR . '/inc/template-tags.php';
require_once MYSALARY_DIR . '/inc/acf-fields.php';
require_once MYSALARY_DIR . '/inc/acf-fields-pages.php';
require_once MYSALARY_DIR . '/inc/polylang-slug.php';
require_once MYSALARY_DIR . '/inc/polylang.php';
require_once MYSALARY_DIR . '/inc/form-handler.php';
require_once MYSALARY_DIR . '/inc/github-updater.php';
require_once MYSALARY_DIR . '/inc/cache.php';



/**
 * Walker that outputs <a> tags directly (no <li> wrapper) — matches the
 * markup the original CSS expects in .ms-nav.
 */
if ( ! class_exists( 'MySalary_Anchor_Only_Walker' ) ) {
    class MySalary_Anchor_Only_Walker extends Walker_Nav_Menu {
        public function start_lvl( &$output, $depth = 0, $args = null ) {}
        public function end_lvl( &$output, $depth = 0, $args = null ) {}
        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            $atts = '';
			$url  = $item->url;

			// Prepend homepage URL for anchor links on inner pages.
			if ( ! is_front_page() && ! empty( $url ) && 0 === strpos( $url, '#' ) ) {
				$language_home = function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' );
				$url = $language_home . $url;
			}

			if ( ! empty( $url ) ) {
				$atts .= ' href="' . esc_url( $url ) . '"';
			}
            if ( ! empty( $item->target ) ) { 
				$atts .= ' target="' . esc_attr( $item->target ) . '"'; 
			}
            if ( ! empty( $item->xfn ) ) { 
				$atts .= ' rel="' . esc_attr( $item->xfn ) . '"'; 
			}

			
			
			
			/**
			 * Add menu item classes
			 */
			$classes = ! empty( $item->classes ) ? (array) $item->classes : [];
			$classes = array_filter($classes); // remove empty values

			if ( ! empty( $classes ) ) {
				$atts .= ' class="' . esc_attr( implode( ' ', $classes ) ) . '"';
			}
			
            $output .= '<a' . $atts . '>' . esc_html( $item->title ) . '</a>';
        }
        public function end_el( &$output, $item, $depth = 0, $args = null ) {}
    }
}
