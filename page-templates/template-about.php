<?php
/**
 * Template Name: About
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$eyebrow = get_field( 'about_eyebrow' );
$heading = get_field( 'about_heading' );

?>

<section class="ip-hero">
      <div class="ms-container">
		<?php if ( $eyebrow ) : ?> 
        <span class="ip-eyebrow"><span class="ms-hero__eyebrow-dot"></span> <?php echo esc_html( $eyebrow ); ?></span>
		<?php endif; ?>
        <h1><?php the_title(); ?></h1>
        <p class="ip-lead"><?php echo esc_html( $heading ); ?></p>
      </div>
    </section>

    <section class="ip-section">
      <div class="ms-container">
        <div class="about-prose">
          <?php the_content(); ?>
        </div>
      </div>
    </section>
<?php
get_footer();
