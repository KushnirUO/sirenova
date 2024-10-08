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
<div class="single__product-main 
<?php
$classes = [];
if ($product->is_on_sale()) {
    $classes[] = 'sale-single-product';
}
if ($product->is_featured()) {
    $classes[] = 'hit-single-product';
}
echo implode(' ', $classes);
?>
">

    <!-- Додати до блока вище клас sale-single-product якщо він є на сейлі  -->
    <input type="hidden" name="product_id" value="<?php echo $product->get_id(); ?>">
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
    $gallery_image_ids = $product->get_gallery_image_ids();

    $pr_cocntent = get_the_content();
    $size_table = get_field('sizes_table', $product->get_id());
    $harakterystyky = get_field('harakterystyky', $product->get_id());
    $dostavka_tovaru = get_field('dostavka_tovaru', 'options');
    $obmin_ta_povernennya = get_field('obmin_ta_povernennya', 'options');

    // Перевірка товарів на складі
    $has_stock = false;

    // Якщо продукт варіативний
    if ($product->is_type('variable')) {
        $variation_ids = $product->get_children(); // Отримуємо ID всіх варіацій

        foreach ($variation_ids as $variation_id) {
            $variation = wc_get_product($variation_id);

            if ($variation->get_manage_stock()) {
                // Перевіряємо, чи є на складі хоча б одна варіація з кількістю більше 0
                if ($variation->get_stock_quantity() > 0) {
                    $has_stock = true;
                    break;
                }
            } elseif ($variation->is_in_stock()) {
                // Якщо керування запасами вимкнено, перевіряємо статус на складі
                $has_stock = true;
                break;
            }
        }
    } else {
        // Для простого продукту
        $has_stock = !$product->get_manage_stock() || $product->is_in_stock();
    }
    ?>

    <div class="">
        <div class="slider-wrapper">
            <div class="slider-cart-wrapper">
                <button type="button" class="nav-up"></button>
                <div class="slider-product-cart-nav">
                    <?php foreach ($gallery_image_ids as $image_id): ?>
                        <?php
                        $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                        ?>
                        <div class="slider-product-cart-nav-wrapp"><img src="<?php echo esc_url($image_url); ?>" alt="">
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="nav-down"></button>
            </div>
            <div class="slider-product-cart">
                <?php foreach ($gallery_image_ids as $image_id): ?>
                    <?php
                    // Отримуємо URL зображення для відображення
                    $image_url_full = wp_get_attachment_image_url($image_id, 'woocommerce_single'); // Отримуємо URL зображення

                    ?>
                    <a href="<?php echo wp_get_attachment_image_url($image_id, 'medium_large'); ?>" data-fancybox="productGallery"
                        class="slider-product-cart-single">
                        <img src="<?php echo esc_url($image_url_full); ?>" alt="">
                    </a>
                <?php endforeach; ?>
            </div>
            <?php if ($is_new): ?>
                <span class="new-badge"><?php esc_html_e('New', 'woocommerce'); ?></span>
            <?php endif;
            if ($product->is_on_sale()) {
                echo '<div class="sale-flash">' . wc_get_template_html('woocommerce/loop/sale-flash.php') . '</div>';
            }
            ?>
        </div>


    </div>
    <div class="info">
        <h2><?php the_title(); ?></h2>
        <?php
        if ($has_stock):
            wc_get_template_part('loop/price-single'); ?>
            <div class="cart__counter">
                <span>К-сть:</span>
                <input type="number" name="quantity" value="1">
                <span class="increase"></span>
                <span class="decrease"></span>
            </div>
            <div class="info__colors">
                <?php
                if ($product->is_type('variable')) {
                    $available_variations = $product->get_available_variations();
                    $attributes = $product->get_variation_attributes();

                    // Масив для збереження залишків
                    $stock_data = [];

                    if (isset($attributes['pa_color'])) {
                        $colors = $attributes['pa_color'];

                        if (!empty($colors)) {
                            echo '<span>КОЛІР:</span>';
                            echo '<div class="pallete">';
                            foreach ($colors as $color_slug) {
                                $term = get_term_by('slug', $color_slug, 'pa_color');
                                $color_hex = get_term_meta($term->term_id, 'attribute_color', true);

                                foreach ($available_variations as $variation) {
                                    // Перевірка наявності обох атрибутів
                                    if (isset($variation['attributes']['attribute_pa_color']) && $variation['attributes']['attribute_pa_color'] == $color_slug) {
                                        $variation_obj = new WC_Product_Variation($variation['variation_id']);
                                        $stock_quantity = $variation_obj->get_stock_quantity();
                                        $variation_id = $variation['variation_id'];

                                        // Перевірка чи варіація зберігається вже в масиві $stock_data
                                        if (!isset($stock_data[$variation_id])) {
                                            $stock_data[$variation_id] = [
                                                'color' => $color_slug,
                                                'size' => isset($variation['attributes']['attribute_pa_size']) ? $variation['attributes']['attribute_pa_size'] : '',
                                                'stock_quantity' => $stock_quantity
                                            ];
                                        }
                                    }
                                }

                                echo '<div class="pallete-one">';
                                echo '<input type="radio" name="color" id="color-' . esc_attr($term->slug) . '" value="' . esc_attr($term->slug) . '" style="background-color: ' . esc_attr($color_hex) . ';" />';
                                echo '<label for="color-' . esc_attr($term->slug) . '" style="background-color: ' . esc_attr($color_hex) . '"></label>';
                                echo $term->name;
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    }
                }
                ?>
            </div>

            <div class="size__dropdown">
                <?php
                if ($product->is_type('variable')) {
                    $attributes = $product->get_variation_attributes();

                    if (isset($attributes['pa_size'])) {
                        $sizes = $attributes['pa_size'];

                        if (!empty($sizes)) {
                            echo '<span>РОЗМІР:</span>';
                            echo '<div class="size__dropdown-content">';
                            foreach ($sizes as $size_slug) {
                                $term = get_term_by('slug', $size_slug, 'pa_size');
                                if ($term) {
                                    foreach ($available_variations as $variation) {
                                        // Перевірка наявності обох атрибутів
                                        if (isset($variation['attributes']['attribute_pa_size']) && $variation['attributes']['attribute_pa_size'] == $size_slug) {
                                            $variation_obj = new WC_Product_Variation($variation['variation_id']);
                                            $stock_quantity = $variation_obj->get_stock_quantity();
                                            $variation_id = $variation['variation_id'];

                                            // Перевірка чи варіація зберігається вже в масиві $stock_data
                                            if (!isset($stock_data[$variation_id])) {
                                                $stock_data[$variation_id] = [
                                                    'color' => isset($variation['attributes']['attribute_pa_color']) ? $variation['attributes']['attribute_pa_color'] : '',
                                                    'size' => $size_slug,
                                                    'stock_quantity' => $stock_quantity
                                                ];
                                            }
                                        }
                                    }

                                    echo "<div class='sizes-single'>";
                                    echo '<input type="radio" name="size" id="size-' . esc_attr($term->slug) . '" value="' . esc_attr($term->slug) . '" />';
                                    echo '<label for="size-' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</label>';
                                    echo '</div>';
                                }
                            }
                            echo '</div>';
                        }
                    }
                }
                ?>
            </div>

            <script>
                var stockData = <?php echo json_encode($stock_data); ?>;
                console.log(stockData);
            </script>


            <div class="info__btns">
                <div class="info__btns-like">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.9369 1.59554C11.2645 0.872795 10.3222 0.461561 9.33508 0.460037C8.34712 0.46118 7.40392 0.872196 6.73047 1.59508L6.50095 1.83761L6.27143 1.59508C4.93513 0.156852 2.68589 0.0742567 1.24769 1.41056C1.18396 1.4698 1.12241 1.53132 1.06317 1.59508C-0.354391 3.1241 -0.354391 5.48713 1.06317 7.01614L6.16366 12.3949C6.34012 12.5812 6.63418 12.5892 6.82047 12.4127C6.82657 12.407 6.8325 12.401 6.83827 12.3949L11.9369 7.01614C13.3544 5.48729 13.3544 3.1244 11.9369 1.59554ZM11.2646 6.37637H11.2641L6.50095 11.4002L1.73733 6.37637C0.654391 5.20806 0.654391 3.4027 1.73733 2.23439C2.72077 1.16849 4.38212 1.10166 5.44801 2.0851C5.49977 2.13285 5.54956 2.18264 5.59731 2.23439L6.16366 2.83188C6.3503 3.01733 6.65163 3.01733 6.83827 2.83188L7.40463 2.23485C8.38806 1.16896 10.0494 1.10212 11.1153 2.08556C11.1671 2.13331 11.2169 2.1831 11.2646 2.23485C12.357 3.40501 12.365 5.21367 11.2646 6.37637Z"
                            fill="black"></path>
                    </svg>
                </div>
                <button class="btn info__btns-cart">Додати в кошик</button>
            </div>
        <?php else: ?>
            <p>Немає в наявності</p>
        <?php endif; ?>
    </div>
</div>
<div class="single__product-desc">
    <div class="sir-tabs-container">
        <ul class="sir-tabs-menu">
            <?php if ($pr_cocntent): ?>
                <li class="sir-tab sir-active" data-tab="tab-1">Опис</li>
            <?php endif;
            if ($harakterystyky): ?>
                <li class="sir-tab" data-tab="tab-2">Характеристики</li>
            <?php endif;
            if ($size_table): ?>
                <li class="sir-tab" data-tab="tab-3">Розмірна сітка</li>
            <?php endif;
            if ($dostavka_tovaru): ?>
                <li class="sir-tab" data-tab="tab-4">Доставка</li>
            <?php endif;
            if ($obmin_ta_povernennya): ?>
                <li class="sir-tab" data-tab="tab-5">Обмін та повернення</li>
            <?php endif; ?>
        </ul>

        <?php if ($pr_cocntent): ?>
            <div class="sir-tab-content sir-active" id="tab-1">
                <h3 class="sir-accordion-title">Опис</h3>
                <div class="sir-accordion-content">
                    <p><?php the_content(); ?></p>
                </div>
            </div>
        <?php endif;
        if ($harakterystyky): ?>
            <div class="sir-tab-content" id="tab-2">
                <h3 class="sir-accordion-title">Характеристики</h3>
                <div class="sir-accordion-content">
                    <?php foreach ($harakterystyky as $harakterystyka): ?>
                        <div class="sir-accordion-char">
                            <p><?php echo $harakterystyka['tajtl']; ?></p>
                            <p><?php echo $harakterystyka['opys']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif;
        if ($size_table): ?>
            <div class="sir-tab-content" id="tab-3">
                <h3 class="sir-accordion-title">Розмірна сітка</h3>
                <div class="sir-accordion-content">
                    <?php echo $size_table; ?>
                </div>
            </div>
        <?php endif;
        if ($dostavka_tovaru): ?>
            <div class="sir-tab-content" id="tab-4">
                <h3 class="sir-accordion-title">Доставка</h3>
                <div class="sir-accordion-content">
                    <p><?php echo $dostavka_tovaru; ?></p>
                </div>
            </div>
        <?php endif;
        if ($obmin_ta_povernennya): ?>
            <div class="sir-tab-content" id="tab-5">
                <h3 class="sir-accordion-title">Обмін та повернення</h3>
                <div class="sir-accordion-content">
                    <p>
                        <?php echo $obmin_ta_povernennya; ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

</div>
<section class="wrapper single__product-more">
    <h2>Доповни свій образ</h2>
    <div class="product__slider main__new-slider" id="mainTopSlider">
        <?php echo get_template_part('woocommerce/templates/sirenova-related-proudcts'); ?>
    </div>
</section>