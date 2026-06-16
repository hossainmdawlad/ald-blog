<?php
/**
 * The page template
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
                    </header>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="post-thumbnail">
                            <?php
                            the_post_thumbnail(
                                'ald-blog-featured',
                                array(
                                    'alt' => get_the_title(),
                                    'loading' => 'eager',
                                )
                            );
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . __( 'Pages:', 'ald-blog' ),
                            'after'  => '</div>',
                        ) );
                        ?>
                    </div>

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
