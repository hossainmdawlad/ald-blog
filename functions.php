<?php
/**
 * ALD Blog Theme Functions
 *
 * @package ALD_Blog
 * @version 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Theme version for cache busting
 */
define( 'ALD_BLOG_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'ALD_BLOG_DIR', get_template_directory() );
define( 'ALD_BLOG_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function ald_blog_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable post thumbnails
    add_theme_support( 'post-thumbnails' );

    // Set content width
    $GLOBALS['content_width'] = 720;

    // HTML5 markup support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ) );

    // Responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Block editor styles
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor.css' );

    // Wide alignment
    add_theme_support( 'align-wide' );

    // Custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Custom header
    add_theme_support( 'custom-header', array(
        'default-image'      => '',
        'width'              => 1200,
        'height'             => 300,
        'flex-height'        => true,
        'flex-width'         => true,
        'uploads'            => true,
        'video'              => false,
    ) );

    // WooCommerce support (optional)
    // add_theme_support( 'woocommerce' );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'ald-blog' ),
        'footer'  => __( 'Footer Menu', 'ald-blog' ),
    ) );

    // Image sizes
    add_image_size( 'ald-blog-card', 600, 340, true );
    add_image_size( 'ald-blog-featured', 1200, 630, true );
}
add_action( 'after_setup_theme', 'ald_blog_setup' );

/**
 * Register widget areas (sidebars)
 */
function ald_blog_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'ald-blog' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'ald-blog' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 1', 'ald-blog' ),
        'id'            => 'footer-1',
        'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 2', 'ald-blog' ),
        'id'            => 'footer-2',
        'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 3', 'ald-blog' ),
        'id'            => 'footer-3',
        'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'ald_blog_widgets_init' );

/**
 * Enqueue scripts and styles — Performance optimized
 */
function ald_blog_scripts() {
    // Main stylesheet (already contains critical CSS inline, this is deferred)
    wp_enqueue_style(
        'ald-blog-style',
        ALD_BLOG_URI . '/style.css',
        array(),
        ALD_BLOG_VERSION
    );

    // Non-critical CSS — deferred loading
    wp_enqueue_style(
        'ald-blog-main',
        ALD_BLOG_URI . '/assets/css/main.css',
        array(),
        ALD_BLOG_VERSION,
        'print' // Load as print first, then switch to all via JS
    );

    // Add media="all" to deferred CSS after page load
    wp_script_add_data( 'ald-blog-main', 'async', true );

    // Main vanilla JS — deferred
    wp_enqueue_script(
        'ald-blog-main',
        ALD_BLOG_URI . '/assets/js/main.js',
        array(),
        ALD_BLOG_VERSION,
        true // Load in footer
    );

    // Comment reply script — only on single posts with open comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // Remove WordPress block library CSS (we don't use blocks on frontend)
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' );
    wp_dequeue_style( 'global-styles' );
    wp_dequeue_style( 'classic-theme-styles' );

    // Remove emoji scripts
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );

    // Remove unnecessary WP head links
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    remove_action( 'wp_head', 'rel_canonical' ); // We handle this manually
    remove_action( 'wp_head', 'feed_links_extra', 3 ); // Remove extra feed links

    // Remove dashicons for non-admin users
    if ( ! is_admin() && ! is_user_logged_in() ) {
        wp_deregister_style( 'dashicons' );
    }
}
add_action( 'wp_enqueue_scripts', 'ald_blog_scripts', 100 );

/**
 * Defer non-critical CSS — swap media from "print" to "all" via onload
 */
function ald_blog_defer_css( $html, $handle ) {
    if ( 'ald-blog-main' === $handle ) {
        $html = str_replace(
            "media='print'",
            "media='print' onload=\"this.media='all'\"",
            $html
        );
        // Add noscript fallback
        $html .= '<noscript><link rel="stylesheet" href="' . esc_url( ALD_BLOG_URI . '/assets/css/main.css' ) . '?ver=' . ALD_BLOG_VERSION . '"></noscript>';
    }
    return $html;
}
add_filter( 'style_loader_tag', 'ald_blog_defer_css', 10, 2 );

/**
 * Add preload for critical assets
 */
function ald_blog_resource_hints( $hints, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        // Preconnect to Google Fonts (if used) and AdSense
        $hints[] = 'https://fonts.googleapis.com';
        $hints[] = 'https://fonts.gstatic.com';
        $hints[] = 'https://pagead2.googlesyndication.com';
        $hints[] = 'https://googleads.g.doubleclick.net';
    }
    if ( 'dns-prefetch' === $relation_type ) {
        $hints[] = 'https://pagead2.googlesyndication.com';
        $hints[] = 'https://googleads.g.doubleclick.net';
        $hints[] = 'https://tpc.googlesyndication.com';
    }
    return $hints;
}
add_filter( 'wp_resource_hints', 'ald_blog_resource_hints', 10, 2 );

/**
 * Add async/defer to specific scripts
 */
function ald_blog_add_async_defer( $tag, $handle ) {
    // Scripts that should be deferred
    $defer_scripts = array( 'ald-blog-main' );

    if ( in_array( $handle, $defer_scripts, true ) ) {
        return str_replace( ' src=', ' defer src=', $tag );
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'ald_blog_add_async_defer', 10, 2 );

/**
 * Lazy load images — add loading="lazy" to post content images
 */
function ald_blog_lazy_load_images( $content ) {
    if ( is_admin() || is_feed() ) {
        return $content;
    }

    // Add loading="lazy" to images that don't have it
    $content = preg_replace(
        '/<img([^>]+?)(\/?)>/i',
        function ( $matches ) {
            if ( strpos( $matches[1], 'loading=' ) !== false ) {
                return $matches[0];
            }
            // Don't lazy-load the first image (likely above the fold)
            static $count = 0;
            $count++;
            if ( $count <= 1 ) {
                return '<img' . $matches[1] . ' decoding="async"' . $matches[2] . '>';
            }
            return '<img' . $matches[1] . ' loading="lazy" decoding="async"' . $matches[2] . '>';
        },
        $content
    );

    return $content;
}
add_filter( 'the_content', 'ald_blog_lazy_load_images', 20 );

/**
 * Add width and height to images to prevent CLS
 */
function ald_blog_image_dimensions( $html, $id ) {
    if ( is_admin() ) {
        return $html;
    }

    $image = wp_get_attachment_image_src( $id, 'full' );
    if ( $image && strpos( $html, 'width=' ) === false ) {
        $html = str_replace( '<img', '<img width="' . esc_attr( $image[1] ) . '" height="' . esc_attr( $image[2] ) . '"', $html );
    }

    return $html;
}
add_filter( 'wp_get_attachment_image_html', 'ald_blog_image_dimensions', 10, 2 );

/**
 * Custom excerpt length
 */
function ald_blog_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'ald_blog_excerpt_length' );

/**
 * Custom excerpt more
 */
function ald_blog_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'ald_blog_excerpt_more' );

/**
 * Add custom body classes
 */
function ald_blog_body_classes( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'singular';
    }
    if ( is_active_sidebar( 'sidebar-1' ) && ( is_home() || is_archive() || is_single() ) ) {
        $classes[] = 'has-sidebar';
    }
    return $classes;
}
add_filter( 'body_class', 'ald_blog_body_classes' );

/**
 * Add custom post classes
 */
function ald_blog_post_classes( $classes ) {
    if ( ! is_singular() ) {
        $classes[] = 'post-card';
    }
    return $classes;
}
add_filter( 'post_class', 'ald_blog_post_classes' );

/**
 * Output canonical tag manually (cleaner than WP default)
 */
function ald_blog_canonical() {
    if ( is_singular() ) {
        echo '<link rel="canonical" href="' . esc_url( get_permalink() ) . '">' . "\n";
    } elseif ( is_home() || is_front_page() ) {
        echo '<link rel="canonical" href="' . esc_url( home_url( '/' ) ) . '">' . "\n";
    } elseif ( is_category() || is_tag() || is_tax() ) {
        echo '<link rel="canonical" href="' . esc_url( get_queried_object_link() ) . '">' . "\n";
    } elseif ( is_search() ) {
        echo '<link rel="canonical" href="' . esc_url( get_search_link() ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'ald_blog_canonical', 1 );

/**
 * Helper: Get term archive link
 */
function get_queried_object_link() {
    $obj = get_queried_object();
    if ( $obj && isset( $obj->term_id ) ) {
        return get_term_link( $obj );
    }
    return '';
}

/**
 * Add Open Graph meta tags (basic — SEO plugins can override)
 */
function ald_blog_og_tags() {
    if ( ! is_singular() ) {
        return;
    }

    global $post;

    $title = get_the_title();
    $url   = get_permalink();
    $desc  = has_excerpt() ? get_the_excerpt() : wp_trim_words( $post->post_content, 30 );
    $img   = get_the_post_thumbnail_url( $post->ID, 'large' );

    echo '<meta property="og:type" content="article">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";

    if ( $img ) {
        echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
    }

    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";

    if ( $img ) {
        echo '<meta name="twitter:image" content="' . esc_url( $img ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'ald_blog_og_tags', 5 );

/**
 * Schema.org structured data — BlogPosting
 */
function ald_blog_schema() {
    if ( ! is_singular( 'post' ) ) {
        return;
    }

    global $post;

    $schema = array(
        '@context'         => 'https://schema.org',
        '@type'            => 'BlogPosting',
        'headline'         => get_the_title(),
        'description'      => get_the_excerpt(),
        'url'              => get_permalink(),
        'datePublished'    => get_the_date( 'c' ),
        'dateModified'     => get_the_modified_date( 'c' ),
        'author'           => array(
            '@type' => 'Person',
            'name'  => get_the_author(),
            'url'   => get_author_posts_url( get_the_author_meta( 'ID' ) ),
        ),
        'publisher'        => array(
            '@type' => 'Organization',
            'name'  => get_bloginfo( 'name' ),
            'url'   => home_url( '/' ),
        ),
        'mainEntityOfPage' => array(
            '@type' => 'WebPage',
            '@id'   => get_permalink(),
        ),
    );

    // Add featured image
    if ( has_post_thumbnail() ) {
        $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
        if ( $img ) {
            $schema['image'] = array(
                '@type'  => 'ImageObject',
                'url'    => $img[0],
                'width'  => $img[1],
                'height' => $img[2],
            );
        }
    }

    // Add categories
    $categories = get_the_category();
    if ( $categories ) {
        $schema['articleSection'] = $categories[0]->name;
    }

    // Add tags
    $tags = get_the_tags();
    if ( $tags ) {
        $schema['keywords'] = implode( ', ', wp_list_pluck( $tags, 'name' ) );
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'ald_blog_schema', 20 );

/**
 * Schema.org — BreadcrumbList
 */
function ald_blog_breadcrumb_schema() {
    if ( is_front_page() ) {
        return;
    }

    $breadcrumbs = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => array(),
    );

    // Home
    $breadcrumbs['itemListElement'][] = array(
        '@type'    => 'ListItem',
        'position' => 1,
        'name'     => __( 'Home', 'ald-blog' ),
        'item'     => home_url( '/' ),
    );

    $position = 2;

    if ( is_category() || is_tag() || is_tax() ) {
        $obj = get_queried_object();
        if ( $obj ) {
            $breadcrumbs['itemListElement'][] = array(
                '@type'    => 'ListItem',
                'position' => $position,
                'name'     => $obj->name,
                'item'     => get_term_link( $obj ),
            );
        }
    } elseif ( is_single() ) {
        $categories = get_the_category();
        if ( $categories ) {
            $breadcrumbs['itemListElement'][] = array(
                '@type'    => 'ListItem',
                'position' => $position,
                'name'     => $categories[0]->name,
                'item'     => get_category_link( $categories[0]->term_id ),
            );
            $position++;
        }
        $breadcrumbs['itemListElement'][] = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => get_the_title(),
        );
    } elseif ( is_page() ) {
        $breadcrumbs['itemListElement'][] = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => get_the_title(),
        );
    } elseif ( is_search() ) {
        $breadcrumbs['itemListElement'][] = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => sprintf( __( 'Search Results for "%s"', 'ald-blog' ), get_search_query() ),
        );
    } elseif ( is_author() ) {
        $breadcrumbs['itemListElement'][] = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => get_the_author(),
        );
    } elseif ( is_date() ) {
        $breadcrumbs['itemListElement'][] = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => get_the_date(),
        );
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $breadcrumbs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'ald_blog_breadcrumb_schema', 21 );

/**
 * Schema.org — Organization (on homepage)
 */
function ald_blog_organization_schema() {
    if ( ! is_front_page() ) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        'name'     => get_bloginfo( 'name' ),
        'url'      => home_url( '/' ),
        'logo'     => '',
    );

    // Add logo if custom logo is set
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    if ( $custom_logo_id ) {
        $logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
        if ( $logo ) {
            $schema['logo'] = array(
                '@type'  => 'ImageObject',
                'url'    => $logo[0],
                'width'  => $logo[1],
                'height' => $logo[2],
            );
        }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'ald_blog_organization_schema', 22 );

/**
 * Ad container helper function
 *
 * @param string $position  Position identifier (header, content, sidebar, footer).
 * @param string $class     Additional CSS class.
 * @param string $id        Optional unique ID for AdRotate.
 */
function ald_blog_ad_container( $position = 'content', $class = '', $id = '' ) {
    $classes = 'ad-container ad-container--' . sanitize_html_class( $position );
    if ( $class ) {
        $classes .= ' ' . esc_attr( $class );
    }

    echo '<div class="' . $classes . '"';

    if ( $id ) {
        echo ' id="' . esc_attr( $id ) . '"';
    }

    echo '>';
    echo '<span class="ad-container__label">' . esc_html__( 'Advertisement', 'ald-blog' ) . '</span>';
    echo '<!-- Ad code for ' . esc_html( $position ) . ' goes here -->';
    echo '</div>' . "\n";
}

/**
 * Load AdSense/AdRotate scripts with interaction-based delay
 * This is the key function for preventing ad scripts from blocking LCP
 */
function ald_blog_deferred_ads() {
    if ( is_admin() ) {
        return;
    }
    ?>
<script>
/**
 * ALD Blog — Deferred Ad Loading
 * Delays ad script loading until first user interaction (scroll/touch/click)
 * This prevents ads from blocking LCP and CLS metrics
 */
(function() {
    'use strict';

    var adScriptsLoaded = false;

    function loadAdScripts() {
        if (adScriptsLoaded) return;
        adScriptsLoaded = true;

        // === Google AdSense ===
        // Uncomment and replace YOUR_ADSENSE_ID with your actual publisher ID
        /*
        var adsense = document.createElement('script');
        adsense.async = true;
        adsense.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-YOUR_ADSENSE_ID';
        adsense.crossOrigin = 'anonymous';
        document.head.appendChild(adsense);
        */

        // === AdRotate ===
        // Uncomment if using AdRotate
        /*
        var adrotate = document.createElement('script');
        adrotate.async = true;
        adrotate.src = '<?php echo esc_url( ALD_BLOG_URI . '/assets/js/adrotate-tracking.js' ); ?>';
        document.head.appendChild(adrotate);
        */

        // Dispatch event so other scripts can listen
        document.dispatchEvent(new CustomEvent('aldBlogAdsLoaded'));
    }

    // Load on first user interaction
    var events = ['scroll', 'touchstart', 'click', 'mousemove', 'keydown'];
    var triggerLoad = function() {
        loadAdScripts();
        events.forEach(function(evt) {
            window.removeEventListener(evt, triggerLoad);
        });
    };

    events.forEach(function(evt) {
        window.addEventListener(evt, triggerLoad, { passive: true, once: true });
    });

    // Fallback: load after 5 seconds even without interaction
    setTimeout(loadAdScripts, 5000);
})();
</script>
    <?php
}
add_action( 'wp_footer', 'ald_blog_deferred_ads', 50 );

/**
 * Remove jQuery dependency for frontend (keep for admin)
 */
function ald_blog_dequeue_jquery() {
    if ( ! is_admin() && ! is_user_logged_in() ) {
        // Only dequeue if no other plugin needs it
        // wp_dequeue_script( 'jquery' );
        // Note: Many plugins require jQuery, so we keep it but don't use it in our theme
    }
}
add_action( 'wp_enqueue_scripts', 'ald_blog_dequeue_jquery', 999 );

/**
 * Clean up wp_head — remove unnecessary meta
 */
function ald_blog_cleanup_head() {
    // Remove WordPress version
    remove_action( 'wp_head', 'wp_generator' );

    // Remove adjacent posts links
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

    // Remove shortlink
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

    // Remove REST API link
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10, 0 );

    // Remove oEmbed links
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10, 0 );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );

    // Remove generator tag for feeds
    remove_action( 'wp_head', 'feed_links_extra', 3 );
}
add_action( 'init', 'ald_blog_cleanup_head' );

/**
 * Disable WordPress auto-embeds in content (oEmbed)
 * Prevents WP from auto-converting URLs to embeds (saves DB queries)
 */
function ald_blog_disable_embeds() {
    if ( ! is_admin() ) {
        wp_dequeue_script( 'wp-embed' );
    }
}
add_action( 'wp_footer', 'ald_blog_disable_embeds' );

/**
 * Optimize heartbeat API
 */
function ald_blog_heartbeat_settings( $settings ) {
    $settings['interval'] = 60; // Reduce to every 60 seconds
    return $settings;
}
add_filter( 'heartbeat_settings', 'ald_blog_heartbeat_settings' );

/**
 * Limit post revisions
 */
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
    define( 'WP_POST_REVISIONS', 5 );
}

/**
 * Disable post autosave interval (reduce AJAX calls)
 */
if ( ! defined( 'AUTOSAVE_INTERVAL' ) ) {
    define( 'AUTOSAVE_INTERVAL', 120 ); // 2 minutes
}

/**
 * Custom pagination (replaces default prev/next links)
 */
function ald_blog_pagination() {
    global $wp_query;

    if ( $wp_query->max_num_pages <= 1 ) {
        return;
    }

    $big = 999999999;
    $paginate = paginate_links( array(
        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'    => '?paged=%#%',
        'current'   => max( 1, get_query_var( 'paged' ) ),
        'total'     => $wp_query->max_num_pages,
        'prev_text' => '&larr; ' . __( 'Previous', 'ald-blog' ),
        'next_text' => __( 'Next', 'ald-blog' ) . ' &rarr;',
        'type'      => 'list',
        'mid_size'  => 2,
        'end_size'  => 1,
    ) );

    if ( $paginate ) {
        echo '<nav class="pagination" aria-label="' . esc_attr__( 'Posts Navigation', 'ald-blog' ) . '">';
        echo $paginate; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo '</nav>';
    }
}

/**
 * Breadcrumb function
 */
function ald_blog_breadcrumbs() {
    if ( is_front_page() ) {
        return;
    }

    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumbs', 'ald-blog' ) . '">';
    echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'ald-blog' ) . '</a>';

    if ( is_category() || is_single() ) {
        echo '<span class="separator">&raquo;</span>';
        $categories = get_the_category();
        if ( $categories ) {
            echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
        }
        if ( is_single() ) {
            echo '<span class="separator">&raquo;</span>';
            echo '<span class="current">' . get_the_title() . '</span>';
        }
    } elseif ( is_page() ) {
        echo '<span class="separator">&raquo;</span>';
        echo '<span class="current">' . get_the_title() . '</span>';
    } elseif ( is_search() ) {
        echo '<span class="separator">&raquo;</span>';
        echo '<span class="current">' . sprintf( __( 'Search: %s', 'ald-blog' ), get_search_query() ) . '</span>';
    } elseif ( is_author() ) {
        echo '<span class="separator">&raquo;</span>';
        echo '<span class="current">' . get_the_author() . '</span>';
    } elseif ( is_tag() ) {
        echo '<span class="separator">&raquo;</span>';
        echo '<span class="current">' . single_tag_title( '', false ) . '</span>';
    } elseif ( is_date() ) {
        echo '<span class="separator">&raquo;</span>';
        echo '<span class="current">' . get_the_date() . '</span>';
    } elseif ( is_404() ) {
        echo '<span class="separator">&raquo;</span>';
        echo '<span class="current">' . __( '404 Not Found', 'ald-blog' ) . '</span>';
    }

    echo '</nav>' . "\n";
}

/**
 * Estimate reading time
 */
function ald_blog_reading_time() {
    global $post;

    $content = get_post_field( 'post_content', $post->ID );
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 ); // 200 WPM average

    return $reading_time;
}

/**
 * Add reading time to post meta
 */
function ald_blog_post_meta() {
    $time = get_the_time( get_option( 'date_format' ) );
    $reading_time = ald_blog_reading_time();

    echo '<div class="post-card__meta entry-meta">';
    echo '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( $time ) . '</time>';
    echo ' <span class="meta-separator">&middot;</span> ';
    echo '<span class="reading-time">' . sprintf( _n( '%d min read', '%d min read', $reading_time, 'ald-blog' ), $reading_time ) . '</span>';

    if ( has_category() ) {
        echo ' <span class="meta-separator">&middot;</span> ';
        echo '<span class="post-categories">' . get_the_category_list( ', ' ) . '</span>';
    }

    echo '</div>' . "\n";
}

/**
 * Custom comment callback
 */
function ald_blog_comment( $comment, $args, $depth ) {
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
    ?>
    <<?php echo $tag; // phpcs:ignore ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent', $comment ); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php
                    if ( 0 !== $args['avatar_size'] ) {
                        echo get_avatar( $comment, $args['avatar_size'] );
                    }
                    ?>
                    <?php
                    printf(
                        '<b class="fn">%s</b> <span class="says">%s</span>',
                        get_comment_author_link( $comment ),
                        __( 'says:', 'ald-blog' )
                    );
                    ?>
                </div>

                <div class="comment-metadata">
                    <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                        <time datetime="<?php comment_time( 'c' ); ?>">
                            <?php
                            printf(
                                __( '%1$s at %2$s', 'ald-blog' ),
                                get_comment_date( '', $comment ),
                                get_comment_time()
                            );
                            ?>
                        </time>
                    </a>
                    <?php edit_comment_link( __( 'Edit', 'ald-blog' ), '<span class="edit-link">', '</span>' ); ?>
                </div>

                <?php if ( '0' === $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'ald-blog' ); ?></p>
                <?php endif; ?>
            </footer>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>

            <div class="reply">
                <?php
                comment_reply_link(
                    array_merge(
                        $args,
                        array(
                            'add_below' => 'div-comment',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                        )
                    )
                );
                ?>
            </div>
        </article>
    <?php
}

/**
 * Add no-js class removal script (inline, in head)
 */
function ald_blog_nojs() {
    ?>
    <script>document.documentElement.classList.remove('no-js');</script>
    <?php
}
add_action( 'wp_head', 'ald_blog_nojs', 0 );

/**
 * Load text domain for translations
 */
function ald_blog_load_textdomain() {
    load_theme_textdomain( 'ald-blog', ALD_BLOG_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'ald_blog_load_textdomain' );

/**
 * Add theme support for selective refresh in customizer
 */
function ald_blog_customize_selective_refresh( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => function() {
                    bloginfo( 'name' );
                },
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => function() {
                    bloginfo( 'description' );
                },
            )
        );
    }
}
add_action( 'customize_register', 'ald_blog_customize_selective_refresh' );

/**
 * Customizer additions
 */
require ALD_BLOG_DIR . '/inc/customizer.php';
