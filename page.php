<?php
/**
 * Generic page template.
 *
 * @package MySalary
 */

get_header();
?>

<section class="ms-section">
    <div class="ms-container" style="max-width: 760px;">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header style="margin-bottom: 32px;">
                    <h1><?php the_title(); ?></h1>
                </header>

                <div class="ms-page-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>

<?php get_footer(); ?>
