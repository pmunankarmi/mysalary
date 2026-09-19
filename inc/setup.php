<?php
/**
 * Theme setup — runs on after_setup_theme.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'after_setup_theme', function () {

    // Standard supports.
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption', 'script', 'style' ] );

    // Custom logo (replaces the bundled brand SVG when set).
    add_theme_support( 'custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ] );

    // Image sizes used by templates.
    add_image_size( 'mysalary-hero',     1600, 900,  true );
    add_image_size( 'mysalary-banner',   993,  1080, false );  // hero rotating banners — preserve aspect

    // Translations.
    load_theme_textdomain( 'mysalary', MYSALARY_DIR . '/languages' );

    // Menus — Polylang assigns these per-language automatically.
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'mysalary' ),
        'company'  => __( 'Company Navigation',  'mysalary' ),
		'legal'  => __( 'Legal Navigation',  'mysalary' ),
    ] );
} );

/**
 * Soft notice if ACF and/or Polylang aren't installed yet.
 */
add_action( 'admin_notices', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    $missing = [];
    if ( ! mysalary_has( 'acf' ) )      { $missing[] = 'Advanced Custom Fields (Pro recommended)'; }
    if ( ! mysalary_has( 'polylang' ) ) { $missing[] = 'Polylang'; }
    if ( ! $missing ) { return; }

    echo '<div class="notice notice-warning"><p><strong>' . esc_html__( 'MySalary theme:', 'mysalary' ) . '</strong> ';
    echo esc_html(
        sprintf(
            /* translators: %s = comma-separated plugin names */
            __( 'install %s to unlock the editable sections and bilingual content.', 'mysalary' ),
            implode( ', ', $missing )
        )
    );
    echo '</p></div>';
} );

/**
 * Body class — adds is-rtl when the current language is RTL, plus a language slug.
 * Useful for CSS overrides without parsing <html lang>.
 */
add_filter( 'body_class', function ( $classes ) {
    if ( is_rtl() ) {
        $classes[] = 'is-rtl';
    }
    if ( function_exists( 'pll_current_language' ) ) {
        $lang = pll_current_language( 'slug' );
        if ( $lang ) {
            $classes[] = 'lang-' . sanitize_html_class( $lang );
        }
    }
    return $classes;
} );
