
<?php 

add_action('after_setup_theme', function() {
    add_theme_support('woocommerce');
}, 20);

register_nav_menus(
    array(
        'header-menu'=> __('Меню шапки','sirenova'),
        'footer-menu'=> __('Меню футеру','sirenova'),
    )
);

require get_template_directory() . '/inc/theme-enqueue.php';
require_once get_template_directory() .'/inc/class-sirenova-header-menu.php';

show_admin_bar(false);
