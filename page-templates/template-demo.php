<?php
/**
 * Template Name: Request a Demo
 *
 * The bilingual contact form page. Assign this template to a page named
 * "Request a Demo" (and translate the page in Polylang to get an Arabic
 * version). All form labels and placeholders use Polylang-registered
 * strings, so they're translatable in Languages → String Translations.
 *
 * @package MySalary
 */

get_header();
$plain_logo = get_theme_mod( 'plain_logo', MYSALARY_URI . '/assets/images/mysalary-logo-plain.svg' );
?>

<div class="demo-page">
    <div class="demo-container">

        <aside class="demo-brand">
            <div class="demo-brand-content">
                <div class="demo-brand-logo">
                   <img src="<?php echo esc_url( $plain_logo ); ?>" width="150" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
                </div>

                <div style="display:flex; gap: 20px; margin-bottom: 20px;">
				<span class="demo-eyebrow">
                    <?php echo '<a href="'.esc_url( home_url( '/' ) ).'">'. esc_html( mysalary_pll( 'form_brand_eyebrow', 'Home' ) ) . '</a>'; ?>
                </span>
				<span class="demo-eyebrow">
                    <?php echo esc_html( mysalary_pll( 'form_brand_eyebrow', 'Request a Demo' ) ); ?>
                </span>
				</div>
                <h1 class="demo-headline">
                    <?php echo wp_kses_post( mysalary_pll( 'form_brand_headline', 'Give your team instant access to their <em>earned salary</em>.' ) ); ?>
                </h1>
                <p class="demo-subhead">
                    <?php echo esc_html( mysalary_pll( 'form_brand_subhead', 'See how MySalary works for your company — no interest, no HR workload, fully automated.' ) ); ?>
                </p>

                <ul class="demo-bullets">
                    <li>
                        <span class="demo-check">
                            <?php echo mysalary_icon( 'check', [ 'width' => 12, 'height' => 12, 'stroke-width' => 3 ] ); // phpcs:ignore ?>
                        </span>
                        <?php echo esc_html( mysalary_pll( 'trust_compliant', 'Shariah-compliant' ) ); ?>
                    </li>
                    <li>
                        <span class="demo-check">
                            <?php echo mysalary_icon( 'check', [ 'width' => 12, 'height' => 12, 'stroke-width' => 3 ] ); // phpcs:ignore ?>
                        </span>
                        <?php echo esc_html( mysalary_pll( 'trust_automated', 'Fully automated' ) ); ?>
                    </li>
                    <li>
                        <span class="demo-check">
                            <?php echo mysalary_icon( 'check', [ 'width' => 12, 'height' => 12, 'stroke-width' => 3 ] ); // phpcs:ignore ?>
                        </span>
                        <?php echo esc_html( mysalary_pll( 'trust_secure', 'Secure' ) ); ?>
                    </li>
                </ul>
            </div>
        </aside>

        <section class="demo-form-panel">
            <h2 class="form-title"><?php echo esc_html( mysalary_pll( 'form_title', 'Book your demo' ) ); ?></h2>
            <p class="form-intro"><?php echo esc_html( mysalary_pll( 'form_intro', 'A specialist will reach out within one business day.' ) ); ?></p>

            <form class="demo-form mysalary-ajax-form" id="demoForm" data-action="mysalary_demo_submit" novalidate>

                <?php wp_nonce_field( 'mysalary_forms', 'mysalary_nonce' ); ?>
                <input type="hidden" name="action" value="mysalary_demo_submit" />
                <input type="hidden" name="lang" value="<?php echo esc_attr( function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : ( is_rtl() ? 'ar' : 'en' ) ); ?>" />

                <!-- Honeypot for bots — visually hidden, real users won't fill it. -->
                <div style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
                    <label>Website (leave empty)
                        <input type="text" name="website" tabindex="-1" autocomplete="off" />
                    </label>
                </div>

                <div class="form-field">
                    <label class="form-label" for="name">
                        <?php echo esc_html( mysalary_pll( 'form_full_name', 'Full name' ) ); ?><span class="req">*</span>
                    </label>
                    <input class="form-input" type="text" id="name" name="name"
                           placeholder="<?php echo esc_attr( mysalary_pll( 'form_full_name_ph', 'e.g. Ahmed Al-Saud' ) ); ?>"
                           maxlength="200" autocomplete="name" required>
					<div class="field-error"></div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="jobTitle">
                        <?php echo esc_html( mysalary_pll( 'form_job_title', 'Job title' ) ); ?>
                    </label>
                    <input class="form-input" type="text" id="jobTitle" name="jobTitle"
                           placeholder="<?php echo esc_attr( mysalary_pll( 'form_job_title_ph', 'e.g. HR Manager' ) ); ?>"
                           maxlength="200" autocomplete="organization-title">
					<div class="field-error"></div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="email">
                        <?php echo esc_html( mysalary_pll( 'form_work_email', 'Work email' ) ); ?><span class="req">*</span>
                    </label>
                    <input class="form-input" type="email" id="email" name="email"
                           placeholder="<?php echo esc_attr( mysalary_pll( 'form_work_email_ph', 'name@company.com' ) ); ?>"
                           maxlength="254" autocomplete="email" required>
					<div class="field-error"></div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="phone">
                        <?php echo esc_html( mysalary_pll( 'form_phone', 'Phone number' ) ); ?><span class="req">*</span>
                    </label>
                    <input class="form-input" type="tel" id="phone" name="phone"
                           placeholder="<?php echo esc_attr( mysalary_pll( 'form_phone_ph', '+966 5X XXX XXXX' ) ); ?>"
                           maxlength="50" autocomplete="tel" required>
					<div class="field-error"></div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="company">
                        <?php echo esc_html( mysalary_pll( 'form_company', 'Company name' ) ); ?>
                    </label>
                    <input class="form-input" type="text" id="company" name="company"
                           placeholder="<?php echo esc_attr( mysalary_pll( 'form_company_ph', 'Your company' ) ); ?>"
                           maxlength="200" autocomplete="organization">
                </div>

                <div class="form-field">
                    <label class="form-label" for="country">
                        <?php echo esc_html( mysalary_pll( 'form_country', 'Country' ) ); ?>
                    </label>
                    <select class="form-select" id="country" name="country">
                        <option value="SA" selected><?php echo esc_html( mysalary_pll( 'form_country_sa', 'Saudi Arabia' ) ); ?></option>
                    </select>
                </div>

                <div class="form-field form-field--full">
                    <label class="form-label" for="employees">
                        <?php echo esc_html( mysalary_pll( 'form_employees', 'Number of employees' ) ); ?>
                    </label>
                    <select class="form-select" id="employees" name="employees">
                        <option value="" disabled selected><?php echo esc_html( mysalary_pll( 'form_employees_ph', 'Select company size' ) ); ?></option>
                        <option><?php echo esc_html( mysalary_pll( 'form_size_1', '1–50 employees' ) ); ?></option>
                        <option><?php echo esc_html( mysalary_pll( 'form_size_2', '50–250 employees' ) ); ?></option>
                        <option><?php echo esc_html( mysalary_pll( 'form_size_3', '250–500 employees' ) ); ?></option>
                        <option><?php echo esc_html( mysalary_pll( 'form_size_4', '500–5,000 employees' ) ); ?></option>
                        <option><?php echo esc_html( mysalary_pll( 'form_size_5', 'More than 5,000 employees' ) ); ?></option>
                    </select>
                </div>
				<div class="form-field form-field--full">
                	<div class="form-terms">
                    	<input type="checkbox" id="agree" name="agree" required>
						<label for="agree">
							<?php echo esc_html( mysalary_pll( 'form_terms', 'I agree to the terms and conditions and privacy policy.' ) ); ?>
						</label>
					</div>
					<div class="field-error"></div>
                </div>

                <button class="form-submit" type="submit">
                    <?php echo esc_html( mysalary_pll( 'form_submit', 'Request my demo' ) ); ?>
                    <?php echo mysalary_icon( 'arrow-right', [ 'width' => 16, 'height' => 16, 'stroke-width' => 1.8 ] ); // phpcs:ignore ?>
                </button>

                <p class="form-status" id="formStatus" aria-live="polite"></p>

                <p class="form-footnote">
                    <?php echo esc_html( mysalary_pll( 'form_footnote', 'No credit checks · No paperwork · Setup in days' ) ); ?>
                </p>
            </form>
        </section>

    </div>
</div>
<?php get_footer(); ?>
