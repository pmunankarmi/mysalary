<?php
/**
 * Template Name: Careers
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$eyebrow      = get_the_title();
$heading      = mysalary_field( 'careers_heading' );
$intro        = get_the_content();
$why_heading  = mysalary_field( 'careers_why_heading' );
$why_points   = mysalary_field( 'careers_why_points', false, [] );
$form_heading = mysalary_field(
	'careers_form_heading',
	false,
	mysalary_form_string( 'career_apply_now', 'Apply now', 'قدم الآن' )
);
$success_text = mysalary_field(
	'careers_success_text',
	false,
	mysalary_form_string( 'career_success', 'Thank you. Your application has been submitted.', 'شكرًا لك. تم إرسال طلب التوظيف بنجاح.' )
);
?>
<section class="ip-hero">
	<div class="ms-container">
		<?php if ( $eyebrow ) : ?>
			<span class="ip-eyebrow"><span class="ms-hero__eyebrow-dot"></span> <?php echo esc_html( $eyebrow ); ?></span>
		<?php endif; ?>
		<?php if ( $heading ) : ?><h1><?php echo esc_html( $heading ); ?></h1><?php endif; ?>
		<?php if ( $intro ) : ?><div class="ip-lead"><?php echo wp_kses_post( apply_filters( 'the_content', $intro ) ); ?></div><?php endif; ?>
	</div>
</section>

<section class="ip-section">
	<div class="ms-container">
		<div class="careers-grid">
			<?php if ( ! empty( $why_points ) ) : ?>
				<div class="careers-intro">
					<?php if ( $why_heading ) : ?><h2><?php echo esc_html( $why_heading ); ?></h2><?php endif; ?>
					<ul class="careers-perks">
						<?php foreach ( $why_points as $point ) : ?>
							<?php if ( empty( $point['text'] ) ) continue; ?>
							<li class="ms-hero__bullet"><?php mysalary_check_icon(); ?><?php echo esc_html( $point['text'] ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<div class="careers-form-wrap">
				<h2><?php echo esc_html( $form_heading ); ?></h2>
				<form class="ms-form mysalary-ajax-form" id="careerForm" data-action="mysalary_career_submit" data-success="<?php echo esc_attr( $success_text ); ?>" novalidate enctype="multipart/form-data">
					<?php wp_nonce_field( 'mysalary_forms', 'mysalary_nonce' ); ?>
					<input type="hidden" name="action" value="mysalary_career_submit">
					<input type="hidden" name="lang" value="<?php echo esc_attr( function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : ( is_rtl() ? 'ar' : 'en' ) ); ?>">

					<div class="form-field">
						<label class="form-label" for="career-name"><?php echo esc_html( mysalary_form_string( 'career_name', 'Full name', 'الاسم الكامل' ) ); ?><span class="req">*</span></label>
						<input class="form-input" type="text" id="career-name" name="name" placeholder="<?php echo esc_attr( mysalary_form_string( 'career_name_placeholder', 'e.g. Sara Al-Otaibi', 'مثال: سارة العتيبي' ) ); ?>" maxlength="200" autocomplete="name" required>
						<div class="field-error"></div>
					</div>
					<div class="form-field">
						<label class="form-label" for="career-email"><?php echo esc_html( mysalary_form_string( 'career_email', 'Email address', 'البريد الإلكتروني' ) ); ?><span class="req">*</span></label>
						<input class="form-input" type="email" id="career-email" name="email" placeholder="name@email.com" maxlength="254" autocomplete="email" required>
						<div class="field-error"></div>
					</div>
					<div class="form-field">
						<label class="form-label" for="career-phone"><?php echo esc_html( mysalary_form_string( 'career_phone', 'Mobile number', 'رقم الجوال' ) ); ?><span class="req">*</span></label>
						<input class="form-input" type="tel" id="career-phone" name="phone" placeholder="+966 5X XXX XXXX" maxlength="50" autocomplete="tel" required>
						<div class="field-error"></div>
					</div>
					<div class="form-field">
						<label class="form-label" for="career-position"><?php echo esc_html( mysalary_form_string( 'career_position', 'Position applied for', 'الوظيفة المتقدم لها' ) ); ?><span class="req">*</span></label>
						<input class="form-input" type="text" id="career-position" name="position" placeholder="<?php echo esc_attr( mysalary_form_string( 'career_position_placeholder', 'e.g. Software Engineer', 'مثال: مهندس برمجيات' ) ); ?>" maxlength="200" required>
						<div class="field-error"></div>
					</div>
					<div class="form-field form-field--full">
						<label class="form-label" for="career-portfolio">
							<?php echo esc_html( mysalary_form_string( 'career_linkedin', 'LinkedIn profile', 'حساب لينكدإن' ) ); ?>
							<span class="form-optional"><?php echo esc_html( mysalary_form_string( 'form_optional', '(optional)', '(اختياري)' ) ); ?></span>
						</label>
						<input class="form-input" type="url" id="career-portfolio" name="portfolio" placeholder="https://linkedin.com/in/…" maxlength="500">
						<div class="field-error"></div>
					</div>
					<div class="form-field form-field--full">
						<label class="form-label" for="career-cv">
							<?php echo esc_html( mysalary_form_string( 'career_cv', 'Upload CV', 'رفع السيرة الذاتية' ) ); ?>
							<span class="form-optional"><?php echo esc_html( mysalary_form_string( 'career_cv_types', '(PDF / DOC / DOCX, maximum 5 MB)', '(PDF / DOC / DOCX، بحد أقصى 5 ميجابايت)' ) ); ?></span><span class="req">*</span>
						</label>
						<input class="form-file" type="file" id="career-cv" name="cv" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
						<div class="field-error"></div>
					</div>
					<div class="form-field form-field--full">
						<label class="form-label" for="career-message">
							<?php echo esc_html( mysalary_form_string( 'career_message', 'Message', 'الرسالة' ) ); ?>
							<span class="form-optional"><?php echo esc_html( mysalary_form_string( 'form_optional', '(optional)', '(اختياري)' ) ); ?></span>
						</label>
						<textarea class="form-textarea" id="career-message" name="message" maxlength="5000" placeholder="<?php echo esc_attr( mysalary_form_string( 'career_message_placeholder', 'A few lines about your experience and why you would like to join…', 'نبذة قصيرة عن خبرتك وسبب رغبتك في الانضمام إلينا…' ) ); ?>"></textarea>
						<div class="field-error"></div>
					</div>

					<input type="text" name="website" class="ms-hp" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;">
					<button class="form-submit" type="submit">
						<?php echo esc_html( mysalary_form_string( 'career_submit', 'Submit application', 'إرسال الطلب' ) ); ?>
						<?php echo mysalary_icon( 'arrow-right', [ 'width' => 16, 'height' => 16, 'stroke-width' => 1.8 ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>
					<p class="form-status" aria-live="polite"></p>
				</form>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
