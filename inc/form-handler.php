<?php
/**
 * AJAX form handling and the unified Form Submissions admin screen.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Supported form types.
 *
 * @return array<string,string>
 */
function mysalary_submission_types() {
	return [
		'demo'    => __( 'Demo Request', 'mysalary' ),
		'contact' => __( 'Contact Message', 'mysalary' ),
		'career'  => __( 'Career Application', 'mysalary' ),
	];
}

/**
 * Field labels used by admin details, email, and CSV export.
 *
 * @return array<string,array<string,string>>
 */
function mysalary_submission_fields() {
	return [
		'demo' => [
			'name'      => __( 'Name', 'mysalary' ),
			'job_title' => __( 'Job Title', 'mysalary' ),
			'email'     => __( 'Email', 'mysalary' ),
			'phone'     => __( 'Phone', 'mysalary' ),
			'company'   => __( 'Company', 'mysalary' ),
			'country'   => __( 'Country', 'mysalary' ),
			'employees' => __( 'Employees', 'mysalary' ),
		],
		'contact' => [
			'name'    => __( 'Name', 'mysalary' ),
			'company' => __( 'Company', 'mysalary' ),
			'email'   => __( 'Email', 'mysalary' ),
			'phone'   => __( 'Phone', 'mysalary' ),
			'subject' => __( 'Subject', 'mysalary' ),
			'message' => __( 'Message', 'mysalary' ),
		],
		'career' => [
			'name'      => __( 'Name', 'mysalary' ),
			'email'     => __( 'Email', 'mysalary' ),
			'phone'     => __( 'Phone', 'mysalary' ),
			'position'  => __( 'Position', 'mysalary' ),
			'portfolio' => __( 'LinkedIn Profile', 'mysalary' ),
			'message'   => __( 'Message', 'mysalary' ),
			'cv'        => __( 'CV', 'mysalary' ),
		],
	];
}

/** Register the private submission record type. */
add_action( 'init', function () {
	register_post_type( 'ms_submission', [
		'labels' => [
			'name'               => __( 'Form Submissions', 'mysalary' ),
			'singular_name'      => __( 'Form Submission', 'mysalary' ),
			'menu_name'          => __( 'Form Submissions', 'mysalary' ),
			'all_items'          => __( 'All Submissions', 'mysalary' ),
			'search_items'       => __( 'Search Submissions', 'mysalary' ),
			'not_found'          => __( 'No submissions found.', 'mysalary' ),
			'not_found_in_trash' => __( 'No submissions found in Trash.', 'mysalary' ),
		],
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-email-alt',
		'menu_position'       => 25,
		'capability_type'     => 'post',
		'map_meta_cap'        => true,
		'capabilities'        => [ 'create_posts' => 'do_not_allow' ],
		'supports'            => [ 'title' ],
		'exclude_from_search' => true,
		'show_in_rest'        => false,
	] );
} );

/** Move records created by the earlier demo-only theme into the unified list. */
add_action( 'admin_init', function () {
	if ( get_option( 'mysalary_submission_migration_120' ) ) {
		return;
	}

	$legacy_ids = get_posts( [
		'post_type'        => 'demo_request',
		'post_status'      => 'any',
		'posts_per_page'   => -1,
		'fields'           => 'ids',
		'suppress_filters' => true,
	] );

	foreach ( $legacy_ids as $legacy_id ) {
		wp_update_post( [ 'ID' => $legacy_id, 'post_type' => 'ms_submission' ] );
		update_post_meta( $legacy_id, 'submission_type', 'demo' );
	}

	update_option( 'mysalary_submission_migration_120', 1, false );
} );

/** Remove an uploaded CV when its career submission is permanently deleted. */
add_action( 'before_delete_post', function ( $post_id ) {
	if ( 'ms_submission' !== get_post_type( $post_id ) || 'career' !== get_post_meta( $post_id, 'submission_type', true ) ) {
		return;
	}

	$attachment_id = (int) get_post_meta( $post_id, 'cv_id', true );
	if ( $attachment_id ) {
		wp_delete_attachment( $attachment_id, true );
	}
} );

/** Read-only details on an individual submission. */
add_action( 'add_meta_boxes_ms_submission', function () {
	add_meta_box(
		'mysalary_submission_details',
		__( 'Submitted Data', 'mysalary' ),
		function ( $post ) {
			$type       = get_post_meta( $post->ID, 'submission_type', true );
			$all_fields = mysalary_submission_fields();
			$fields     = isset( $all_fields[ $type ] ) ? $all_fields[ $type ] : [];

			echo '<table class="widefat striped"><tbody>';
			echo '<tr><th style="width:220px">' . esc_html__( 'Form', 'mysalary' ) . '</th><td>' . esc_html( isset( mysalary_submission_types()[ $type ] ) ? mysalary_submission_types()[ $type ] : $type ) . '</td></tr>';

			foreach ( $fields as $key => $label ) {
				$value = get_post_meta( $post->ID, $key, true );
				if ( 'cv' === $key && $value ) {
					$value = '<a href="' . esc_url( $value ) . '" target="_blank" rel="noopener">' . esc_html__( 'Download CV', 'mysalary' ) . '</a>';
				} else {
					$value = nl2br( esc_html( $value ) );
				}
				echo '<tr><th>' . esc_html( $label ) . '</th><td>' . $value . '</td></tr>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			echo '<tr><th>' . esc_html__( 'Language', 'mysalary' ) . '</th><td>' . esc_html( strtoupper( get_post_meta( $post->ID, 'lang', true ) ) ) . '</td></tr>';
			echo '<tr><th>' . esc_html__( 'Submitted', 'mysalary' ) . '</th><td>' . esc_html( get_post_meta( $post->ID, 'submitted', true ) ) . '</td></tr>';
			echo '</tbody></table>';
		},
		'ms_submission',
		'normal',
		'high'
	);
} );

/** Admin list columns. */
add_filter( 'manage_ms_submission_posts_columns', function ( $columns ) {
	return [
		'cb'              => isset( $columns['cb'] ) ? $columns['cb'] : '<input type="checkbox" />',
		'title'           => __( 'Submission', 'mysalary' ),
		'submission_type' => __( 'Form', 'mysalary' ),
		'email'           => __( 'Email', 'mysalary' ),
		'phone'           => __( 'Phone', 'mysalary' ),
		'context'         => __( 'Company / Position', 'mysalary' ),
		'lang'            => __( 'Language', 'mysalary' ),
		'date'            => __( 'Date', 'mysalary' ),
	];
} );

add_action( 'manage_ms_submission_posts_custom_column', function ( $column, $post_id ) {
	$type = get_post_meta( $post_id, 'submission_type', true );

	switch ( $column ) {
		case 'submission_type':
			$types = mysalary_submission_types();
			echo esc_html( isset( $types[ $type ] ) ? $types[ $type ] : $type );
			break;
		case 'email':
			$email = get_post_meta( $post_id, 'email', true );
			echo $email ? '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' : '&mdash;';
			break;
		case 'phone':
			echo esc_html( get_post_meta( $post_id, 'phone', true ) ?: '—' );
			break;
		case 'context':
			$value = 'career' === $type ? get_post_meta( $post_id, 'position', true ) : get_post_meta( $post_id, 'company', true );
			echo esc_html( $value ?: '—' );
			break;
		case 'lang':
			echo esc_html( strtoupper( get_post_meta( $post_id, 'lang', true ) ) ?: '—' );
			break;
	}
}, 10, 2 );

/** Filter the admin list by any of the three forms. */
add_action( 'restrict_manage_posts', function ( $post_type ) {
	if ( 'ms_submission' !== $post_type ) {
		return;
	}

	$current = isset( $_GET['submission_type'] ) ? sanitize_key( wp_unslash( $_GET['submission_type'] ) ) : '';
	echo '<select name="submission_type">';
	echo '<option value="">' . esc_html__( 'All forms', 'mysalary' ) . '</option>';
	foreach ( mysalary_submission_types() as $key => $label ) {
		echo '<option value="' . esc_attr( $key ) . '" ' . selected( $current, $key, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select>';
} );

add_action( 'pre_get_posts', function ( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() || 'ms_submission' !== $query->get( 'post_type' ) ) {
		return;
	}

	$type = isset( $_GET['submission_type'] ) ? sanitize_key( wp_unslash( $_GET['submission_type'] ) ) : '';
	if ( isset( mysalary_submission_types()[ $type ] ) ) {
		$query->set( 'meta_key', 'submission_type' );
		$query->set( 'meta_value', $type );
	}
} );

/** Add the CSV button above the unified list. */
add_action( 'manage_posts_extra_tablenav', function ( $which ) {
	global $typenow;
	if ( 'ms_submission' !== $typenow || 'top' !== $which ) {
		return;
	}

	$type = isset( $_GET['submission_type'] ) ? sanitize_key( wp_unslash( $_GET['submission_type'] ) ) : '';
	$url  = wp_nonce_url(
		add_query_arg(
			[ 'action' => 'mysalary_export_submissions', 'submission_type' => $type ],
			admin_url( 'admin-post.php' )
		),
		'mysalary_export_submissions'
	);

	echo '<div class="alignleft actions"><a class="button button-primary" href="' . esc_url( $url ) . '">' . esc_html__( 'Export to CSV', 'mysalary' ) . '</a></div>';
} );

/** CSV-safe cell value. */
function mysalary_csv_value( $value ) {
	$value = (string) $value;
	return preg_match( '/^[=+\-@\t\r]/', $value ) ? "'" . $value : $value;
}

/** Export all submissions, or the currently filtered type, to UTF-8 CSV. */
add_action( 'admin_post_mysalary_export_submissions', function () {
	if ( ! current_user_can( 'edit_others_posts' ) ) {
		wp_die( esc_html__( 'You are not allowed to export submissions.', 'mysalary' ), '', [ 'response' => 403 ] );
	}

	check_admin_referer( 'mysalary_export_submissions' );
	$type  = isset( $_GET['submission_type'] ) ? sanitize_key( wp_unslash( $_GET['submission_type'] ) ) : '';
	$args  = [
		'post_type'      => 'ms_submission',
		'post_status'    => 'private',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'no_found_rows'  => true,
	];

	if ( isset( mysalary_submission_types()[ $type ] ) ) {
		$args['meta_key']   = 'submission_type';
		$args['meta_value'] = $type;
	} else {
		$type = 'all';
	}

	$posts = get_posts( $args );
	$keys  = [ 'name', 'job_title', 'email', 'phone', 'company', 'country', 'employees', 'subject', 'position', 'portfolio', 'message', 'cv', 'lang', 'submitted' ];

	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename="mysalary-submissions-' . $type . '-' . gmdate( 'Y-m-d' ) . '.csv"' );
	$output = fopen( 'php://output', 'w' );
	if ( false === $output ) {
		wp_die( esc_html__( 'Could not create the export.', 'mysalary' ) );
	}

	fwrite( $output, "\xEF\xBB\xBF" );
	fputcsv( $output, array_merge( [ 'ID', 'Form' ], array_map( 'ucwords', array_map( function ( $key ) { return str_replace( '_', ' ', $key ); }, $keys ) ) ) );

	foreach ( $posts as $post ) {
		$post_type = get_post_meta( $post->ID, 'submission_type', true );
		$types     = mysalary_submission_types();
		$row       = [ $post->ID, isset( $types[ $post_type ] ) ? $types[ $post_type ] : $post_type ];
		foreach ( $keys as $key ) {
			$row[] = get_post_meta( $post->ID, $key, true );
		}
		fputcsv( $output, array_map( 'mysalary_csv_value', $row ) );
	}

	fclose( $output );
	exit;
} );

/** Safely read a text field from the current request. */
function mysalary_form_text_value( $key ) {
	return isset( $_POST[ $key ] ) && is_string( $_POST[ $key ] )
		? sanitize_text_field( wp_unslash( $_POST[ $key ] ) )
		: '';
}

/** Current Polylang language slug, when available. */
function mysalary_submission_language() {
	if ( isset( $_POST['lang'] ) && is_string( $_POST['lang'] ) ) {
		$lang = sanitize_key( wp_unslash( $_POST['lang'] ) );
		if ( in_array( $lang, [ 'en', 'ar' ], true ) ) {
			return $lang;
		}
	}

	return function_exists( 'pll_current_language' ) ? (string) pll_current_language( 'slug' ) : '';
}

/** Shared request checks. Returns the transient key to set on success. */
function mysalary_verify_form_request( $type ) {
	if ( 'POST' !== strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) ) {
		wp_send_json_error( [ 'message' => __( 'Invalid request method.', 'mysalary' ) ], 405 );
	}

	if ( false === check_ajax_referer( 'mysalary_forms', 'mysalary_nonce', false ) ) {
		wp_send_json_error( [ 'message' => mysalary_form_string( 'form_error_security', 'Security check failed. Please refresh the page and try again.', 'فشل التحقق الأمني. يرجى تحديث الصفحة والمحاولة مرة أخرى.' ) ], 403 );
	}

	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_success( [ 'message' => 'OK' ] );
	}

	$remote = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$key    = 'mysalary_form_' . hash( 'sha256', $type . '|' . $remote . '|' . wp_salt( 'nonce' ) );
	if ( get_transient( $key ) ) {
		wp_send_json_error( [ 'message' => mysalary_form_string( 'form_error_rate', 'Please wait a moment before submitting again.', 'يرجى الانتظار قليلًا قبل الإرسال مرة أخرى.' ) ], 429 );
	}

	return $key;
}

/** Store one form submission. */
function mysalary_create_submission( $type, $title, $fields ) {
	if ( ! isset( mysalary_submission_types()[ $type ] ) ) {
		return new WP_Error( 'invalid_submission_type', __( 'Invalid form type.', 'mysalary' ) );
	}

	$meta = array_merge(
		$fields,
		[
			'submission_type' => $type,
			'submitted'       => current_time( 'mysql' ),
			'lang'            => mysalary_submission_language(),
		]
	);

	return wp_insert_post(
		[
			'post_type'   => 'ms_submission',
			'post_status' => 'private',
			'post_title'  => $title,
			'meta_input'  => $meta,
		],
		true
	);
}

/** Send the stored data to the configured recipient. */
function mysalary_email_submission( $type, $fields, $attachment_id = 0 ) {
	$types     = mysalary_submission_types();
	$all       = mysalary_submission_fields();
	$recipient = function_exists( 'get_field' ) ? get_field( 'form_recipient', 'option' ) : '';
	$recipient = $recipient && is_email( $recipient ) ? $recipient : get_option( 'admin_email' );
	$subject   = sprintf( '[MySalary] %s — %s', isset( $types[ $type ] ) ? $types[ $type ] : $type, isset( $fields['name'] ) ? $fields['name'] : '' );
	$body      = '<h2>' . esc_html( isset( $types[ $type ] ) ? $types[ $type ] : $type ) . '</h2><table cellpadding="7" cellspacing="0" border="0">';

	foreach ( isset( $all[ $type ] ) ? $all[ $type ] : [] as $key => $label ) {
		$value = isset( $fields[ $key ] ) ? $fields[ $key ] : '';
		if ( ! $value ) {
			continue;
		}
		if ( 'cv' === $key ) {
			$value = '<a href="' . esc_url( $value ) . '">' . esc_html__( 'Download CV', 'mysalary' ) . '</a>';
		} else {
			$value = nl2br( esc_html( $value ) );
		}
		$body .= '<tr><th align="left">' . esc_html( $label ) . '</th><td>' . $value . '</td></tr>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	$body .= '</table>';

	$headers = [ 'Content-Type: text/html; charset=UTF-8' ];
	if ( ! empty( $fields['email'] ) && is_email( $fields['email'] ) ) {
		$headers[] = 'Reply-To: ' . sanitize_text_field( $fields['name'] ) . ' <' . sanitize_email( $fields['email'] ) . '>';
	}
	$attachments = $attachment_id ? [ get_attached_file( $attachment_id ) ] : [];

	return wp_mail( $recipient, $subject, $body, $headers, array_filter( $attachments ) );
}

/** Send a short confirmation to the submitter. */
function mysalary_email_confirmation( $email, $name, $message ) {
	if ( ! is_email( $email ) ) {
		return false;
	}
	$body = '<p>' . sprintf( esc_html__( 'Hi %s,', 'mysalary' ), esc_html( $name ) ) . '</p><p>' . esc_html( $message ) . '</p>';
	return wp_mail( $email, __( 'We received your submission — MySalary', 'mysalary' ), $body, [ 'Content-Type: text/html; charset=UTF-8' ] );
}

/** Demo request. */
function mysalary_handle_demo_submit() {
	$rate_key  = mysalary_verify_form_request( 'demo' );
	$name      = mysalary_form_text_value( 'name' );
	$job_title = mysalary_form_text_value( 'jobTitle' );
	$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone     = mysalary_form_text_value( 'phone' );
	$company   = mysalary_form_text_value( 'company' );
	$country   = mysalary_form_text_value( 'country' );
	$employees = mysalary_form_text_value( 'employees' );
	$agree     = ! empty( $_POST['agree'] );
	$errors    = [];

	if ( ! $name ) $errors['name'] = mysalary_form_string( 'form_error_name', 'Name is required.', 'الاسم مطلوب.' );
	if ( ! is_email( $email ) ) $errors['email'] = mysalary_form_string( 'form_error_email', 'Enter a valid email.', 'يرجى إدخال بريد إلكتروني صحيح.' );
	if ( strlen( preg_replace( '/\D/', '', $phone ) ) < 7 ) $errors['phone'] = mysalary_form_string( 'form_error_phone', 'A valid phone number is required.', 'يرجى إدخال رقم جوال صحيح.' );
	if ( ! $agree ) $errors['agree'] = mysalary_form_string( 'form_error_terms', 'You must accept the terms.', 'يجب الموافقة على الشروط.' );
	if ( $errors ) wp_send_json_error( [ 'errors' => $errors, 'message' => mysalary_form_string( 'form_error_fields', 'Please fix the highlighted fields.', 'يرجى تصحيح الحقول المحددة.' ) ], 422 );

	$fields  = compact( 'name', 'job_title', 'email', 'phone', 'company', 'country', 'employees' );
	$post_id = mysalary_create_submission( 'demo', sprintf( '%s — %s', $name, $company ?: $email ), $fields );
	if ( is_wp_error( $post_id ) ) wp_send_json_error( [ 'message' => mysalary_form_string( 'form_error_save', 'Could not save the request. Please try again.', 'تعذر حفظ الطلب. يرجى المحاولة مرة أخرى.' ) ], 500 );

	set_transient( $rate_key, 1, MINUTE_IN_SECONDS );
	mysalary_email_submission( 'demo', $fields );
	mysalary_email_confirmation( $email, $name, mysalary_form_string( 'demo_confirmation', 'Thanks for requesting a demo. A specialist will contact you within one business day.', 'شكرًا لطلب العرض التوضيحي. سيتواصل معك أحد المختصين خلال يوم عمل واحد.' ) );
	wp_send_json_success( [ 'message' => mysalary_form_string( 'form_success', '✓ Request received', '✓ تم استلام الطلب' ) ] );
}
add_action( 'wp_ajax_mysalary_demo_submit', 'mysalary_handle_demo_submit' );
add_action( 'wp_ajax_nopriv_mysalary_demo_submit', 'mysalary_handle_demo_submit' );

/** Contact message. */
function mysalary_handle_contact_submit() {
	$rate_key = mysalary_verify_form_request( 'contact' );
	$name     = mysalary_form_text_value( 'name' );
	$company  = mysalary_form_text_value( 'company' );
	$email    = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone    = mysalary_form_text_value( 'phone' );
	$subject  = mysalary_form_text_value( 'subject' );
	$message  = isset( $_POST['message'] ) && is_string( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$errors   = [];

	if ( ! $name ) $errors['name'] = mysalary_form_string( 'form_error_name', 'Name is required.', 'الاسم مطلوب.' );
	if ( ! is_email( $email ) ) $errors['email'] = mysalary_form_string( 'form_error_email', 'Enter a valid email.', 'يرجى إدخال بريد إلكتروني صحيح.' );
	if ( ! $message ) $errors['message'] = mysalary_form_string( 'contact_error_message', 'Message is required.', 'الرسالة مطلوبة.' );
	if ( $phone && strlen( preg_replace( '/\D/', '', $phone ) ) < 7 ) $errors['phone'] = mysalary_form_string( 'form_error_phone', 'A valid phone number is required.', 'يرجى إدخال رقم جوال صحيح.' );
	if ( $errors ) wp_send_json_error( [ 'errors' => $errors, 'message' => mysalary_form_string( 'form_error_fields', 'Please fix the highlighted fields.', 'يرجى تصحيح الحقول المحددة.' ) ], 422 );

	$fields  = compact( 'name', 'company', 'email', 'phone', 'subject', 'message' );
	$post_id = mysalary_create_submission( 'contact', sprintf( '%s — %s', $name, $subject ?: $email ), $fields );
	if ( is_wp_error( $post_id ) ) wp_send_json_error( [ 'message' => mysalary_form_string( 'form_error_save', 'Could not save the request. Please try again.', 'تعذر حفظ الطلب. يرجى المحاولة مرة أخرى.' ) ], 500 );

	set_transient( $rate_key, 1, MINUTE_IN_SECONDS );
	mysalary_email_submission( 'contact', $fields );
	$success = mysalary_form_string( 'contact_success', 'Thank you. Your message has been sent.', 'شكرًا لك. تم إرسال رسالتك بنجاح.' );
	mysalary_email_confirmation( $email, $name, $success );
	wp_send_json_success( [ 'message' => $success ] );
}
add_action( 'wp_ajax_mysalary_contact_submit', 'mysalary_handle_contact_submit' );
add_action( 'wp_ajax_nopriv_mysalary_contact_submit', 'mysalary_handle_contact_submit' );

/** Validate and upload a career CV, returning an attachment ID or WP_Error. */
function mysalary_upload_career_cv() {
	if ( empty( $_FILES['cv'] ) || ! is_array( $_FILES['cv'] ) ) {
		return new WP_Error( 'missing_cv', mysalary_form_string( 'career_error_cv', 'Please upload your CV.', 'يرجى رفع السيرة الذاتية.' ) );
	}
	$file = $_FILES['cv'];
	if ( ! isset( $file['error'], $file['size'], $file['name'] ) || is_array( $file['error'] ) || is_array( $file['size'] ) || is_array( $file['name'] ) ) {
		return new WP_Error( 'invalid_cv_upload', mysalary_form_string( 'career_error_cv_upload', 'The CV could not be uploaded. Please try again.', 'تعذر رفع السيرة الذاتية. يرجى المحاولة مرة أخرى.' ) );
	}
	if ( UPLOAD_ERR_OK !== (int) $file['error'] ) {
		return new WP_Error( 'upload_error', mysalary_form_string( 'career_error_cv_upload', 'The CV could not be uploaded. Please try again.', 'تعذر رفع السيرة الذاتية. يرجى المحاولة مرة أخرى.' ) );
	}
	if ( (int) $file['size'] > 5 * MB_IN_BYTES ) {
		return new WP_Error( 'cv_too_large', mysalary_form_string( 'career_error_cv_size', 'The CV must be 5 MB or smaller.', 'يجب ألا يتجاوز حجم السيرة الذاتية 5 ميجابايت.' ) );
	}

	$allowed = [
		'pdf'  => 'application/pdf',
		'doc'  => 'application/msword',
		'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	];
	$name    = isset( $file['name'] ) ? sanitize_file_name( $file['name'] ) : '';
	$ext     = strtolower( pathinfo( $name, PATHINFO_EXTENSION ) );
	if ( ! isset( $allowed[ $ext ] ) ) {
		return new WP_Error( 'invalid_cv_type', mysalary_form_string( 'career_error_cv_type', 'Upload a PDF, DOC, or DOCX file.', 'يرجى رفع ملف بصيغة PDF أو DOC أو DOCX.' ) );
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	return media_handle_upload( 'cv', 0, [], [ 'test_form' => false, 'mimes' => $allowed ] );
}

/** Career application. */
function mysalary_handle_career_submit() {
	$rate_key = mysalary_verify_form_request( 'career' );
	$name      = mysalary_form_text_value( 'name' );
	$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone     = mysalary_form_text_value( 'phone' );
	$position  = mysalary_form_text_value( 'position' );
	$portfolio = isset( $_POST['portfolio'] ) ? esc_url_raw( wp_unslash( $_POST['portfolio'] ) ) : '';
	$message   = isset( $_POST['message'] ) && is_string( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$errors    = [];

	if ( ! $name ) $errors['name'] = mysalary_form_string( 'form_error_name', 'Name is required.', 'الاسم مطلوب.' );
	if ( ! is_email( $email ) ) $errors['email'] = mysalary_form_string( 'form_error_email', 'Enter a valid email.', 'يرجى إدخال بريد إلكتروني صحيح.' );
	if ( strlen( preg_replace( '/\D/', '', $phone ) ) < 7 ) $errors['phone'] = mysalary_form_string( 'form_error_phone', 'A valid phone number is required.', 'يرجى إدخال رقم جوال صحيح.' );
	if ( ! $position ) $errors['position'] = mysalary_form_string( 'career_error_position', 'Position is required.', 'الوظيفة المتقدم لها مطلوبة.' );
	if ( $errors ) wp_send_json_error( [ 'errors' => $errors, 'message' => mysalary_form_string( 'form_error_fields', 'Please fix the highlighted fields.', 'يرجى تصحيح الحقول المحددة.' ) ], 422 );

	$attachment_id = mysalary_upload_career_cv();
	if ( is_wp_error( $attachment_id ) ) {
		wp_send_json_error( [ 'errors' => [ 'cv' => $attachment_id->get_error_message() ], 'message' => $attachment_id->get_error_message() ], 422 );
	}
	$cv     = wp_get_attachment_url( $attachment_id );
	$fields = compact( 'name', 'email', 'phone', 'position', 'portfolio', 'message', 'cv' );
	$post_id = mysalary_create_submission( 'career', sprintf( '%s — %s', $name, $position ), $fields );
	if ( is_wp_error( $post_id ) ) {
		wp_delete_attachment( $attachment_id, true );
		wp_send_json_error( [ 'message' => mysalary_form_string( 'form_error_save', 'Could not save the request. Please try again.', 'تعذر حفظ الطلب. يرجى المحاولة مرة أخرى.' ) ], 500 );
	}
	update_post_meta( $post_id, 'cv_id', $attachment_id );

	set_transient( $rate_key, 1, MINUTE_IN_SECONDS );
	mysalary_email_submission( 'career', $fields, $attachment_id );
	$success = mysalary_form_string( 'career_success', 'Thank you. Your application has been submitted.', 'شكرًا لك. تم إرسال طلب التوظيف بنجاح.' );
	mysalary_email_confirmation( $email, $name, $success );
	wp_send_json_success( [ 'message' => $success ] );
}
add_action( 'wp_ajax_mysalary_career_submit', 'mysalary_handle_career_submit' );
add_action( 'wp_ajax_nopriv_mysalary_career_submit', 'mysalary_handle_career_submit' );
