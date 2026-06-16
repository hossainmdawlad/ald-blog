<?php
/**
 * The 404 template
 *
 * @package ALD_Blog
 */

get_header();
?>

<div class="container">
    <div class="content-sidebar-wrap">

        <div class="content-area" id="primary-content">

            <article class="error-404 not-found">

                <header class="entry-header">
                    <h1 class="page-title"><?php esc_html_e( '404 — Page Not Found', 'ald-blog' ); ?></h1>
                </header>

                <div class="entry-content">
                    <p><?php esc_html_e( 'Sorry, the page you are looking for does not exist. It may have been moved or removed.', 'ald-blog' ); ?></p>

                    <p><?php esc_html_e( 'Try searching for what you were looking for:', 'ald-blog' ); ?></p>

                    <?php get_search_form(); ?>

                    <p>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button">
                            <?php esc_html_e( '&larr; Back to Home', 'ald-blog' ); ?>
                        </a>
                    </p>
                </div>

            </article>

        </div><!-- .content-area -->

        <?php get_sidebar(); ?>

    </div><!-- .content-sidebar-wrap -->
</div><!-- .container -->

<?php
get_footer();
