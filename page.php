<?php
/**
 * Page template
 *
 * @package ALD_Blog
 */

get_header();
?>

<main class="site-content page-content-wrap" role="main">
    <div class="container">

        <div class="content-grid">

            <!-- Main Column: Page Content -->
            <div class="main-column">

                <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>
                    <header class="page-header">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                    </header>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="page-featured-image">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="page-content">
                        <?php the_content(); ?>
                    </div>
                </article>

                <?php
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>

                <?php endwhile; ?>

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
