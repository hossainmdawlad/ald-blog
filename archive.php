<?php
/**
 * The archive template (category, tag, date, author)
 *
 * @package ALD_Blog
 */

get_header();
?>

<div class="container">
    <div class="content-sidebar-wrap">

        <div class="content-area" id="primary-content">

            <?php ald_blog_breadcrumbs(); ?>

            <header class="archive-header">
                <?php
                the_archive_title( '<h1 class="archive-title">', '</h1>' );
                the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
            </header>

            <?php if ( have_posts() ) : ?>

                <?php ald_blog_ad_container( 'header', 'ad-container--below-title' ); ?>

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
