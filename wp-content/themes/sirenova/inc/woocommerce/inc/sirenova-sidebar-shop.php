<!-- Start Sidebar Area Wrapper -->
<div class="filter-mobile-catalog btn">
    Фільтр
</div>
<div class="catalog__main-filters">


    <form action="" method="POST" id="ajaxform">
        <div class="product-config-area">
            <div class="filters">
                <h4>Сортувати:</h4>
                <div class="filters__dropdown">
                    <input type="hidden" name="order" value="up">
                    <input type="hidden" name="orderby" value="new">
                    <a href="javascript:void(0);" id="dropdownFilterResult" data-dropdown-filter="product-date"
                        class="">По новизні</a>
                    <ul id="dropdownFilterContent" style="display: none;">
                        <li data-dropdown-filter="product-date">По новизні</li>
                        <li data-dropdown-filter="popular">За популярністю</li>
                        <li data-dropdown-filter="price-up">Ціна за зростом</li>
                        <li data-dropdown-filter="price-down">Ціна за зниженням</li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
        $product_categories = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => true));
        if ($product_categories): ?>
            <!-- Start Single Sidebar -->
            <div class="single-sidebar-wrap active">
                <h3 class="product-title" style="<?php echo is_product_category() ? 'display: none;' : ''; ?>">Категорії
                    товарів</h3>
                <div class="sidebar-body" style="<?php echo is_product_category() ? 'display: none;' : ''; ?>">
                    <ul class="sidebar-list">
                        <?php foreach ($product_categories as $product_category): ?>
                            <li class="<?php echo $product_category->parent == '0' ? 'parent-filter' : 'child-filter'; ?>">
                                <input type="checkbox" name="product_cats[]"
                                    id="product-cat-<?php echo absint($product_category->term_id) ?>"
                                    value="<?php echo absint($product_category->term_id) ?>" />
                                <label
                                    for="product-cat-<?php echo absint($product_category->term_id) ?>"><?php echo esc_html($product_category->name) ?>
                                    <span>(<?php echo absint($product_category->count) ?>)</span></label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <!-- End Single Sidebar -->
        <?php endif; ?>

        <!-- Start Single Sidebar -->
        <div class="single-sidebar-wrap active">
            <h3 class="product-title">Ціни</h3>
            <div class="sidebar-body">
                <?php
                global $wpdb;
                $min_price = $wpdb->get_var("SELECT MIN(meta_value + 0) FROM {$wpdb->prefix}postmeta WHERE meta_key = '_price' AND post_id IN (SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'product' AND post_status = 'publish')");
                $max_price = $wpdb->get_var("SELECT MAX(meta_value + 0) FROM {$wpdb->prefix}postmeta WHERE meta_key = '_price' AND post_id IN (SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'product' AND post_status = 'publish')");
                ?>

                <div class="price-range-wrap">
                    <div class="price-range" data-min="<?php echo $min_price; ?>" data-max="<?php echo $max_price; ?>">
                    </div>
                    <div class="range-slider">
                        <input type="hidden" id="amount" value="" />
                        <div class="range-slider_label">
                            <p>Мін</p>
                            <p>Мах</p>
                        </div>
                        <input id="min_price" name="min_price"
                            value="<?php echo isset($_GET['min_price']) ? intval($_GET['min_price']) : $min_price; ?>" />
                        <input id="max_price" name="max_price"
                            value="<?php echo isset($_GET['max_price']) ? intval($_GET['max_price']) : $max_price; ?>" />
                        <?php echo wc_query_string_form_fields(null, array('min_price', 'max_price', 'paged'), '', true); ?>
                    </div>
                </div>

            </div>
        </div>
        <?php
        // Отримати атрибути товарів
        $product_attributes = wc_get_attribute_taxonomies();
        foreach ($product_attributes as $attribute) {
            $attribute_name = wc_attribute_taxonomy_name($attribute->attribute_name);
            $terms = get_terms(array('taxonomy' => $attribute_name, 'hide_empty' => false));

            // Перевірити, чи поточний атрибут є атрибутом кольору
            if ($attribute_name === 'pa_color') {
                echo '<div class="single-sidebar-wrap active">';
                echo '<h3 class="product-title">' . esc_html($attribute->attribute_label) . '</h3>';
                echo '<div class="sidebar-body">';
                echo '<ul class="size-list">'; // Змінено клас для кольорів
                // Отримати значення атрибуту 'pa_color' для поточного товару
                foreach ($terms as $term) {
                    $color_hex = get_term_meta($term->term_id, 'attribute_color', true);
                    echo '<li>';
                    echo '<label for="color-' . esc_attr($term->slug) . '" style="background-color: ' . esc_attr($color_hex) . '"></label>'; // Мітка без тексту
        
                    echo '<input type="checkbox" name="color" id="color-' . esc_attr($term->slug) . '" value="' . esc_attr($term->slug) . '" style="background-color: ' . $color_hex . ';" />';
                    echo $term->name;
                    echo '</li>';
                }
                echo '</ul>';
                echo '</div>';
                echo '</div>';
            } else {
                // Вивести інші атрибути за звичайною логікою
                echo '<div class="single-sidebar-wrap active">';
                echo '<h3 class="product-title">' . esc_html($attribute->attribute_label) . '</h3>';
                echo '<div class="sidebar-body">';
                echo '<ul class="size-list">'; // Змінено клас для розмірів
                foreach ($terms as $term) {
                    echo '<li>';
                    echo '<input type="checkbox" name="size" id="size-' . esc_attr($term->slug) . '" value="' . esc_attr($term->slug) . '" />';
                    echo '<label for="size-' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</label>';
                    echo '</li>';
                }
                echo '</ul>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>
        <input type="hidden" name="action" value="ajaxfilter" />
        <input type="hidden" name="page" value="1" />
        <?php if (is_product_category()):
            $category = get_queried_object();
            $category_id = $category->term_id;
            ?>
            <input type="hidden" name="product_cats[]:" value="<?php echo $category_id; ?>">
        <?php endif; ?>
        <?php if (is_page('sale')):
            ?>
            <input type="hidden" name="sale-page" value="<?php echo 'sale'; ?>">
        <?php endif; ?>

    </form>
    <div class="wrapper-btn-select desctop">
        <div class="wrapper-btn-select_btn">
            <div class="wrapper-btn-select_btn-wrap">
                <div class="btn">Застосувати</div>
                <div class="btn-link">Скинути фільтри</div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper-btn-select mobile">
    <div class="wrapper-btn-select_btn btn-fixed">
        <div class="wrapper-btn-select_btn-wrap">
            <div class="btn">Застосувати</div>
            <div class="btn-link">Скинути фільтри</div>
        </div>
    </div>
</div>

<!-- End Sidebar Area Wrapper -->