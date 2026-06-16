<?php
/**
 * Fallback menu for when no menu is assigned
 *
 * @package ALD_Blog
 */

if ( ! function_exists( 'ald_blog_fallback_menu' ) ) :
    function ald_blog_fallback_menu() {
        echo '<ul class="nav-menu">';
        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'ald-blog' ) . '</a></li>';

        // Show top-level pages
        $pages = get_pages( array(
            'sort_column' => 'menu_order',
            'parent'      => 0,
            'number'      => 10,
        ) );

        foreach ( $pages as $page ) {
            echo '<li><a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . esc_html( get_the_title( $page->ID ) ) . '</a></li>';
        }

        echo '</ul>';
    }
endif;
