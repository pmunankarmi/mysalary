<?php
/**
 * Template Name: Contact
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$eyebrow         = mysalary_field( 'contact_eyebrow' );
$heading         = mysalary_field( 'contact_heading' );
$intro           = mysalary_field( 'contact_intro' );
$form_heading    = mysalary_field( 'contact_form_heading' );
$details_heading = mysalary_field( 'contact_details_heading' );
$email           = mysalary_field( 'contact_email' );
$address         = mysalary_field( 'contact_address' );
$map_link        = mysalary_field( 'contact_map_link' );
$success_text    = mysalary_field(
	'contact_success_text',
	false,
	mysalary_form_string( 'contact_success', 'Thank you. Your message has been sent.', 'شكرًا لك. تم إرسال رسالتك بنجاح.' )
);
?>
<section class="ms-section ms-contact">
	<div class="ms-container" style="padding-top:60px;">
		<?php if ( $eyebrow ) : ?>
			<span class="ms-hero__eyebrow"><span class="ms-hero__eyebrow-dot"></span><?php echo esc_html( $eyebrow ); ?></span>
		<?php endif; ?>
		<?php if ( $heading ) : ?><h1><?php echo esc_html( $heading ); ?></h1><?php endif; ?>
		<?php if ( $intro ) : ?><p><?php echo esc_html( $intro ); ?></p><?php endif; ?>

		<div class="ms-contact__grid" style="display:grid;grid-template-columns:1.2fr 0.8fr;gap:40px;margin-top:32px;">
			<div class="ms-contact__form-col">
				<?php if ( $form_heading ) : ?><h2><?php echo esc_html( $form_heading ); ?></h2><?php endif; ?>

				<form class="ms-form mysalary-ajax-form" novalidate
					data-action="mysalary_contact_submit"
					data-success="<?php echo esc_attr( $success_text ); ?>">
					<?php wp_nonce_field( 'mysalary_forms', 'mysalary_nonce' ); ?>
					<input type="hidden" name="action" value="mysalary_contact_submit">
					<input type="hidden" name="lang" value="<?php echo esc_attr( function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : ( is_rtl() ? 'ar' : 'en' ) ); ?>">
					<input type="text" name="website" class="ms-honeypot" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;">

					<div class="form-field">
						<label class="form-label" for="contact-name"><?php echo esc_html( mysalary_form_string( 'contact_name', 'Full name', 'الاسم الكامل' ) ); ?> <span class="req">*</span></label>
						<input class="form-input" id="contact-name" type="text" name="name" maxlength="200" autocomplete="name" required>
						<div class="field-error"></div>
					</div>
					<div class="form-field">
						<label class="form-label" for="contact-company"><?php echo esc_html( mysalary_form_string( 'contact_company', 'Company', 'الشركة' ) ); ?></label>
						<input class="form-input" id="contact-company" type="text" name="company" maxlength="200" autocomplete="organization">
						<div class="field-error"></div>
					</div>
					<div class="form-field">
						<label class="form-label" for="contact-email"><?php echo esc_html( mysalary_form_string( 'contact_email', 'Email', 'البريد الإلكتروني' ) ); ?> <span class="req">*</span></label>
						<input class="form-input" id="contact-email" type="email" name="email" maxlength="254" autocomplete="email" required>
						<div class="field-error"></div>
					</div>
					<div class="form-field">
						<label class="form-label" for="contact-phone"><?php echo esc_html( mysalary_form_string( 'contact_phone', 'Phone', 'رقم الجوال' ) ); ?></label>
						<input class="form-input" id="contact-phone" type="tel" name="phone" maxlength="50" autocomplete="tel">
						<div class="field-error"></div>
					</div>
					<div class="form-field form-field--full">
						<label class="form-label" for="contact-subject"><?php echo esc_html( mysalary_form_string( 'contact_subject', 'Subject', 'الموضوع' ) ); ?></label>
						<input class="form-input" id="contact-subject" type="text" name="subject" maxlength="200">
						<div class="field-error"></div>
					</div>
					<div class="form-field form-field--full">
						<label class="form-label" for="contact-message"><?php echo esc_html( mysalary_form_string( 'contact_message', 'Message', 'الرسالة' ) ); ?> <span class="req">*</span></label>
						<textarea class="form-input" id="contact-message" name="message" rows="5" maxlength="5000" required></textarea>
						<div class="field-error"></div>
					</div>

					<button class="form-submit" type="submit"><?php echo esc_html( mysalary_form_string( 'contact_submit', 'Send message', 'إرسال الرسالة' ) ); ?></button>
					<p class="form-status" aria-live="polite"></p>
				</form>
			</div>

			<div class="ms-contact__details-col">
				<?php if ( $details_heading ) : ?><h2><?php echo esc_html( $details_heading ); ?></h2><?php endif; ?>
				<?php if ( $email ) : ?><p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p><?php endif; ?>
				<?php if ( $address ) : ?><p><?php echo nl2br( esc_html( $address ) ); ?></p><?php endif; ?>
				<?php if ( $map_link ) : ?>
					<p><a href="<?php echo esc_url( $map_link ); ?>" target="_blank" rel="noopener"><?php echo esc_html( mysalary_form_string( 'contact_open_maps', 'Open in Google Maps', 'فتح في خرائط Google' ) ); ?></a></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
