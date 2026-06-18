<?php
/**
 * Archive / Category template
 *
 * @package ALD_Blog
 */

get_header();
?>

<main class="site-content" role="main">
    <div class="container">

        <!-- Row 1: Title + Post Loop (left) | Sidebar (right) -->
        <div class="content-grid">

            <div class="main-column">

                <!-- Archive Title -->
                <header class="archive-header">
                    <h1 class="archive-title"><?php single_cat_title(); ?></h1>
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

        <!-- Row 2: Archive Description (full width, bottom) -->
        <?php
        $desc = category_description();
        if ( $desc ) :
            ?>
            <div class="archive-description-full"><?php echo $desc; ?></div>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
