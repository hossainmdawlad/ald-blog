<?php
/**
 * The search results template
 *
 * @package ALD_Blog
 */

get_header();
?>

<main class="site-content" role="main">
    <div class="container">

        <!-- Row 1: Title + Sidebar side by side -->
        <div class="content-grid">

            <div class="main-column">

                <!-- Search Title -->
                <header class="archive-header">
                    <h1 class="archive-title">
                        <?php
                        printf(
                            esc_html__( 'Search Results for: %s', 'ald-blog' ),
                            '<span>' . get_search_query() . '</span>'
                        );
                        ?>
                    </h1>
                    <?php
                    global $wp_query;
                    if ( have_posts() ) :
                        printf(
                            '<p class="results-count">%s</p>',
                            sprintf(
                                _n(
                                    '%d result found',
                                    '%d results found',
                                    $wp_query->found_posts,
                                    'ald-blog'
                                ),
                                $wp_query->found_posts
                            )
                        );
                    endif;
                    ?>
                </header>

                <?php if ( have_posts() ) : ?>

                    <!-- 2-Column Post Grid -->
                    <div class="two-col-grid">
                        <?php
                        while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/content', 'grid' );
                        endwhile;
                        ?>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <?php
                        echo paginate_links( array(
                            'prev_text' => '← ' . esc_html__( 'Previous', 'ald-blog' ),
                            'next_text' => esc_html__( 'Next', 'ald-blog' ) . ' →',
                        ) );
                        ?>
                    </div>

                <?php else : ?>
                    <p class="no-results"><?php esc_html_e( 'No articles found', 'ald-blog' ); ?></p>
                <?php endif; ?>

            </div>

            <!-- Sidebar (right) -->
            <aside class="sidebar-column">
                <?php get_sidebar(); ?>
            </aside>

        </div>

    </div>
</main>

<?php
get_footer();
