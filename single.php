<?php
/**
 * Single article template
 *
 * @package ALD_Blog
 */

get_header();
?>

<main class="site-content single-article-page" role="main">
    <div class="container">

        <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article' ); ?>>

            <!-- Article Header -->
            <header class="single-header">
                <div class="single-meta-top">
                    <?php
                    $cats = get_the_category();
                    if ( $cats ) :
                        ?>
                        <a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>" class="cat-badge lg">
                            <?php echo esc_html( $cats[0]->name ); ?>
                        </a>
                    <?php endif; ?>
                    <span class="read-time"><?php esc_html_e( 'Read time:', 'ald-blog' ); ?> <?php echo ald_blog_reading_time(); ?> min</span>
                </div>

                <h1 class="single-title"><?php the_title(); ?></h1>

                <div class="single-meta">
                    <span class="author"><?php the_author(); ?></span>
                    <span class="separator">•</span>
                    <time datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
                </div>

                <!-- Action Buttons -->
                <div class="single-actions">
                    <button class="action-btn bookmark-btn" id="bookmarkBtn" title="Bookmark">
                        <span class="heart-icon">♡</span>
                        <span class="label"><?php esc_html_e( 'Bookmark', 'ald-blog' ); ?></span>
                    </button>
                    <button class="action-btn font-size-btn" id="fontSizeBtn" title="Font size">
                        <span class="label"><?php esc_html_e( 'Font Size', 'ald-blog' ); ?></span>
                        <select id="fontSizeSelect">
                            <option value="sm"><?php esc_html_e( 'Small', 'ald-blog' ); ?></option>
                            <option value="base" selected><?php esc_html_e( 'Medium', 'ald-blog' ); ?></option>
                            <option value="lg"><?php esc_html_e( 'Large', 'ald-blog' ); ?></option>
                            <option value="xl"><?php esc_html_e( 'Extra Large', 'ald-blog' ); ?></option>
                        </select>
                    </button>
                    <button class="action-btn print-btn" onclick="window.print()" title="Print">
                        <span class="label"><?php esc_html_e( 'Print', 'ald-blog' ); ?></span>
                    </button>
                </div>
            </header>

            <!-- Featured Image -->
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="single-image">
                    <?php the_post_thumbnail( 'large' ); ?>
                </div>
            <?php endif; ?>

            <!-- Article Content -->
            <div class="single-content" id="singleContent">
                <?php the_content(); ?>
            </div>

            <!-- Tags -->
            <?php
            $tags = get_the_tags();
            if ( $tags ) :
                ?>
                <div class="single-tags">
                    <?php foreach ( $tags as $tag ) : ?>
                        <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag"><?php echo esc_html( $tag->name ); ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Comments -->
            <div class="single-comments">
                <?php
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>
            </div>

        </article>

        <?php endwhile; ?>

    </div>
</main>

<?php
get_footer();
