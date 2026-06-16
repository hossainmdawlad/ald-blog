<?php
/**
 * The sidebar template
 *
 * @package ALD_Blog
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<aside class="sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'ald-blog' ); ?>">

    <?php ald_blog_ad_container( 'sidebar', 'ad-container--sidebar-top' ); ?>

    <?php dynamic_sidebar( 'sidebar-1' ); ?>

    <?php ald_blog_ad_container( 'sidebar', 'ad-container--sidebar-bottom' ); ?>

</aside>
