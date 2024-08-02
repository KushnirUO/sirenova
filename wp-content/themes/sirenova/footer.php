<?php
$phone_icon = get_field('phone_icon', 'options');
$phone_number = get_field('phone_number', 'options');
$header_logo = get_field('header_logo', 'option');
$instagram_text = get_field('instagram_text', 'options');
$instagram_url = get_field('instagram_url', 'options');
$tiktok_url = get_field('tiktok_url', 'options');
$tiktok_text = get_field('tiktok_text', 'options');
$hours = get_field('hours', 'options');
?>
<footer class="footer">
    <div class="footer-catalog__btn">
        <button class="btn js-catalog__footer">Каталог товарів</button>
    </div>
    <div class="wrapper footer__top">
        <div class="footer-catalog__wrap js-toggle-catalog__footer hide">
            <div class="footer-catalog">
                <?php wp_nav_menu(
                    array(
                        "container" => false,
                        "walker" => new Footer_Menu_Walker,
                        'theme_location' => 'footer-menu',
                        'items_wrap' => '%3$s'
                    )
                );
                ?>
            </div>
        </div>
        <div class="footer-inner">
            <div class="footer-logo">
                <a href="" class="header__top-logo-mobile" id="mobileLogo">
                    <img src="<?php echo $header_logo['url']; ?>" alt="Sirenova">
                </a>
            </div>
            <div class="footer-contacts width-25">
                <div class="footer-about__info">
                    <div class="footer-delivery">
                        <img src="<?php echo $phone_icon['url']; ?>" alt="">
                    </div>
                    <a href="tel:<?php echo esc_attr($phone_number); ?>" class="footer-number"> <?php echo $phone_number; ?></a>


                </div>

                <div class="footer-schedule">
                    <?php foreach ($hours as $hour) : ?>
                        <p class="footer-schedule__item"><?php echo $hour['working_hours']; ?></p>
                    <?php endforeach; ?>
                </div>

            </div>
            <div class="footer-socials width-25">
                <div class="footer-socials-title">
                    <a href="<?php echo $instagram_url; ?>" target='_blank'>
                        <div class="svg-footer"><svg class="c-footer-social__svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 169.063 169.063" style="enable-background:new 0 0 169.063 169.063;" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M122.406,0H46.654C20.929,0,0,20.93,0,46.655v75.752c0,25.726,20.929,46.655,46.654,46.655h75.752   c25.727,0,46.656-20.93,46.656-46.655V46.655C169.063,20.93,148.133,0,122.406,0z M154.063,122.407   c0,17.455-14.201,31.655-31.656,31.655H46.654C29.2,154.063,15,139.862,15,122.407V46.655C15,29.201,29.2,15,46.654,15h75.752   c17.455,0,31.656,14.201,31.656,31.655V122.407z" data-original="#000000"></path>
                                        <path d="M84.531,40.97c-24.021,0-43.563,19.542-43.563,43.563c0,24.02,19.542,43.561,43.563,43.561s43.563-19.541,43.563-43.561   C128.094,60.512,108.552,40.97,84.531,40.97z M84.531,113.093c-15.749,0-28.563-12.812-28.563-28.561   c0-15.75,12.813-28.563,28.563-28.563s28.563,12.813,28.563,28.563C113.094,100.281,100.28,113.093,84.531,113.093z" data-original="#000000"></path>
                                        <path d="M129.921,28.251c-2.89,0-5.729,1.17-7.77,3.22c-2.051,2.04-3.23,4.88-3.23,7.78c0,2.891,1.18,5.73,3.23,7.78   c2.04,2.04,4.88,3.22,7.77,3.22c2.9,0,5.73-1.18,7.78-3.22c2.05-2.05,3.22-4.89,3.22-7.78c0-2.9-1.17-5.74-3.22-7.78   C135.661,29.421,132.821,28.251,129.921,28.251z" data-original="#000000"></path>
                                    </g>
                                </g>
                            </svg></div>
                        <?php echo $instagram_text; ?>
                    </a>
                </div>
                <div class="footer-socials-title">
                    <a href="<?php echo $tiktok_url; ?>" target='_blank'>
                        <div class="svg-footer"><svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 449.45 515.38">
                                <path fill-rule="nonzero" d="M382.31 103.3c-27.76-18.1-47.79-47.07-54.04-80.82-1.35-7.29-2.1-14.8-2.1-22.48h-88.6l-.15 355.09c-1.48 39.77-34.21 71.68-74.33 71.68-12.47 0-24.21-3.11-34.55-8.56-23.71-12.47-39.94-37.32-39.94-65.91 0-41.07 33.42-74.49 74.48-74.49 7.67 0 15.02 1.27 21.97 3.44V190.8c-7.2-.99-14.51-1.59-21.97-1.59C73.16 189.21 0 262.36 0 352.3c0 55.17 27.56 104 69.63 133.52 26.48 18.61 58.71 29.56 93.46 29.56 89.93 0 163.08-73.16 163.08-163.08V172.23c34.75 24.94 77.33 39.64 123.28 39.64v-88.61c-24.75 0-47.8-7.35-67.14-19.96z" />
                            </svg></div>
                        <?php echo $tiktok_text; ?>
                    </a>
                </div>
            </div>
            <div class="footer-delivery width-25">
                <a href="<?php echo home_url('/dostavka-i-oplata/'); ?>">Доставка і оплата</a>
                <a href="<?php echo home_url('/pro-nas/'); ?>">Про нас</a>
            </div>
            <div class="footer-sale width-25">
                <a href="<?php echo home_url('/sale/'); ?>" class='footer-sale-btn'>ЗНИЖКИ ДО -70% </a>
            </div>
            <div class="footer-info__second sm">
                <div class="footer-info__second-block sm">
                    <div class="footer-info__svg">
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 12C2 6.48 6.47 2 11.99 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 11.99 22C6.47 22 2 17.52 2 12ZM15.97 8H18.92C17.96 6.35 16.43 5.07 14.59 4.44C15.19 5.55 15.65 6.75 15.97 8ZM12 4.04C12.83 5.24 13.48 6.57 13.91 8H10.09C10.52 6.57 11.17 5.24 12 4.04ZM4 12C4 12.69 4.1 13.36 4.26 14H7.64C7.56 13.34 7.5 12.68 7.5 12C7.5 11.32 7.56 10.66 7.64 10H4.26C4.1 10.64 4 11.31 4 12ZM5.08 16H8.03C8.35 17.25 8.81 18.45 9.41 19.56C7.57 18.93 6.04 17.66 5.08 16ZM5.08 8H8.03C8.35 6.75 8.81 5.55 9.41 4.44C7.57 5.07 6.04 6.34 5.08 8ZM12 19.96C11.17 18.76 10.52 17.43 10.09 16H13.91C13.48 17.43 12.83 18.76 12 19.96ZM9.5 12C9.5 12.68 9.57 13.34 9.66 14H14.34C14.43 13.34 14.5 12.68 14.5 12C14.5 11.32 14.43 10.65 14.34 10H9.66C9.57 10.65 9.5 11.32 9.5 12ZM14.59 19.56C15.19 18.45 15.65 17.25 15.97 16H18.92C17.96 17.65 16.43 18.93 14.59 19.56ZM16.5 12C16.5 12.68 16.44 13.34 16.36 14H19.74C19.9 13.36 20 12.69 20 12C20 11.31 19.9 10.64 19.74 10H16.36C16.44 10.66 16.5 11.32 16.5 12Z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Офіційний<br>
                            інтернет магазин</p>
                    </div>
                </div>
                <div class="footer-info__second-block sm">
                    <div class="footer-info__svg">
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM9.97 9.47C9.97 10.2 10.54 10.69 12.31 11.14C14.07 11.6 15.96 12.36 15.97 14.56C15.96 16.17 14.76 17.04 13.24 17.33V19H10.9V17.3C9.4 16.99 8.14 16.03 8.04 14.33H9.76C9.85 15.25 10.48 15.97 12.08 15.97C13.79 15.97 14.18 15.11 14.18 14.58C14.18 13.86 13.79 13.17 11.84 12.71C9.67 12.19 8.18 11.29 8.18 9.5C8.18 7.99 9.39 7.01 10.9 6.69V5H13.23V6.71C14.85 7.11 15.67 8.34 15.72 9.68H14.01C13.97 8.7 13.45 8.04 12.07 8.04C10.76 8.04 9.97 8.63 9.97 9.47Z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Без комісії<br>
                            на усі товари</p>
                    </div>
                </div>
                <div class="footer-info__second-block sm">
                    <div class="footer-info__svg">
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M3 15H3.78C4.33 14.39 5.12 14 6 14C6.88 14 7.67 14.39 8.22 15H15V6H3V15Z" fill="#1D1E1F"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17 4H3C1.9 4 1 4.9 1 6V17H3C3 18.66 4.34 20 6 20C7.66 20 9 18.66 9 17H15C15 18.66 16.34 20 18 20C19.66 20 21 18.66 21 17H23V12L20 8H17V4ZM6 18C5.45 18 5 17.55 5 17C5 16.45 5.45 16 6 16C6.55 16 7 16.45 7 17C7 17.55 6.55 18 6 18ZM8.22 15H15V6H3V15H3.78C4.33 14.39 5.11 14 6 14C6.89 14 7.67 14.39 8.22 15ZM18 18C17.45 18 17 17.55 17 17C17 16.45 17.45 16 18 16C18.55 16 19 16.45 19 17C19 17.55 18.55 18 18 18ZM17 9.5V12H21.46L19.5 9.5H17Z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Безкоштовна доставка при замовленні від 999 грн.*</p>
                    </div>
                </div>
                <div class="footer-info__second-block sm">
                    <div class="footer-info__svg">
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1ZM19 11C19 15.52 16.02 19.69 12 20.93C7.98 19.69 5 15.52 5 11V6.3L12 3.19L19 6.3V11ZM6 13L7.41 11.59L10 14.17L16.59 7.58L18 9L10 17L6 13Z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Гарантія якості<br>
                            на всю продукцію</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="footer-copyright">
        <div class="footer-copyright__wrapper">
            <div class="footer-copyright__brand">© SIRENOVA 2023 ЗРОБЛЕНО З ЛЮБОВ'Ю ДЛЯ ЛЮБОВІ</div>
            <a href="<?php echo home_url('/privacy-policy/'); ?>">
                Політика Конфіденційності
            </a>
        </div>
    </div>
    </div>
</footer>
<?php wp_footer(); ?>
</div>
</body>

</html>