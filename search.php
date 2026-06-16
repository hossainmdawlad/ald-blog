<?php
/**
 * The search results template
 *
 * @package ALD_Blog
 */

get_header();
?>

<div class="container">
    <div class="content-sidebar-wrap">

        <div class="content-area" id="primary-content">

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

            <?php if ( have_posts() ) : ?>

                <p class="results-count">
                    <?php
                    global $wp_query;
                    printf(
                        esc_html( _n(
                            '%d result found',
                            '%d results found',
                            $wp_query->found_posts,
                            'ald-blog'
                        ) ),
                        $wp_query->found_posts
                    );
                    ?>
                </p>

                <?php
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/content', 'search' );
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
