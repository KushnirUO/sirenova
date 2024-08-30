<?php
/**
 * Template Name: Sale
 */

defined('ABSPATH') || exit;

$total_discounted_products = get_total_discounted_products_count();

get_header();

do_action('woocommerce_before_main_content');
woocommerce_breadcrumb();
?>
<h1><?php the_title(); ?></h1>


<div class="catalog__main">
    <input type="hidden" name="product_count" value="<?php echo $total_discounted_products; ?>">
    <?php get_template_part('inc/woocommerce/inc/sirenova-sidebar-shop'); ?>
    <div class="catalog__main-products">
        <div class="catalog_products">
            <?php
            // Get products on sale
            $sale_products = wc_get_product_ids_on_sale();

            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 12, // Set the number of products per page
                'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
                'post__in' => $sale_products,
                'orderby' => 'date', // Order by date or other criteria
            );

            $query = new WP_Query($args);

            if ($query->have_posts()):

                do_action('woocommerce_before_shop_loop');

                woocommerce_product_loop_start();

                while ($query->have_posts()):
                    $query->the_post();

                    wc_get_template_part('content', 'product');

                endwhile;

                woocommerce_product_loop_end();

                do_action('woocommerce_after_shop_loop');
            else:
                do_action('woocommerce_no_products_found');
            endif;

            wp_reset_postdata();
            ?>
        </div>
        <div class="pagination products__pagination">
            <?php
            echo paginate_links(array(
                'total' => $query->max_num_pages,
            ));
            ?>
        </div>
    </div>
</div>

<?php
do_action('woocommerce_after_main_content');
get_footer();
?>