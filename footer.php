<?php
/**
 * Footer template — Widget-ready footer
 *
 * @package ALD_Blog
 */
?>

    </div><!-- .site-main -->

    <footer class="site-footer" role="contentinfo">
        <div class="container">

            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
            <div class="footer-grid">
                <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                    <?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
                        <div class="footer-col">
                            <?php dynamic_sidebar( 'footer-' . $i ); ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <?php else : ?>
            <!-- Default footer content if no widgets -->
            <div class="footer-grid">
                <div class="footer-col">
                    <h2 class="footer-logo"><?php bloginfo( 'name' ); ?></h2>
                    <p class="footer-desc"><?php bloginfo( 'description' ); ?></p>
                </div>
                <div class="footer-col">
                    <h3 class="footer-heading"><?php esc_html_e( 'Categories', 'ald-blog' ); ?></h3>
                    <ul class="footer-links">
                        <?php
                        $categories = get_categories( array( 'number' => 6, 'orderby' => 'count', 'order' => 'DESC' ) );
                        foreach ( $categories as $cat ) :
                            ?>
                            <li><a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"><?php echo esc_html( $cat->name ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3 class="footer-heading"><?php esc_html_e( 'About', 'ald-blog' ); ?></h3>
                    <ul class="footer-links">
                        <li><a href="#"><?php esc_html_e( 'About Us', 'ald-blog' ); ?></a></li>
                        <li><a href="#"><?php esc_html_e( 'Contact', 'ald-blog' ); ?></a></li>
                        <li><a href="#"><?php esc_html_e( 'Advertise', 'ald-blog' ); ?></a></li>
                        <li><a href="#"><?php esc_html_e( 'Privacy Policy', 'ald-blog' ); ?></a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3 class="footer-heading"><?php esc_html_e( 'Newsletter', 'ald-blog' ); ?></h3>
                    <p class="footer-desc"><?php esc_html_e( 'Subscribe to get the latest news delivered to your inbox.', 'ald-blog' ); ?></p>
                    <form class="newsletter-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                        <input type="hidden" name="action" value="ald_blog_newsletter">
                        <?php wp_nonce_field( 'ald_blog_newsletter_nonce', 'ald_blog_newsletter_field' ); ?>
                        <input type="email" name="email" placeholder="<?php esc_attr_e( 'Your email...', 'ald-blog' ); ?>" required>
                        <button type="submit"><?php esc_html_e( 'Subscribe', 'ald-blog' ); ?></button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- Copyright -->
            <div class="footer-bottom">
                <p>© <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'ald-blog' ); ?></p>
                <?php
                if ( has_nav_menu( 'footer' ) ) :
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-bottom-links',
                        'container'      => false,
                        'depth'          => 1,
                    ) );
                endif;
                ?>
            </div>

        </div>
    </footer>

</div><!-- .site-container -->

<?php wp_footer(); ?>

</body>
</html>
