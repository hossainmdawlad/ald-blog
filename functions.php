<?php
/**
 * ALD Blog Theme Functions — Prothom Alo Bengali News Portal
 *
 * @package ALD_Blog
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'ALD_BLOG_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'ALD_BLOG_DIR', get_template_directory() );
define( 'ALD_BLOG_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function ald_blog_setup() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ) );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'custom-logo', array( 'height' => 60, 'width' => 200, 'flex-width' => true ) );

    $GLOBALS['content_width'] = 1200;

    register_nav_menus( array(
        'primary' => __( 'Primary Navigation', 'ald-blog' ),
        'footer'  => __( 'Footer Navigation', 'ald-blog' ),
    ) );

    add_image_size( 'lead-article', 1200, 675, true );
    add_image_size( 'secondary-article', 600, 450, true );
    add_image_size( 'grid-article', 400, 300, true );
    add_image_size( 'sidebar-thumb', 120, 120, true );
}
add_action( 'after_setup_theme', 'ald_blog_setup' );

/**
 * Enqueue Scripts & Styles
 */
function ald_blog_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'ald-blog-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700;800&family=Source+Serif+4:opsz,wght@8..60,400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style( 'ald-blog-style', get_stylesheet_uri(), array( 'ald-blog-fonts' ), ALD_BLOG_VERSION );

    // Dark mode JS
    wp_enqueue_script( 'ald-blog-dark-mode', ALD_BLOG_URI . '/assets/js/dark-mode.js', array(), ALD_BLOG_VERSION, true );

    // Main JS
    wp_enqueue_script( 'ald-blog-main', ALD_BLOG_URI . '/assets/js/main.js', array( 'ald-blog-dark-mode' ), ALD_BLOG_VERSION, true );

    // Localize for JS
    wp_localize_script( 'ald-blog-main', 'aldBlog', array(
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'ald_blog_nonce' ),
        'themeUrl' => ALD_BLOG_URI,
        'homeUrl'  => home_url( '/' ),
    ) );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'ald_blog_scripts' );

/**
 * Bengali Number Conversion
 */
function ald_blog_to_bengali_number( $number ) {
    $bangla = array( '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯' );
    return str_replace( range( 0, 9 ), $bangla, $number );
}

/**
 * Bengali Date
 */
function ald_blog_bengali_date() {
    $days = array( 'রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার' );
    $months = array( 'জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর' );

    $now = current_time( 'timestamp' );
    $day_name = $days[ date( 'w', $now ) ];
    $day_num  = ald_blog_to_bengali_number( date( 'j', $now ) );
    $month    = $months[ date( 'n', $now ) - 1 ];
    $year     = ald_blog_to_bengali_number( date( 'Y', $now ) );

    // Approximate Bangla calendar
    $b_month = date( 'n', $now );
    $b_day   = date( 'j', $now );
    if ( $b_month == 6 && $b_day >= 15 ) {
        $bangla = ald_blog_to_bengali_number( $b_day - 14 ) . ' আষাঢ়, বর্ষা ঋতু';
    } elseif ( $b_month == 6 ) {
        $bangla = ald_blog_to_bengali_number( $b_day + 16 ) . ' জ্যৈষ্ঠ, গ্রীষ্ম ঋতু';
    } elseif ( $b_month == 7 ) {
        $bangla = ald_blog_to_bengali_number( $b_day ) . ' শ্রাবণ, বর্ষা ঋতু';
    } else {
        $bangla = '১ আষাঢ়, বর্ষা ঋতু';
    }

    return array(
        'gregorian'  => $day_name . ', ' . $day_num . ' ' . $month . ' ' . $year,
        'traditional' => 'বঙ্গাব্দ ' . ald_blog_to_bengali_number( '1433' ) . ' - ' . $bangla,
    );
}

/**
 * Get Ticker Messages
 */
function ald_blog_get_tickers() {
    $tickers = get_option( 'ald_blog_tickers' );
    if ( $tickers ) {
        return $tickers;
    }
    return array(
        'মহা সমারোহে ঢাকায় পা রাখলেন লিওনেল মেসি, বিকেলে বাফুফে কর্মকর্তাদের সাথে শুভেচ্ছা বিনিময়',
        'দেশের বাজারে স্বর্ণের দাম কমলো, আজ থেকেই কার্যকর হচ্ছে নতুন মূল্য তালিকা',
        'রপ্তানি প্রবৃদ্ধি বজায় রাখতে কৃষিজ পণ্যে বিশেষ নগদ সহায়তা বাড়ালো বাণিজ্য মন্ত্রণালয়',
    );
}

/**
 * Reading Time
 */
function ald_blog_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $count   = str_word_count( strip_tags( $content ) );
    $time    = max( 1, floor( $count / 200 ) );
    return ald_blog_to_bengali_number( $time );
}

/**
 * Widget Areas
 */
function ald_blog_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'ald-blog' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Main sidebar', 'ald-blog' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( __( 'Footer Column %d', 'ald-blog' ), $i ),
            'id'            => 'footer-' . $i,
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-heading">',
            'after_title'   => '</h3>',
        ) );
    }
}
add_action( 'widgets_init', 'ald_blog_widgets_init' );

/**
 * Newsletter Handler
 */
function ald_blog_newsletter_handler() {
    if ( ! isset( $_POST['ald_blog_newsletter_field'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['ald_blog_newsletter_field'], 'ald_blog_newsletter_nonce' ) ) return;

    $email = sanitize_email( $_POST['email'] );
    if ( ! is_email( $email ) ) return;

    $subscribers = get_option( 'ald_blog_newsletter_subscribers', array() );
    if ( ! in_array( $email, $subscribers, true ) ) {
        $subscribers[] = $email;
        update_option( 'ald_blog_newsletter_subscribers', $subscribers );
    }

    wp_safe_redirect( wp_get_referer() ? wp_get_referer() : home_url( '/' ) );
    exit;
}
add_action( 'admin_post_ald_blog_newsletter', 'ald_blog_newsletter_handler' );
add_action( 'admin_post_nopriv_ald_blog_newsletter', 'ald_blog_newsletter_handler' );

/**
 * AJAX Search
 */
function ald_blog_ajax_search() {
    check_ajax_referer( 'ald_blog_nonce', 'nonce' );

    $query = sanitize_text_field( $_GET['q'] ?? '' );
    if ( strlen( $query ) < 2 ) {
        wp_send_json( array() );
    }

    $results = new WP_Query( array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        's'              => $query,
        'posts_per_page' => 10,
    ) );

    $data = array();
    if ( $results->have_posts() ) {
        while ( $results->have_posts() ) {
            $results->the_post();
            $data[] = array(
                'title' => get_the_title(),
                'url'   => get_the_permalink(),
                'img'   => get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ),
            );
        }
    }
    wp_reset_postdata();
    wp_send_json( $data );
}
add_action( 'wp_ajax_ald_blog_search', 'ald_blog_ajax_search' );
add_action( 'wp_ajax_nopriv_ald_blog_search', 'ald_blog_ajax_search' );

/**
 * AJAX Category Filter
 */
function ald_blog_ajax_filter() {
    check_ajax_referer( 'ald_blog_nonce', 'nonce' );

    $category = sanitize_text_field( $_GET['category'] ?? 'all' );
    $search   = sanitize_text_field( $_GET['search'] ?? '' );
    $paged    = absint( $_GET['paged'] ?? 1 );

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 12,
        'paged'          => $paged,
    );

    if ( $category !== 'all' ) {
        $args['category_name'] = $category;
    }

    if ( $search ) {
        $args['s'] = $search;
    }

    $query = new WP_Query( $args );
    $data  = array(
        'html'       => '',
        'max_pages'  => $query->max_num_pages,
        'found'      => $query->found_posts,
    );

    if ( $query->have_posts() ) {
        ob_start();
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/content', 'grid' );
        }
        $data['html'] = ob_get_clean();
    } else {
        $data['html'] = '<p class="no-results">' . esc_html__( 'কোনো সংবাদ পাওয়া যায়নি', 'ald-blog' ) . '</p>';
    }
    wp_reset_postdata();
    wp_send_json( $data );
}
add_action( 'wp_ajax_ald_blog_filter', 'ald_blog_ajax_filter' );
add_action( 'wp_ajax_nopriv_ald_blog_filter', 'ald_blog_ajax_filter' );

/**
 * Fallback menu for primary navigation
 */
function ald_blog_fallback_menu() {
    $categories = get_categories( array(
        'number'     => 8,
        'orderby'    => 'count',
        'order'      => 'DESC',
        'hide_empty' => true,
    ) );
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'ald-blog' ) . '</a></li>';
    foreach ( $categories as $cat ) {
        echo '<li><a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
    }
    echo '</ul>';
}

/**
 * Custom Widgets
 */
require ALD_BLOG_DIR . '/inc/widgets.php';

/**
 * Customizer
 */
require ALD_BLOG_DIR . '/inc/customizer.php';
