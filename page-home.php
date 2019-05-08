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
        </div>

    </div>

</div>
<?php

get_footer(); ?>