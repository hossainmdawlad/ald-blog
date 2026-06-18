<?php
/**
 * The header template — Prothom Alo Inspired News Portal
 *
 * @package ALD_Blog
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#primary-content"><?php esc_html_e( 'Skip to main content', 'ald-blog' ); ?></a>

<div class="site-container">

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-inner">
                <div class="top-bar-date">
                    <?php
                    $topbar_left = get_theme_mod( 'topbar_left_text', '' );
                    if ( $topbar_left ) {
                        echo esc_html( $topbar_left );
                    } else {
                        $date = ald_blog_bengali_date();
                        echo esc_html( $date['gregorian'] );
                    }
                    ?>
                </div>
                <div class="top-bar-actions">
                    <span class="bookmark-count">
                        <span class="bookmark-icon">🔖</span>
                        <?php esc_html_e( 'Bookmarks:', 'ald-blog' ); ?> <strong>0</strong>
                    </span>
                    <?php
                    $broadcast_text = get_theme_mod( 'topbar_broadcast_text', __( 'Top Broadcast', 'ald-blog' ) );
                    $broadcast_url  = get_theme_mod( 'topbar_broadcast_url', '#' );
                    ?>
                    <a href="<?php echo esc_url( $broadcast_url ); ?>" class="broadcast-link">
                        <span class="live-dot"></span>
                        <?php echo esc_html( $broadcast_text ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="site-header" role="banner">
        <div class="container">
            <div class="header-inner">

                <div class="header-left">
                    <button class="btn-add-news" id="addNewsBtn">
                        <span>+</span>
                        <span class="hidden-sm"><?php esc_html_e( 'Add News', 'ald-blog' ); ?></span>
                    </button>
                    <button class="btn-dark-mode" id="darkModeBtn" aria-label="Toggle dark mode">
                        <span class="sun-icon">☀️</span>
                        <span class="moon-icon">🌙</span>
                    </button>
                </div>

                <div class="site-branding">
                    <?php if ( has_custom_logo() ) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
                        <p class="site-description"><?php bloginfo( 'description' ); ?></p>
                    <?php endif; ?>
                </div>

                <div class="header-right">
                    <button class="btn-search" id="searchBtn" aria-label="Search">
                        🔍
                    </button>
                    <button class="btn-bell" aria-label="Notifications">
                        🔔
                        <span class="notification-dot"></span>
                    </button>
                    <a href="#" class="btn-login"><?php esc_html_e( 'Login', 'ald-blog' ); ?></a>
                    <button class="btn-menu-toggle" id="menuToggle" aria-label="Toggle menu" aria-expanded="false">
                        <span class="hamburger"></span>
                        <span class="hamburger"></span>
                        <span class="hamburger"></span>
                    </button>
                </div>

            </div>

            <!-- Search Bar -->
            <div class="search-bar" id="searchBar">
                <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search" name="s" placeholder="<?php esc_attr_e( 'Search news...', 'ald-blog' ); ?>" autocomplete="off">
                    <button type="submit"><?php esc_html_e( 'Search', 'ald-blog' ); ?></button>
                </form>
                <div class="search-results" id="searchResults"></div>
            </div>

            <!-- Primary Navigation (Categories) -->
            <nav class="primary-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'ald-blog' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => 'ald_blog_fallback_menu',
                    'depth'          => 1,
                ) );
                ?>
            </nav>

            <!-- Breaking News Ticker -->
            <div class="ticker-wrap">
                <div class="ticker-label">
                    <span class="ticker-dot"></span>
                    <?php esc_html_e( 'Breaking News', 'ald-blog' ); ?>
                </div>
                <div class="ticker-content">
                    <div class="ticker-scroll">
                        <?php
                        $ticker_posts = new WP_Query( array(
                            'posts_per_page' => 5,
                            'post_status'    => 'publish',
                        ) );
                        if ( $ticker_posts->have_posts() ) :
                            while ( $ticker_posts->have_posts() ) : $ticker_posts->the_post();
                                ?>
                                <a href="<?php the_permalink(); ?>" class="ticker-item"><?php the_title(); ?></a>
                                <span class="ticker-separator">•</span>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        // Duplicate for seamless loop
                        if ( $ticker_posts->have_posts() ) :
                            while ( $ticker_posts->have_posts() ) : $ticker_posts->the_post();
                                ?>
                                <a href="<?php the_permalink(); ?>" class="ticker-item"><?php the_title(); ?></a>
                                <span class="ticker-separator">•</span>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <!-- Mobile Navigation -->
        <nav class="mobile-nav" id="mobileMenu" role="navigation" aria-label="<?php esc_attr_e( 'Mobile Menu', 'ald-blog' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_id'        => 'mobile-menu',
                'menu_class'     => 'mobile-nav-menu',
                'container'      => false,
                'fallback_cb'    => 'ald_blog_fallback_menu',
                'depth'          => 1,
            ) );
            ?>
        </nav>

    </header>

    <div class="site-main" role="main">
