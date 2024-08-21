<?
/**
 * Template Name: Privacy-policy
 */
get_header();
?>
<section class="wrapper post">
    <?php woocommerce_breadcrumb(); ?>
    <div class="post__content">
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </div>
</section>

<?php get_footer();