<?php
/**
 * ALD Blog Customizer — Prothom Alo Theme Options
 *
 * @package ALD_Blog
 */

function ald_blog_customize_register( $wp_customize ) {

    // === COLORS SECTION ===
    $wp_customize->add_section( 'ald_blog_colors', array(
        'title'    => __( 'Theme Colors', 'ald-blog' ),
        'priority' => 30,
    ) );

    $colors = array(
        'primary_color'   => array( 'label' => __( 'Primary Color (Red)', 'ald-blog' ),   'default' => '#D60000' ),
        'primary_dark'    => array( 'label' => __( 'Dark Primary', 'ald-blog' ),          'default' => '#a30000' ),
        'primary_light'   => array( 'label' => __( 'Light Primary', 'ald-blog' ),         'default' => '#ff1a1a' ),
        'bg_color'        => array( 'label' => __( 'Background Color', 'ald-blog' ),       'default' => '#ffffff' ),
        'text_color'      => array( 'label' => __( 'Text Color', 'ald-blog' ),             'default' => '#1a1a1a' ),
        'text_secondary'  => array( 'label' => __( 'Secondary Text', 'ald-blog' ),         'default' => '#525252' ),
        'text_muted'      => array( 'label' => __( 'Muted Text', 'ald-blog' ),             'default' => '#737373' ),
        'border_color'    => array( 'label' => __( 'Border Color', 'ald-blog' ),           'default' => '#e5e5e5' ),
        'bg_alt'          => array( 'label' => __( 'Alt Background', 'ald-blog' ),         'default' => '#f5f5f5' ),
        'footer_bg'       => array( 'label' => __( 'Footer Background', 'ald-blog' ),      'default' => '#171717' ),
        'footer_text'     => array( 'label' => __( 'Footer Text', 'ald-blog' ),            'default' => '#a3a3a3' ),
    );

    foreach ( $colors as $id => $args ) {
        $wp_customize->add_setting( $id, array(
            'default'           => $args['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
            'label'   => $args['label'],
            'section' => 'ald_blog_colors',
        ) ) );
    }

    // === HOMEPAGE SECTION ===
    $wp_customize->add_section( 'ald_blog_homepage', array(
        'title'    => __( 'Homepage Blocks', 'ald-blog' ),
        'priority' => 40,
    ) );

    // Show/Hide blocks
    $blocks = array(
        'show_hero'     => array( 'label' => __( 'Show Lead Article', 'ald-blog' ),        'default' => true ),
        'show_politics'  => array( 'label' => __( 'Show 3-Column Post Section', 'ald-blog' ), 'default' => true ),
        'show_latest'    => array( 'label' => __( 'Show 2-Column Post Section', 'ald-blog' ), 'default' => true ),
        'show_economy'   => array( 'label' => __( 'Show 4-Column Post Section', 'ald-blog' ), 'default' => true ),
    );
    foreach ( $blocks as $id => $args ) {
        $wp_customize->add_setting( $id, array(
            'default'           => $args['default'],
            'sanitize_callback' => 'wp_validate_boolean',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( $id, array(
            'label'   => $args['label'],
            'section' => 'ald_blog_homepage',
            'type'    => 'checkbox',
        ) );
    }

    // Category selectors
    $categories = get_categories( array( 'hide_empty' => false ) );
    $cat_choices = array( '' => __( '— Select Category —', 'ald-blog' ) );
    foreach ( $categories as $cat ) {
        $cat_choices[ $cat->slug ] = $cat->name;
    }

    $wp_customize->add_setting( 'politics_category', array(
        'default'           => 'opinion',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'politics_category', array(
        'label'    => __( '3-Column Post Section — Category', 'ald-blog' ),
        'section'  => 'ald_blog_homepage',
        'type'     => 'select',
        'choices'  => $cat_choices,
    ) );

    $wp_customize->add_setting( 'economy_category', array(
        'default'           => 'business',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'economy_category', array(
        'label'    => __( '4-Column Post Section — Category', 'ald-blog' ),
        'section'  => 'ald_blog_homepage',
        'type'     => 'select',
        'choices'  => $cat_choices,
    ) );

    // Latest Posts (2-Column) category selector
    $wp_customize->add_setting( 'latest_category', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'latest_category', array(
        'label'    => __( '2-Column Post Section — Category', 'ald-blog' ),
        'section'  => 'ald_blog_homepage',
        'type'     => 'select',
        'choices'  => $cat_choices,
    ) );

    $wp_customize->add_setting( 'latest_posts_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'latest_posts_count', array(
        'label'   => __( 'Number of Latest Posts', 'ald-blog' ),
        'section' => 'ald_blog_homepage',
        'type'    => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 12 ),
    ) );

    // === TICKER SECTION ===
    $wp_customize->add_section( 'ald_blog_ticker', array(
        'title'    => __( 'Breaking News Ticker', 'ald-blog' ),
        'priority' => 45,
    ) );

    $wp_customize->add_setting( 'ticker_count', array(
        'default'           => 5,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'ticker_count', array(
        'label'       => __( 'Number of posts in ticker', 'ald-blog' ),
        'section'     => 'ald_blog_ticker',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 10 ),
    ) );

    // Ticker background color
    $wp_customize->add_setting( 'ticker_bg_color', array(
        'default'           => '#D60000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ticker_bg_color', array(
        'label'   => __( 'Ticker Background Color', 'ald-blog' ),
        'section' => 'ald_blog_ticker',
    ) ) );

    // Ticker text color
    $wp_customize->add_setting( 'ticker_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ticker_text_color', array(
        'label'   => __( 'Ticker Text Color', 'ald-blog' ),
        'section' => 'ald_blog_ticker',
    ) ) );

    // Ticker link color
    $wp_customize->add_setting( 'ticker_link_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ticker_link_color', array(
        'label'   => __( 'Ticker Link Color', 'ald-blog' ),
        'section' => 'ald_blog_ticker',
    ) ) );

    // === TOP BAR SECTION ===
    $wp_customize->add_section( 'ald_blog_topbar', array(
        'title'    => __( 'Top Bar', 'ald-blog' ),
        'priority' => 35,
    ) );

    // Top bar left text
    $wp_customize->add_setting( 'topbar_left_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'topbar_left_text', array(
        'label'       => __( 'Left Side Text', 'ald-blog' ),
        'description' => __( 'Text displayed on the left side of the top bar. Leave empty to show date.', 'ald-blog' ),
        'section'     => 'ald_blog_topbar',
        'type'        => 'text',
    ) );

    // Top bar broadcast link text
    $wp_customize->add_setting( 'topbar_broadcast_text', array(
        'default'           => __( 'Top Broadcast', 'ald-blog' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'topbar_broadcast_text', array(
        'label'   => __( 'Broadcast Link Text', 'ald-blog' ),
        'section' => 'ald_blog_topbar',
        'type'    => 'text',
    ) );

    // Top bar broadcast link URL
    $wp_customize->add_setting( 'topbar_broadcast_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'topbar_broadcast_url', array(
        'label'   => __( 'Broadcast Link URL', 'ald-blog' ),
        'section' => 'ald_blog_topbar',
        'type'    => 'url',
    ) );

    // Show/Hide broadcast link
    $wp_customize->add_setting( 'topbar_broadcast_show', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'topbar_broadcast_show', array(
        'label'   => __( 'Show Broadcast Link', 'ald-blog' ),
        'section' => 'ald_blog_topbar',
        'type'    => 'checkbox',
    ) );

    // === SOCIAL MEDIA SECTION ===
    $wp_customize->add_section( 'ald_blog_social', array(
        'title'    => __( 'Social Media', 'ald-blog' ),
        'priority' => 37,
    ) );

    $social_fields = array(
        'social_facebook_url'  => array( 'label' => __( 'Facebook URL', 'ald-blog' ),  'default' => '' ),
        'social_twitter_url'   => array( 'label' => __( 'Twitter / X URL', 'ald-blog' ), 'default' => '' ),
        'social_instagram_url' => array( 'label' => __( 'Instagram URL', 'ald-blog' ), 'default' => '' ),
        'social_youtube_url'   => array( 'label' => __( 'YouTube URL', 'ald-blog' ),   'default' => '' ),
        'social_linkedin_url'  => array( 'label' => __( 'LinkedIn URL', 'ald-blog' ),  'default' => '' ),
    );

    foreach ( $social_fields as $id => $args ) {
        $wp_customize->add_setting( $id, array(
            'default'           => $args['default'],
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( $id, array(
            'label'   => $args['label'],
            'section' => 'ald_blog_social',
            'type'    => 'url',
        ) );
    }

    // === HEADER BUTTONS SECTION ===
    $wp_customize->add_section( 'ald_blog_header_buttons', array(
        'title'    => __( 'Header Buttons', 'ald-blog' ),
        'priority' => 36,
    ) );

    // Add News button text
    $wp_customize->add_setting( 'header_addnews_text', array(
        'default'           => __( 'Add News', 'ald-blog' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'header_addnews_text', array(
        'label'   => __( 'Add News Button Text', 'ald-blog' ),
        'section' => 'ald_blog_header_buttons',
        'type'    => 'text',
    ) );

    // Add News button URL
    $wp_customize->add_setting( 'header_addnews_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'header_addnews_url', array(
        'label'   => __( 'Add News Button URL', 'ald-blog' ),
        'section' => 'ald_blog_header_buttons',
        'type'    => 'url',
    ) );

    // Add News button visibility
    $wp_customize->add_setting( 'header_addnews_show', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'header_addnews_show', array(
        'label'   => __( 'Show Add News Button', 'ald-blog' ),
        'section' => 'ald_blog_header_buttons',
        'type'    => 'checkbox',
    ) );

    // Login button text
    $wp_customize->add_setting( 'header_login_text', array(
        'default'           => __( 'Login', 'ald-blog' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'header_login_text', array(
        'label'   => __( 'Login Button Text', 'ald-blog' ),
        'section' => 'ald_blog_header_buttons',
        'type'    => 'text',
    ) );

    // Login button URL
    $wp_customize->add_setting( 'header_login_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'header_login_url', array(
        'label'   => __( 'Login Button URL', 'ald-blog' ),
        'section' => 'ald_blog_header_buttons',
        'type'    => 'url',
    ) );

    // Login button visibility
    $wp_customize->add_setting( 'header_login_show', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'header_login_show', array(
        'label'   => __( 'Show Login Button', 'ald-blog' ),
        'section' => 'ald_blog_header_buttons',
        'type'    => 'checkbox',
    ) );

    // === FOOTER SECTION ===
    $wp_customize->add_section( 'ald_blog_footer', array(
        'title'    => __( 'Footer', 'ald-blog' ),
        'priority' => 50,
    ) );

    // Footer column link color
    $wp_customize->add_setting( 'footer_link_color', array(
        'default'           => '#a3a3a3',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_link_color', array(
        'label'   => __( 'Footer Column Link Color', 'ald-blog' ),
        'section' => 'ald_blog_footer',
    ) ) );

    // Footer column link hover color
    $wp_customize->add_setting( 'footer_link_hover_color', array(
        'default'           => '#D60000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_link_hover_color', array(
        'label'   => __( 'Footer Column Link Hover Color', 'ald-blog' ),
        'section' => 'ald_blog_footer',
    ) ) );

    // Footer bottom link color
    $wp_customize->add_setting( 'footer_bottom_link_color', array(
        'default'           => '#a3a3a3',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bottom_link_color', array(
        'label'   => __( 'Footer Bottom Link Color', 'ald-blog' ),
        'section' => 'ald_blog_footer',
    ) ) );

    // Footer bottom link hover color
    $wp_customize->add_setting( 'footer_bottom_link_hover_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bottom_link_hover_color', array(
        'label'   => __( 'Footer Bottom Link Hover Color', 'ald-blog' ),
        'section' => 'ald_blog_footer',
    ) ) );

    // Footer nav link color (footer-nav .nav-menu a)
    $wp_customize->add_setting( 'footer_nav_link_color', array(
        'default'           => '#a0aec0',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_nav_link_color', array(
        'label'   => __( 'Footer Nav Link Color', 'ald-blog' ),
        'section' => 'ald_blog_footer',
    ) ) );

    // Footer nav link hover color
    $wp_customize->add_setting( 'footer_nav_link_hover_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_nav_link_hover_color', array(
        'label'   => __( 'Footer Nav Link Hover Color', 'ald-blog' ),
        'section' => 'ald_blog_footer',
    ) ) );
}
add_action( 'customize_register', 'ald_blog_customize_register' );

/**
 * Customizer CSS Output
 */
function ald_blog_customizer_css() {
    $primary    = get_theme_mod( 'primary_color', '#D60000' );
    $primary_dk = get_theme_mod( 'primary_dark', '#a30000' );
    $primary_lt = get_theme_mod( 'primary_light', '#ff1a1a' );
    $bg         = get_theme_mod( 'bg_color', '#ffffff' );
    $text       = get_theme_mod( 'text_color', '#1a1a1a' );
    $text_sec   = get_theme_mod( 'text_secondary', '#525252' );
    $text_muted = get_theme_mod( 'text_muted', '#737373' );
    $border     = get_theme_mod( 'border_color', '#e5e5e5' );
    $bg_alt     = get_theme_mod( 'bg_alt', '#f5f5f5' );
    $footer_bg  = get_theme_mod( 'footer_bg', '#171717' );
    $footer_txt = get_theme_mod( 'footer_text', '#a3a3a3' );
    $ticker_bg  = get_theme_mod( 'ticker_bg_color', '#D60000' );
    $ticker_txt = get_theme_mod( 'ticker_text_color', '#ffffff' );
    $ticker_link = get_theme_mod( 'ticker_link_color', '#ffffff' );
    $footer_link = get_theme_mod( 'footer_link_color', '#a3a3a3' );
    $footer_link_hover = get_theme_mod( 'footer_link_hover_color', '#D60000' );
    $footer_bottom_link = get_theme_mod( 'footer_bottom_link_color', '#a3a3a3' );
    $footer_bottom_link_hover = get_theme_mod( 'footer_bottom_link_hover_color', '#ffffff' );
    $footer_nav_link = get_theme_mod( 'footer_nav_link_color', '#a0aec0' );
    $footer_nav_link_hover = get_theme_mod( 'footer_nav_link_hover_color', '#ffffff' );
    ?>
    <style>
        :root {
            --color-primary: <?php echo esc_attr( $primary ); ?>;
            --color-primary-dark: <?php echo esc_attr( $primary_dk ); ?>;
            --color-primary-light: <?php echo esc_attr( $primary_lt ); ?>;
            --color-bg: <?php echo esc_attr( $bg ); ?>;
            --color-text: <?php echo esc_attr( $text ); ?>;
            --color-text-secondary: <?php echo esc_attr( $text_sec ); ?>;
            --color-text-muted: <?php echo esc_attr( $text_muted ); ?>;
            --color-border: <?php echo esc_attr( $border ); ?>;
            --color-bg-alt: <?php echo esc_attr( $bg_alt ); ?>;
            --color-footer-bg: <?php echo esc_attr( $footer_bg ); ?>;
            --color-footer-text: <?php echo esc_attr( $footer_txt ); ?>;
            --color-ticker-bg: <?php echo esc_attr( $ticker_bg ); ?>;
            --color-ticker-text: <?php echo esc_attr( $ticker_txt ); ?>;
            --color-ticker-link: <?php echo esc_attr( $ticker_link ); ?>;
            --color-footer-link: <?php echo esc_attr( $footer_link ); ?>;
            --color-footer-link-hover: <?php echo esc_attr( $footer_link_hover ); ?>;
            --color-footer-bottom-link: <?php echo esc_attr( $footer_bottom_link ); ?>;
            --color-footer-bottom-link-hover: <?php echo esc_attr( $footer_bottom_link_hover ); ?>;
            --color-footer-nav-link: <?php echo esc_attr( $footer_nav_link ); ?>;
            --color-footer-nav-link-hover: <?php echo esc_attr( $footer_nav_link_hover ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'ald_blog_customizer_css', 5 );
