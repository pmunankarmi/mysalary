<?php
/**
 * ACF field groups for the secondary page templates:
 * About, Careers, Contact. Kept lean — long-form copy uses the normal
 * WordPress editor (post_content); only the structured, repeatable
 * bits get their own fields.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

	/* ================= ABOUT ================= */
	acf_add_local_field_group(
		[
			'key'   => 'group_ms_about',
			'title' => __( 'About Page — Content', 'mysalary' ),

			'fields' => [
				[
					'key'   => 'field_ms_about_eyebrow',
					'label' => __( 'Eyebrow', 'mysalary' ),
					'name'  => 'about_eyebrow',
					'type'  => 'text',
				],
				[
					'key'   => 'field_ms_about_heading',
					'label' => __( 'Heading', 'mysalary' ),
					'name'  => 'about_heading',
					'type'  => 'textarea',
				],
			],

			'location' => [
				[
					[
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/template-about.php',
					],
				],
			],

			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'seamless',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => 0,
		]
	);
	/* ================= CAREERS ================= */
	acf_add_local_field_group( [
		'key'   => 'group_ms_careers',
		'title' => __( 'Careers Page — Content', 'mysalary' ),

		'fields' => [
			[
				'key'   => 'field_ms_careers_heading',
				'label' => __( 'Heading', 'mysalary' ),
				'name'  => 'careers_heading',
				'type'  => 'text',
			],
			[
				'key'   => 'field_ms_careers_why_heading',
				'label' => __( 'Why Us Heading', 'mysalary' ),
				'name'  => 'careers_why_heading',
				'type'  => 'text',
			],
			[
				'key'          => 'field_ms_careers_why_points',
				'label'        => __( 'Why Us Bullet Points', 'mysalary' ),
				'name'         => 'careers_why_points',
				'type'         => 'repeater',
				'layout'       => 'table',
				'button_label' => __( 'Add Point', 'mysalary' ),

				'sub_fields' => [
					[
						'key'   => 'field_ms_careers_why_text',
						'label' => __( 'Text', 'mysalary' ),
						'name'  => 'text',
						'type'  => 'text',
					],
				],
			],
			[
				'key'   => 'field_ms_careers_form_heading',
				'label' => __( 'Application Form Heading', 'mysalary' ),
				'name'  => 'careers_form_heading',
				'type'  => 'text',
			],
			[
				'key'   => 'field_ms_careers_success_text',
				'label' => __( 'Success Message', 'mysalary' ),
				'name'  => 'careers_success_text',
				'type'  => 'text',
			],
		],

		'location' => [
			[
				[
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => 'page-templates/template-careers.php',
				],
			],
		],

		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'seamless',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'active'                => true,
		'show_in_rest'          => 0,
	] );

	/* ================= CONTACT ================= */
	acf_add_local_field_group( array(
		'key'    => 'group_ms_contact',
		'title'  => __( 'Contact Page — Content', 'mysalary' ),
		'fields' => array(
			array( 'key' => 'field_ms_contact_eyebrow', 'label' => 'Eyebrow', 'name' => 'contact_eyebrow', 'type' => 'text' ),
			array( 'key' => 'field_ms_contact_heading', 'label' => 'Heading', 'name' => 'contact_heading', 'type' => 'text' ),
			array( 'key' => 'field_ms_contact_intro', 'label' => 'Intro copy', 'name' => 'contact_intro', 'type' => 'textarea', 'rows' => 3 ),
			array( 'key' => 'field_ms_contact_form_heading', 'label' => 'Form heading', 'name' => 'contact_form_heading', 'type' => 'text' ),
			array( 'key' => 'field_ms_contact_details_heading', 'label' => 'Contact details heading', 'name' => 'contact_details_heading', 'type' => 'text' ),
			array( 'key' => 'field_ms_contact_email', 'label' => 'Email address', 'name' => 'contact_email', 'type' => 'email' ),
			array( 'key' => 'field_ms_contact_address', 'label' => 'Address', 'name' => 'contact_address', 'type' => 'textarea', 'rows' => 3 ),
			array( 'key' => 'field_ms_contact_map_link', 'label' => 'Google Maps link', 'name' => 'contact_map_link', 'type' => 'url' ),
			array( 'key' => 'field_ms_contact_success_text', 'label' => 'Success message', 'name' => 'contact_success_text', 'type' => 'text' ),
		),
		'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-templates/template-contact.php' ) ) ),
		'style' => 'seamless',
	) );

} );
