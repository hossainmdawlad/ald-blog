<?php
/**
 * Sidebar template
 *
 * @package ALD_Blog
 */

$sidebar_args = array(
    'before_widget' => '<div class="widget %s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
);
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div class="sidebar-widgets">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div>
<?php else : ?>
    <div class="sidebar-widgets">
        <?php the_widget( 'ALD_Latest_News_Widget', array( 'count' => 8 ), $sidebar_args ); ?>
        <?php the_widget( 'ALD_Weather_Widget', array(
            'city'      => 'Dhaka',
            'temp'      => '32°C',
            'condition' => 'Partly Cloudy',
            'humidity'  => '78%',
            'wind'      => '12 km/h',
        ), $sidebar_args ); ?>
        <?php the_widget( 'ALD_Multimedia_Widget', array(), $sidebar_args ); ?>
        <?php the_widget( 'ALD_Ad_Banner_Widget', array(), $sidebar_args ); ?>
    </div>
<?php endif; ?>
