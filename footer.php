<?php
/**
 * The footer template
 *
 * @package ALD_Blog
 */
?>

    </div><!-- .site-main -->

    <?php if ( is_active_sidebar( 'footer-ad' ) ) : ?>
        <div class="container">
            <?php ald_blog_ad_container( 'footer' ); ?>
        </div>
    <?php endif; ?>

    <footer class="site-footer" role="contentinfo">
        <div class="container">

            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
                <div class="footer-widgets">
                    <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar( 'footer-1' ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar( 'footer-2' ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar( 'footer-3' ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ( has_nav_menu( 'footer' ) ) : ?>
                <nav class="footer-nav" role="navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'ald-blog' ); ?>">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'depth'          => 1,
                    ) );
                    ?>
                </nav>
            <?php endif; ?>

            <div class="footer-bottom">
                <p>
                    &copy; <?php echo date( 'Y' ); ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>.
                    <?php esc_html_e( 'All rights reserved.', 'ald-blog' ); ?>
                </p>
            </div>

        </div>
    </footer>

</div><!-- .site-container -->

<?php wp_footer(); ?>

</body>
</html>
