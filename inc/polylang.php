<?php
/**
 * Polylang integration.
 *
 * Registers theme-wide strings with Polylang so editors can translate
 * them in WP admin → Languages → String Translations. These are the
 * strings that aren't tied to a specific page (CTA labels, app store
 * captions, footer text, form placeholders, etc.).
 *
 * For per-page editorial content (section headings, leads, FAQs), we
 * don't register strings — those are ACF fields on the Home page and
 * Polylang automatically gives each translated copy of the page its
 * own ACF values.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', function () {

    if ( ! function_exists( 'pll_register_string' ) ) {
        return; // Polylang not installed yet — bail silently.
    }

    $group = 'MySalary Theme';

    // Keys: pass these as the second arg to pll__() in templates;
    // values: the English/default strings.
    $strings = [
        // CTAs
        'request_demo'         => 'Request a Demo',
        'cta_note_no_credit'   => 'No credit checks · No paperwork',
        'cta_setup_days'       => 'Setup in days · No credit checks · Full HR support',
        'subscribe'            => 'Subscribe',
        'nav_solution'         => 'Solution',
        'nav_how'              => 'How it works',
        'nav_employers'        => 'Employers',
        'nav_trust'            => 'Trust',
        'nav_faq'              => 'FAQ',
        'nav_open_menu'        => 'Open menu',
        'nav_close_menu'       => 'Close menu',

        // Footer
        'footer_tagline'       => 'Empowering the flow of income for employees across the Kingdom of Saudi Arabia.',
        'footer_company'       => 'Company',
        'footer_legal'         => 'Legal',
        'footer_download_app'  => 'Download the App',
        'footer_copyright'     => '© 2026 MySalary. All Rights Reserved.',
        'footer_about'         => 'About Us',
        'footer_careers'       => 'Careers',
        'footer_press'         => 'Press',
        'footer_contact'       => 'Contact',
        'footer_help'          => 'Help Center',
        'footer_privacy'       => 'Privacy Policy',
        'footer_terms'         => 'Terms of Service',
        'footer_security'      => 'Security',
        'footer_shariah'       => 'Shariah-compliant',
        'footer_legal_description' => 'Alajur Alraqmia Liltiqniat Company, a Saudi Simplified Joint Stock Company, registered under Unified National Number 7053385717, with its headquarters located at Building No. 8646, King Abdulaziz Road, Al Ghadeer District, Postal Code 13311, Riyadh, Kingdom of Saudi Arabia.',

        // Demo form
        'form_title'           => 'Book your demo',
        'form_intro'           => 'A specialist will reach out within one business day.',
        'form_full_name'       => 'Full name',
        'form_full_name_ph'    => 'e.g. Ahmed Al-Saud',
        'form_job_title'       => 'Job title',
        'form_job_title_ph'    => 'e.g. HR Manager',
        'form_work_email'      => 'Work email',
        'form_work_email_ph'   => 'name@company.com',
        'form_phone'           => 'Phone number',
        'form_phone_ph'        => '+966 5X XXX XXXX',
        'form_company'         => 'Company name',
        'form_company_ph'      => 'Your company',
        'form_country'         => 'Country',
        'form_country_sa'      => 'Saudi Arabia',
        'form_employees'       => 'Number of employees',
        'form_employees_ph'    => 'Select company size',
        'form_size_1'          => '1–50 employees',
        'form_size_2'          => '50–250 employees',
        'form_size_3'          => '250–500 employees',
        'form_size_4'          => '500–5,000 employees',
        'form_size_5'          => 'More than 5,000 employees',
        'form_terms'           => 'I agree to the terms and conditions and privacy policy.',
        'form_submit'          => 'Request my demo',
        'form_footnote'        => 'No credit checks · No paperwork · Setup in days',
        'form_brand_eyebrow'   => 'Request a Demo',
        'form_brand_headline'  => 'Give your team instant access to their earned salary.',
        'form_brand_subhead'   => 'See how MySalary works for your company — no interest, no HR workload, fully automated.',
        'form_sending'         => 'Sending…',
        'form_success'         => '✓ Request received',
        'form_error'           => 'Something went wrong. Please try again.',
        'form_error_name'      => 'Name is required.',
        'form_error_email'     => 'Enter a valid email.',
        'form_error_phone'     => 'A valid phone number is required.',
        'form_error_terms'     => 'You must accept the terms.',
        'form_error_fields'    => 'Please fix the highlighted fields.',
        'form_error_security'  => 'Security check failed. Please refresh the page and try again.',
        'form_error_rate'      => 'Please wait a moment before submitting again.',
        'form_error_save'      => 'Could not save the request. Please try again.',

        // Contact form
        'contact_name'          => 'Full name',
        'contact_company'       => 'Company',
        'contact_email'         => 'Email',
        'contact_phone'         => 'Phone',
        'contact_subject'       => 'Subject',
        'contact_message'       => 'Message',
        'contact_submit'        => 'Send message',
        'contact_success'       => 'Thank you. Your message has been sent.',
        'contact_error_message' => 'Message is required.',
        'contact_open_maps'     => 'Open in Google Maps',

        // Career form
        'career_apply_now'            => 'Apply now',
        'career_name'                 => 'Full name',
        'career_name_placeholder'     => 'e.g. Sara Al-Otaibi',
        'career_email'                => 'Email address',
        'career_phone'                => 'Mobile number',
        'career_position'             => 'Position applied for',
        'career_position_placeholder' => 'e.g. Software Engineer',
        'career_linkedin'             => 'LinkedIn profile',
        'career_cv'                   => 'Upload CV',
        'career_cv_types'             => '(PDF / DOC / DOCX, maximum 5 MB)',
        'career_message'              => 'Message',
        'career_message_placeholder'  => 'A few lines about your experience and why you would like to join…',
        'career_submit'               => 'Submit application',
        'career_success'              => 'Thank you. Your application has been submitted.',
        'career_error_position'       => 'Position is required.',
        'career_error_cv'             => 'Please upload your CV.',
        'career_error_cv_upload'      => 'The CV could not be uploaded. Please try again.',
        'career_error_cv_size'        => 'The CV must be 5 MB or smaller.',
        'career_error_cv_type'        => 'Upload a PDF, DOC, or DOCX file.',
        'form_optional'               => '(optional)',
        'form_sent'                   => '✓ Sent successfully',
        'form_error_required'         => 'This field is required.',
        'form_error_url'              => 'Enter a valid URL.',
        'demo_confirmation'           => 'Thanks for requesting a demo. A specialist will contact you within one business day.',

        // Trust strip on demo page
        'trust_secure'         => 'Secure',
        'trust_compliant'      => 'Shariah-compliant',
        'trust_automated'      => 'Fully automated',
    ];

    foreach ( $strings as $name => $value ) {
        pll_register_string( $name, $value, $group, false );
    }
} );

/**
 * Make ACF translate URLs in repeater rows. (No-op if ACF or Polylang
 * isn't active — the function is harmless either way.)
 */
add_filter( 'pll_get_post_types', function ( $post_types, $is_settings ) {
    // Make sure pages are translatable (default, but explicit is good).
    $post_types['page'] = 'page';
    return $post_types;
}, 10, 2 );
