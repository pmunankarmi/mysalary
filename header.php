<?php
/**
 * Site header.
 *
 * @package MySalary
 */
$header_home_url = function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-4LEREL9DL6"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-4LEREL9DL6');
	</script>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#3D2A8C" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'mysalary' ); ?></a>
<?php if( ! is_page_template ( 'page-templates/template-demo.php' ) ) : ?>
<header class="ms-header" role="banner">
    <div class="ms-container ms-header__inner">

        <a href="<?php echo esc_url( $header_home_url ); ?>"
           class="ms-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' ' . __( 'home', 'mysalary' ) ); ?>">
            <?php
            $custom_logo_id = (int) get_theme_mod( 'custom_logo' );
            if ( $custom_logo_id ) {
                echo wp_get_attachment_image( $custom_logo_id, 'full', false, [
                    'class'   => 'ms-logo__image',
                    'loading' => 'eager',
                ] );
            } else {
                ?>
                <img class="ms-logo__image"
                     src="<?php echo esc_url( MYSALARY_URI . '/assets/images/mysalary-logo.svg' ); ?>"
                     width="200" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
                <?php
            }
            ?>
        </a>

        <nav class="ms-nav" id="msNav" aria-label="<?php esc_attr_e( 'Primary', 'mysalary' ); ?>">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '%3$s',  // raw <li>s — but our CSS targets bare anchors, so we strip li below
                    'walker'         => new MySalary_Anchor_Only_Walker(),
                  //  'depth'          => 1,
                    'fallback_cb'    => '__return_false',
                ] );
            } else {
                // Default in-page anchors when no menu has been assigned yet.
                $defaults = [
                    '#solution'  => mysalary_form_string( 'nav_solution', 'Solution', 'الحل' ),
                    '#how'       => mysalary_form_string( 'nav_how', 'How it works', 'كيف تعمل الخدمة' ),
                    '#benefits'  => mysalary_form_string( 'nav_employers', 'Employers', 'أصحاب العمل' ),
                    '#trust'     => mysalary_form_string( 'nav_trust', 'Trust', 'الثقة' ),
                    '#faq'       => mysalary_form_string( 'nav_faq', 'FAQ', 'الأسئلة الشائعة' ),
                ];
                foreach ( $defaults as $href => $label ) {
                    $nav_url = is_front_page() ? $href : $header_home_url . $href;
                    printf( '<a href="%s">%s</a>', esc_url( $nav_url ), esc_html( $label ) );
                }
            }
            ?>

           <?php $demo_url  = mysalary_field( 'demo_url', 'option', mysalary_get_demo_url() ); ?>
            <a href="<?php echo esc_url( $demo_url ); ?>" class="ms-btn ms-btn--primary ms-header__cta">
                <?php echo esc_html( mysalary_form_string( 'request_demo', 'Request a Demo', 'طلب عرض توضيحي' ) ); ?>
                <?php echo mysalary_icon( 'arrow-right', [ 'class' => 'ms-btn__arrow', 'width' => 14, 'height' => 14, 'stroke-width' => 2.5 ] ); // phpcs:ignore ?>
            </a>

            <?php mysalary_language_switcher(); ?>
        </nav>

        <button class="ms-burger" type="button"
                aria-label="<?php echo esc_attr( mysalary_form_string( 'nav_open_menu', 'Open menu', 'فتح القائمة' ) ); ?>"
                data-open-label="<?php echo esc_attr( mysalary_form_string( 'nav_open_menu', 'Open menu', 'فتح القائمة' ) ); ?>"
                data-close-label="<?php echo esc_attr( mysalary_form_string( 'nav_close_menu', 'Close menu', 'إغلاق القائمة' ) ); ?>"
                aria-controls="msNav" aria-expanded="false" id="msBurger">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
<?php endif; ?>
<main id="main">
