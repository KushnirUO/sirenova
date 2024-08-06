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

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div <?php wc_product_class( '', $product ); ?>>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
?>

<div class="product__img-wrap">
<a href='<?php the_permalink(); ?>'>
<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );
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

if (isset($attributes['pa_size']) && $attributes['pa_size']->is_taxonomy()):
    $size_terms = get_terms(array(
        'taxonomy' => $attributes['pa_size']->get_taxonomy(),
        'hide_empty' => false,
    ));

    // Виведення тільки термінів, що застосовуються до поточного продукту
    $product_size_terms = wp_get_post_terms($product->get_id(), $attributes['pa_size']->get_taxonomy());

    if (!empty($product_size_terms)):
?>
    <div class="product__sizes-like">
        <div class="size">
            <?php foreach ($product_size_terms as $term): ?>
                <span class="size"><?php echo esc_html($term->name); ?></span>
            <?php endforeach; ?>
        </div>
	<?php
		// Виведення тільки термінів, що застосовуються до поточного продукту
    $product_color_terms = wp_get_post_terms($product->get_id(), $attributes['pa_color']->get_taxonomy());

    if (!empty($product_color_terms)):
?>
    <div class="product__colors">
        <?php foreach ($product_color_terms as $term): ?>
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
	do_action( 'woocommerce_shop_loop_item_title' );



if ( ! $product ) {
    $product = wc_get_product( get_the_ID() );
}

if ( $product && $product->is_type( 'variable' ) ) {
    $available_variations = $product->get_available_variations();
    $regular_prices = array();
    $sale_prices = array();

    foreach ( $available_variations as $variation ) {
        $variation_obj = new WC_Product_Variation( $variation['variation_id'] );
        $regular_prices[] = $variation_obj->get_regular_price();
        $sale_prices[] = $variation_obj->get_sale_price();
    }

    if ( ! empty( $regular_prices ) ) {
        $min_regular_price = min( $regular_prices );
    } else {
        $min_regular_price = null;
    }

    if ( ! empty( $sale_prices ) ) {
        // Фільтруємо масив, щоб видалити порожні значення (варіації без знижки)
        $sale_prices = array_filter( $sale_prices );
        if ( ! empty( $sale_prices ) ) {
            $min_sale_price = min( $sale_prices );
        } else {
            $min_sale_price = null;
        }
    } else {
        $min_sale_price = null;
    }
}

if ( ! isset( $min_sale_price ) || ! $min_sale_price ) {
    $min_sale_price = $min_regular_price;
}

if ( ! isset( $min_regular_price ) ) {
    $min_regular_price = '';
}
?>

<div class="product__price">
    <span><?php echo custom_price_format( wc_price( $min_sale_price ), $product ); ?></span>
    <?php if ( $min_regular_price && $min_regular_price != $min_sale_price ) : ?>
        <span class="old-price"><?php echo custom_price_format( wc_price( $min_regular_price ), $product ); ?></span>
    <?php endif; ?>
</div>

<a href="<?php the_permalink(); ?>" class="btn product__buy" >Переглянути</a>
<?php
	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );




	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</div>
