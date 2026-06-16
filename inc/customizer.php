<?php
/**
 * ALD Blog Customizer
 *
 * @package ALD_Blog
 */

function ald_blog_customizer_settings( $wp_customize ) {

    // === General Settings Panel ===
    $wp_customize->add_section( 'ald_blog_general', array(
        'title'    => __( 'ALD Blog Settings', 'ald-blog' ),
        'priority' => 30,
    ) );

    // Show/Hide Reading Time
    $wp_customize->add_setting( 'ald_blog_show_reading_time', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'ald_blog_show_reading_time', array(
        'label'   => __( 'Show Reading Time', 'ald-blog' ),
        'section' => 'ald_blog_general',
        'type'    => 'checkbox',
    ) );

    // Show/Hide Breadcrumbs
    $wp_customize->add_setting( 'ald_blog_show_breadcrumbs', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'ald_blog_show_breadcrumbs', array(
        'label'   => __( 'Show Breadcrumbs', 'ald-blog' ),
        'section' => 'ald_blog_general',
        'type'    => 'checkbox',
    ) );

    // Excerpt length
    $wp_customize->add_setting( 'ald_blog_excerpt_length', array(
        'default'           => 25,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'ald_blog_excerpt_length', array(
        'label'       => __( 'Excerpt Length (words)', 'ald-blog' ),
        'section'     => 'ald_blog_general',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 100,
            'step' => 1,
        ),
    ) );

    // === AdSense Section ===
    $wp_customize->add_section( 'ald_blog_ads', array(
        'title'    => __( 'Ad Settings', 'ald-blog' ),
        'priority' => 35,
    ) );

    // AdSense Publisher ID
    $wp_customize->add_setting( 'ald_blog_adsense_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'ald_blog_adsense_id', array(
        'label'       => __( 'AdSense Publisher ID', 'ald-blog' ),
        'description' => __( 'Enter your AdSense publisher ID (e.g., ca-pub-XXXXXXXXXXXXXXXX)', 'ald-blog' ),
        'section'     => 'ald_blog_ads',
        'type'        => 'text',
    ) );

    // Enable header ad
    $wp_customize->add_setting( 'ald_blog_ad_header', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'ald_blog_ad_header', array(
        'label'   => __( 'Enable Header Ad', 'ald-blog' ),
        'section' => 'ald_blog_ads',
        'type'    => 'checkbox',
    ) );

    // Enable content ad
    $wp_customize->add_setting( 'ald_blog_ad_content', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'ald_blog_ad_content', array(
        'label'   => __( 'Enable In-Content Ad', 'ald-blog' ),
        'section' => 'ald_blog_ads',
        'type'    => 'checkbox',
    ) );

    // Enable sidebar ad
    $wp_customize->add_setting( 'ald_blog_ad_sidebar', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'ald_blog_ad_sidebar', array(
        'label'   => __( 'Enable Sidebar Ad', 'ald-blog' ),
        'section' => 'ald_blog_ads',
        'type'    => 'checkbox',
    ) );

    // === Footer Section ===
    $wp_customize->add_section( 'ald_blog_footer', array(
        'title'    => __( 'Footer Settings', 'ald-blog' ),
        'priority' => 40,
    ) );

    // Footer text
    $wp_customize->add_setting( 'ald_blog_footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'ald_blog_footer_text', array(
        'label'   => __( 'Footer Text', 'ald-blog' ),
        'section' => 'ald_blog_footer',
        'type'    => 'textarea',
    ) );

    // === Colors ===
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'ald_blog_customizer_settings' );
