<?php
/**
 * The single post template
 *
 * @package ALD_Blog
 */

get_header();
?>

<div class="container">

    <?php
    while ( have_posts() ) :
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div class="content-sidebar-wrap">

                <div class="content-area" id="primary-content">

                    <?php ald_blog_breadcrumbs(); ?>

                    <header class="entry-header">
                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        <?php ald_blog_post_meta(); ?>
                    </header>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="post-thumbnail">
                            <?php
                            the_post_thumbnail(
                                'ald-blog-featured',
                                array(
                                    'alt' => get_the_title(),
                                    'loading' => 'eager', // Featured image is above the fold
                                )
                            );
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php ald_blog_ad_container( 'header', 'ad-container--below-title' ); ?>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . __( 'Pages:', 'ald-blog' ),
                            'after'  => '</div>',
                        ) );
                        ?>
                    </div>

                    <?php ald_blog_ad_container( 'content', 'ad-container--in-content' ); ?>

                    <footer class="entry-footer">
                        <?php if ( has_tag() ) : ?>
                            <div class="post-tags">
                                <strong><?php esc_html_e( 'Tags:', 'ald-blog' ); ?></strong>
                                <?php the_tags( '', ', ', '' ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( has_category() && ! is_category() ) : ?>
                            <div class="post-categories-footer">
                                <strong><?php esc_html_e( 'Categories:', 'ald-blog' ); ?></strong>
                                <?php the_category( ', ' ); ?>
                            </div>
                        <?php endif; ?>
                    </footer>

                    <nav class="post-navigation" aria-label="<?php esc_attr_e( 'Post Navigation', 'ald-blog' ); ?>">
                        <div class="nav-links">
                            <div class="nav-previous">
                                <?php previous_post_link( '<a href="%link" rel="prev">', '</a>' ); ?>
                            </div>
                            <div class="nav-next">
                                <?php next_post_link( '<a href="%link" rel="next">', '</a>' ); ?>
                            </div>
                        </div>
                    </nav>

                    <?php
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                    ?>

                </div><!-- .content-area -->

                <?php get_sidebar(); ?>

            </div><!-- .content-sidebar-wrap -->

        </article>

    <?php endwhile; ?>

</div><!-- .container -->

<?php
get_footer();
