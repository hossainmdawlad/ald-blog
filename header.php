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
                        echo esc_html( date_i18n( 'l, F j, Y' ) );
                    }
                    ?>
                </div>
                <div class="top-bar-actions">
                    <div class="top-bar-social">
                        <?php if ( $fb_url = get_theme_mod( 'social_facebook_url', '' ) ) : ?>
                            <a href="<?php echo esc_url( $fb_url ); ?>" target="_blank" rel="noopener noreferrer" class="social-link social-fb" aria-label="Facebook">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if ( $tw_url = get_theme_mod( 'social_twitter_url', '' ) ) : ?>
                            <a href="<?php echo esc_url( $tw_url ); ?>" target="_blank" rel="noopener noreferrer" class="social-link social-tw" aria-label="Twitter / X">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if ( $ig_url = get_theme_mod( 'social_instagram_url', '' ) ) : ?>
                            <a href="<?php echo esc_url( $ig_url ); ?>" target="_blank" rel="noopener noreferrer" class="social-link social-ig" aria-label="Instagram">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if ( $yt_url = get_theme_mod( 'social_youtube_url', '' ) ) : ?>
                            <a href="<?php echo esc_url( $yt_url ); ?>" target="_blank" rel="noopener noreferrer" class="social-link social-yt" aria-label="YouTube">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if ( $li_url = get_theme_mod( 'social_linkedin_url', '' ) ) : ?>
                            <a href="<?php echo esc_url( $li_url ); ?>" target="_blank" rel="noopener noreferrer" class="social-link social-li" aria-label="LinkedIn">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php if ( get_theme_mod( 'topbar_broadcast_show', true ) ) : ?>
                    <?php
                    $broadcast_text = get_theme_mod( 'topbar_broadcast_text', __( 'Top Broadcast', 'ald-blog' ) );
                    $broadcast_url  = get_theme_mod( 'topbar_broadcast_url', '#' );
                    ?>
                    <a href="<?php echo esc_url( $broadcast_url ); ?>" class="broadcast-link">
                        <span class="live-dot"></span>
                        <?php echo esc_html( $broadcast_text ); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="site-header" role="banner">
        <div class="container">
            <div class="header-inner">

                <div class="header-left">
                    <?php if ( get_theme_mod( 'header_addnews_show', true ) ) : ?>
                    <?php
                    $addnews_text = get_theme_mod( 'header_addnews_text', __( 'Add News', 'ald-blog' ) );
                    $addnews_url  = get_theme_mod( 'header_addnews_url', '#' );
                    ?>
                    <a href="<?php echo esc_url( $addnews_url ); ?>" class="btn-add-news" id="addNewsBtn">
                        <span>+</span>
                        <span class="hidden-sm"><?php echo esc_html( $addnews_text ); ?></span>
                    </a>
                    <?php endif; ?>
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
                    <?php if ( get_theme_mod( 'header_login_show', true ) ) : ?>
                    <?php
                    $login_text = get_theme_mod( 'header_login_text', __( 'Login', 'ald-blog' ) );
                    $login_url  = get_theme_mod( 'header_login_url', '#' );
                    ?>
                    <a href="<?php echo esc_url( $login_url ); ?>" class="btn-login"><?php echo esc_html( $login_text ); ?></a>
                    <?php endif; ?>
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
