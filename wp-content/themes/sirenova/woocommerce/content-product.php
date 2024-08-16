<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<div <?php wc_product_class('', $product); ?>>
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_open - 10
     */
    do_action('woocommerce_before_shop_loop_item');
    ?>

    <div class="product__img-wrap">
        <a href='<?php the_permalink(); ?>'>
            <?php
            if (!$product) {
                $product = wc_get_product(get_the_ID());
            }

            // Get the product publish date
            $publish_date = $product->get_date_created();
            $now = new DateTime();
            $publish_date_obj = new DateTime($publish_date);
            $interval = $now->diff($publish_date_obj);

            $days_since_publish = $interval->days;

            // Check if the product is within the last 30 days
            $is_new = $days_since_publish <= 30;

            ?>
            <!-- Your existing product display code -->

            <?php if ($is_new) : ?>
            <span class="new-badge"><?php esc_html_e('New', 'woocommerce'); ?></span>
            <?php endif;
            /**
             * Hook: woocommerce_before_shop_loop_item_title.
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action('woocommerce_before_shop_loop_item_title');

            // New product flash
            ?>
        </a>
    </div>

    <div class="product__sizes-like">
        <a href="<?php the_permalink(); ?>">
            <div class="product__desc">
                <p><?php the_title(); ?></p>
            </div>
        </a>
        <label class="icons like" data-product="6926">
            <input type="checkbox" name="productLike" tabindex="-1">
            <div class="like__icon"></div>
        </label>
    </div>
    <?php

    // Отримання атрибутів продукту
    $attributes = $product->get_attributes();

    if (isset($attributes['pa_size']) && $attributes['pa_size']->is_taxonomy()) :
        $size_terms = get_terms(
            array(
                'taxonomy' => $attributes['pa_size']->get_taxonomy(),
                'hide_empty' => false,
            )
        );

        // Виведення тільки термінів, що застосовуються до поточного продукту
        $product_size_terms = wp_get_post_terms($product->get_id(), $attributes['pa_size']->get_taxonomy());

        if (!empty($product_size_terms)) :
    ?>
    <hr>
    <div class="product__sizes-like">
        <h4>Розмір:</h4>
        <div class="size">
            <?php foreach ($product_size_terms as $term) : ?>
            <span class="size"><?php echo esc_html($term->name); ?></span>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
            // Виведення тільки термінів, що застосовуються до поточного продукту
            $product_color_terms = wp_get_post_terms($product->get_id(), $attributes['pa_color']->get_taxonomy());

            if (!empty($product_color_terms)) :
            ?>
    <div class="product__sizes-like">
        <h4>Колір:</h4>
        <div class="product__colors">
            <?php foreach ($product_color_terms as $term) : ?>
            <?php
                            // Мета-дані кольору 
                            $color = get_term_meta($term->term_id, 'attribute_color', true);
                            ?>
            <div data-color="<?php echo esc_attr($color); ?>">
                <span style="background: <?php echo esc_attr($color); ?>;"></span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php
            endif;

                ?>
    </div>
    <hr>
    <?php
        endif;
    endif;
        ?>

    <?php
        /**
         * Hook: woocommerce_shop_loop_item_title.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action('woocommerce_shop_loop_item_title');


        /**
         * Hook: woocommerce_after_shop_loop_item_title.
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action('woocommerce_after_shop_loop_item_title');

        /**
         * Hook: woocommerce_after_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_close - 5
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        do_action('woocommerce_after_shop_loop_item');
        ?>
</div>