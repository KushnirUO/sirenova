<?

/**
 * Template Name: Шаблон "Список бажань"
 */
get_header();
?>
<section class="wrapper favorites">
    <?php woocommerce_breadcrumb(); ?>
    <h1><? the_title() ?></h1>
    <div class="favorites__products">

    </div>
</section>

<? get_footer();
