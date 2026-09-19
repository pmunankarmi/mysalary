<?php
/**
 * Fallback template — rarely hit. The site is single-page focused, but
 * this exists to satisfy WordPress's template hierarchy requirements.
 *
 * @package MySalary
 */

get_header();
?>

<section class="ms-section">
    <div class="ms-container" style="max-width: 760px;">
        <?php if ( have_posts() ) : ?>
            <header style="margin-bottom: 32px;">
                <h1><?php
                    if ( is_home() && ! is_front_page() ) {
                        single_post_title();
                    } elseif ( is_archive() ) {
                        the_archive_title();
                    } elseif ( is_search() ) {
                        /* translators: %s = search query */
                        printf( esc_html__( 'Search results for "%s"', 'mysalary' ), esc_html( get_search_query() ) );
                    }
                ?></h1>
            </header>

            <?php while ( have_posts() ) : the_post(); ?>
                <article <?php post_class(); ?> style="margin-bottom: 48px;">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div><?php the_excerpt(); ?></div>
                </article>
            <?php endwhile; ?>

            <?php the_posts_pagination(); ?>

        <?php else : ?>
            <p><?php esc_html_e( 'Nothing to display.', 'mysalary' ); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
