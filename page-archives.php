<?php
/**
 * The template for displaying archives.
 *
 */

get_header(); ?>

    <main class="site-content">
        <div class="layout-container">

          <article id="post-<?php the_ID(); ?>" <?php post_class('search-post'); ?>>

	<?php
// the query
$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>10)); ?>


<div class="container">
            <div class="col-sm-12">
            <div class="bs-calltoaction bs-calltoaction-default">
                    <div class="row">
                        <div class="col-md-9 cta-contents">
                            <h2 class="h3 search-post-title">ALL ARTICLES<span style="color: #f15b41">.</span></h2>
</div></div></div>
<?php if ( $wpb_all_query->have_posts() ) : ?>

 <!-- the loop -->

    <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>

                <div class="bs-calltoaction bs-calltoaction-default">
                    <div class="row">
                        <div class="col-md-9 cta-contents">
                            <h1 class="cta-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" style="color: black; text-decoration: none;"><?php the_title(); ?></a></h1>
                            <div class="cta-desc">
                                <p> <?php the_excerpt(); ?></p>
        <p><?php $date = get_the_date( 'l F j, Y' );  echo $date . '<span style="color:#f15b41">&bull;</span>'; echo do_shortcode('[rt_reading_time postfix="minutes" postfix_singular="minute"]'); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3 cta-button">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail');  ?></a>
                        </div>
                     </div>
                </div>
                 <?php endwhile; ?>
    <!-- end of the loop -->
            </div>
        </div>

    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>


        </div>
    </main>

<div id="orange-block">
    <h1> Back to Community <h1>
</div>

<?php get_footer(); ?>
