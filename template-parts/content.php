<?php
/**
 * Template part for displaying posts in archive/index
 *
 * @package ALD_Blog
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" class="post-card__thumbnail" aria-hidden="true" tabindex="-1">
            <?php
            the_post_thumbnail(
                'ald-blog-card',
                array(
                    'alt' => get_the_title(),
                )
            );
            ?>
        </a>
    <?php endif; ?>

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
