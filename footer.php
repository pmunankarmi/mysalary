<?php
/**
 * Site footer.
 *
 * @package MySalary
 */

$plain_logo = get_theme_mod( 'plain_logo', MYSALARY_URI . '/assets/images/mysalary-logo-plain.svg' );

$default_socials = [
	[ 'network' => 'linkedin',  'url' => 'https://linkedin.com/company/mysalarysa' ],
	[ 'network' => 'x',         'url' => 'https://x.com/Mysalarysa' ],
	[ 'network' => 'instagram', 'url' => 'https://www.instagram.com/Mysalarysa' ],
	[ 'network' => 'snapchat',  'url' => 'https://www.snapchat.com/@mysalarysa' ],
	[ 'network' => 'tiktok',    'url' => 'https://www.tiktok.com/@Mysalarysa' ],
	[ 'network' => 'facebook',  'url' => 'https://www.facebook.com/profile.php?id=61579519384255' ],
];

$socials       = mysalary_field( 'socials', 'option', $default_socials );
$app_store_url = mysalary_field( 'app_store_url', 'option', 'https://apps.apple.com/app/id6785230853' );
$play_store_url = mysalary_field( 'play_store_url', 'option', 'https://play.google.com/store/apps/details?id=io.invento.mysalary' );
$certificate_setting = mysalary_field( 'shariah_certificate_url', 'option', '' );
$footer_home_url = function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' );

$footer_page_url = static function ( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page && function_exists( 'pll_get_post' ) ) {
		$translated_id = pll_get_post( $page->ID );
		if ( $translated_id ) {
			$page = get_post( $translated_id );
		}
	}
	return $page ? get_permalink( $page ) : home_url( '/' . trim( $slug, '/' ) . '/' );
};

$certificate_setting  = trim( (string) $certificate_setting );
$certificate_setting  = wp_http_validate_url( $certificate_setting ) ? $certificate_setting : '';
$certificate_url      = $certificate_setting ?: $footer_page_url( 'sharia-compliance' );
$certificate_external = (bool) $certificate_setting;
?>

</main><!-- #main -->

<?php if ( ! is_page_template( 'page-templates/template-demo.php' ) ) : ?>
<footer class="ms-footer" role="contentinfo">
	<div class="ms-container">
		<div class="ms-footer__grid">
			<div class="ms-footer__brand">
				<a href="<?php echo esc_url( $footer_home_url ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' ' . __( 'home', 'mysalary' ) ); ?>">
					<img src="<?php echo esc_url( $plain_logo ); ?>" width="200" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
				</a>
				<p><?php echo esc_html( mysalary_form_string( 'footer_tagline', 'Empowering the flow of income for employees across the Kingdom of Saudi Arabia.', 'نعزز مرونة الدخل للموظفين في جميع أنحاء المملكة العربية السعودية.' ) ); ?></p>
			</div>

			<div class="ms-footer__col">
				<h4><?php echo esc_html( mysalary_form_string( 'footer_company', 'Company', 'الشركة' ) ); ?></h4>
				<?php if ( has_nav_menu( 'company' ) ) : ?>
					<?php
					wp_nav_menu( [
						'theme_location' => 'company',
						'container'      => false,
						'menu_class'     => '',
						'depth'          => 1,
						'fallback_cb'    => '__return_false',
					] );
					?>
				<?php else : ?>
					<ul>
						<li><a href="<?php echo esc_url( $footer_page_url( 'about' ) ); ?>"><?php echo esc_html( mysalary_form_string( 'footer_about', 'About Us', 'من نحن' ) ); ?></a></li>
						<li><a href="<?php echo esc_url( $footer_page_url( 'careers' ) ); ?>"><?php echo esc_html( mysalary_form_string( 'footer_careers', 'Careers', 'الوظائف' ) ); ?></a></li>
						<li><a href="#"><?php echo esc_html( mysalary_form_string( 'footer_press', 'Press', 'المركز الإعلامي' ) ); ?></a></li>
						<li><a href="<?php echo esc_url( $footer_page_url( 'contact' ) ); ?>"><?php echo esc_html( mysalary_form_string( 'footer_contact', 'Contact', 'تواصل معنا' ) ); ?></a></li>
						<li><a href="<?php echo esc_url( $footer_home_url . '#faq' ); ?>"><?php echo esc_html( mysalary_form_string( 'footer_help', 'Help Center', 'مركز المساعدة' ) ); ?></a></li>
					</ul>
				<?php endif; ?>
			</div>

			<div class="ms-footer__col">
				<h4><?php echo esc_html( mysalary_form_string( 'footer_legal', 'Legal', 'قانوني' ) ); ?></h4>
				<?php if ( has_nav_menu( 'legal' ) ) : ?>
					<?php
					wp_nav_menu( [
						'theme_location' => 'legal',
						'container'      => false,
						'menu_class'     => '',
						'depth'          => 1,
						'fallback_cb'    => '__return_false',
					] );
					?>
				<?php else : ?>
					<ul>
						<li><a href="<?php echo esc_url( $footer_page_url( 'privacy-policy' ) ); ?>"><?php echo esc_html( mysalary_form_string( 'footer_privacy', 'Privacy Policy', 'سياسة الخصوصية' ) ); ?></a></li>
						<li><a href="<?php echo esc_url( $footer_page_url( 'terms-of-service' ) ); ?>"><?php echo esc_html( mysalary_form_string( 'footer_terms', 'Terms of Service', 'شروط الاستخدام' ) ); ?></a></li>
						<li><a href="<?php echo esc_url( $footer_page_url( 'security' ) ); ?>"><?php echo esc_html( mysalary_form_string( 'footer_security', 'Security', 'الأمان' ) ); ?></a></li>
						<li><a href="<?php echo esc_url( $certificate_url ); ?>"<?php echo $certificate_external ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( mysalary_form_string( 'footer_shariah', 'Shariah-compliant', 'متوافق مع الشريعة' ) ); ?></a></li>
					</ul>
				<?php endif; ?>
			</div>

			<div class="ms-footer__col">
				<h4><?php echo esc_html( mysalary_form_string( 'footer_download_app', 'Download the App', 'حمّل التطبيق' ) ); ?></h4>
				<ul class="ms-download__icons">
					<li>
						<a href="<?php echo esc_url( $app_store_url ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Download on the App Store', 'mysalary' ); ?>">
							<img src="<?php echo esc_url( MYSALARY_URI . '/assets/images/appstore.svg' ); ?>" alt="<?php esc_attr_e( 'Download on the App Store', 'mysalary' ); ?>" />
						</a>
					</li>
					<li>
						<a href="<?php echo esc_url( $play_store_url ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Get it on Google Play', 'mysalary' ); ?>">
							<img src="<?php echo esc_url( MYSALARY_URI . '/assets/images/playstore.svg' ); ?>" alt="<?php esc_attr_e( 'Get it on Google Play', 'mysalary' ); ?>" />
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="ms-footer__bottom">
			<div class="ms-footer__desc">
				<p><?php echo esc_html( mysalary_form_string(
					'footer_legal_description',
					'Alajur Alraqmia Liltiqniat Company, a Saudi Simplified Joint Stock Company, registered under Unified National Number 7053385717, with its headquarters located at Building No. 8646, King Abdulaziz Road, Al Ghadeer District, Postal Code 13311, Riyadh, Kingdom of Saudi Arabia.',
					'شركة الأجور الرقمية للتقنيات، شركة مساهمة مبسطة سعودية، مسجلة بالرقم الوطني الموحد 7053385717، ويقع مقرها الرئيسي في حي الغدير، طريق الملك عبدالعزيز، رقم المبنى 8646، الرمز البريدي 13311، الرياض، المملكة العربية السعودية.'
				) ); ?></p>
			</div>

			<span><?php echo esc_html( mysalary_form_string( 'footer_copyright', '© ' . wp_date( 'Y' ) . ' MySalary. All Rights Reserved.', '© ' . wp_date( 'Y' ) . ' MySalary. جميع الحقوق محفوظة.' ) ); ?></span>

			<?php if ( ! empty( $socials ) && is_array( $socials ) ) : ?>
				<div class="ms-footer__socials">
					<?php foreach ( $socials as $social ) : ?>
						<?php
						if ( empty( $social['url'] ) || empty( $social['network'] ) ) continue;
						$label = 'x' === $social['network'] ? 'Twitter / X' : ucfirst( $social['network'] );
						?>
						<a href="<?php echo esc_url( $social['url'] ); ?>" class="ms-footer__social"
						   aria-label="<?php echo esc_attr( $label ); ?>" target="_blank" rel="noopener noreferrer">
							<?php echo mysalary_social_icon( $social['network'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</footer>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
