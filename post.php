<?php
/**
 * The template for displaying posts.
 *
 */

get_header(); ?>

    <main class="site-content">
        <div class="layout-container">

          <article id="post-<?php the_ID(); ?>" <?php post_class('search-post'); ?>>

	<?php
// the query

<div class="container">
            <div class="col-sm-12">

 <?php if ( have_posts() ) :?>
            <div class="bs-calltoaction bs-calltoaction-default">
                    <div class="row">
                        <div class="col-md-9 cta-contents">
            <?php the_title( sprintf( '<h2 class="h3 search-post-title">', esc_url( get_permalink() ) ), '</h2>' ); ?>
</div></div></div>
           <div class="entry-content">

		<?php
		the_post();
		the_content(); ?>

	</div><!-- .entry-content -->
 <?php endif; // End of the loop. ?>
    <!-- end of the loop -->
            </div>
        </div>

    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>


        </div>
    </main>

        </div>
    </main>

<?php get_footer(); ?>
