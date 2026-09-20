<?php
/**
 * Template Name: Sharia Compliance
 *
 * All editorial content is managed with individual ACF fields on the page.
 * Create a translated page in Polylang to manage the Arabic field values.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$current_language = function_exists( 'pll_current_language' ) ? (string) pll_current_language( 'slug' ) : '';
$is_arabic        = 'ar' === $current_language || ( ! $current_language && is_rtl() );

$english_defaults = [
	'sharia_hero_eyebrow'               => 'Sharia governance',
	'sharia_hero_heading'               => 'Sharia Compliance',
	'sharia_hero_intro'                 => 'We are committed to complying with Sharia governance practices such as (but not limited to) the establishment of a Sharia Committee, independence of pronouncement, administration of Sharia audit and Sharia reporting.',
	'sharia_hero_view_label'            => 'View Sharia Certificate',
	'sharia_hero_verify_label'          => 'Verify the certificate',
	'sharia_certification_aria_label'   => 'Sharia certification',
	'sharia_certified_by_label'         => 'Certified by',
	'sharia_certification_logo_alt'     => 'Shariyah Review Bureau',
	'sharia_uid_label'                  => 'UID code',
	'sharia_governance_heading'         => 'Sharia Governance',
	'sharia_governance_intro'           => 'We have appointed Shariyah Review Bureau (SRB) to help us adhere to the best practices and guidelines on Sharia governance.',
	'sharia_committee_heading'          => 'Sharia Committee',
	'sharia_committee_intro'            => 'For the purpose of effective Sharia governance and supervision, a renowned and qualified Sharia scholar has been assigned. The Sharia scholars independently issue pronouncements, and these rulings are binding on us. The names of the Sharia Committee members are provided below:',
	'sharia_certificate_heading'        => 'Sharia Certificate',
	'sharia_certificate_thumbnail_alt'  => 'First page of the Opinion on Sharia Compliance issued by Shariyah Review Bureau for the MySalary Earned Wage Access Service',
	'sharia_certificate_preview_label'  => 'View certificate',
	'sharia_certificate_title'          => 'Opinion on Sharia Compliance',
	'sharia_issued_by_label'             => 'Issued by',
	'sharia_issued_by_value'             => 'Shariyah Review Bureau (SRB)',
	'sharia_product_label'               => 'Product',
	'sharia_product_value'               => 'MySalary Earned Wage Access Service',
	'sharia_company_label'               => 'Company',
	'sharia_company_value'               => 'Alajur Alraqmia Liltiqniat Company',
	'sharia_date_label'                  => 'Date',
	'sharia_date_value'                  => '26 June 2026',
	'sharia_copy_label'                  => 'Copy',
	'sharia_copied_label'                => 'Copied',
	'sharia_copied_status'               => 'UID code copied',
	'sharia_view_button_label'           => 'View certificate',
	'sharia_download_button_label'       => 'Download PDF',
	'sharia_verify_heading'              => 'Verify the certificate',
	'sharia_verify_before_uid'           => 'The authenticity of this document and list of documents approved can be verified at shariyah.net using UID code',
	'sharia_verify_after_uid'            => '.',
	'sharia_verify_button_label'         => 'Verify on shariyah.net',
	'sharia_viewer_title'                => 'Sharia Certificate',
	'sharia_viewer_subtitle'             => 'Shariyah Review Bureau · 5 pages',
	'sharia_viewer_download_label'       => 'Download',
	'sharia_viewer_verify_label'         => 'Verify',
	'sharia_viewer_close_label'          => 'Close certificate',
	'sharia_viewer_pages_label'          => 'Certificate pages',
	'sharia_viewer_caption_format'       => 'Page %1$d of %2$d',
	'sharia_viewer_alt_format'           => 'Certificate page %1$d of %2$d',
];

$arabic_defaults = [
	'sharia_hero_eyebrow'               => 'الحوكمة الشرعية',
	'sharia_hero_heading'               => 'الامتثال لأحكام الشريعة',
	'sharia_hero_intro'                 => 'نلتزم بتطبيق ممارسات الحوكمة الشرعية، بما يشمل - على سبيل المثال لا الحصر - تشكيل لجنة شرعية، واستقلالية إصدار القرارات الشرعية، وإجراء التدقيق الشرعي، وإعداد التقارير الشرعية.',
	'sharia_hero_view_label'            => 'عرض الشهادة الشرعية',
	'sharia_hero_verify_label'          => 'التحقق من الشهادة',
	'sharia_certification_aria_label'   => 'اعتماد الامتثال الشرعي',
	'sharia_certified_by_label'         => 'معتمد من',
	'sharia_certification_logo_alt'     => 'دار المراجعة الشرعية',
	'sharia_uid_label'                  => 'رمز التحقق',
	'sharia_governance_heading'         => 'الحوكمة الشرعية',
	'sharia_governance_intro'           => 'قمنا بتعيين دار المراجعة الشرعية (SRB) لمساعدتنا على الالتزام بأفضل الممارسات والإرشادات المتعلقة بالحوكمة الشرعية.',
	'sharia_committee_heading'          => 'اللجنة الشرعية',
	'sharia_committee_intro'            => 'لضمان فعالية الحوكمة والرقابة الشرعية، تم تعيين عالم شرعي مرموق ومؤهل. ويصدر عالم الشريعة أحكامه بصورة مستقلة، وتكون هذه الأحكام ملزمة لنا. ويرد أدناه اسم عضو اللجنة الشرعية:',
	'sharia_certificate_heading'        => 'الشهادة الشرعية',
	'sharia_certificate_thumbnail_alt'  => 'الصفحة الأولى من وثيقة الرأي حول التوافق الشرعي الصادرة عن دار المراجعة الشرعية لخدمة ماي سالاري للوصول إلى الأجر المكتسب',
	'sharia_certificate_preview_label'  => 'عرض الشهادة',
	'sharia_certificate_title'          => 'الرأي حول التوافق الشرعي',
	'sharia_issued_by_label'             => 'صادرة عن',
	'sharia_issued_by_value'             => 'دار المراجعة الشرعية (SRB)',
	'sharia_product_label'               => 'المنتج',
	'sharia_product_value'               => 'خدمة ماي سالاري للوصول إلى الأجر المكتسب',
	'sharia_company_label'               => 'الشركة',
	'sharia_company_value'               => 'شركة الأجور الرقمية للتقنيات',
	'sharia_date_label'                  => 'التاريخ',
	'sharia_date_value'                  => '26 يونيو 2026',
	'sharia_copy_label'                  => 'نسخ',
	'sharia_copied_label'                => 'تم النسخ',
	'sharia_copied_status'               => 'تم نسخ رمز التحقق',
	'sharia_view_button_label'           => 'عرض الشهادة',
	'sharia_download_button_label'       => 'تنزيل ملف PDF',
	'sharia_verify_heading'              => 'التحقق من الشهادة',
	'sharia_verify_before_uid'           => 'يمكن التحقق من صحة هذه الوثيقة وقائمة المستندات المعتمدة عبر موقع shariyah.net باستخدام رمز التحقق',
	'sharia_verify_after_uid'            => '.',
	'sharia_verify_button_label'         => 'التحقق عبر shariyah.net',
	'sharia_viewer_title'                => 'الشهادة الشرعية',
	'sharia_viewer_subtitle'             => 'دار المراجعة الشرعية · 5 صفحات',
	'sharia_viewer_download_label'       => 'تنزيل',
	'sharia_viewer_verify_label'         => 'تحقق',
	'sharia_viewer_close_label'          => 'إغلاق الشهادة',
	'sharia_viewer_pages_label'          => 'صفحات الشهادة',
	'sharia_viewer_caption_format'       => 'الصفحة %1$d من %2$d',
	'sharia_viewer_alt_format'           => 'الصفحة %1$d من %2$d من الشهادة',
];

$field = static function ( $name, $fallback = '' ) use ( $is_arabic, $english_defaults, $arabic_defaults ) {
	$english_fallback   = $english_defaults[ $name ] ?? $fallback;
	$localized_fallback = $is_arabic && isset( $arabic_defaults[ $name ] )
		? $arabic_defaults[ $name ]
		: $english_fallback;

	if ( ! function_exists( 'get_field' ) ) {
		return $localized_fallback;
	}

	$value = get_field( $name, false );
	if ( null === $value || '' === $value || false === $value ) {
		return $localized_fallback;
	}

	// ACF returns its English default_value even when the translated page
	// has never saved the field. Replace only that unchanged default.
	if ( $is_arabic && isset( $arabic_defaults[ $name ] ) && $value === $english_fallback ) {
		return $arabic_defaults[ $name ];
	}

	return $value;
};

$media_url = static function ( $value, $fallback = '' ) {
	if ( is_array( $value ) && ! empty( $value['url'] ) ) {
		return $value['url'];
	}

	if ( is_numeric( $value ) ) {
		$url = wp_get_attachment_url( (int) $value );
		return $url ?: $fallback;
	}

	if ( is_string( $value ) && $value ) {
		return $value;
	}

	return $fallback;
};

$english_governance_points = [
	[
		'icon'  => 'shield-check',
		'title' => 'Sharia governance support',
		'text'  => 'SRB facilitates Sharia related discussions, product research and Sharia reporting across the organization.',
	],
	[
		'icon'  => 'users',
		'title' => 'Independent Sharia Committee',
		'text'  => 'SRB helps establish and maintain a qualified and independent Sharia Committee.',
	],
	[
		'icon'  => 'document',
		'title' => 'Sharia reviews and audits',
		'text'  => 'SRB coordinates Sharia reviews and supervises the Sharia audit to verify compliance.',
	],
	[
		'icon'  => 'tag',
		'title' => 'Product compliance',
		'text'  => 'SRB supports product development and ensures relevant products are approved and certified by the Sharia Committee.',
	],
	[
		'icon'  => 'refresh',
		'title' => 'Ongoing Sharia alignment',
		'text'  => 'SRB helps ensure relevant products and services remain in line with Sharia principles and the rulings of the Sharia Committee.',
	],
];

$arabic_governance_points = [
	[
		'icon'  => 'shield-check',
		'title' => 'دعم الحوكمة الشرعية',
		'text'  => 'تسهّل دار المراجعة الشرعية المناقشات ذات الصلة بالشريعة، وأبحاث المنتجات، وإعداد التقارير الشرعية في جميع أنحاء الشركة.',
	],
	[
		'icon'  => 'users',
		'title' => 'لجنة شرعية مستقلة',
		'text'  => 'تساعد دار المراجعة الشرعية على تشكيل لجنة شرعية مؤهلة ومستقلة والمحافظة عليها.',
	],
	[
		'icon'  => 'document',
		'title' => 'المراجعات والتدقيق الشرعي',
		'text'  => 'تنسّق دار المراجعة الشرعية عمليات المراجعة الشرعية وتشرف على التدقيق الشرعي للتحقق من الالتزام.',
	],
	[
		'icon'  => 'tag',
		'title' => 'امتثال المنتجات',
		'text'  => 'تدعم دار المراجعة الشرعية تطوير المنتجات، وتضمن اعتماد المنتجات ذات الصلة والموافقة عليها من اللجنة الشرعية.',
	],
	[
		'icon'  => 'refresh',
		'title' => 'الالتزام الشرعي المستمر',
		'text'  => 'تساعد دار المراجعة الشرعية على ضمان استمرار توافق المنتجات والخدمات ذات الصلة مع مبادئ الشريعة وقرارات اللجنة الشرعية.',
	],
];

$english_committee_members = [
	[
		'name' => 'Sh. Dr. Abdullah Bin Khalid AlJohar',
		'role' => 'Sharia Advisor',
		'bio'  => "Sheikh Dr. Abdullah Bin Khalid AlJohar is a Saudi academic and Sharia consultant specializing in comparative jurisprudence, contracts, and contemporary financial transactions, with more than 13 years of academic and advisory experience. He currently serves as Assistant Professor of Jurisprudence at King Faisal University's College of Sharia and Islamic Studies and has previously taught at Imam Muhammad Ibn Saud Islamic University.\n\nHe provides Sharia and legal consultancy to academic, financial, and research institutions and serves as an arbitrator in commercial and financial disputes. He holds a PhD in Jurisprudence from Imam Muhammad Ibn Saud Islamic University, with research focusing on dependency in financial transactions, alongside a Master's and Bachelor's in Sharia and Comparative Jurisprudence. His research interests include Sukuk, hedging, risk management, Murabaha and Mudaraba structures, financial contracts, Zakat jurisprudence, Islamic legal maxims and objectives, and contemporary financial markets. He is also certified by the Chartered Institute of Arbitrators (CIArb), UK, and has undertaken advanced training in Islamic banking, cooperative insurance, and financial product development.\n\nHe actively serves on Sharia Boards and provides Sharia advisory oversight to institutions across the insurance, financing, investment fund, and fintech sectors.",
	],
];

$arabic_committee_members = [
	[
		'name' => 'فضيلة الشيخ الدكتور عبدالله بن خالد الجوهر',
		'role' => 'المستشار الشرعي',
		'bio'  => "الشيخ الدكتور عبدالله بن خالد الجوهر أكاديمي سعودي ومستشار شرعي متخصص في الفقه المقارن والعقود والمعاملات المالية المعاصرة، ويتمتع بخبرة أكاديمية واستشارية تزيد على 13 عامًا. ويشغل حاليًا منصب أستاذ مساعد في الفقه بكلية الشريعة والدراسات الإسلامية بجامعة الملك فيصل، وسبق له التدريس في جامعة الإمام محمد بن سعود الإسلامية.\n\nيقدم الاستشارات الشرعية والقانونية للجهات الأكاديمية والمالية والبحثية، ويعمل محكمًا في المنازعات التجارية والمالية. حصل على درجة الدكتوراه في الفقه من جامعة الإمام محمد بن سعود الإسلامية، وتركزت أبحاثه على التبعية في المعاملات المالية، كما يحمل درجتي الماجستير والبكالوريوس في الشريعة والفقه المقارن. وتشمل اهتماماته البحثية الصكوك والتحوط وإدارة المخاطر وهياكل المرابحة والمضاربة والعقود المالية وفقه الزكاة والقواعد والمقاصد الشرعية والأسواق المالية المعاصرة. كما أنه معتمد من المعهد القانوني للمحكمين (CIArb) في المملكة المتحدة، وأتم برامج تدريب متقدمة في المصرفية الإسلامية والتأمين التعاوني وتطوير المنتجات المالية.\n\nويشارك بفاعلية في عضوية الهيئات الشرعية، ويقدم الإشراف والاستشارات الشرعية لمؤسسات تعمل في قطاعات التأمين والتمويل وصناديق الاستثمار والتقنية المالية.",
	],
];

$default_governance_points = $is_arabic ? $arabic_governance_points : $english_governance_points;
$default_committee_members = $is_arabic ? $arabic_committee_members : $english_committee_members;
$governance_points         = $field( 'sharia_governance_points', $default_governance_points );
$committee_members         = $field( 'sharia_committee_members', $default_committee_members );

// Replace unchanged English repeater defaults on the Arabic page.
if ( $is_arabic && $english_governance_points === $governance_points ) {
	$governance_points = $arabic_governance_points;
}

if ( $is_arabic && $english_committee_members === $committee_members ) {
	$committee_members = $arabic_committee_members;
}

if ( ! is_array( $governance_points ) || ! $governance_points ) {
	$governance_points = $default_governance_points;
}

if ( ! is_array( $committee_members ) || ! $committee_members ) {
	$committee_members = $default_committee_members;
}

$uid_code       = $field( 'sharia_uid_code', 'AALC-4749-01-01-06-26' );
$uid_label      = $field( 'sharia_uid_label', 'UID code' );
$verify_url     = $field( 'sharia_verify_url', 'https://shariyah.net/verify-your-certificate/' );
$certificate_pdf = $media_url(
	$field( 'sharia_certificate_pdf', [] ),
	MYSALARY_URI . '/assets/documents/MySalary-Sharia-Certificate.pdf'
);
$certificate_thumbnail = $media_url(
	$field( 'sharia_certificate_thumbnail', [] ),
	MYSALARY_URI . '/assets/images/sharia/certificate/certificate-thumb.jpg'
);
$certification_logo = $media_url(
	$field( 'sharia_certification_logo', [] ),
	MYSALARY_URI . '/assets/images/sharia/srb-logo.svg'
);

$certificate_title = $field( 'sharia_certificate_title', 'Opinion on Sharia Compliance' );
$download_name      = sanitize_file_name( $certificate_title . '.pdf' );
$copy_label         = $field( 'sharia_copy_label', 'Copy' );
$copied_label       = $field( 'sharia_copied_label', 'Copied' );
$copied_status      = $field( 'sharia_copied_status', 'UID code copied' );

$default_certificate_pages = [];
for ( $page_number = 1; $page_number <= 5; $page_number++ ) {
	$default_certificate_pages[] = [
		'image'   => MYSALARY_URI . '/assets/images/sharia/certificate/certificate-page-' . $page_number . '.jpg',
		'alt'     => '',
		'caption' => '',
	];
}

$certificate_pages = $field( 'sharia_certificate_pages', $default_certificate_pages );
if ( ! is_array( $certificate_pages ) || ! $certificate_pages ) {
	$certificate_pages = $default_certificate_pages;
}

$certificate_pages = array_values( array_filter( $certificate_pages, static function ( $page ) use ( $media_url ) {
	return is_array( $page ) && $media_url( $page['image'] ?? '' );
} ) );

if ( ! $certificate_pages ) {
	$certificate_pages = $default_certificate_pages;
}

$page_count             = count( $certificate_pages );
$page_caption_format    = $field( 'sharia_viewer_caption_format', 'Page %1$d of %2$d' );
$page_alt_format        = $field( 'sharia_viewer_alt_format', 'Certificate page %1$d of %2$d' );
$allowed_icons          = [ 'shield-check', 'users', 'document', 'tag', 'refresh' ];
$format_page_text       = static function ( $format, $current, $total ) {
	return str_replace( [ '%1$d', '%2$d' ], [ (string) $current, (string) $total ], $format );
};
?>

<section class="sc-hero">
	<div class="ms-container sc-hero__inner">
		<div class="sc-hero__copy">
			<span class="sc-eyebrow"><?php echo esc_html( $field( 'sharia_hero_eyebrow', 'Sharia governance' ) ); ?></span>
			<h1><?php echo esc_html( $field( 'sharia_hero_heading', 'Sharia Compliance' ) ); ?></h1>
			<p class="sc-hero__lead"><?php echo esc_html( $field( 'sharia_hero_intro', 'We are committed to complying with Sharia governance practices such as (but not limited to) the establishment of a Sharia Committee, independence of pronouncement, administration of Sharia audit and Sharia reporting.' ) ); ?></p>
			<div class="sc-hero__actions">
				<a class="ms-btn ms-btn--cyan js-cert-open" href="<?php echo esc_url( $certificate_pdf ); ?>" target="_blank" rel="noopener">
					<?php echo esc_html( $field( 'sharia_hero_view_label', 'View Sharia Certificate' ) ); ?>
					<?php echo mysalary_icon( 'document', [ 'width' => 16, 'height' => 16, 'stroke-width' => 2.2 ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
				<a class="sc-hero__link" href="#verify"><?php echo esc_html( $field( 'sharia_hero_verify_label', 'Verify the certificate' ) ); ?></a>
			</div>
		</div>

		<aside class="sc-seal" aria-label="<?php echo esc_attr( $field( 'sharia_certification_aria_label', 'Sharia certification' ) ); ?>">
			<span class="sc-seal__label"><?php echo esc_html( $field( 'sharia_certified_by_label', 'Certified by' ) ); ?></span>
			<img class="sc-seal__logo" src="<?php echo esc_url( $certification_logo ); ?>" alt="<?php echo esc_attr( $field( 'sharia_certification_logo_alt', 'Shariyah Review Bureau' ) ); ?>" width="132" height="158">
			<div class="sc-seal__uid">
				<span><?php echo esc_html( $uid_label ); ?></span>
				<strong><?php echo esc_html( $uid_code ); ?></strong>
			</div>
		</aside>
	</div>
</section>

<section class="sc-section" id="governance">
	<div class="ms-container">
		<div class="sc-head">
			<h2><?php echo esc_html( $field( 'sharia_governance_heading', 'Sharia Governance' ) ); ?></h2>
			<p><?php echo esc_html( $field( 'sharia_governance_intro', 'We have appointed Shariyah Review Bureau (SRB) to help us adhere to the best practices and guidelines on Sharia governance.' ) ); ?></p>
		</div>

		<ul class="sc-points">
			<?php foreach ( $governance_points as $point ) : ?>
				<?php
				$icon = isset( $point['icon'] ) && in_array( $point['icon'], $allowed_icons, true ) ? $point['icon'] : 'shield-check';
				?>
				<li class="sc-point">
					<span class="sc-point__icon"><?php echo mysalary_icon( $icon, [ 'width' => 28, 'height' => 28 ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php if ( ! empty( $point['title'] ) ) : ?><h3><?php echo esc_html( $point['title'] ); ?></h3><?php endif; ?>
					<?php if ( ! empty( $point['text'] ) ) : ?><p><?php echo esc_html( $point['text'] ); ?></p><?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="sc-section sc-section--alt" id="committee">
	<div class="ms-container">
		<div class="sc-head">
			<h2><?php echo esc_html( $field( 'sharia_committee_heading', 'Sharia Committee' ) ); ?></h2>
			<p><?php echo esc_html( $field( 'sharia_committee_intro', 'For the purpose of effective Sharia governance and supervision, a renowned and qualified Sharia scholar has been assigned. The Sharia scholars independently issue pronouncements, and these rulings are binding on us. The names of the Sharia Committee members are provided below:' ) ); ?></p>
		</div>

		<?php foreach ( $committee_members as $member ) : ?>
			<article class="sc-advisor">
				<div class="sc-advisor__id">
					<span class="sc-advisor__mark" aria-hidden="true"><?php echo mysalary_icon( 'shield-check', [ 'width' => 30, 'height' => 30 ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php if ( ! empty( $member['name'] ) ) : ?><h3><?php echo esc_html( $member['name'] ); ?></h3><?php endif; ?>
					<?php if ( ! empty( $member['role'] ) ) : ?><span class="sc-advisor__role"><?php echo esc_html( $member['role'] ); ?></span><?php endif; ?>
				</div>
				<div class="sc-advisor__bio">
					<?php echo wpautop( esc_html( $member['bio'] ?? '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<section class="sc-section" id="certificate">
	<div class="ms-container">
		<div class="sc-head">
			<h2><?php echo esc_html( $field( 'sharia_certificate_heading', 'Sharia Certificate' ) ); ?></h2>
		</div>

		<div class="sc-cert">
			<a class="sc-cert__preview js-cert-open" href="<?php echo esc_url( $certificate_pdf ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $field( 'sharia_certificate_preview_label', 'View certificate' ) . ': ' . $certificate_title ); ?>">
				<img src="<?php echo esc_url( $certificate_thumbnail ); ?>" width="900" height="514" alt="<?php echo esc_attr( $field( 'sharia_certificate_thumbnail_alt', 'First page of the Opinion on Sharia Compliance issued by Shariyah Review Bureau for the MySalary Earned Wage Access Service' ) ); ?>" loading="lazy">
				<span class="sc-cert__zoom">
					<?php echo mysalary_icon( 'search-plus', [ 'width' => 18, 'height' => 18, 'stroke-width' => 2.2 ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php echo esc_html( $field( 'sharia_certificate_preview_label', 'View certificate' ) ); ?>
				</span>
			</a>

			<div class="sc-cert__info">
				<h3 class="sc-cert__title"><?php echo esc_html( $certificate_title ); ?></h3>
				<dl class="sc-cert__list">
					<div><dt><?php echo esc_html( $field( 'sharia_issued_by_label', 'Issued by' ) ); ?></dt><dd><?php echo esc_html( $field( 'sharia_issued_by_value', 'Shariyah Review Bureau (SRB)' ) ); ?></dd></div>
					<div><dt><?php echo esc_html( $field( 'sharia_product_label', 'Product' ) ); ?></dt><dd><?php echo esc_html( $field( 'sharia_product_value', 'MySalary Earned Wage Access Service' ) ); ?></dd></div>
					<div><dt><?php echo esc_html( $field( 'sharia_company_label', 'Company' ) ); ?></dt><dd><?php echo esc_html( $field( 'sharia_company_value', 'Alajur Alraqmia Liltiqniat Company' ) ); ?></dd></div>
					<div><dt><?php echo esc_html( $field( 'sharia_date_label', 'Date' ) ); ?></dt><dd><?php echo esc_html( $field( 'sharia_date_value', '26 June 2026' ) ); ?></dd></div>
					<div>
						<dt><?php echo esc_html( $uid_label ); ?></dt>
						<dd class="sc-uid">
							<code id="scUid"><?php echo esc_html( $uid_code ); ?></code>
							<button type="button" class="sc-copy" data-copy="<?php echo esc_attr( $uid_code ); ?>" data-copy-label="<?php echo esc_attr( $copy_label ); ?>" data-copied-label="<?php echo esc_attr( $copied_label ); ?>" data-copied-status="<?php echo esc_attr( $copied_status ); ?>" aria-describedby="scUid">
								<?php echo mysalary_icon( 'copy', [ 'width' => 15, 'height' => 15, 'stroke-width' => 2.2 ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<span class="sc-copy__label"><?php echo esc_html( $copy_label ); ?></span>
							</button>
							<span class="sc-copy__status" role="status"></span>
						</dd>
					</div>
				</dl>

				<div class="sc-cert__actions">
					<a class="ms-btn ms-btn--primary js-cert-open" href="<?php echo esc_url( $certificate_pdf ); ?>" target="_blank" rel="noopener">
						<?php echo esc_html( $field( 'sharia_view_button_label', 'View certificate' ) ); ?>
						<?php echo mysalary_icon( 'eye', [ 'width' => 16, 'height' => 16, 'stroke-width' => 2.2 ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
					<a class="ms-btn ms-btn--ghost" href="<?php echo esc_url( $certificate_pdf ); ?>" download="<?php echo esc_attr( $download_name ); ?>">
						<?php echo esc_html( $field( 'sharia_download_button_label', 'Download PDF' ) ); ?>
						<?php echo mysalary_icon( 'download', [ 'width' => 16, 'height' => 16, 'stroke-width' => 2.2 ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</div>
			</div>
		</div>

		<div class="sc-verify" id="verify">
			<div class="sc-verify__copy">
				<h3><?php echo esc_html( $field( 'sharia_verify_heading', 'Verify the certificate' ) ); ?></h3>
				<p><?php echo esc_html( trim( $field( 'sharia_verify_before_uid', 'The authenticity of this document and list of documents approved can be verified at shariyah.net using UID code' ) ) ); ?> <strong><?php echo esc_html( $uid_code ); ?></strong><?php echo esc_html( $field( 'sharia_verify_after_uid', '.' ) ); ?></p>
			</div>
			<a class="ms-btn ms-btn--white sc-verify__btn" href="<?php echo esc_url( $verify_url ); ?>" target="_blank" rel="noopener">
				<?php echo esc_html( $field( 'sharia_verify_button_label', 'Verify on shariyah.net' ) ); ?>
				<?php echo mysalary_icon( 'external-link', [ 'width' => 15, 'height' => 15, 'stroke-width' => 2.2 ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		</div>
	</div>
</section>

<dialog class="sc-viewer" id="scViewer" aria-labelledby="scViewerTitle">
	<div class="sc-viewer__bar">
		<div class="sc-viewer__title">
			<strong id="scViewerTitle"><?php echo esc_html( $field( 'sharia_viewer_title', 'Sharia Certificate' ) ); ?></strong>
			<span><?php echo esc_html( $field( 'sharia_viewer_subtitle', 'Shariyah Review Bureau · 5 pages' ) ); ?></span>
		</div>
		<div class="sc-viewer__tools">
			<a class="sc-viewer__tool" href="<?php echo esc_url( $certificate_pdf ); ?>" download="<?php echo esc_attr( $download_name ); ?>" aria-label="<?php echo esc_attr( $field( 'sharia_viewer_download_label', 'Download' ) ); ?>">
				<?php echo mysalary_icon( 'download', [ 'width' => 16, 'height' => 16, 'stroke-width' => 2.2 ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php echo esc_html( $field( 'sharia_viewer_download_label', 'Download' ) ); ?></span>
			</a>
			<a class="sc-viewer__tool" href="<?php echo esc_url( $verify_url ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $field( 'sharia_viewer_verify_label', 'Verify' ) ); ?>">
				<?php echo mysalary_icon( 'shield', [ 'width' => 16, 'height' => 16, 'stroke-width' => 2.2 ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php echo esc_html( $field( 'sharia_viewer_verify_label', 'Verify' ) ); ?></span>
			</a>
			<button type="button" class="sc-viewer__close" aria-label="<?php echo esc_attr( $field( 'sharia_viewer_close_label', 'Close certificate' ) ); ?>">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
			</button>
		</div>
	</div>
	<div class="sc-viewer__pages" tabindex="0" aria-label="<?php echo esc_attr( $field( 'sharia_viewer_pages_label', 'Certificate pages' ) ); ?>">
		<?php foreach ( $certificate_pages as $index => $page ) : ?>
			<?php
			$current_page = $index + 1;
			$page_url     = $media_url( $page['image'] ?? '' );
			$page_alt     = ! empty( $page['alt'] ) ? $page['alt'] : $format_page_text( $page_alt_format, $current_page, $page_count );
			$page_caption = ! empty( $page['caption'] ) ? $page['caption'] : $format_page_text( $page_caption_format, $current_page, $page_count );
			?>
			<figure>
				<img src="<?php echo esc_url( $page_url ); ?>" alt="<?php echo esc_attr( $page_alt ); ?>" loading="lazy">
				<figcaption><?php echo esc_html( $page_caption ); ?></figcaption>
			</figure>
		<?php endforeach; ?>
	</div>
</dialog>

<?php get_footer(); ?>
