<?php
add_action( 'wp_enqueue_scripts', 'sirenova_scripts' );

function sirenova_scripts() {
    wp_enqueue_style('custom',  get_template_directory_uri() . '/style/custom.css');
    wp_enqueue_style('dev_0_basic',  get_template_directory_uri() . '/style/dev_0_basic.css');
    wp_enqueue_style('dev_1',  get_template_directory_uri() . '/style/dev_1.css');
    wp_enqueue_style('normalize',  get_template_directory_uri() . '/style/normalize.css');
    wp_enqueue_style('responsive',  get_template_directory_uri() . '/style/responsive.css');

    
    // wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr-2.5.3.min.js');
    
}
