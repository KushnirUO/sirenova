        <?php
        get_header();

        $product_categories = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false, // Измените на true, если нужно скрыть пустые категории
                'parent' => 0,
        ));
        ?>

        <section class="promo-section">
                <img class="promo-bg" src="https://sirenova.com.ua/wp-content/themes/v2.3/img/bg-first-sect.png" alt="">
                <div class="promo-section__wrapper">
                        <div class="promo-text">
                                <h1>Білизна, яка варта твоєї уваги</h1>
                                <div class="gift-promo">
                                        <img class="gift-promo-img" src="https://sirenova.com.ua/wp-content/themes/v2.3/img/gift-promo.png" alt="">
                                        <p>Замовляй комплект - отримуй трусики у подарунок</p>
                                </div>
                                <a href="https://sirenova.com.ua/shop/" target="" class="btn">Перейти до магазину</a>
                        </div>
                        <img class="promo-image" src="https://sirenova.com.ua/wp-content/themes/v2.3/img/img-first-sect.png" alt="">
                </div>

        </section>

        <section class="wrapper main__categoryes">
                <h2>Категорії</h2>
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

        <?php
        get_footer();
        ?>