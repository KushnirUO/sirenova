
<?php 

add_action('after_setup_theme', function() {
    add_theme_support('woocommerce');
}, 20);

register_nav_menus(
    array(
        'Header-menu'=> __('Меню шапки','sirenova'),
        'Footer-menu'=> __('Меню футеру','sirenova'),
    )
);

require get_template_directory() . '/inc/theme-enqueue.php';
