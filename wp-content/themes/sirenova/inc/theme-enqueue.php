<?php
add_action('wp_enqueue_scripts', 'sirenova_scripts');

function sirenova_scripts()
{
    if (!is_checkout()) {
        // Відключаємо стилі WooCommerce, якщо не на сторінці чекауту
        wp_deregister_style('woocommerce-general');
        wp_deregister_style('woocommerce-layout');
    }


    wp_enqueue_style('normalize', get_template_directory_uri() . '/style/normalize_min.css');
    wp_enqueue_style('dev_0_basic', get_template_directory_uri() . '/style/dev_0_basic_min.css');
    wp_enqueue_style('dev_1', get_template_directory_uri() . '/style/dev_1_min.css');
    wp_enqueue_style('slick', get_template_directory_uri() . '/style/slick_min.css');
    wp_enqueue_style('fancyboxcss', get_template_directory_uri() . '/style/fancybox_min.css');

    wp_enqueue_style('customcss', get_template_directory_uri() . '/style/custom_min.css');
    wp_enqueue_style('responsive', get_template_directory_uri() . '/style/responsive_min.css');

    wp_enqueue_style('jquery-ui-css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.0/themes/base/jquery-ui.min.css');

    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/scripts/jquery-3.7.1.min.js');
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-new', get_template_directory_uri() . '/scripts/jquery-3.7.1.min.js');

    wp_enqueue_script('jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.0/jquery-ui.min.js');

    wp_enqueue_script('jquery-ui-touch-punch', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js');

    wp_enqueue_script('slick', get_template_directory_uri() . '/scripts/slick.min.js');
    wp_enqueue_script('fancybox', get_template_directory_uri() . '/scripts/fancybox.min.js');

    wp_enqueue_script('slider-config', get_template_directory_uri() . '/scripts/develop/slider-config.js');


    // AJAX на товарі
    wp_enqueue_script('product-ajax', get_template_directory_uri() . '/scripts/product-ajax.js');
    // AJAX на пошук
    wp_enqueue_script('form-find-ajax', get_template_directory_uri() . '/scripts/form-find-ajax.js');
    wp_enqueue_script('customjs', get_template_directory_uri() . '/scripts/custom_min.js');
}
