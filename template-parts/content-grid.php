<?php
/**
 * Template part for grid post cards
 *
 * @package ALD_Blog
 */
?>
<article <?php post_class( 'grid-card' ); ?>>
    <a href="<?php the_permalink(); ?>" class="grid-card-link">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="grid-card-image">
                <?php the_post_thumbnail( 'grid-article' ); ?>
            </div>
        <?php endif; ?>
        <div class="grid-card-content">
            <?php
            $cats = get_the_category();
            if ( $cats ) :
                ?>
                <span class="cat-badge sm"><?php echo esc_html( $cats[0]->name ); ?></span>
            <?php endif; ?>
            <h3 class="grid-card-title"><?php the_title(); ?></h3>
            <p class="grid-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
            <div class="grid-card-meta">
                <span class="author sm"><?php the_author(); ?></span>
                <span class="separator">•</span>
                <span class="time sm"><?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago'; ?></span>
            </div>
        </div>
    </a>
</article>
