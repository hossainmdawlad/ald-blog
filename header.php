<?php
/**
 * The header template
 *
 * @package ALD_Blog
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#primary-content"><?php esc_html_e( 'Skip to main content', 'ald-blog' ); ?></a>

<div class="site-container">

    <header class="site-header" role="banner">
        <div class="container">
            <div class="header-inner">

                <div class="site-branding">
                    <?php
                    if ( has_custom_logo() ) :
                        the_custom_logo();
                    else :
                        ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
                        <?php
                        $description = get_bloginfo( 'description', 'display' );
                        if ( $description || is_customize_preview() ) :
                            ?>
                            <p class="site-description"><?php echo esc_html( $description ); ?></p>
                        <?php endif;
                    endif;
                    ?>
                </div>

                <nav class="primary-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'ald-blog' ); ?>">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'fallback_cb'    => 'ald_blog_fallback_menu',
                        'depth'          => 2,
                    ) );
                    ?>
                </nav>

                <button class="menu-toggle" aria-controls="mobile-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'ald-blog' ); ?>">
                    <span class="menu-toggle-bar"></span>
                </button>

            </div>

            <nav class="mobile-nav" id="mobile-menu" role="navigation" aria-label="<?php esc_attr_e( 'Mobile Menu', 'ald-blog' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'mobile-menu-list',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => 'ald_blog_fallback_menu',
                    'depth'          => 2,
                ) );
                ?>
            </nav>
        </div>

        <?php if ( is_active_sidebar( 'header-ad' ) ) : ?>
            <div class="container">
                <?php ald_blog_ad_container( 'header' ); ?>
            </div>
        <?php endif; ?>
    </header>

    <div class="site-main" role="main">
