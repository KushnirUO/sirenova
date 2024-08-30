<?

/**
 * Template Name: About
 */

$about_page_id = get_the_ID();
$subtitle = get_field('subtitle', $about_page_id);
$sec_subtitle = get_field('block-2_title', $about_page_id);
$block_2_img = get_field('block-2_img', $about_page_id);
$block_2_text = get_field('block-2_text', $about_page_id);
$block_3_title = get_field('block-3_title', $about_page_id);
$block_3_img = get_field('block-3_img', $about_page_id);
$block_3_text = get_field('block-3_text', $about_page_id);
$block_4_title = get_field('block-4_title', $about_page_id);
$block_4_text = get_field('block-4_text', $about_page_id);
get_header();
?>


<section class="about__first">
    <div class="about__first-wrap">
        <?php echo get_the_post_thumbnail(); ?>
    </div>
    <div class="wrapper about__first-info">
        <h1><?php the_title(); ?></h1>
        <svg width="48" height="12" viewBox="0 0 48 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="5.82683" cy="5.82659" r="5.32659" stroke="#9152C5"></circle>
            <path
                d="M29.4621 5.82659C29.4621 8.75736 27.0264 11.1532 23.9968 11.1532C20.9672 11.1532 18.5315 8.75736 18.5315 5.82659C18.5315 2.89582 20.9672 0.5 23.9968 0.5C27.0264 0.5 29.4621 2.89582 29.4621 5.82659Z"
                stroke="#9152C5"></path>
            <circle cx="42.1706" cy="5.82659" r="5.32659" stroke="#9152C5"></circle>
        </svg>
        <p><?php echo $subtitle; ?></p>
    </div>
</section>
<section class="wrapper about__info">
    <h2><?php echo $sec_subtitle; ?></h2>
    <div class="about__info-experience">
        <div class="experience__wrap">
            <img src="<?php echo $block_2_img['url']; ?>" alt="">
        </div>
        <div class="experience__block">
            <?php foreach ($block_2_text as $content): ?>
                <p><?php echo $content['block-2_content']; ?></p>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="about__info-price1">
        <div class="price1__info">
            <h2><strong><?php echo $block_3_title; ?></strong></h2>
            <?php foreach ($block_3_text as $content): ?>
                <p><?php echo $content['block-3_content']; ?></p>
            <?php endforeach; ?>
        </div>
        <div class="price1__wrap">
            <img src="<?php echo $block_3_img['url']; ?>" alt="">
        </div>
    </div>
    <div class="about__info-price2">
        <h2><?php echo $block_4_title; ?></h2>
        <p><?php echo $block_4_text; ?></p>
    </div>
</section>
<? get_footer();
