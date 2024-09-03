<?php

/**
 * Template Name: checkout
 */
get_header();
?>
<section class="wrapper post">

    <div class="bredacrumbs">

    </div>
    <div class="post__content">
        <h1>Оформлення замовлення</h1>
        <?php echo do_shortcode('[woocommerce_checkout]'); ?>

    </div>
</section>