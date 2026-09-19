<?php
/**
 * Template tags / helpers.
 *
 * Convention: prefix everything with `mysalary_` to avoid clashes.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Get an ACF field for the current post (or a given post), with a fallback.
 *
 * Returns $fallback if ACF isn't active, or the field is empty/null.
 */
function mysalary_field( $name, $post_id = false, $fallback = '' ) {
    if ( ! function_exists( 'get_field' ) ) {
        return $fallback;
    }
    $value = get_field( $name, $post_id );
    return ( $value === null || $value === '' || $value === false ) ? $fallback : $value;
}

/**
 * Get a Polylang-registered string by name.
 *
 * If Polylang isn't active, just returns the default. The names used here
 * are registered in inc/polylang.php so editors can translate them in
 * Languages → String Translations.
 */
function mysalary_pll( $name, $default = '' ) {
    if ( function_exists( 'pll__' ) ) {
        $translated = pll__( $default );
        return $translated !== '' ? $translated : $default;
    }
    return $default;
}

/**
 * Return a Polylang string with an immediate Arabic fallback.
 *
 * Polylang remains the editor-controlled source. The fallback prevents
 * untranslated form controls from reverting to English on Arabic pages.
 */
function mysalary_form_string( $name, $english, $arabic = '' ) {
    $translated = mysalary_pll( $name, $english );
    $posted_lang = isset( $_POST['lang'] ) && is_string( $_POST['lang'] )
        ? sanitize_key( wp_unslash( $_POST['lang'] ) )
        : '';
    $current_lang = $posted_lang;

    if ( ! $current_lang && function_exists( 'pll_current_language' ) ) {
        $current_lang = (string) pll_current_language( 'slug' );
    }

    if ( 'ar' === $current_lang && $arabic && $translated === $english ) {
        return $arabic;
    }

    return $translated;
}

/**
 * Output a language switcher (English ↔ Arabic), or nothing if Polylang isn't active.
 *
 * Renders the other language as the pill used by the production header.
 */
function mysalary_language_switcher() {
    if ( ! function_exists( 'pll_the_languages' ) ) {
        return;
    }
    $links = pll_the_languages( [
        'raw'                    => 1,
		'hide_current'			 => 1,
        'hide_if_no_translation' => 0,
        'display_names_as'       => 'name',
    ] );
    if ( empty( $links ) ) {
        return;
    }
    foreach ( $links as $slug => $lang ) {
        $label   = ! empty( $lang['name'] ) ? $lang['name'] : strtoupper( $slug );
        $url     = ! empty( $lang['no_translation'] ) && function_exists( 'pll_home_url' )
            ? pll_home_url( $slug )
            : $lang['url'];
        printf(
            '<a class="ms-lang" href="%1$s" lang="%2$s" hreflang="%2$s">%3$s</a>',
            esc_url( $url ),
            esc_attr( $slug ),
            esc_html( $label )
        );
        break;
    }
}

add_action('customize_register', function($wp_customize) {

    // Add setting
    $wp_customize->add_setting('plain_logo', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ]);

    // Add control inside "Site Identity"
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'plain_logo',
            [
                'label'       => __('Plain Logo', 'textdomain'),
                'section'     => 'title_tagline', // Site Identity tab
                'settings'    => 'plain_logo',
                'description' => __('Upload a plain (light/dark compatible) logo version.', 'textdomain'),
            ]
        )
    );

});

add_action('customize_controls_enqueue_scripts', function () {
    wp_add_inline_style('customize-controls', '
        #customize-control-plain_logo {
            background: #1f0f42;
			color: #fff;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
			width: 100%;
            max-width: 100%;
            height: auto;
            display: block;
        }
    ');
});

/**
 * Bundled SVG icon. Returns the inline SVG markup so it can be styled
 * with `currentColor` from CSS. Falls back to a simple placeholder if
 * the icon name isn't recognised.
 *
 * @param string $name 'check' | 'arrow-right' | 'plus' | 'shield' | 'eye' | …
 * @param array  $attrs HTML attrs to add to the root <svg> (class, width, height).
 */
function mysalary_icon( $name, $attrs = [] ) {
    $defaults = [
        'width'        => '22',
        'height'       => '22',
        'viewBox'      => '0 0 24 24',
        'fill'         => 'none',
        'stroke'       => 'currentColor',
        'stroke-width' => '2',
        'stroke-linecap'  => 'round',
        'stroke-linejoin' => 'round',
        'aria-hidden'  => 'true',
        'focusable'    => 'false',
    ];
	
    $attrs = array_merge( $defaults, $attrs );

    // Library of inline icons used across the original design.
    $paths = [
        'check'        => '<polyline points="20 6 9 17 4 12"/>',
        'arrow-right'  => '<path d="M5 12h14M12 5l7 7-7 7"/>',
        'plus'         => '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>',
        'shield-check' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>',
        'no-percent'   => '<line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>',
        'eye'          => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
        'tag'          => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>',
        'refresh'      => '<polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>',
        'pin'          => '<path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/>',
        'document'     => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>',
		'download'     => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>',
		'copy'         => '<rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>',
		'external-link'=> '<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>',
		'search-plus'  => '<circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/>',
        'no-circle'    => '<circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>',
        'heart'        => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>',
        'lightning'    => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
        'link'         => '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>',
        'cart'         => '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>',
        'users'        => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'monitor'      => '<rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>',
        'alert'        => '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
		'wps'		   => '<path d="M9.77615 0.0234527C9.73401 0.0466159 9.66845 0.199492 9.63568 0.343104C9.61227 0.445022 9.51394 1.31132 9.51394 1.40861C9.51394 1.50589 9.50458 1.49663 9.49053 1.49663C9.47648 1.49663 9.37816 1.45494 9.27046 1.40861C8.37147 0.996305 7.76278 0.773939 7.40693 0.718347C7.10258 0.672021 6.69055 0.685918 6.47516 0.746142C6.07249 0.857325 5.01899 1.41324 4.45712 1.81165L4.32601 1.9043L4.57885 1.9182C4.88788 1.94136 5.1735 2.02938 5.57617 2.23322C5.95543 2.42315 6.16613 2.56213 6.71396 2.97907C7.07449 3.25703 7.14941 3.32188 7.11195 3.34041C7.07449 3.35894 6.85442 3.4099 6.5969 3.4655C4.93939 3.85 3.45043 4.43372 2.19559 5.18883C1.84442 5.40194 1.85379 5.39267 1.68991 5.81887C1.44175 6.47207 0.968843 8.00547 1.00162 8.03327C1.0063 8.04253 1.02971 8.03327 1.04844 8.01937C1.09995 7.97768 1.90997 7.60707 2.23773 7.47735C3.10863 7.12527 4.10127 6.81026 5.17818 6.55546C5.81028 6.40722 6.62499 6.24044 6.64372 6.2636C6.65309 6.27287 6.53603 6.41648 6.38152 6.58789C5.57149 7.49125 4.64441 8.55676 4.32601 8.95053C4.25578 9.03855 4.12468 9.19606 4.03571 9.30724C3.34274 10.1457 1.7976 12.3555 1.33874 13.157L1.28255 13.2635L1.52603 13.6851C1.98489 14.4726 3.04308 16.2052 3.10395 16.2655C3.12736 16.2886 3.1695 16.2377 3.27719 16.0662C4.05444 14.834 5.37484 12.9948 6.26446 11.8923C7.07917 10.8916 9.08317 8.56602 9.13 8.56602C9.17682 8.56602 9.15341 11.3641 9.15341 14.783V21H10.9935C10.9935 20.9954 12.8337 20.9861 12.8337 20.9861L12.843 14.7737C12.843 11.0213 12.8571 8.56139 12.8711 8.56139C12.8945 8.56139 13.7795 9.56667 14.3601 10.243C15.5774 11.6699 16.0644 12.2721 16.8089 13.282C17.4503 14.153 18.2323 15.2787 18.7426 16.0848L18.8784 16.3025L18.9814 16.1404C19.0376 16.0477 19.1266 15.9087 19.1781 15.8254C19.3232 15.603 20.2784 14.0233 20.5125 13.6156C20.6998 13.2959 20.7139 13.2542 20.6858 13.194C20.6249 13.0643 19.8477 11.8737 19.445 11.2993C18.3166 9.68712 17.4644 8.64014 15.4651 6.41648C15.3948 6.34236 15.3433 6.26824 15.3574 6.2636C15.3902 6.23118 16.8885 6.56009 17.6189 6.7593C18.6724 7.04652 20.0537 7.56074 20.7794 7.93598C20.8965 7.99621 20.9948 8.04254 20.9995 8.0379C21.0042 8.0379 20.9761 7.93135 20.9433 7.8109C20.9105 7.69045 20.8497 7.47735 20.8122 7.33838C20.6249 6.64811 20.1895 5.45753 20.0958 5.3834C19.9928 5.30002 19.5386 5.03596 19.2249 4.86918C18.1012 4.27157 16.8885 3.82684 15.3995 3.47476C15.1139 3.40527 14.8798 3.33578 14.8798 3.32188C14.8798 3.28019 15.7788 2.60846 16.0644 2.43705C16.631 2.09887 17.0336 1.94599 17.4269 1.92746L17.6891 1.91357L17.5346 1.80702C16.9447 1.39471 15.938 0.866591 15.5119 0.74151C15.3246 0.685919 14.7487 0.685918 14.4865 0.732245C14.1962 0.787836 13.5734 1.02873 12.8571 1.34838C12.6745 1.43177 12.5199 1.492 12.5106 1.48736C12.4965 1.4781 12.4778 1.37618 12.4684 1.25573C12.4263 0.810999 12.3701 0.375532 12.328 0.241185C12.2531 -0.0182418 12.3514 0.000289576 11.0123 0.000289576C9.67314 0.000289576 9.81829 0.0141863 9.79488 0.0280842L9.77615 0.0234527Z" fill="#3D2A8C"></path>',
		'instant'	   => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>',
        'shield'       => '<path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z"/><polyline points="9 12 11 14 15 10"/>',
        'lock'         => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        'clock'        => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
    ];

    $body = isset( $paths[ $name ] ) ? $paths[ $name ] : '<circle cx="12" cy="12" r="10"/>';
	if ($name === 'wps') {
		$attrs['fill'] = 'none';
		$attrs['stroke'] = 'none';
	}
    $html_attrs = '';
    foreach ( $attrs as $k => $v ) {
        $html_attrs .= sprintf( ' %s="%s"', esc_attr( $k ), esc_attr( $v ) );
    }
    return sprintf(
        '<svg xmlns="http://www.w3.org/2000/svg"%s>%s</svg>',
        $html_attrs,
        $body
    );
}

/**
 * Social-network icon (inline SVG, fills with currentColor).
 */
function mysalary_social_icon( $network ) {
    $svgs = [
        'linkedin'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>',
        'x'         => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
        'instagram' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
        'tiktok'    => '<svg width="16" height="16" viewBox="0 0 512 512" fill="currentColor" aria-hidden="true" focusable="false"><path d="M480.32 128.39c-29.22 0-56.18-9.68-77.83-26.01-24.83-18.72-42.67-46.18-48.97-77.83-1.56-7.82-2.4-15.89-2.48-24.16h-83.47v228.08l-.1 124.93c0 33.4-21.75 61.72-51.9 71.68-8.75 2.89-18.2 4.26-28.04 3.72-12.56-.69-24.33-4.48-34.56-10.6-21.77-13.02-36.53-36.64-36.93-63.66-.63-42.23 33.51-76.66 75.71-76.66 8.33 0 16.33 1.36 23.82 3.83v-62.34-22.41c-7.9-1.17-15.94-1.78-24.07-1.78-46.19 0-89.39 19.2-120.27 53.79-23.34 26.14-37.34 59.49-39.5 94.46-2.83 45.94 13.98 89.61 46.58 121.83 4.79 4.73 9.82 9.12 15.08 13.17 27.95 21.51 62.12 33.17 98.11 33.17 8.13 0 16.17-.6 24.07-1.77 33.62-4.98 64.64-20.37 89.12-44.57 30.08-29.73 46.7-69.2 46.88-111.21l-.43-186.56c14.35 11.07 30.04 20.23 46.88 27.34 26.19 11.05 53.96 16.65 82.54 16.64v-60.61-22.49c.02.02-.22.02-.24.02z"/></svg>',
        'facebook'  => '<svg width="16" height="16" viewBox="0 0 155 155" fill="currentColor" aria-hidden="true" focusable="false"><path d="M89.584,155.139V84.378h23.742l3.562-27.585H89.584V39.184c0-7.984,2.208-13.425,13.67-13.425l14.595-0.006V1.08C115.325,0.752,106.661,0,96.577,0C75.52,0,61.104,12.853,61.104,36.452v20.341H37.29v27.585h23.814v70.761H89.584z"/></svg>',
        'snapchat'  => '<svg width="16" height="16" viewBox="0 0 468 468" fill="currentColor" aria-hidden="true" focusable="false"><path d="M233.962,33.724c62.857,0.021,115.216,52.351,115.292,115.36c0.018,14.758,0.473,28.348,1.306,40.867c0.514,7.724,6.938,13.448,14.305,13.448c1.085,0,2.19-0.124,3.3-0.384l19.691-4.616c0.838-0.197,1.679-0.291,2.51-0.291c5.001,0,9.606,3.417,10.729,8.478c1.587,7.152-2.42,14.378-9.35,16.808l-29.89,12.066c-7.546,3.046-11.599,11.259-9.474,19.115c23.98,88.654,90.959,79.434,90.959,90.984c0,14.504-50.485,16.552-55.046,21.114s-0.198,26.701-10.389,30.987c-1.921,0.808-4.65,1.089-7.979,1.089c-7.676,0-18.532-1.498-29.974-1.498c-9.925,0-20.291,1.127-29.404,5.337c-24.176,11.168-47.484,32.028-76.378,32.028s-52.202-20.86-76.378-32.028c-9.115-4.211-19.478-5.337-29.404-5.337c-11.441,0-22.299,1.498-29.974,1.498c-3.327,0-6.059-0.282-7.979-1.089c-10.191-4.286-5.828-26.425-10.389-30.987S25,360.062,25,345.558c0-11.551,66.979-2.331,90.959-90.984c2.125-7.855-1.928-16.068-9.475-19.115l-29.89-12.066c-6.931-2.43-10.938-9.656-9.35-16.808c1.123-5.062,5.728-8.479,10.729-8.478c0.83,0,1.672,0.094,2.51,0.291l19.691,4.616c1.11,0.26,2.215,0.384,3.3,0.384c7.366,0,13.791-5.725,14.305-13.448c0.833-12.519,1.289-26.109,1.307-40.867C119.162,86.075,171.104,33.746,233.962,33.724"/></svg>',
    ];
    return isset( $svgs[ $network ] ) ? $svgs[ $network ] : '';
}

function mysalary_check_icon() { ?>
	<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
<?php
}

/**
 * Convenience: the "primary" CTA button used across the design.
 */
function mysalary_cta_button( $url, $label, $variant = 'primary' ) {
    $variant_class = 'ms-btn ms-btn--' . sanitize_html_class( $variant );
    printf(
        '<a href="%1$s" class="%2$s">%3$s %4$s</a>',
        esc_url( $url ),
        esc_attr( $variant_class ),
        esc_html( $label ),
        mysalary_icon( 'arrow-right', [
            'class'        => 'ms-btn__arrow',
            'width'        => '14',
            'height'       => '14',
            'stroke-width' => '2.5',
        ] )
    );
}

add_filter('use_block_editor_for_post', '__return_false', 10);
/*
* SVG Support
*/

function allow_svg_uploads($mimes) {
    // Allow only for admins
    if (current_user_can('administrator')) {
        $mimes['svg'] = 'image/svg+xml';
    }
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

// Fix SVG display in media library
function fix_svg_display() {
    echo '<style>
        .attachment-266x266, .thumbnail img[src$=".svg"] {
            width: 100% !important;
            height: auto !important;
        }
    </style>';
}
add_action('admin_head', 'fix_svg_display');


function mysalary_get_demo_url() {

    // Try ACF/custom field first
    $demo_url = mysalary_field('demo_url', false, '');

    if ( ! $demo_url ) {

        // Try to find a page using the demo template
        $demo_page = get_pages([
            'meta_key'   => '_wp_page_template',
            'meta_value' => 'page-templates/template-demo.php',
            'number'     => 1,
        ]);

        if ( ! empty($demo_page) ) {
            $demo_url = get_permalink($demo_page[0]->ID);
        } else {
            $demo_url = '#';
        }
    }

    return $demo_url;
}
