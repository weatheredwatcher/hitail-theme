<?php
if ( ! function_exists( 'hightail_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hightail_setup() {

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );



    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => 'Primary Menu Nav',
        'footer' => 'Footer Nav'
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    /*
     * Enable support for Post Formats.
     * See https://developer.wordpress.org/themes/functionality/post-formats/
     */
    add_theme_support( 'post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
    ) );

}
endif; // hightail_setup
add_action( 'after_setup_theme', 'hightail_setup' );


/********************************************************************************************************************************************************************************************
 * THIS IS FOR JETPACK RELATED POSTS
 */
function jetpackme_remove_rp() {
   if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
       $jprp = Jetpack_RelatedPosts::init();
       $callback = array( $jprp, 'filter_add_target_to_dom' );
       remove_filter( 'the_content', $callback, 40 );
   }
}
add_filter( 'wp', 'jetpackme_remove_rp', 20 );

function jetpackme_custom_related( $atts ) {
    $posts_titles = array();

    if ( class_exists( 'Jetpack_RelatedPosts' ) && method_exists( 'Jetpack_RelatedPosts', 'init_raw' ) ) {
        $related = Jetpack_RelatedPosts::init_raw()
            ->set_query_name( 'jetpackme-shortcode' ) // Optional, name can be anything
            ->get_for_post_id(
                get_the_ID(),
                array( 'size' => 3 )
            );

        if ( $related ) {
            foreach ( $related as $result ) {
                // Get the related post IDs
                $related_post = get_post( $result[ 'id' ] );
                $excerpt = $related_post->post_content;
                $excerpt = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $excerpt);
                $related_content = wp_trim_words($excerpt, 15);

                echo '<li class="single-post-related-list-item"><p class="single-post-related-list-header"><a href="';
                echo post_permalink($related_post);
                echo '" rel="bookmark" title="';
                echo $related_post->post_title;
                echo '">';
                echo $related_post->post_title;
                echo '</a></strong></p><p class="single-post-related-list-content">';
                echo $related_content;
                echo '</p></li>';
            }
        }
    }
}

 //add boostrap nav walker

//require_once get_template_directory() . '/wp-bootstrap-navwalker.php';

if ( ! file_exists( get_template_directory() . '/wp-bootstrap-navwalker.php' ) ) {
	// file does not exist... return an error.
	return new WP_Error( 'wp-bootstrap-navwalker-missing', __( 'It appears the wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
} else {
	// file exists... require it.
	require_once get_template_directory() . '/wp-bootstrap-navwalker.php';
}

// Create a [jprel] shortcode
add_shortcode( 'jprel', 'jetpackme_custom_related' );


/**
 * Enqueue scripts and styles.
 */
function hightail_scripts() {
    wp_enqueue_style( 'hightail-style', get_stylesheet_uri() );
    wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
    wp_enqueue_script( 'boot1','https://code.jquery.com/jquery-3.3.1.slim.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'boot2','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'boot3','https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'main', '/wp-content/themes/hitail-theme/main.js', array( 'jquery'));
}
add_action( 'wp_enqueue_scripts', 'hightail_scripts' );


function custom_excerpt_length( $length ) {
    if (is_home()) {
        return 20;
    } elseif (is_single()) {
        return 50;
    } else {
        return 50;
    }
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function wpdocs_excerpt_more( $more ) {
    return '&hellip;&nbsp;<a href="' . get_permalink($post->ID) . '" style="color: #f15b41">Read more <span class="screen-reader-text"></span></a>';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

/**
 * Change number of posts on home and archive pages
 */
function limit_posts( $query ) {
    if ( $query->is_main_query() ) {
        $query->set( 'posts_per_page', 12 );
    }
}
add_action( 'pre_get_posts', 'limit_posts' );

/**
 * Comment layout
 */
function custom_comments_layout($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
    <li id="comment-<?php comment_ID(); ?>" class="comment-list-item parent">
        <div class="comment-avatar"><?php echo get_avatar($comment, 35); ?></div>
        <div class="comment-meta">
            <p class="comment-meta-author"><?php comment_author( $comment_ID ); ?></p>
            <p class="comment-meta-time"><?php printf( _x( '%s ago', '%s = human-readable time difference', 'your-text-domain' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></p>
        </div>
        <div class="comment-text">
            <?php if ($comment->comment_approved == '0') : ?>
                <p class="no-margin comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.','bonestheme') ?></p>
            <?php endif; ?>
            <?php comment_text() ?>
        </div>
		<div class="comment-reply">
	        <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'], 'class' => 'comment-reply-link' ) ) ); ?>
	    </div>
    <!-- </li> is added by wordpress automatically -->
<?php
}

/**
 * Disable open graph in Jetpack plugin
 */
add_filter( 'jetpack_enable_opengraph', '__return_false', 99 );

function sm_custom_meta() {
    add_meta_box( 'sm_meta', __( 'Featured Posts', 'sm-textdomain' ), 'sm_meta_callback', 'post' );
}
function sm_meta_callback( $post ) {
    $featured = get_post_meta( $post->ID );
    ?>

    <p>
    <div class="sm-row-content">
        <label for="feature-checkbox">
            <input type="checkbox" name="feature-checkbox" id="feature-checkbox" value="yes" <?php if ( isset ( $featured['feature-checkbox'] ) ) checked( $featured['feature-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Feature this post', 'sm-textdomain' )?>
        </label> <br />
        <label for="thumbnail-checkbox">
            <input type="checkbox" name="thumbnail-checkbox" id="thumbnail-checkbox" value="yes" <?php if ( isset ( $featured['thumbnail-checkbox'] ) ) checked( $featured['thumbnail-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Include Pre-Set Thumbnail', 'sm-textdomain' )?>
        </label>

    </div>
    </p>

    <?php
}
add_action( 'add_meta_boxes', 'sm_custom_meta' );

/**
 * Saves the custom meta input
 */
function sm_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'sm_nonce' ] ) && wp_verify_nonce( $_POST[ 'sm_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and saves
    if( isset( $_POST[ 'feature-checkbox' ] ) ) {
        update_post_meta( $post_id, 'feature-checkbox', 'yes' );
    } else {
        update_post_meta( $post_id, 'feature-checkbox', '' );
    }

    if( isset( $_POST[ 'thumbnail-checkbox' ] ) ) {
        update_post_meta( $post_id, 'thumbnail-checkbox', 'yes' );
    } else {
        update_post_meta( $post_id, 'thumbnail-checkbox', '' );
    }

   // update_post_meta($post_id, 'meta-quote', );

}
add_action( 'save_post', 'sm_meta_save' );

/**
 * Removes the regular excerpt box. We're not getting rid
 * of it, we're just moving it above the wysiwyg editor
 *
 * @return null
 */
function ot_remove_normal_excerpt() {
    remove_meta_box( 'postexcerpt' , 'post' , 'normal' );
}
add_action( 'admin_menu' , 'ot_remove_normal_excerpt' );

/**
 * Add the excerpt meta box back in with a custom screen location
 *
 * @param  string $post_type
 * @return null
 */
function ot_add_excerpt_meta_box( $post_type ) {
    if ( in_array( $post_type, array( 'post', 'page' ) ) ) {
        add_meta_box(
            'ot_postexcerpt',
            __( 'Excerpt', 'thetab-theme' ),
            'post_excerpt_meta_box',
            $post_type,
            'after_title',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'ot_add_excerpt_meta_box' );

/**
 * You can't actually add meta boxes after the title by default in WP so
 * we're being cheeky. We've registered our own meta box position
 * `after_title` onto which we've registered our new meta boxes and
 * are now calling them in the `edit_form_after_title` hook which is run
 * after the post tile box is displayed.
 *
 * @return null
 */
function ot_run_after_title_meta_boxes() {
    global $post, $wp_meta_boxes;
    # Output the `below_title` meta boxes:
    do_meta_boxes( get_current_screen(), 'after_title', $post );
}
add_action( 'edit_form_after_title', 'ot_run_after_title_meta_boxes' );

function get_stock_hero($category)
{
    switch ($category) {
        case "Technology":
        return "https//unsplash.com/photos/SpVHcbuKi6E&d=DwIFaQ&c=ZgVRmm3mf2P1-XDAyDsu4A&r=oSXGsybfQcSSLrX1uxRnsbIfEjjSxpHE12TUfoP7ulU&m=3GfbZ2gXazD0NGuUl5NKpOdcCAj60YbMfdu18zBBsUc&s=FYbJqc7NAHszBZp3x7Ad-s-QsblJ2VcOrpjaOxgGW1g&e=";
        break;

        case "Creative":
        case "Creativity":
        return "https://urldefense.proofpoint.com/v2/url?u=https-3A__unsplash.com_photos_l3N9Q27zULw&d=DwIFaQ&c=ZgVRmm3mf2P1-XDAyDsu4A&r=oSXGsybfQcSSLrX1uxRnsbIfEjjSxpHE12TUfoP7ulU&m=3GfbZ2gXazD0NGuUl5NKpOdcCAj60YbMfdu18zBBsUc&s=lVX93bad6YufYJ9E3-8sXwVPcQr9Njlgr_VHoGzSB88&e=";
        break;

        case "Product":
        case "How to Hightail":
        return "https://urldefense.proofpoint.com/v2/url?u=https-3A__unsplash.com_photos_KE0nC8-2D58MQ&d=DwIFaQ&c=ZgVRmm3mf2P1-XDAyDsu4A&r=oSXGsybfQcSSLrX1uxRnsbIfEjjSxpHE12TUfoP7ulU&m=3GfbZ2gXazD0NGuUl5NKpOdcCAj60YbMfdu18zBBsUc&s=KQBh3tBg7pLGvaOXJ8aRAIWh19FZzrPcLyAj_cMpPzs&e=";
        break;

    case "Culture":
    case "International":
    case "Opinion":
    case "Team collaboration":
        return "https://urldefense.proofpoint.com/v2/url?u=https-3A__unsplash.com_photos_IgUR1iX0mqM&d=DwIFaQ&c=ZgVRmm3mf2P1-XDAyDsu4A&r=oSXGsybfQcSSLrX1uxRnsbIfEjjSxpHE12TUfoP7ulU&m=3GfbZ2gXazD0NGuUl5NKpOdcCAj60YbMfdu18zBBsUc&s=ZIWyCgpfnR8XkauXFsIGLssg0auFzTCc6ALbyQdUQm4&e=";
           // break;

    case "Customers":
    case "Customer stories":
        return "https://urldefense.proofpoint.com/v2/url?u=https-3A__unsplash.com_photos_GWe0dlVD9e0&d=DwIFaQ&c=ZgVRmm3mf2P1-XDAyDsu4A&r=oSXGsybfQcSSLrX1uxRnsbIfEjjSxpHE12TUfoP7ulU&m=3GfbZ2gXazD0NGuUl5NKpOdcCAj60YbMfdu18zBBsUc&s=20GoQvahlR8iBDn8wZ1ulcK54ENROjYmME3PADfdidQ&e=";
        break;
 //       case "Marketers": or "Content Marketing" or "agencies" which is now "Marketing" Category: https://urldefense.proofpoint.com/v2/url?u=https-3A__unsplash.com_photos_yktK2qaiVHI&d=DwIFaQ&c=ZgVRmm3mf2P1-XDAyDsu4A&r=oSXGsybfQcSSLrX1uxRnsbIfEjjSxpHE12TUfoP7ulU&m=3GfbZ2gXazD0NGuUl5NKpOdcCAj60YbMfdu18zBBsUc&s=AIW_omiDrNG6vNmc8n0HR9h8FkAwyFWY2Gtb2s2Qza4&e=
 //   case "Productivity" Category: https://urldefense.proofpoint.com/v2/url?u=https-3A__unsplash.com_photos_qY9zgRqmNtA&d=DwIFaQ&c=ZgVRmm3mf2P1-XDAyDsu4A&r=oSXGsybfQcSSLrX1uxRnsbIfEjjSxpHE12TUfoP7ulU&m=3GfbZ2gXazD0NGuUl5NKpOdcCAj60YbMfdu18zBBsUc&s=BOJ53JEGOVwHA9fXdVKb9TZyblqaVGTyv3xNysgcHTM&e=
//    case "Hightail FAQ" Category which is for future posts, default image can be: https://urldefense.proofpoint.com/v2/url?u=https-3A__unsplash.com_photos_qAriosuB-2DlY&d=DwIFaQ&c=ZgVRmm3mf2P1-XDAyDsu4A&r=oSXGsybfQcSSLrX1uxRnsbIfEjjSxpHE12TUfoP7ulU&m=3GfbZ2gXazD0NGuUl5NKpOdcCAj60YbMfdu18zBBsUc&s=FnC_ck7I-h-qITUQKefVfnEGgSNxhlp0bIZ5BMGqqrs&e=
    }
}

/**
 * Register our sidebars and widgetized areas.
 *
 */
function home_wpp_widgets_init() {

    register_sidebar( array(
        'name'          => 'Home WPP',
        'id'            => 'home_wpp',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );

}
add_action( 'widgets_init', 'home_wpp_widgets_init' );