<?

/**
 * Template Name: cart
 */
get_header()
    ?>
<section class="wrapper cart">
    <div class="bredacrumbs">
        <?php woocommerce_breadcrumb(); ?>
    </div>
    <h1>Кошик</h1>
    <?php
    $shop_url = get_permalink(wc_get_page_id('shop'));
    // Отримуємо всі товари в корзині
    $cart_items = WC()->cart->get_cart();

    if (!empty($cart_items)) { ?>
    <div class="cart__products">

        <?php
            foreach ($cart_items as $cart_item_key => $cart_item) {
                // Отримуємо об'єкт продукту
                $product = $cart_item['data'];
                // Отримуємо назву продукту
                $product_name = $product->get_title();
                // Отримуємо URL до сторінки продукту
                $product_permalink = $product->get_permalink();
                // Отримуємо зображення продукту
                $product_image = $product->get_image();
                // Отримуємо кількість продукту в корзині
                $quantity = $cart_item['quantity'];
                // Отримуємо ціну продукту
                $product_price = custom_price_format(WC()->cart->get_product_price($product), $product);
                // Отримуємо суму за кількість цього продукту
                $product_subtotal = custom_price_format(WC()->cart->get_product_subtotal($product, $quantity), $product);
                // Отримуємо сумму всіх товарів
                $cart_total = custom_price_format(WC()->cart->get_cart_total(), $product);
                // Отримуємо інформацію про варіації, якщо це варіаційний продукт
                $attribute_size = '';
                $attribute_color = '';

                if ($product->is_type('variation')) {
                    $variation_data = wc_get_product_variation_attributes($product->get_id());

                    // Отримуємо читабельне значення для атрибуту "Розмір"
                    if (isset($variation_data['attribute_pa_size'])) {
                        $size_term = get_term_by('slug', $variation_data['attribute_pa_size'], 'pa_size');
                        if ($size_term) {
                            $attribute_size = $size_term->name;
                        }
                    }

                    // Отримуємо читабельне значення для атрибуту "Колір"
                    if (isset($variation_data['attribute_pa_color'])) {
                        $color_term = get_term_by('slug', $variation_data['attribute_pa_color'], 'pa_color');
                        if ($color_term) {
                            $attribute_color = $color_term->name;
                        }
                    }
                }
                ?>
        <div class="cart__products-product-wrap" data-cart_item_key="<?php echo $cart_item_key; ?>">
            <div class="cart__products-product">
                <input type="hidden" name="card_item_key" value="da81668b633a6428d3cb74e4cd5aa088">
                <a href='<?php echo $product_permalink; ?>' class="cart__img-wrap">
                    <?php echo $product_image; ?>
                </a>
                <div class="product-wrapp-all">
                    <div class="cart_name_config">
                        <a href="<?php echo $product_permalink; ?>" class="cart__name"><?php echo $product_name; ?></a>
                        <table class="cart__config">
                            <tbody>
                                <?php if ($attribute_size) { ?>
                                <tr>
                                    <th>Розмір:</th>
                                    <td><?php echo $attribute_size; ?></td>
                                </tr>
                                <?php }
                                        ;
                                        if ($attribute_color) { ?>
                                <tr>
                                    <th>Колір:</th>
                                    <td><?php echo $attribute_color; ?></td>
                                </tr>
                                <?php }
                                        ; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="cart__product-wrapp">
                        <span class="cart__price">
                            <tr>
                                <th>Ціна за шт:</th>
                                <?php echo $product_price; ?>
                            </tr>
                        </span>
                        <div class="cart__counter">
                            <span>К-сть:</span>
                            <input type="number" name="quantity" value="<?php echo $quantity; ?>">
                            <span class="increase"></span>
                            <span class="decrease"></span>
                        </div>
                        <span class="cart__price-all">
                            <tr>
                                <th>Сума:</th>
                                <span class="cart__price-subtotal">
                                    <td><?php echo $product_subtotal; ?></td>
                                </span>
                            </tr>
                        </span>
                    </div>
                </div>
                <button class="cart__delete" data-cart_item_key="<?php echo esc_attr($cart_item_key); ?>">
                    <svg viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13.6416 17.5135H4.35845C4.17206 17.5125 3.99274 17.442 3.85555 17.3158C3.71836 17.1897 3.63314 17.0169 3.61656 16.8312L2.55602 4.16773C2.55322 4.13413 2.55743 4.10032 2.5684 4.06843C2.57936 4.03655 2.59684 4.0073 2.61971 3.98253C2.64258 3.95775 2.67035 3.93801 2.70126 3.92454C2.73217 3.91108 2.76554 3.90418 2.79926 3.9043H15.2027C15.2364 3.90418 15.2698 3.91108 15.3007 3.92454C15.3316 3.93801 15.3594 3.95775 15.3823 3.98253C15.4051 4.0073 15.4226 4.03655 15.4336 4.06843C15.4445 4.10032 15.4488 4.13413 15.446 4.16773L14.3854 16.8312C14.3688 17.0172 14.2833 17.1903 14.1457 17.3165C14.0081 17.4427 13.8283 17.513 13.6416 17.5135ZM3.06293 4.39078L4.10158 16.7906C4.10728 16.8549 4.13676 16.9148 4.18426 16.9585C4.23177 17.0022 4.29388 17.0267 4.35845 17.027H13.6416C13.7062 17.0267 13.7684 17.0023 13.8159 16.9586C13.8635 16.9149 13.893 16.855 13.8987 16.7906L14.9373 4.39078H3.06293Z"
                            fill="black"></path>
                        <path
                            d="M16.0958 4.39295H1.90406C1.76432 4.39276 1.63036 4.33716 1.53155 4.23835C1.43274 4.13954 1.37715 4.00558 1.37695 3.86585V2.63966C1.37708 2.4999 1.43266 2.3659 1.53148 2.26708C1.63031 2.16825 1.7643 2.11268 1.90406 2.11255H16.0958C16.2356 2.11268 16.3696 2.16825 16.4684 2.26708C16.5672 2.3659 16.6228 2.4999 16.623 2.63966V3.86609C16.6227 4.00579 16.5671 4.13968 16.4683 4.23844C16.3695 4.3372 16.2355 4.39276 16.0958 4.39295ZM1.90406 2.59904C1.89329 2.59904 1.88296 2.60332 1.87534 2.61093C1.86772 2.61855 1.86344 2.62888 1.86344 2.63966V3.86609C1.86344 3.87686 1.86772 3.8872 1.87534 3.89481C1.88296 3.90243 1.89329 3.90671 1.90406 3.90671H16.0958C16.1066 3.90671 16.117 3.90243 16.1246 3.89481C16.1322 3.8872 16.1365 3.87686 16.1365 3.86609V2.63966C16.1365 2.62888 16.1322 2.61855 16.1246 2.61093C16.117 2.60332 16.1066 2.59904 16.0958 2.59904H1.90406Z"
                            fill="black"></path>
                        <path
                            d="M11.144 2.59901H6.85701C6.7925 2.59901 6.73063 2.57339 6.68501 2.52777C6.6394 2.48215 6.61377 2.42028 6.61377 2.35577V1.12326C6.61396 0.954426 6.68112 0.792564 6.8005 0.673181C6.91989 0.553798 7.08175 0.486643 7.25058 0.48645H10.7504C10.9192 0.486643 11.0811 0.553798 11.2005 0.673181C11.3198 0.792564 11.387 0.954426 11.3872 1.12326V2.35577C11.3872 2.42028 11.3616 2.48215 11.316 2.52777C11.2703 2.57339 11.2085 2.59901 11.144 2.59901ZM7.10026 2.11253H10.9007V1.12326C10.9007 1.08339 10.8849 1.04516 10.8567 1.01696C10.8285 0.988773 10.7903 0.972936 10.7504 0.972936H7.25058C7.21071 0.972936 7.17248 0.988773 7.14429 1.01696C7.1161 1.04516 7.10026 1.08339 7.10026 1.12326V2.11253Z"
                            fill="black"></path>
                        <path
                            d="M11.5447 13.6289C11.5376 13.6289 11.5304 13.6289 11.5233 13.6289C11.459 13.6233 11.3997 13.5924 11.3582 13.543C11.3167 13.4936 11.2966 13.4298 11.3022 13.3655L11.859 7.00931C11.8612 6.97707 11.8699 6.9456 11.8844 6.91675C11.8989 6.88789 11.9191 6.86222 11.9437 6.84123C11.9682 6.82025 11.9967 6.80437 12.0275 6.79452C12.0583 6.78468 12.0907 6.78106 12.1229 6.78389C12.1551 6.78672 12.1864 6.79593 12.215 6.81099C12.2436 6.82605 12.2689 6.84666 12.2894 6.87161C12.31 6.89656 12.3253 6.92535 12.3346 6.9563C12.3439 6.98725 12.3469 7.01974 12.3435 7.05187L11.787 13.4071C11.7816 13.4677 11.7538 13.524 11.7089 13.5651C11.6641 13.6062 11.6055 13.6289 11.5447 13.6289Z"
                            fill="black"></path>
                        <path
                            d="M9.00008 13.6289C8.93557 13.6289 8.8737 13.6033 8.82808 13.5577C8.78246 13.5121 8.75684 13.4502 8.75684 13.3857V7.02974C8.75684 6.96523 8.78246 6.90336 8.82808 6.85774C8.8737 6.81213 8.93557 6.7865 9.00008 6.7865C9.0646 6.7865 9.12647 6.81213 9.17209 6.85774C9.21771 6.90336 9.24333 6.96523 9.24333 7.02974V13.3857C9.24333 13.4502 9.21771 13.5121 9.17209 13.5577C9.12647 13.6033 9.0646 13.6289 9.00008 13.6289Z"
                            fill="black"></path>
                        <path
                            d="M6.45496 13.629C6.39395 13.6293 6.33509 13.6066 6.29003 13.5654C6.24498 13.5243 6.21702 13.4677 6.21172 13.407L5.65614 7.05102C5.65273 7.01888 5.65576 6.98639 5.66505 6.95544C5.67433 6.92449 5.68969 6.8957 5.71023 6.87075C5.73077 6.84581 5.75607 6.8252 5.78466 6.81014C5.81325 6.79508 5.84455 6.78587 5.87674 6.78304C5.90893 6.78021 5.94136 6.78382 5.97214 6.79367C6.00292 6.80351 6.03143 6.81939 6.056 6.84038C6.08057 6.86136 6.10072 6.88704 6.11526 6.91589C6.1298 6.94475 6.13844 6.97622 6.14069 7.00845L6.69748 13.3646C6.70308 13.4289 6.68293 13.4927 6.64147 13.5421C6.6 13.5915 6.54062 13.6224 6.47637 13.6281C6.47004 13.6288 6.46202 13.629 6.45496 13.629Z"
                            fill="black"></path>
                    </svg>
                </button>
            </div>
        </div>
        <?php }
            ; ?>
    </div>
    <div class="cart__total">
        <span>Сума замовлення:</span>
        <span class="cart__total-price">
            <span class="woocommerce-Price-amount amount"><?php echo $cart_total; ?>
            </span>
        </span>
    </div>
    <div class="cart__btns">
        <a href="<?php echo $shop_url ?>">Повернутись до магазину</a>
        <a href="<?php echo wc_get_checkout_url(); ?>" class="btn">Замовити</a>
    </div>
    <h4>Безкоштовна доставка від 1000 грн</h4>
    <?php
    } else {
        echo '<div class="cart-empty">';
        echo '<p>У Вашій корзині ще немає товарів</p>';
        echo "<a href='$shop_url'>Повернутись до магазину</a>";
        echo '</div>';
    }
    ;
    ?>
</section>
<? get_footer();