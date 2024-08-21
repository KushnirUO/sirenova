<?

/**
 * Template Name: delivery
 */
get_header()

    ?>
<section class="wrapper post delivery_and-payment">
    <?php woocommerce_breadcrumb(); ?>
    <div class="post__content">
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </div>
</section>
<? get_footer();