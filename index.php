<?php
/**
 * Template Name: Full Width
 */

get_header(); ?>

    <section id="primary" class="content-area col-sm-12" style="margin-left: 200px; width: 800px;" >
        <main id="main" class="site-main" role="main">

            <?php
            while ( have_posts() ) : the_post();

                get_template_part( 'template-parts/content', 'page' );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>

        </main><!-- #main -->
    </section><!-- #primary -->

<?php
get_footer();
