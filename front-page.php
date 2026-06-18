<?php
/**
 * The homepage template — Prothom Alo Inspired News Portal
 *
 * @package ALD_Blog
 */

get_header();

// Get category settings from Customizer
$politics_cat    = get_theme_mod( 'politics_category', 'opinion' );
$economy_cat     = get_theme_mod( 'economy_category', 'business' );
$latest_cat      = get_theme_mod( 'latest_category', '' );
$latest_count    = absint( get_theme_mod( 'latest_posts_count', 6 ) );
$show_politics   = get_theme_mod( 'show_politics', true );
$show_economy    = get_theme_mod( 'show_economy', true );
$show_latest     = get_theme_mod( 'show_latest', true );
?>

<main class="site-content" role="main">
    <div class="container">

        <!-- Main Content + Sidebar Grid -->
        <div class="content-grid">

            <!-- Main Content (9 cols) -->
            <div class="main-column">

                <?php
                // === LEAD ARTICLE ===
                $lead_query = new WP_Query( array(
                    'posts_per_page' => 1,
                    'meta_key'       => '_thumbnail_id',
                    'post_status'    => 'publish',
                ) );

                if ( $lead_query->have_posts() ) :
                    while ( $lead_query->have_posts() ) : $lead_query->the_post();
                        ?>
                        <article class="lead-article" id="leadArticle">
                            <a href="<?php the_permalink(); ?>" class="lead-article-link">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="lead-article-image">
                                        <?php the_post_thumbnail( 'lead-article' ); ?>
                                        <span class="lead-badge">
                                            <span class="live-dot"></span>
                                            <?php esc_html_e( 'Top Story', 'ald-blog' ); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <div class="lead-article-content">
                                    <?php
                                    $cats = get_the_category();
                                    if ( $cats ) :
                                        ?>
                                        <span class="cat-badge"><?php echo esc_html( $cats[0]->name ); ?></span>
                                    <?php endif; ?>
                                    <h2 class="lead-title"><?php the_title(); ?></h2>
                                    <p class="lead-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 30 ); ?></p>
                                    <div class="lead-meta">
                                        <span class="author"><?php the_author(); ?></span>
                                        <span class="separator">•</span>
                                        <span class="time"><?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago'; ?></span>
                                    </div>
                                </div>
                            </a>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>

                <!-- Secondary Stories Row -->
                <div class="secondary-row">
                    <?php
                    $secondary_query = new WP_Query( array(
                        'posts_per_page' => 2,
                        'offset'         => 1,
                        'meta_key'       => '_thumbnail_id',
                        'post_status'    => 'publish',
                    ) );

                    if ( $secondary_query->have_posts() ) :
                        $i = 0;
                        while ( $secondary_query->have_posts() ) : $secondary_query->the_post();
                            $i++;
                            ?>
                            <article class="secondary-card <?php echo ( $i === 1 ) ? 'first' : 'second'; ?>">
                                <a href="<?php the_permalink(); ?>" class="secondary-link">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="secondary-image">
                                            <?php the_post_thumbnail( 'secondary-article' ); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="secondary-content">
                                        <div class="secondary-top">
                                            <?php
                                            $cats = get_the_category();
                                            if ( $cats ) :
                                                ?>
                                                <span class="cat-badge sm"><?php echo esc_html( $cats[0]->name ); ?></span>
                                            <?php endif; ?>
                                            <span class="time sm"><?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago'; ?></span>
                                        </div>
                                        <h3 class="secondary-title"><?php the_title(); ?></h3>
                                        <p class="secondary-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                                        <span class="author sm"><?php the_author(); ?></span>
                                    </div>
                                </a>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

                <?php
                // === 3-COLUMN POST SECTION ===
                if ( $show_politics && $politics_cat ) :
                    $politics_query = new WP_Query( array(
                        'category_name'  => $politics_cat,
                        'posts_per_page' => 3,
                        'post_status'    => 'publish',
                    ) );
                    if ( $politics_query->have_posts() ) :
                        ?>
                        <section class="section-block">
                            <div class="section-header">
                                <div class="section-accent"></div>
                                <h2 class="section-title"><?php echo esc_html( get_category_by_slug( $politics_cat ) ? get_category_by_slug( $politics_cat )->name : 'News' ); ?></h2>
                                <a href="<?php echo esc_url( get_category_link( get_category_by_slug( $politics_cat ) ) ); ?>" class="section-more"><?php esc_html_e( 'View All →', 'ald-blog' ); ?></a>
                            </div>
                            <div class="three-col-grid">
                                <?php
                                while ( $politics_query->have_posts() ) : $politics_query->the_post();
                                    ?>
                                    <article class="politics-card">
                                        <a href="<?php the_permalink(); ?>">
                                            <h4 class="politics-title"><?php the_title(); ?></h4>
                                            <p class="politics-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 12 ); ?></p>
                                            <div class="politics-meta">
                                                <span class="time"><?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago'; ?></span>
                                                <span class="author"><?php the_author(); ?></span>
                                            </div>
                                        </a>
                                    </article>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </section>
                    <?php
                    endif;
                endif;
                ?>

                <?php
                // === 2-COLUMN POST SECTION ===
                if ( $show_latest ) :
                    ?>
                    <section class="section-block">
                        <div class="section-header">
                            <div class="section-accent"></div>
                            <h2 class="section-title">
                                <?php
                                if ( $latest_cat && get_category_by_slug( $latest_cat ) ) {
                                    echo esc_html( get_category_by_slug( $latest_cat )->name );
                                } else {
                                    esc_html_e( 'Latest Articles', 'ald-blog' );
                                }
                                ?>
                            </h2>
                            <?php if ( $latest_cat ) : ?>
                                <a href="<?php echo esc_url( get_category_link( get_category_by_slug( $latest_cat ) ) ); ?>" class="section-more"><?php esc_html_e( 'View All →', 'ald-blog' ); ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="two-col-grid" id="postsGrid">
                            <?php
                            $latest_args = array(
                                'posts_per_page' => $latest_count,
                                'offset'         => 3,
                                'post_status'    => 'publish',
                            );
                            if ( $latest_cat ) {
                                $latest_args['category_name'] = $latest_cat;
                            }
                            $latest_query = new WP_Query( $latest_args );

                            if ( $latest_query->have_posts() ) :
                                while ( $latest_query->have_posts() ) : $latest_query->the_post();
                                    get_template_part( 'template-parts/content', 'grid' );
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </section>
                <?php endif; ?>

            </div>

            <!-- Sidebar (3 cols) -->
            <aside class="sidebar-column">
                <?php get_sidebar(); ?>
            </aside>

        </div>

        <?php
        // === 4-COLUMN POST SECTION (full width) ===
        if ( $show_economy && $economy_cat ) :
            $economy_query = new WP_Query( array(
                'category_name'  => $economy_cat,
                'posts_per_page' => 4,
                'post_status'    => 'publish',
            ) );
            if ( $economy_query->have_posts() ) :
                ?>
                <section class="section-block economy-section">
                    <div class="section-header">
                        <div class="section-accent"></div>
                        <h2 class="section-title"><?php echo esc_html( get_category_by_slug( $economy_cat ) ? get_category_by_slug( $economy_cat )->name : 'News' ); ?></h2>
                        <div class="section-line"></div>
                        <a href="<?php echo esc_url( get_category_link( get_category_by_slug( $economy_cat ) ) ); ?>" class="section-more"><?php esc_html_e( 'View All →', 'ald-blog' ); ?></a>
                    </div>
                    <div class="four-col-grid">
                        <?php
                        while ( $economy_query->have_posts() ) : $economy_query->the_post();
                            ?>
                            <article class="economy-card">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="economy-image">
                                            <?php the_post_thumbnail( 'grid-article' ); ?>
                                        </div>
                                    <?php endif; ?>
                                    <h4 class="economy-title"><?php the_title(); ?></h4>
                                    <div class="economy-meta">
                                        <span class="time"><?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago'; ?></span>
                                        <span class="author"><?php the_author(); ?></span>
                                    </div>
                                </a>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </section>
            <?php
            endif;
        endif;
        ?>

    </div>
</main>

<?php
get_footer();
