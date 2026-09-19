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

$field = static function ( $name, $fallback = '' ) {
	return mysalary_field( $name, false, $fallback );
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

$default_governance_points = [
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

$default_committee_members = [
	[
		'name' => 'Sh. Dr. Abdullah Bin Khalid AlJohar',
		'role' => 'Sharia Advisor',
		'bio'  => "Sheikh Dr. Abdullah Bin Khalid AlJohar is a Saudi academic and Sharia consultant specializing in comparative jurisprudence, contracts, and contemporary financial transactions, with more than 13 years of academic and advisory experience. He currently serves as Assistant Professor of Jurisprudence at King Faisal University's College of Sharia and Islamic Studies and has previously taught at Imam Muhammad Ibn Saud Islamic University.\n\nHe provides Sharia and legal consultancy to academic, financial, and research institutions and serves as an arbitrator in commercial and financial disputes. He holds a PhD in Jurisprudence from Imam Muhammad Ibn Saud Islamic University, with research focusing on dependency in financial transactions, alongside a Master's and Bachelor's in Sharia and Comparative Jurisprudence. His research interests include Sukuk, hedging, risk management, Murabaha and Mudaraba structures, financial contracts, Zakat jurisprudence, Islamic legal maxims and objectives, and contemporary financial markets. He is also certified by the Chartered Institute of Arbitrators (CIArb), UK, and has undertaken advanced training in Islamic banking, cooperative insurance, and financial product development.\n\nHe actively serves on Sharia Boards and provides Sharia advisory oversight to institutions across the insurance, financing, investment fund, and fintech sectors.",
	],
];

$governance_points = $field( 'sharia_governance_points', $default_governance_points );
$committee_members = $field( 'sharia_committee_members', $default_committee_members );

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
