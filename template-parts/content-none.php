<?php
/**
 * Template part for displaying a message when no posts are found
 *
 * @package ALD_Blog
 */
?>

<article class="no-results not-found">

    <header class="entry-header">
        <h2 class="post-card__title"><?php esc_html_e( 'Nothing Found', 'ald-blog' ); ?></h2>
    </header>

    <div class="entry-content">
        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'ald-blog' ); ?></p>

        <?php get_search_form(); ?>

        <p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php esc_html_e( '&larr; Back to Home', 'ald-blog' ); ?>
            </a>
        </p>
    </div>

</article>
