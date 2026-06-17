<?php
/**
 * Page template
 *
 * @package ALD_Blog
 */

get_header();
?>

<main class="site-content" role="main">
    <div class="container">

        <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>
            <header class="page-header">
                <h1 class="page-title"><?php the_title(); ?></h1>
            </header>
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
</main>

<?php
get_footer();
