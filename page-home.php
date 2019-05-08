<?php

/**
 * The template for displaying the home page.
 *
 */

//This query loads the last five featured posts.
$args = array(
    'posts_per_page' => 5,
    'meta_key' => 'meta-checkbox',
    'meta_value' => 'yes'
);

$featured = new WP_Query($args);
// end of featured posts query

get_header(); ?>


<div class="container-fluid">

    <div class="row">
        <div class="col">
            <h1>FEATURED<span style="color: orange;">.</span></h1>
            <?php
            if ($featured->have_posts()): while($featured->have_posts()): $featured->the_post(); ?>


                <?php if (has_post_thumbnail()) : ?>
                    <figure> <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium_large', ['class' => 'featured']); ?></a> </figure>
                    <h3><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h3>


                    <p ><?php the_excerpt();?></p>
                    <?php echo get_avatar( get_the_author_meta( 'ID'), ['class' => 'rounded']); ?>
                    <p class="details">By <a href="<?php the_author_posts() ?>"><?php the_author(); ?> </a> / On <?php echo get_the_date('F j, Y'); ?> / In <?php the_category(', '); ?></p>
                <?php
                endif;
            endwhile; else:
            endif;

            ?>

        </div>
        <div class="col-sm">
            <h1>POPULAR<span style="color: orange;">.</span></h1>
            <?php dynamic_sidebar( 'home_wpp' ); ?>


            <h1>CATEGORIES<span style="color: orange;">.</span></h1>

        </div>
    </div>
    <hr />
        <!-- the loop -->

        <?php
        // the query
        $wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>3)); ?>
    <div class="container-fluid">
        <div class="row">
            <div class=""col-sm">
            <h1 class="h3 search-post-title">LATEST<span style="color: #f15b41">.</span></h1>
        </div>
        </div>
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
    <div class="center-label"><a href="/archives/">View More</a></div>
    </div>


<?php

get_footer(); ?>