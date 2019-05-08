<?php
/**
 * The template for displaying archives.
 *
 */

get_header(); ?>

    <main class="site-content">
        <div class="layout-container">

          <article id="post-<?php the_ID(); ?>" <?php post_class('search-post'); ?>>
	<?php the_title( sprintf( '<h2 class="h3 search-post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	<?php if ( 'post' === get_post_type() ) : ?>
	<p class="search-post-meta"><a href="<?php get_bloginfo('url'); ?>/author/<?php the_author_meta( 'user_login' ); ?>"><?php the_author(); ?></a> on <?php the_date(); ?></p>
	<?php endif; ?>

	<div class="entry-summary">
		<p><?php the_excerpt(); ?></p>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( ', ' );
			if ( $categories_list && hightail_twentysixteen_categorized_blog() ) {
				printf( '<p class="small search-post-categories">' . esc_html__( 'Posted in %1$s' ) . '</p>', $categories_list ); // WPCS: XSS OK.
			}
		}
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

        </div>
    </main>

<?php get_footer(); ?>
