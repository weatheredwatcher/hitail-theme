<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

include 'header-post.php'; ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php
            // Start the loop.
            while ( have_posts() ) : the_post();
?>

               <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>

    <header class="entry-header">
<img class="header-image" src="/wp-content/themes/hitail-theme/william-iven-8515-unsplash.jpg" alt="category" />
    </header><!-- .entry-header -->
    <div class="entry-content">
        <?php

            the_content(); ?>
            </div>
            <div>
                <img src="/wp-content/themes/hitail-theme/CC%20CTA.png" alt="community collaboration" style="width: 100%" />
            </div>
            <hr />
            <div class="social-icons">
                <p><h1 style="font-family: verbregular;">SHARE THIS POST</h1></p>
               <h1>filt</h1>
            </div>

                 <?php
            endwhile;
            ?>
<div class="community-footer">
                <h1 class="community-footer-txt">   <a href="/archives">All Articles</a> | <a href="/">Community</a> | <?php next_post_link('Next Article', 'Next Article', 'yes'); ?> </h1>
</div>





        </main><!-- .site-main -->
    </div><!-- .content-area -->

<?php get_footer();
