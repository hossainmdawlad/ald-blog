<?php
/**
 * Sidebar template
 *
 * @package ALD_Blog
 */
?>

<div class="sidebar-widgets">

    <!-- Latest News Feed -->
    <div class="widget widget-latest-news">
        <div class="widget-header">
            <span class="live-dot-sm"></span>
            <h3 class="widget-title"><?php esc_html_e( 'Latest News', 'ald-blog' ); ?></h3>
        </div>
        <div class="latest-news-list">
            <?php
            $latest = new WP_Query( array(
                'posts_per_page' => 8,
                'post_status'    => 'publish',
            ) );
            if ( $latest->have_posts() ) :
                while ( $latest->have_posts() ) : $latest->the_post();
                    ?>
                    <a href="<?php the_permalink(); ?>" class="news-item">
                        <span class="news-time"><?php echo get_the_time( 'H:i' ); ?></span>
                        <span class="news-title"><?php echo wp_trim_words( get_the_title(), 8 ); ?></span>
                    </a>
                <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>

    <!-- Weather Widget -->
    <div class="widget widget-weather">
        <div class="weather-header">
            <span class="weather-icon">📍</span>
            <h3 class="widget-title"><?php esc_html_e( 'Weather', 'ald-blog' ); ?></h3>
        </div>
        <div class="weather-body">
            <div class="weather-city">Dhaka</div>
            <div class="weather-temp">32°C</div>
            <div class="weather-condition">Partly Cloudy</div>
            <div class="weather-details">
                <span>Humidity: 78%</span>
                <span>Wind: 12 km/h</span>
            </div>
        </div>
    </div>

    <!-- Multimedia Promo -->
    <div class="widget widget-multimedia">
        <div class="video-promo">
            <div class="play-overlay">
                <span class="play-btn">▶</span>
            </div>
            <div class="video-title"><?php esc_html_e( 'Latest Video Reports', 'ald-blog' ); ?></div>
        </div>
    </div>

    <!-- Ad Banner -->
    <div class="widget widget-ad">
        <span class="ad-label"><?php esc_html_e( 'Advertisement', 'ald-blog' ); ?></span>
        <div class="ad-banner">
            <p>300 x 250 Banner Space</p>
            <p><?php esc_html_e( 'Advertise on the most read news portal.', 'ald-blog' ); ?></p>
        </div>
    </div>

</div>
