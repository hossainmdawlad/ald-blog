<?php
/**
 * Template part for displaying search results
 *
 * @package ALD_Blog
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">
        <?php the_title( '<h2 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
    </header>

    <?php ald_blog_post_meta(); ?>

    <div class="post-card__excerpt">
        <?php the_excerpt(); ?>
    </div>

    <a href="<?php the_permalink(); ?>" class="post-card__read-more">
        <?php esc_html_e( 'Read More &rarr;', 'ald-blog' ); ?>
    </a>

</article>
