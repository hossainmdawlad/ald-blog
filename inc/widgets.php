<?php
/**
 * ALD Blog Custom Widgets
 *
 * @package ALD_Blog
 */

// === Latest News Widget ===
class ALD_Latest_News_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'ald_latest_news',
            __( 'ALD Latest News', 'ald-blog' ),
            array( 'description' => __( 'Displays latest posts in a news feed format', 'ald-blog' ) )
        );
    }

    public function widget( $args, $instance ) {
        $title  = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Latest News', 'ald-blog' );
        $count  = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 8;

        echo $args['before_widget'];
        ?>
        <div class="widget-latest-news">
            <div class="widget-header">
                <span class="live-dot-sm"></span>
                <?php echo $args['before_title'] . esc_html( $title ) . $args['after_title']; ?>
            </div>
            <div class="latest-news-list">
                <?php
                $latest = new WP_Query( array(
                    'posts_per_page' => $count,
                    'post_status'    => 'publish',
                ) );
                if ( $latest->have_posts() ) :
                    while ( $latest->have_posts() ) : $latest->the_post();
                        ?>
                        <a href="<?php the_permalink(); ?>" class="news-item">
                            <span class="news-time"><?php echo get_the_date( 'M j, Y' ); ?></span>
                            <span class="news-title"><?php echo wp_trim_words( get_the_title(), 8 ); ?></span>
                        </a>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Latest News', 'ald-blog' );
        $count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 8;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'ald-blog' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'ald-blog' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" max="20" value="<?php echo esc_attr( $count ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance          = array();
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['count'] = absint( $new_instance['count'] );
        return $instance;
    }
}

// === Weather Widget ===
class ALD_Weather_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'ald_weather',
            __( 'ALD Weather', 'ald-blog' ),
            array( 'description' => __( 'Displays live weather from Open-Meteo (free, no API key)', 'ald-blog' ) )
        );
    }

    /**
     * Fetch weather data from Open-Meteo API.
     * Returns array with temp, condition, humidity, wind, city, icon or false on failure.
     */
    private function get_weather_data( $city ) {
        $cache_key = 'ald_weather_' . sanitize_title( $city );
        $cached    = get_transient( $cache_key );

        if ( $cached !== false ) {
            return $cached;
        }

        // Step 1: Geocode city name → lat/lon
        $geo_url = add_query_arg( array(
            'name'     => $city,
            'count'    => 1,
            'language' => 'en',
            'format'   => 'json',
        ), 'https://geocoding-api.open-meteo.com/v1/search' );

        $geo_response = wp_remote_get( $geo_url, array( 'timeout' => 5 ) );

        if ( is_wp_error( $geo_response ) ) {
            return false;
        }

        $geo_body = json_decode( wp_remote_retrieve_body( $geo_response ), true );
        if ( empty( $geo_body['results'][0] ) ) {
            return false;
        }

        $lat  = $geo_body['results'][0]['latitude'];
        $lon  = $geo_body['results'][0]['longitude'];
        $name = $geo_body['results'][0]['name'];
        $country = isset( $geo_body['results'][0]['country'] ) ? $geo_body['results'][0]['country'] : '';

        // Step 2: Fetch current weather
        $weather_url = add_query_arg( array(
            'latitude'  => $lat,
            'longitude' => $lon,
            'current'   => 'temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m',
            'timezone'  => 'auto',
        ), 'https://api.open-meteo.com/v1/forecast' );

        $weather_response = wp_remote_get( $weather_url, array( 'timeout' => 5 ) );

        if ( is_wp_error( $weather_response ) ) {
            return false;
        }

        $weather_body = json_decode( wp_remote_retrieve_body( $weather_response ), true );
        if ( empty( $weather_body['current'] ) ) {
            return false;
        }

        $current = $weather_body['current'];
        $wmo_code = isset( $current['weather_code'] ) ? (int) $current['weather_code'] : 0;

        $data = array(
            'temp'      => round( $current['temperature_2m'] ) . '°C',
            'condition' => $this->wmo_condition( $wmo_code ),
            'icon'      => $this->wmo_icon( $wmo_code ),
            'humidity'  => $current['relative_humidity_2m'] . '%',
            'wind'      => round( $current['wind_speed_10m'] ) . ' km/h',
            'city'      => $name . ( $country ? ', ' . $country : '' ),
        );

        // Cache for 30 minutes
        set_transient( $cache_key, $data, 30 * MINUTE_IN_SECONDS );

        return $data;
    }

    /**
     * Map WMO weather code to human-readable condition.
     */
    private function wmo_condition( $code ) {
        $map = array(
            0  => 'Clear Sky',
            1  => 'Mainly Clear',
            2  => 'Partly Cloudy',
            3  => 'Overcast',
            45 => 'Foggy',
            48 => 'Rime Fog',
            51 => 'Light Drizzle',
            53 => 'Moderate Drizzle',
            55 => 'Dense Drizzle',
            56 => 'Freezing Drizzle',
            57 => 'Heavy Freezing Drizzle',
            61 => 'Slight Rain',
            63 => 'Moderate Rain',
            65 => 'Heavy Rain',
            66 => 'Freezing Rain',
            67 => 'Heavy Freezing Rain',
            71 => 'Slight Snow',
            73 => 'Moderate Snow',
            75 => 'Heavy Snow',
            77 => 'Snow Grains',
            80 => 'Slight Showers',
            81 => 'Moderate Showers',
            82 => 'Violent Showers',
            85 => 'Slight Snow Showers',
            86 => 'Heavy Snow Showers',
            95 => 'Thunderstorm',
            96 => 'Thunderstorm + Hail',
            99 => 'Thunderstorm + Heavy Hail',
        );
        return isset( $map[ $code ] ) ? $map[ $code ] : 'Unknown';
    }

    /**
     * Map WMO weather code to emoji icon.
     */
    private function wmo_icon( $code ) {
        if ( $code === 0 ) return '☀️';
        if ( $code <= 3 ) return '⛅';
        if ( $code <= 48 ) return '🌫️';
        if ( $code <= 57 ) return '🌧️';
        if ( $code <= 67 ) return '🌧️';
        if ( $code <= 77 ) return '❄️';
        if ( $code <= 82 ) return '🌦️';
        if ( $code <= 86 ) return '🌨️';
        return '⛈️';
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Weather', 'ald-blog' );
        $city  = ! empty( $instance['city'] ) ? $instance['city'] : 'Dhaka';

        // Try live API first
        $weather = $this->get_weather_data( $city );

        if ( $weather ) {
            $temp      = $weather['temp'];
            $condition = $weather['condition'];
            $icon      = $weather['icon'];
            $humidity  = $weather['humidity'];
            $wind      = $weather['wind'];
            $city_name = $weather['city'];
        } else {
            // Fallback to static values
            $temp      = ! empty( $instance['temp'] ) ? $instance['temp'] : '32°C';
            $condition = ! empty( $instance['condition'] ) ? $instance['condition'] : 'Partly Cloudy';
            $icon      = '⛅';
            $humidity  = ! empty( $instance['humidity'] ) ? $instance['humidity'] : '78%';
            $wind      = ! empty( $instance['wind'] ) ? $instance['wind'] : '12 km/h';
            $city_name = $city;
        }

        echo $args['before_widget'];
        ?>
        <div class="widget-weather">
            <div class="weather-header">
                <span class="weather-icon"><?php echo esc_html( $icon ); ?></span>
                <?php echo $args['before_title'] . esc_html( $title ) . $args['after_title']; ?>
            </div>
            <div class="weather-body">
                <div class="weather-city"><?php echo esc_html( $city_name ); ?></div>
                <div class="weather-temp"><?php echo esc_html( $temp ); ?></div>
                <div class="weather-condition"><?php echo esc_html( $condition ); ?></div>
                <div class="weather-details">
                    <span><?php esc_html_e( 'Humidity:', 'ald-blog' ); ?> <?php echo esc_html( $humidity ); ?></span>
                    <span><?php esc_html_e( 'Wind:', 'ald-blog' ); ?> <?php echo esc_html( $wind ); ?></span>
                </div>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title     = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Weather', 'ald-blog' );
        $city      = ! empty( $instance['city'] ) ? $instance['city'] : 'Dhaka';
        $temp      = ! empty( $instance['temp'] ) ? $instance['temp'] : '32°C';
        $condition = ! empty( $instance['condition'] ) ? $instance['condition'] : 'Partly Cloudy';
        $humidity  = ! empty( $instance['humidity'] ) ? $instance['humidity'] : '78%';
        $wind      = ! empty( $instance['wind'] ) ? $instance['wind'] : '12 km/h';
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'ald-blog' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'city' ) ); ?>"><?php esc_html_e( 'City (for live weather):', 'ald-blog' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'city' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'city' ) ); ?>" type="text" value="<?php echo esc_attr( $city ); ?>">
            <small><?php esc_html_e( 'Enter city name (e.g. Dhaka, London, Tokyo). Leave fallback fields below for when API is unavailable.', 'ald-blog' ); ?></small>
        </p>
        <hr>
        <p><strong><?php esc_html_e( 'Fallback Values (used if API fails):', 'ald-blog' ); ?></strong></p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'temp' ) ); ?>"><?php esc_html_e( 'Temperature:', 'ald-blog' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'temp' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'temp' ) ); ?>" type="text" value="<?php echo esc_attr( $temp ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'condition' ) ); ?>"><?php esc_html_e( 'Condition:', 'ald-blog' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'condition' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'condition' ) ); ?>" type="text" value="<?php echo esc_attr( $condition ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'humidity' ) ); ?>"><?php esc_html_e( 'Humidity:', 'ald-blog' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'humidity' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'humidity' ) ); ?>" type="text" value="<?php echo esc_attr( $humidity ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'wind' ) ); ?>"><?php esc_html_e( 'Wind:', 'ald-blog' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'wind' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'wind' ) ); ?>" type="text" value="<?php echo esc_attr( $wind ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance              = array();
        $instance['title']     = sanitize_text_field( $new_instance['title'] );
        $instance['city']      = sanitize_text_field( $new_instance['city'] );
        $instance['temp']      = sanitize_text_field( $new_instance['temp'] );
        $instance['condition'] = sanitize_text_field( $new_instance['condition'] );
        $instance['humidity']  = sanitize_text_field( $new_instance['humidity'] );
        $instance['wind']      = sanitize_text_field( $new_instance['wind'] );

        // Clear cached weather for the old city if city changed
        if ( ! empty( $old_instance['city'] ) && $old_instance['city'] !== $instance['city'] ) {
            delete_transient( 'ald_weather_' . sanitize_title( $old_instance['city'] ) );
        }

        return $instance;
    }
}

// === Multimedia Promo Widget ===
class ALD_Multimedia_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'ald_multimedia',
            __( 'ALD Multimedia Promo', 'ald-blog' ),
            array( 'description' => __( 'Displays a video/multimedia promo block', 'ald-blog' ) )
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Latest Video Reports', 'ald-blog' );
        $url   = ! empty( $instance['url'] ) ? $instance['url'] : '#';

        echo $args['before_widget'];
        ?>
        <div class="widget-multimedia">
            <a href="<?php echo esc_url( $url ); ?>" class="video-promo">
                <div class="play-overlay">
                    <span class="play-btn">▶</span>
                </div>
                <div class="video-title"><?php echo esc_html( $title ); ?></div>
            </a>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Latest Video Reports', 'ald-blog' );
        $url   = ! empty( $instance['url'] ) ? $instance['url'] : '#';
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'ald-blog' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_html_e( 'Link URL:', 'ald-blog' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="url" value="<?php echo esc_attr( $url ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance          = array();
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['url']   = esc_url_raw( $new_instance['url'] );
        return $instance;
    }
}

// === Ad Banner Widget ===
class ALD_Ad_Banner_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'ald_ad_banner',
            __( 'ALD Ad Banner', 'ald-blog' ),
            array( 'description' => __( 'Displays an advertisement banner', 'ald-blog' ) )
        );
    }

    public function widget( $args, $instance ) {
        $title    = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Advertisement', 'ald-blog' );
        $content  = ! empty( $instance['content'] ) ? $instance['content'] : '';
        $bg_color = ! empty( $instance['bg_color'] ) ? $instance['bg_color'] : '#f5f5f5';

        echo $args['before_widget'];
        ?>
        <div class="widget-ad">
            <span class="ad-label"><?php echo esc_html( $title ); ?></span>
            <div class="ad-banner" style="background: <?php echo esc_attr( $bg_color ); ?>;">
                <?php if ( $content ) : ?>
                    <?php echo wp_kses_post( $content ); ?>
                <?php else : ?>
                    <p>300 x 250 Banner Space</p>
                    <p><?php esc_html_e( 'Advertise on the most read news portal.', 'ald-blog' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title    = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Advertisement', 'ald-blog' );
        $content  = ! empty( $instance['content'] ) ? $instance['content'] : '';
        $bg_color = ! empty( $instance['bg_color'] ) ? $instance['bg_color'] : '#f5f5f5';
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'ald-blog' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php esc_html_e( 'Content (HTML allowed):', 'ald-blog' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>" rows="4"><?php echo esc_textarea( $content ); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>"><?php esc_html_e( 'Background Color:', 'ald-blog' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bg_color' ) ); ?>" type="text" value="<?php echo esc_attr( $bg_color ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance             = array();
        $instance['title']    = sanitize_text_field( $new_instance['title'] );
        $instance['content']  = wp_kses_post( $new_instance['content'] );
        $instance['bg_color'] = sanitize_hex_color( $new_instance['bg_color'] );
        return $instance;
    }
}

// === Register all widgets ===
function ald_blog_register_widgets() {
    register_widget( 'ALD_Latest_News_Widget' );
    register_widget( 'ALD_Weather_Widget' );
    register_widget( 'ALD_Multimedia_Widget' );
    register_widget( 'ALD_Ad_Banner_Widget' );
}
add_action( 'widgets_init', 'ald_blog_register_widgets' );
