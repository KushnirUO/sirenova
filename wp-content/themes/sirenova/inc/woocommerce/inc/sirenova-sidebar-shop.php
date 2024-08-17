<!-- Start Sidebar Area Wrapper -->
<div class="filter-mobile-catalog btn">
    Фільтр
</div>
<div class="catalog__main-filters">
    <div class="product-config-area">
        <div class="product-config-right">
            <ul class="product-view-mode">
                <li data-viewmode="grid-view" class="active"><i class="fa fa-th"></i></li>
                <li data-viewmode="list-view"><i class="fa fa-list"></i></li>
            </ul>
            <ul class="product-filter-sort">
                <li class="dropdown-show sort-by">
                    <button class="arrow-toggle">Сортувати за</button>
                    <ul class="dropdown-nav">
                        <li><a href="?orderby=date"
                                <?php if (isset($_GET['orderby']) && 'date' == $_GET['orderby']) : ?> class="active"
                                <?php endif; ?>>За новизною</a></li>
                        <li><a href="?orderby=price"
                                <?php if (isset($_GET['orderby']) && 'price' == $_GET['orderby']) : ?> class="active"
                                <?php endif; ?>>Від дешевих до дорогих</a></li>
                        <li><a href="?orderby=price-desc"
                                <?php if (isset($_GET['orderby']) && 'price-desc' == $_GET['orderby']) : ?>
                                class="active" <?php endif; ?>>Від дорогих до дешевих</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <form action="" method="POST" id="ajaxform">

        <?php
        $product_categories = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => true));
        if ($product_categories) : ?>
        <!-- Start Single Sidebar -->
        <div class="single-sidebar-wrap active">
            <h3 class="product-title">Категорії товарів</h3>
            <div class="sidebar-body">
                <ul class="sidebar-list">
                    <?php foreach ($product_categories as $product_category) : ?>
                    <li class="<?php echo $product_category->parent=='0' ? 'parent-filter' : 'child-filter'; ?>">
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
                        <input type="text" id="amount" value="" />
                        <input type="hidden" id="min_price" name="min_price"
                            value="<?php echo isset($_GET['min_price']) ? intval($_GET['min_price']) : $min_price; ?>" />
                        <input type="hidden" id="max_price" name="max_price"
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
                    echo '<input type="checkbox" name="color" id="color-' . esc_attr($term->slug) . '" value="' . esc_attr($term->slug) . '" style="background-color: ' . $color_hex . ';" />';
                    echo $term->name;
                    echo '<label for="color-' . esc_attr($term->slug) . '" style="background-color: ' . esc_attr($color_hex) . '"></label>'; // Мітка без тексту
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

        <input type="hidden" name="orderby" value="date" />
        <input type="hidden" name="action" value="ajaxfilter" />
    </form>
    <div class="wrapper-btn-select">
        <div class="wrapper-btn-select_btn">
            <div class="btn">Застосувати</div>
        </div>
    </div>
</div>

<!-- End Sidebar Area Wrapper -->