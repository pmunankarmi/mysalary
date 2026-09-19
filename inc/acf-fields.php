<?php
/**
 * ACF field groups, registered in PHP.
 *
 * All editorial content for the home page lives on a single Page
 * (slug "home" — set as the static front page). Each field group below
 * is locked to that page via a `page_template` rule, so the fields
 * appear on whichever page uses the front-page template.
 *
 * Translating the home page in Polylang automatically gives the Arabic
 * copy its own ACF values — no extra config needed.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'acf/init', function () {

    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    /* Show fields on the static front page (whatever its slug is). */
    $front_page_id = (int) get_option( 'page_on_front' );
    $location_front = $front_page_id
        ? [ [ [ 'param' => 'page', 'operator' => '==', 'value' => $front_page_id ] ] ]
        : [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ];

    /* ===========================================================
     * 1. HERO
     * ======================================================== */
    acf_add_local_field_group( [
        'key'      => 'group_hero',
        'title'    => '01 — Hero',
        'location' => $location_front,
        'menu_order' => 1,
        'fields'   => [
            [ 'key' => 'f_hero_eyebrow',   'label' => 'Eyebrow',          'name' => 'hero_eyebrow',   'type' => 'text',
              'default_value' => 'Earned Wage Access for Saudi Companies' ],
            [ 'key' => 'f_hero_line1',     'label' => 'Headline line 1',  'name' => 'hero_line1',     'type' => 'text',
              'default_value' => 'Not a Loan. Not an Advance.' ],
            [ 'key' => 'f_hero_line2',     'label' => 'Highlight line',   'name' => 'hero_highlight', 'type' => 'text',
              'default_value' => 'Instant Salary Access for Your Employees' ],
            [ 'key' => 'f_hero_desc',      'label' => 'Description',      'name' => 'hero_desc',      'type' => 'textarea', 'rows' => 2,
              'default_value' => 'Give your employees instant access to their earned salary — without interest or HR complexity.' ],
            [
                'key' => 'f_hero_bullets', 'label' => 'Bullets', 'name' => 'hero_bullets',
                'type' => 'repeater', 'layout' => 'table', 'button_label' => 'Add bullet',
                'min' => 0, 'max' => 5,
                'sub_fields' => [
                    [ 'key' => 'f_hero_bullet_text', 'label' => 'Text', 'name' => 'text', 'type' => 'text' ],
                ],
            ],
            [
                'key' => 'f_hero_banners', 'label' => 'Hero rotating banners', 'name' => 'hero_banners',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Add banner',
                'min' => 0, 'max' => 6,
                'instructions' => 'Images that fade in/out in the hero (every 5s). Recommend 993×1080.',
                'sub_fields' => [
                    [ 'key' => 'f_hero_banner_img', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ],
					[ 'key' => 'f_hero_banner_caption', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ],
                ],
            ],
        ],
    ] );

    /* ===========================================================
     * 2. SOLUTION
     * ======================================================== */
    acf_add_local_field_group( [
		'key'        => 'group_solution',
		'title'      => '02 — Solution',
		'location'   => $location_front,
		'menu_order' => 2,

		'fields' => [
			[
				'key'            => 'f_solution_image',
				'label'          => 'Visual',
				'name'           => 'solution_image',
				'type'           => 'image',
				'return_format'  => 'array',
				'preview_size'   => 'medium',
			],
			[
				'key'           => 'f_solution_title',
				'label'         => 'Heading',
				'name'          => 'solution_title',
				'type'          => 'text',
				'default_value' => 'Give your employees salary access — without the complexity',
			],
			[
				'key'           => 'f_solution_lead',
				'label'         => 'Lead paragraph',
				'name'          => 'solution_lead',
				'type'          => 'textarea',
				'rows'          => 3,
				'default_value' => 'Give your employees instant access to their earned salary — while keeping your payroll simple and fully automated.',
			],
			[
				'key'           => 'f_solution_support',
				'label'         => 'Support line',
				'name'          => 'solution_support',
				'type'          => 'text',
				'default_value' => 'No manual work. No disruption. Just a seamless process.',
			],
			[
				'key'   => 'field_ms_compare_col_label',
				'label' => 'Column — row label header',
				'name'  => 'compare_col_label',
				'type'  => 'text',
			],
			[
				'key'   => 'field_ms_compare_col_before',
				'label' => 'Column — before header',
				'name'  => 'compare_col_before',
				'type'  => 'text',
			],
			[
				'key'   => 'field_ms_compare_col_after',
				'label' => 'Column — after header',
				'name'  => 'compare_col_after',
				'type'  => 'text',
			],
			[
				'key'          => 'field_ms_compare_rows',
				'label'        => 'Comparison rows',
				'name'         => 'compare_rows',
				'type'         => 'repeater',
				'layout'       => 'block',
				'button_label' => 'Add row',

				'sub_fields' => [
					[
						'key'   => 'field_ms_compare_row_label',
						'label' => 'Row label',
						'name'  => 'row_label',
						'type'  => 'text',
					],
					[
						'key'   => 'field_ms_compare_row_before',
						'label' => 'Before text',
						'name'  => 'before_text',
						'type'  => 'text',
					],
					[
						'key'   => 'field_ms_compare_row_after',
						'label' => 'After text',
						'name'  => 'after_text',
						'type'  => 'text',
					],
				],
			],
		],
	] );

    /* ===========================================================
     * 3. HOW IT WORKS
     * ======================================================== */
    acf_add_local_field_group( [
        'key' => 'group_how', 'title' => '03 — How it works',
        'location' => $location_front, 'menu_order' => 3,
        'fields' => [
            [ 'key' => 'f_how_title', 'label' => 'Heading', 'name' => 'how_title', 'type' => 'text',
              'default_value' => 'How it works' ],
            [ 'key' => 'f_how_lead', 'label' => 'Lead paragraph', 'name' => 'how_lead', 'type' => 'text',
              'default_value' => 'Simple for your company. Easy for your employees.' ],
            [
                'key' => 'f_how_steps', 'label' => 'Steps', 'name' => 'how_steps',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Add step',
                'min' => 1, 'max' => 6,
                'sub_fields' => [
                    [ 'key' => 'f_how_step_num',   'label' => 'Step number', 'name' => 'num',  'type' => 'text', 'default_value' => '01' ],
                    [ 'key' => 'f_how_step_image', 'label' => 'Illustration (optional)', 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail' ],
                    [ 'key' => 'f_how_step_title', 'label' => 'Title',       'name' => 'title','type' => 'text' ],
                    [ 'key' => 'f_how_step_desc',  'label' => 'Description', 'name' => 'desc', 'type' => 'textarea', 'rows' => 2 ],
                ],
            ],
        ],
    ] );

    /* ===========================================================
     * 4. BENEFITS
     * ======================================================== */
    acf_add_local_field_group( [
        'key' => 'group_benefits', 'title' => '04 — Benefits',
        'location' => $location_front, 'menu_order' => 4,
        'fields' => [
            [ 'key' => 'f_benefits_title', 'label' => 'Heading', 'name' => 'benefits_title', 'type' => 'text',
              'default_value' => 'Why employers choose MySalary' ],
            [
                'key' => 'f_benefits_items', 'label' => 'Benefit cards', 'name' => 'benefits_items',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Add benefit',
                'sub_fields' => [
                    [
                        'key' => 'f_benefit_icon', 'label' => 'Icon', 'name' => 'icon', 'type' => 'select',
                        'choices' => [
                            'document'   => 'Document',
                            'no-circle'  => 'No / cancel',
                            'heart'      => 'Heart',
                            'lightning'  => 'Lightning',
                            'link'       => 'Link',
                            'shield'     => 'Shield',
                            'clock'      => 'Clock',
                        ],
                        'default_value' => 'document',
                    ],
                    [ 'key' => 'f_benefit_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ],
                    [ 'key' => 'f_benefit_desc',  'label' => 'Description', 'name' => 'desc', 'type' => 'textarea', 'rows' => 2 ],
                ],
            ],
        ],
    ] );

    /* ===========================================================
     * 5. DIFFERENTIATION
     * ======================================================== */
    acf_add_local_field_group( [
        'key' => 'group_diff', 'title' => '05 — Differentiation',
        'location' => $location_front, 'menu_order' => 5,
        'fields' => [
            [ 'key' => 'f_diff_title', 'label' => 'Heading', 'name' => 'diff_title', 'type' => 'text',
              'default_value' => 'Simple. Transparent. Compliant.' ],
            [
                'key' => 'f_diff_items', 'label' => 'Items', 'name' => 'diff_items',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Add item',
                'sub_fields' => [
                    [
                        'key' => 'f_diff_icon', 'label' => 'Icon', 'name' => 'icon', 'type' => 'select',
                        'choices' => [
                            'shield-check' => 'Shield (check)',
                            'no-percent'   => 'No interest',
                            'eye'          => 'Eye / transparency',
                            'tag'          => 'Tag / pricing',
                            'refresh'      => 'Refresh / automation',
                            'pin'          => 'Pin / location',
                        ],
                        'default_value' => 'shield-check',
                    ],
                    [ 'key' => 'f_diff_item_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ],
                    [ 'key' => 'f_diff_item_line',  'label' => 'Line', 'name' => 'line', 'type' => 'text' ],
                ],
            ],
        ],
    ] );

    /* ===========================================================
     * 6. TRUST
     * ======================================================== */
    acf_add_local_field_group( [
        'key' => 'group_trust', 'title' => '06 — Trust',
        'location' => $location_front, 'menu_order' => 6,
        'fields' => [
            [ 'key' => 'f_trust_title', 'label' => 'Heading', 'name' => 'trust_title', 'type' => 'text',
              'default_value' => 'Trusted by Saudi Businesses' ],
            [ 'key' => 'f_trust_sub',   'label' => 'Subhead', 'name' => 'trust_sub',   'type' => 'text',
              'default_value' => 'Secure. Compliant. Reliable.' ],
            [
                'key' => 'f_trust_points', 'label' => 'Trust points', 'name' => 'trust_points',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Add point',
                'sub_fields' => [
                    [
                        'key' => 'f_trust_point_icon', 'label' => 'Icon', 'name' => 'icon', 'type' => 'select',
                        'choices' => [
							'wps'	  => 'WPS',
                            'shield'  => 'Shield',
                            'lock'    => 'Lock',
                            'clock'   => 'Clock',
                            'refresh' => 'Refresh',
                            'check'   => 'Check',
							'instant' => 'Instant'
                        ],
                        'default_value' => 'shield',
                    ],
                    [ 'key' => 'f_trust_point_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ],
                    [ 'key' => 'f_trust_point_line',  'label' => 'Line',  'name' => 'line',  'type' => 'text' ],
                ],
            ],
        ],
    ] );

    /* ===========================================================
     * 7. FAQ
     * ======================================================== */
    acf_add_local_field_group( [
        'key' => 'group_faq', 'title' => '07 — FAQ',
        'location' => $location_front, 'menu_order' => 7,
        'fields' => [
            [ 'key' => 'f_faq_title', 'label' => 'Heading', 'name' => 'faq_title', 'type' => 'text',
              'default_value' => 'Frequently asked questions' ],
            [
                'key' => 'f_faq_items', 'label' => 'FAQ items', 'name' => 'faq_items',
                'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Add question',
                'sub_fields' => [
                    [ 'key' => 'f_faq_q', 'label' => 'Question', 'name' => 'question', 'type' => 'text' ],
                    [ 'key' => 'f_faq_a', 'label' => 'Answer',   'name' => 'answer',   'type' => 'textarea', 'rows' => 3 ],
                ],
            ],
        ],
    ] );

    /* ===========================================================
     * 8. FINAL CTA
     * ======================================================== */
    acf_add_local_field_group( [
        'key' => 'group_final_cta', 'title' => '08 — Final CTA',
        'location' => $location_front, 'menu_order' => 8,
        'fields' => [
            [ 'key' => 'f_finalcta_title', 'label' => 'Heading', 'name' => 'finalcta_title', 'type' => 'text',
              'default_value' => 'Ready to offer your employees smarter salary access?' ],
            [ 'key' => 'f_finalcta_desc',  'label' => 'Description', 'name' => 'finalcta_desc', 'type' => 'textarea', 'rows' => 3,
              'default_value' => 'Book a demo and see how MySalary works for your company — Quick setup · Fully automated · No HR workload' ],
        ],
    ] );

    /* ===========================================================
     * SITE-WIDE: footer / nav / demo email
     *
     * These are options-page fields. The strings on this page are
     * NOT translated by Polylang free out of the box; for bilingual
     * footer text, use the Polylang-registered strings in
     * inc/polylang.php (translatable in Languages → String Translations).
     * The fields below are for non-language-specific values.
     * ======================================================== */

    if ( function_exists( 'acf_add_options_page' ) ) {
        acf_add_options_page( [
            'page_title' => __( 'Site Settings', 'mysalary' ),
            'menu_title' => __( 'Site Settings', 'mysalary' ),
            'menu_slug'  => 'mysalary-site-settings',
            'capability' => 'manage_options',
            'icon_url'   => 'dashicons-admin-customizer',
            'position'   => 3,
        ] );
    }

    acf_add_local_field_group( [
        'key'      => 'group_site_settings',
        'title'    => 'Site Settings',
        'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'mysalary-site-settings' ] ] ],
        'fields'   => [
            [ 'key' => 'f_settings_demo_url', 'label' => 'Demo page URL',
              'name' => 'demo_url', 'type' => 'url',
              'default_value' => '/request-a-demo/',
              'instructions' => 'Internal URL of the "Request a Demo" page (created automatically when you assign the page template).' ],
            [ 'key' => 'f_settings_app_store_url', 'label' => 'App Store URL', 'name' => 'app_store_url', 'type' => 'url',
              'default_value' => 'https://apps.apple.com/app/id6785230853' ],
            [ 'key' => 'f_settings_play_store_url','label' => 'Google Play URL','name' => 'play_store_url','type' => 'url',
              'default_value' => 'https://play.google.com/store/apps/details?id=io.invento.mysalary' ],
            [ 'key' => 'f_settings_shariah_url', 'label' => 'Shariah certificate URL',
              'name' => 'shariah_certificate_url', 'type' => 'url',
              'instructions' => 'PDF or page linked from the Legal column in the footer.' ],
            [
                'key' => 'f_settings_socials', 'label' => 'Social links', 'name' => 'socials',
                'type' => 'repeater', 'layout' => 'table', 'button_label' => 'Add link',
                'sub_fields' => [
                    [
                        'key' => 'f_setting_social_net', 'label' => 'Network', 'name' => 'network',
                        'type' => 'select',
                        'choices' => [
                            'linkedin'  => 'LinkedIn',
                            'x'         => 'X / Twitter',
                            'instagram' => 'Instagram',
                            'snapchat'  => 'Snapchat',
                            'tiktok'    => 'TikTok',
                            'facebook'  => 'Facebook',
                        ],
                    ],
                    [ 'key' => 'f_setting_social_url', 'label' => 'URL', 'name' => 'url', 'type' => 'url' ],
                ],
            ],
            [ 'key' => 'f_settings_form_recipient', 'label' => 'Form submissions: send notifications to',
              'name' => 'form_recipient', 'type' => 'email',
              'instructions' => 'Where demo, contact, and career submissions are emailed. Defaults to the WordPress admin email.' ],
        ],
    ] );
} );
