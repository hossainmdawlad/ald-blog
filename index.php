<?php
/**
 * The main index template
 *
 * @package ALD_Blog
 */

get_header();
?>

<div class="container">
    <div class="content-sidebar-wrap">

        <div class="content-area" id="primary-content">

            <?php ald_blog_breadcrumbs(); ?>

            <?php if ( is_home() && ! is_front_page() ) : ?>
                <header class="archive-header">
                    <h1 class="archive-title"><?php single_post_title(); ?></h1>
                </header>
            <?php elseif ( is_archive() ) : ?>
                <header class="archive-header">
                    <?php
                    the_archive_title( '<h1 class="archive-title">', '</h1>' );
                    the_archive_description( '<div class="archive-description">', '</div>' );
                    ?>
                </header>
            <?php elseif ( is_search() ) : ?>
                <header class="archive-header">
                    <h1 class="archive-title">
                        <?php
                        printf(
                            esc_html__( 'Search Results for: %s', 'ald-blog' ),
                            '<span>' . get_search_query() . '</span>'
                        );
                        ?>
                    </h1>
                </header>
            <?php endif; ?>

            <?php if ( have_posts() ) : ?>

                <?php if ( is_home() && ! is_front_page() && ! is_paged() ) : ?>
                    <?php ald_blog_ad_container( 'header', 'ad-container--below-title' ); ?>
                <?php endif; ?>

                <?php
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/content', get_post_type() );
                endwhile;
                ?>

                <?php ald_blog_pagination(); ?>

            <?php else : ?>

                <?php get_template_part( 'template-parts/content', 'none' ); ?>

            <?php endif; ?>

        </div><!-- .content-area -->

        <?php get_sidebar(); ?>

    </div><!-- .content-sidebar-wrap -->
</div><!-- .container -->

<?php
get_footer();
