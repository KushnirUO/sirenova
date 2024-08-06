<?php

/**
 * Template Name: Front page
 */
get_header();

$front_page_id = get_option('page_on_front');
$hero_title = get_field('hero_title', $front_page_id);
$hero_icon = get_field('hero_icon', $front_page_id);
$hero_subtitle = get_field('hero_subtitle', $front_page_id);
$hero_button_text = get_field('hero_button_text', $front_page_id);
$hero_button_url = get_field('hero_button_url', $front_page_id);
$hero_background = get_field('hero_background', $front_page_id);
$hero_img = get_field('hero_img', $front_page_id);
$category_title = get_field('category_title', $front_page_id);

$product_categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false, // Змінити на true, якщо потрібно сховати пусті
        'parent' => 0,
));
?>

<!-- Hero block -->
<section class="promo-section">
        <img class="promo-bg" src="<?php echo $hero_background['url']; ?>" alt="">
        <div class="promo-section__wrapper">
                <div class="promo-text">
                        <h1><?php echo $hero_title; ?></h1>
                        <div class="gift-promo">
                                <img class="gift-promo-img" src="<?php echo $hero_icon['url']; ?>" alt="">
                                <p><?php echo $hero_subtitle; ?></p>
                        </div>
                        <a href="<?php echo $hero_button_url; ?>" target="" class="btn"><?php echo $hero_button_text; ?></a>
                </div>
                <img class="promo-image" src="<?php echo $hero_img['url']; ?>" alt="">
        </div>

</section>

<!-- Category block -->
<section class="wrapper main__categoryes">
        <h2><?php echo $category_title; ?></h2>
        <?php if (!empty($product_categories) && !is_wp_error($product_categories)) : ?>
                <div class="main__categoryes-blocks">
                        <?php foreach ($product_categories as $category) :
                                $category_link = get_term_link($category);
                                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                                $image_url = wp_get_attachment_url($thumbnail_id);
                        ?>
                                <a class="block" href="<?php echo $category_link; ?>">
                                        <div class="block__bg"><img src="<?php echo $image_url; ?>" alt=""></div>
                                        <div class="block__content">
                                                <h3><?php echo $category->name; ?></h3>
                                        </div>
                                </a>
                        <?php endforeach; ?>
                <?php endif; ?>

                </div>
</section>
<section class="wrapper main__new">
        <h2>Акційні товари</h2>
        <div class="product__slider main__new-slider" id="mainNewSlider">
                <div class="product">
                        <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" tabindex="-1">
                                <div class="product__img-wrap">
                                        <img width="300" height="300" src="https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-300x300.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" decoding="async" srcset="https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-300x300.jpg 300w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-150x150.jpg 150w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-100x100.jpg 100w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-470x470.jpg 470w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-60x60.jpg 60w" sizes="(max-width: 300px) 100vw, 300px">
                                </div>
                        </a>

                        <div class="product__sizes-like">
                                <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" tabindex="-1">
                                        <div class="product__desc">
                                                <p>Квітковий чорний Комплект білизни з сіточки</p>
                                        </div>
                                </a>
                                <label class="icons like" data-product="6926">
                                        <input type="checkbox" name="productLike" tabindex="-1">
                                        <div class="like__icon"></div>
                                </label>
                        </div>
                        <div class="product__sizes-like">
                                <div class="size"><span class="active__size">M</span><span class="active__size">XL</span></div>
                                <div class="product__colors">
                                        <div data-color="#000000"><span style="background: rgb(0, 0, 0);"></span></div>
                                </div>
                        </div>


                        <div class="product__price">
                                <span>599 грн</span>
                        </div>
                        <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" class="btn product__buy" tabindex="-1">купити</a>
                </div>
                <div class="product">
                        <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" tabindex="-1">
                                <div class="product__img-wrap">
                                        <img width="300" height="300" src="https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-300x300.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" decoding="async" srcset="https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-300x300.jpg 300w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-150x150.jpg 150w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-100x100.jpg 100w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-470x470.jpg 470w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-60x60.jpg 60w" sizes="(max-width: 300px) 100vw, 300px">
                                </div>
                        </a>

                        <div class="product__sizes-like">
                                <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" tabindex="-1">
                                        <div class="product__desc">
                                                <p>Квітковий чорний Комплект білизни з сіточки</p>
                                        </div>
                                </a>
                                <label class="icons like" data-product="6926">
                                        <input type="checkbox" name="productLike" tabindex="-1">
                                        <div class="like__icon"></div>
                                </label>
                        </div>
                        <div class="product__sizes-like">
                                <div class="size"><span class="active__size">M</span><span class="active__size">XL</span></div>
                                <div class="product__colors">
                                        <div data-color="#000000"><span style="background: rgb(0, 0, 0);"></span></div>
                                </div>
                        </div>


                        <div class="product__price">
                                <span>599 грн</span>
                        </div>
                        <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" class="btn product__buy" tabindex="-1">купити</a>
                </div>
                <div class="product">
                        <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" tabindex="-1">
                                <div class="product__img-wrap">
                                        <img width="300" height="300" src="https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-300x300.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" decoding="async" srcset="https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-300x300.jpg 300w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-150x150.jpg 150w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-100x100.jpg 100w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-470x470.jpg 470w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-60x60.jpg 60w" sizes="(max-width: 300px) 100vw, 300px">
                                </div>
                        </a>

                        <div class="product__sizes-like">
                                <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" tabindex="-1">
                                        <div class="product__desc">
                                                <p>Квітковий чорний Комплект білизни з сіточки</p>
                                        </div>
                                </a>
                                <label class="icons like" data-product="6926">
                                        <input type="checkbox" name="productLike" tabindex="-1">
                                        <div class="like__icon"></div>
                                </label>
                        </div>
                        <div class="product__sizes-like">
                                <div class="size"><span class="active__size">M</span><span class="active__size">XL</span></div>
                                <div class="product__colors">
                                        <div data-color="#000000"><span style="background: rgb(0, 0, 0);"></span></div>
                                </div>
                        </div>


                        <div class="product__price">
                                <span>599 грн</span>
                        </div>
                        <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" class="btn product__buy" tabindex="-1">купити</a>
                </div>
                <div class="product">
                        <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" tabindex="-1">
                                <div class="product__img-wrap">
                                        <img width="300" height="300" src="https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-300x300.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" decoding="async" srcset="https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-300x300.jpg 300w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-150x150.jpg 150w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-100x100.jpg 100w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-470x470.jpg 470w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-60x60.jpg 60w" sizes="(max-width: 300px) 100vw, 300px">
                                </div>
                        </a>

                        <div class="product__sizes-like">
                                <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" tabindex="-1">
                                        <div class="product__desc">
                                                <p>Квітковий чорний Комплект білизни з сіточки</p>
                                        </div>
                                </a>
                                <label class="icons like" data-product="6926">
                                        <input type="checkbox" name="productLike" tabindex="-1">
                                        <div class="like__icon"></div>
                                </label>
                        </div>
                        <div class="product__sizes-like">
                                <div class="size"><span class="active__size">M</span><span class="active__size">XL</span></div>
                                <div class="product__colors">
                                        <div data-color="#000000"><span style="background: rgb(0, 0, 0);"></span></div>
                                </div>
                        </div>


                        <div class="product__price">
                                <span>349 грн</span><span class="old-price">699 грн</span>
                        </div>
                        <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" class="btn product__buy" tabindex="-1">купити</a>
                </div>
                <div class="product">
                        <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" tabindex="-1">
                                <div class="product__img-wrap">
                                        <img width="300" height="300" src="https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-300x300.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" decoding="async" srcset="https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-300x300.jpg 300w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-150x150.jpg 150w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-100x100.jpg 100w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-470x470.jpg 470w, https://sirenova.com.ua/wp-content/uploads/2024/03/IMG_8399-60x60.jpg 60w" sizes="(max-width: 300px) 100vw, 300px">
                                </div>
                        </a>

                        <div class="product__sizes-like">
                                <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" tabindex="-1">
                                        <div class="product__desc">
                                                <p>Квітковий чорний Комплект білизни з сіточки</p>
                                        </div>
                                </a>
                                <label class="icons like" data-product="6926">
                                        <input type="checkbox" name="productLike" tabindex="-1">
                                        <div class="like__icon"></div>
                                </label>
                        </div>
                        <div class="product__sizes-like">
                                <div class="size"><span class="active__size">M</span><span class="active__size">XL</span></div>
                                <div class="product__colors">
                                        <div data-color="#000000"><span style="background: rgb(0, 0, 0);"></span></div>
                                </div>
                        </div>


                        <div class="product__price">
                                <span>349 грн</span><span class="old-price">699 грн</span>
                        </div>
                        <a href="https://sirenova.com.ua/kvitkovyj-chornyj-komplekt-bilyzny-z-sitochky/" class="btn product__buy" tabindex="-1">купити</a>
                </div>
        </div>
</section>
<!-- Footer -->
<?php
get_footer();
?>