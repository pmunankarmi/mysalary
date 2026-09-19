<?php
/**
 * Front-end asset enqueue.
 *
 * Loads Cairo (Arabic) + Inter (Latin) from Google Fonts, the main
 * stylesheet, the inline-extracted JS, and a small piece of inline CSS
 * that wires the right body font to the right language.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_enqueue_scripts', function () {

    // Preconnect to Google Fonts.
    add_action( 'wp_head', function () {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    }, 1 );

    // Cairo + Inter, with all weights/axes used in the design.
    wp_enqueue_style(
        'mysalary-fonts',
        'https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap',
        [],
        null
    );

    // Main stylesheet (the original production CSS, unmodified).
    wp_enqueue_style(
        'mysalary-main',
        MYSALARY_URI . '/assets/css/main.css',
        [ 'mysalary-fonts' ],
        MYSALARY_VERSION
    );
	
    wp_enqueue_style(
        'mysalary-theme',
        get_stylesheet_uri(),
        array(),
        MYSALARY_VERSION
    );



    // Per-language font binding. Cairo is used for Arabic; Inter for everything else.
    // The original CSS uses --ms-display / --ms-body for typography — we override
    // them on <html> when Arabic is active so the whole site re-flows in Cairo.
    $is_arabic = function_exists( 'pll_current_language' )
        ? in_array( pll_current_language( 'slug' ), [ 'ar' ], true )
        : ( get_locale() === 'ar' || is_rtl() );

    $font_family = $is_arabic ? "'Cairo', sans-serif" : "'Inter', sans-serif";

    wp_add_inline_style( 'mysalary-main', sprintf(
        ':root { --ms-display: %1$s; --ms-body: %1$s; }',
        $font_family
    ) );
	
    // Main JS — extracted from the original index.html.
    wp_enqueue_script(
        'mysalary-main',
        MYSALARY_URI . '/assets/js/main.js',
        [],
        MYSALARY_VERSION,
        true
    );

    if ( is_page_template( 'page-templates/template-sharia-compliance.php' ) ) {
        wp_enqueue_style(
            'mysalary-sharia-compliance',
            MYSALARY_URI . '/assets/css/sharia-compliance.css',
            [ 'mysalary-main' ],
            MYSALARY_VERSION
        );

        wp_enqueue_script(
            'mysalary-sharia-compliance',
            MYSALARY_URI . '/assets/js/sharia-compliance.js',
            [],
            MYSALARY_VERSION,
            true
        );
    }

    $form_templates = [
        'page-templates/template-demo.php',
        'page-templates/template-contact.php',
        'page-templates/template-careers.php',
    ];

    if ( is_page_template( $form_templates ) ) {
        wp_enqueue_script(
            'mysalary-forms',
            MYSALARY_URI . '/assets/js/forms.js',
            [],
            MYSALARY_VERSION,
            true
        );

        wp_localize_script( 'mysalary-forms', 'mysalaryForms', [
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'mysalary_forms' ),
            'lang'    => function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : ( is_rtl() ? 'ar' : 'en' ),
            'i18n'    => [
                'sending'  => mysalary_form_string( 'form_sending', 'Sending…', 'جارٍ الإرسال…' ),
                'success'  => mysalary_form_string( 'form_sent', '✓ Sent successfully', '✓ تم الإرسال بنجاح' ),
                'error'    => mysalary_form_string( 'form_error', 'Something went wrong. Please try again.', 'حدث خطأ ما. يرجى المحاولة مرة أخرى.' ),
                'required' => mysalary_form_string( 'form_error_required', 'This field is required.', 'هذا الحقل مطلوب.' ),
                'email'    => mysalary_form_string( 'form_error_email', 'Enter a valid email.', 'يرجى إدخال بريد إلكتروني صحيح.' ),
                'url'      => mysalary_form_string( 'form_error_url', 'Enter a valid URL.', 'يرجى إدخال رابط صحيح.' ),
                'fileType' => mysalary_form_string( 'career_error_cv_type', 'Upload a PDF, DOC, or DOCX file.', 'يرجى رفع ملف بصيغة PDF أو DOC أو DOCX.' ),
                'fileSize' => mysalary_form_string( 'career_error_cv_size', 'The file must be 5 MB or smaller.', 'يجب ألا يتجاوز حجم الملف 5 ميجابايت.' ),
            ],
        ] );
    }
} );
