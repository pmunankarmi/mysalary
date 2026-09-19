<?php
/**
 * ACF field groups for the secondary page templates:
 * About, Careers, Contact, and Sharia Compliance. The structured page
 * templates use individual fields and repeaters instead of HTML blocks.
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

	/* ================= SHARIA COMPLIANCE ================= */
	$sharia_text = static function ( $key, $label, $name, $default = '', $type = 'text', $width = 50 ) {
		$field = [
			'key'           => 'field_ms_sharia_' . $key,
			'label'         => $label,
			'name'          => $name,
			'type'          => $type,
			'default_value' => $default,
			'wrapper'       => [ 'width' => $width ],
		];

		if ( 'textarea' === $type ) {
			$field['rows']      = 4;
			$field['new_lines'] = '';
		}

		return $field;
	};

	$sharia_tab = static function ( $key, $label ) {
		return [
			'key'       => 'field_ms_sharia_tab_' . $key,
			'label'     => $label,
			'name'      => '',
			'type'      => 'tab',
			'placement' => 'top',
		];
	};

	$sharia_fields = [
		$sharia_tab( 'hero', __( 'Hero & Certification', 'mysalary' ) ),
		$sharia_text( 'hero_eyebrow', 'Eyebrow', 'sharia_hero_eyebrow', 'Sharia governance' ),
		$sharia_text( 'hero_heading', 'Page heading', 'sharia_hero_heading', 'Sharia Compliance' ),
		$sharia_text( 'hero_intro', 'Introduction', 'sharia_hero_intro', 'We are committed to complying with Sharia governance practices such as (but not limited to) the establishment of a Sharia Committee, independence of pronouncement, administration of Sharia audit and Sharia reporting.', 'textarea', 100 ),
		$sharia_text( 'hero_view_label', 'Certificate button label', 'sharia_hero_view_label', 'View Sharia Certificate' ),
		$sharia_text( 'hero_verify_label', 'Verify link label', 'sharia_hero_verify_label', 'Verify the certificate' ),
		$sharia_text( 'certified_by', 'Certified by label', 'sharia_certified_by_label', 'Certified by' ),
		[
			'key'           => 'field_ms_sharia_certification_logo',
			'label'         => 'Certification logo',
			'name'          => 'sharia_certification_logo',
			'type'          => 'image',
			'return_format' => 'array',
			'preview_size'  => 'medium',
			'library'       => 'all',
			'wrapper'       => [ 'width' => 50 ],
		],
		$sharia_text( 'certification_logo_alt', 'Certification logo alternative text', 'sharia_certification_logo_alt', 'Shariyah Review Bureau' ),
		$sharia_text( 'certification_aria', 'Certification card screen-reader label', 'sharia_certification_aria_label', 'Sharia certification' ),
		$sharia_text( 'uid_label', 'UID label', 'sharia_uid_label', 'UID code' ),
		$sharia_text( 'uid_code', 'UID code', 'sharia_uid_code', 'AALC-4749-01-01-06-26' ),

		$sharia_tab( 'governance', __( 'Governance', 'mysalary' ) ),
		$sharia_text( 'governance_heading', 'Section heading', 'sharia_governance_heading', 'Sharia Governance' ),
		$sharia_text( 'governance_intro', 'Section introduction', 'sharia_governance_intro', 'We have appointed Shariyah Review Bureau (SRB) to help us adhere to the best practices and guidelines on Sharia governance.', 'textarea', 100 ),
		[
			'key'          => 'field_ms_sharia_governance_points',
			'label'        => 'Governance points',
			'name'         => 'sharia_governance_points',
			'type'         => 'repeater',
			'layout'       => 'block',
			'button_label' => 'Add governance point',
			'sub_fields'   => [
				[
					'key'     => 'field_ms_sharia_point_icon',
					'label'   => 'Icon',
					'name'    => 'icon',
					'type'    => 'select',
					'choices' => [
						'shield-check' => 'Governance shield',
						'users'        => 'Committee',
						'document'     => 'Audit document',
						'tag'          => 'Product',
						'refresh'      => 'Ongoing alignment',
					],
					'default_value' => 'shield-check',
					'wrapper'       => [ 'width' => 25 ],
				],
				[
					'key'     => 'field_ms_sharia_point_title',
					'label'   => 'Title',
					'name'    => 'title',
					'type'    => 'text',
					'wrapper' => [ 'width' => 75 ],
				],
				[
					'key'   => 'field_ms_sharia_point_text',
					'label' => 'Description',
					'name'  => 'text',
					'type'  => 'textarea',
					'rows'  => 3,
				],
			],
		],

		$sharia_tab( 'committee', __( 'Sharia Committee', 'mysalary' ) ),
		$sharia_text( 'committee_heading', 'Section heading', 'sharia_committee_heading', 'Sharia Committee' ),
		$sharia_text( 'committee_intro', 'Section introduction', 'sharia_committee_intro', 'For the purpose of effective Sharia governance and supervision, a renowned and qualified Sharia scholar has been assigned. The Sharia scholars independently issue pronouncements, and these rulings are binding on us. The names of the Sharia Committee members are provided below:', 'textarea', 100 ),
		[
			'key'          => 'field_ms_sharia_committee_members',
			'label'        => 'Committee members',
			'name'         => 'sharia_committee_members',
			'type'         => 'repeater',
			'layout'       => 'block',
			'button_label' => 'Add committee member',
			'sub_fields'   => [
				[
					'key'     => 'field_ms_sharia_member_name',
					'label'   => 'Name',
					'name'    => 'name',
					'type'    => 'text',
					'wrapper' => [ 'width' => 60 ],
				],
				[
					'key'     => 'field_ms_sharia_member_role',
					'label'   => 'Role',
					'name'    => 'role',
					'type'    => 'text',
					'wrapper' => [ 'width' => 40 ],
				],
				[
					'key'          => 'field_ms_sharia_member_bio',
					'label'        => 'Biography',
					'name'         => 'bio',
					'type'         => 'textarea',
					'rows'         => 9,
					'instructions' => 'Use a blank line between paragraphs. HTML is not required.',
				],
			],
		],

		$sharia_tab( 'certificate', __( 'Certificate', 'mysalary' ) ),
		$sharia_text( 'certificate_heading', 'Section heading', 'sharia_certificate_heading', 'Sharia Certificate', 'text', 100 ),
		[
			'key'           => 'field_ms_sharia_certificate_thumbnail',
			'label'         => 'Certificate thumbnail',
			'name'          => 'sharia_certificate_thumbnail',
			'type'          => 'image',
			'return_format' => 'array',
			'preview_size'  => 'medium',
			'wrapper'       => [ 'width' => 50 ],
		],
		[
			'key'           => 'field_ms_sharia_certificate_pdf',
			'label'         => 'Certificate PDF',
			'name'          => 'sharia_certificate_pdf',
			'type'          => 'file',
			'return_format' => 'array',
			'mime_types'    => 'pdf',
			'wrapper'       => [ 'width' => 50 ],
		],
		$sharia_text( 'certificate_thumbnail_alt', 'Thumbnail alternative text', 'sharia_certificate_thumbnail_alt', 'First page of the Opinion on Sharia Compliance issued by Shariyah Review Bureau for the MySalary Earned Wage Access Service', 'textarea', 100 ),
		$sharia_text( 'certificate_preview_label', 'Preview overlay label', 'sharia_certificate_preview_label', 'View certificate' ),
		$sharia_text( 'certificate_title', 'Certificate title', 'sharia_certificate_title', 'Opinion on Sharia Compliance' ),
		$sharia_text( 'issued_by_label', 'Issued by label', 'sharia_issued_by_label', 'Issued by' ),
		$sharia_text( 'issued_by_value', 'Issued by value', 'sharia_issued_by_value', 'Shariyah Review Bureau (SRB)' ),
		$sharia_text( 'product_label', 'Product label', 'sharia_product_label', 'Product' ),
		$sharia_text( 'product_value', 'Product value', 'sharia_product_value', 'MySalary Earned Wage Access Service' ),
		$sharia_text( 'company_label', 'Company label', 'sharia_company_label', 'Company' ),
		$sharia_text( 'company_value', 'Company value', 'sharia_company_value', 'Alajur Alraqmia Liltiqniat Company' ),
		$sharia_text( 'date_label', 'Date label', 'sharia_date_label', 'Date' ),
		$sharia_text( 'date_value', 'Date value', 'sharia_date_value', '26 June 2026' ),
		$sharia_text( 'copy_label', 'Copy button label', 'sharia_copy_label', 'Copy' ),
		$sharia_text( 'copied_label', 'Copied button label', 'sharia_copied_label', 'Copied' ),
		$sharia_text( 'copied_status', 'Screen-reader copied message', 'sharia_copied_status', 'UID code copied' ),
		$sharia_text( 'view_button_label', 'View button label', 'sharia_view_button_label', 'View certificate' ),
		$sharia_text( 'download_button_label', 'Download button label', 'sharia_download_button_label', 'Download PDF' ),

		$sharia_tab( 'verification', __( 'Verification & Viewer', 'mysalary' ) ),
		$sharia_text( 'verify_heading', 'Verification heading', 'sharia_verify_heading', 'Verify the certificate' ),
		$sharia_text( 'verify_before_uid', 'Verification text before UID', 'sharia_verify_before_uid', 'The authenticity of this document and list of documents approved can be verified at shariyah.net using UID code', 'textarea', 100 ),
		$sharia_text( 'verify_after_uid', 'Verification text after UID', 'sharia_verify_after_uid', '.', 'text', 100 ),
		$sharia_text( 'verify_button_label', 'Verification button label', 'sharia_verify_button_label', 'Verify on shariyah.net' ),
		[
			'key'           => 'field_ms_sharia_verify_url',
			'label'         => 'Verification URL',
			'name'          => 'sharia_verify_url',
			'type'          => 'url',
			'default_value' => 'https://shariyah.net/verify-your-certificate/',
			'wrapper'       => [ 'width' => 50 ],
		],
		$sharia_text( 'viewer_title', 'Viewer title', 'sharia_viewer_title', 'Sharia Certificate' ),
		$sharia_text( 'viewer_subtitle', 'Viewer subtitle', 'sharia_viewer_subtitle', 'Shariyah Review Bureau · 5 pages' ),
		$sharia_text( 'viewer_download_label', 'Viewer download label', 'sharia_viewer_download_label', 'Download' ),
		$sharia_text( 'viewer_verify_label', 'Viewer verify label', 'sharia_viewer_verify_label', 'Verify' ),
		$sharia_text( 'viewer_close_label', 'Viewer close screen-reader label', 'sharia_viewer_close_label', 'Close certificate' ),
		$sharia_text( 'viewer_pages_label', 'Viewer pages screen-reader label', 'sharia_viewer_pages_label', 'Certificate pages' ),
		$sharia_text( 'viewer_caption_format', 'Page caption format', 'sharia_viewer_caption_format', 'Page %1$d of %2$d', 'text', 50 ),
		$sharia_text( 'viewer_alt_format', 'Page image alternative-text format', 'sharia_viewer_alt_format', 'Certificate page %1$d of %2$d', 'text', 50 ),
		[
			'key'          => 'field_ms_sharia_certificate_pages',
			'label'        => 'Certificate pages',
			'name'         => 'sharia_certificate_pages',
			'type'         => 'repeater',
			'layout'       => 'block',
			'button_label' => 'Add certificate page',
			'instructions' => 'Optional. Leave empty to use the five certificate images bundled with the theme.',
			'sub_fields'   => [
				[
					'key'           => 'field_ms_sharia_page_image',
					'label'         => 'Page image',
					'name'          => 'image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				],
				[
					'key'   => 'field_ms_sharia_page_alt',
					'label' => 'Alternative text',
					'name'  => 'alt',
					'type'  => 'text',
				],
				[
					'key'   => 'field_ms_sharia_page_caption',
					'label' => 'Caption',
					'name'  => 'caption',
					'type'  => 'text',
				],
			],
		],
	];

	acf_add_local_field_group( [
		'key'                   => 'group_ms_sharia_compliance',
		'title'                 => __( 'Sharia Compliance Page — Content', 'mysalary' ),
		'fields'                => $sharia_fields,
		'location'              => [
			[
				[
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => 'page-templates/template-sharia-compliance.php',
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

} );
