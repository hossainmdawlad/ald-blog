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

        <header class="archive-header">
            <h1 class="archive-title"><?php single_cat_title(); ?></h1>
            <?php
            $desc = category_description();
            if ( $desc ) :
                ?>
                <div class="archive-description"><?php echo $desc; ?></div>
            <?php endif; ?>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="posts-grid">
                <?php
                while ( have_posts() ) : the_post();
                    get_template_part( 'template-parts/content', 'grid' );
                endwhile;
                ?>
            </div>
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
</main>

<?php
get_footer();
