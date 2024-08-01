<!DOCTYPE html>
<?php
$header_logo = get_field('header_logo', 'option');
$phone_icon = get_field('phone_icon', 'options');
$phone_number = get_field('phone_number', 'options');
$instagram_icon = get_field('instagram_icon', 'options');
$instagram_url = get_field('instagram_url', 'options');
$instagram_text = get_field('instagram_text', 'options');

$cart_count = WC()->cart->get_cart_contents_count();

?>
<html <? language_attributes() ?>>

<head>
    <meta charset="<? bloginfo('charset') ?>">

    <meta id="viewport" name="viewport" content="width=device-width, user-scalable=yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="HandheldFriendly" content="false" />
    <meta name="format-detection" content="telephone=no">

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <?php wp_head() ?>
</head>

<body>
    <div class="global-wrapper">

        <!-- Start Mobile top header -->
        <header class="header">
            <!-- Start Mobile top header -->
            <div class="header__top-wrap">
                <div class="wrapper header__top">
                    <a href="<?php echo home_url(); ?>" rel='nofollow' class="header__top-logo-mobile" id="mobileLogo">
                        <img src="<?php echo $header_logo['url']; ?>" alt="Sirenova">
                    </a>
                    <ul>
                        <li>
                            <a href="javascript:void(0);" id="findFormBtn">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0)">
                                        <path d="M12.8412 12.0753L9.14432 8.37851C9.8604 7.49398 10.2916 6.37003 10.2916 5.14588C10.2916 2.30866 7.98299 9.15527e-05 5.14577 9.15527e-05C2.30854 9.15527e-05 0 2.30864 0 5.14586C0 7.98308 2.30857 10.2916 5.14579 10.2916C6.36994 10.2916 7.49389 9.86049 8.37842 9.14441L12.0753 12.8412C12.1809 12.9469 12.3195 13 12.4582 13C12.5969 13 12.7356 12.9469 12.8412 12.8412C13.053 12.6295 13.053 12.2871 12.8412 12.0753ZM5.14579 9.20832C2.90547 9.20832 1.08333 7.38618 1.08333 5.14586C1.08333 2.90554 2.90547 1.0834 5.14579 1.0834C7.38611 1.0834 9.20825 2.90554 9.20825 5.14586C9.20825 7.38618 7.38609 9.20832 5.14579 9.20832Z" fill="white"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0">
                                            <rect width="13" height="13" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://sirenova.com.ua/wishlist/" class="h-like">

                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                    <path d="M7.06137 3.44614L7.49999 4.24773L7.93862 3.44615C8.16695 3.0289 8.54675 2.47166 9.10353 2.04106C9.67576 1.59851 10.3149 1.37891 11.0156 1.37891C12.9734 1.37891 14.5 2.97394 14.5 5.20061C14.5 6.37767 14.0343 7.38917 13.1422 8.46572C12.2373 9.55757 10.9328 10.6714 9.30391 12.0595L9.3039 12.0595L9.30343 12.0599C8.7599 12.5231 8.14246 13.0493 7.50002 13.6109C6.85797 13.0497 6.24082 12.5238 5.69781 12.061L5.69646 12.0598L5.69644 12.0598C4.06734 10.6715 2.76276 9.55764 1.85787 8.46576C0.965655 7.38916 0.5 6.37766 0.5 5.20061C0.5 2.97394 2.02655 1.37891 3.98438 1.37891C4.68506 1.37891 5.32424 1.59851 5.89647 2.04106L6.20235 1.64555L5.89647 2.04106C6.45325 2.47167 6.83305 3.02888 7.06137 3.44614ZM7.52084 13.6291L7.52059 13.6289L7.52084 13.6291Z" fill="transparent" stroke="white"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="h-cart <?php echo $cart_count > 0 ? 'has-something' : 'empty-cart'; ?>">
                                <?php if ($cart_count > 0) : ?>
                                    <span class="cart__counter-icon"><?php echo esc_html($cart_count); ?></span>
                                <?php endif; ?>
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.5001 12.9663L12.6412 3.29448C12.6228 3.07975 12.4419 2.91718 12.2302 2.91718H10.4633C10.4388 1.30368 9.11977 0 7.50014 0C5.88051 0 4.56149 1.30368 4.53695 2.91718H2.77008C2.55535 2.91718 2.37744 3.07975 2.35903 3.29448L1.50014 12.9663C1.50014 12.9785 1.49707 12.9908 1.49707 13.0031C1.49707 14.1043 2.50627 15 3.7486 15H11.2517C12.494 15 13.5032 14.1043 13.5032 13.0031C13.5032 12.9908 13.5032 12.9785 13.5001 12.9663ZM7.50014 0.828221C8.66271 0.828221 9.61057 1.76074 9.63511 2.91718H5.36517C5.38971 1.76074 6.33756 0.828221 7.50014 0.828221ZM11.2517 14.1718H3.7486C2.96946 14.1718 2.33756 13.6564 2.32529 13.0215L3.14738 3.74847H4.53388V5.00613C4.53388 5.2362 4.71793 5.42025 4.94799 5.42025C5.17805 5.42025 5.3621 5.2362 5.3621 5.00613V3.74847H9.63511V5.00613C9.63511 5.2362 9.81916 5.42025 10.0492 5.42025C10.2793 5.42025 10.4633 5.2362 10.4633 5.00613V3.74847H11.8498L12.675 13.0215C12.6627 13.6564 12.0277 14.1718 11.2517 14.1718Z" fill="white"></path>
                                </svg>
                            </a>
                        </li>
                    </ul>
                    <div class="header__top-hamburger" id="mobileMenuBtn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
            <!-- End Mobile top header -->

            <!-- Start Desktop header -->
            <div class="header__bottom-wrap">
                <div class="wrapper header__bottom">
                    <a href="<?php echo home_url(); ?>" rel='nofollow' class="header__bottom-logo">
                        <img src="<?php echo $header_logo['url']; ?>" alt="Sirenova">
                    </a>
                    <ul>
                        <?php wp_nav_menu(
                            array(
                                "container" => false,
                                "walker" => new Sirenova_Header_Menu,
                                'theme_location' => 'header-menu',
                                'items_wrap' => '%3$s'
                            )
                        ); ?>
                        <li class="sale"><a href="/sale">Sale</a></li>
                    </ul>

                    <ul>
                        <li id="menu-item-27" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-27"><a href="https://sirenova.com.ua/o-nas/">Про нас</a></li>
                        <li id="menu-item-24" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24"><a href="https://sirenova.com.ua/dostavka-i-oplata/">Доставка і оплата</a></li>
                        <li id="menu-item-7032" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-privacy-policy menu-item-7032"><a rel="privacy-policy" href="https://sirenova.com.ua/politics/">Політика</a></li>

                        <li><a href="https://sirenova.com.ua/komplekt-bilyzny-seksualnyj-z-lypuchkamy/" class="mobile__menu-signinn">
                                <img src="https://sirenova.com.ua/wp-content/themes/v2.3/img/i-user-black.svg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" id="findFormBtn">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0)">
                                        <path d="M12.8412 12.0753L9.14432 8.37851C9.8604 7.49398 10.2916 6.37003 10.2916 5.14588C10.2916 2.30866 7.98299 9.15527e-05 5.14577 9.15527e-05C2.30854 9.15527e-05 0 2.30864 0 5.14586C0 7.98308 2.30857 10.2916 5.14579 10.2916C6.36994 10.2916 7.49389 9.86049 8.37842 9.14441L12.0753 12.8412C12.1809 12.9469 12.3195 13 12.4582 13C12.5969 13 12.7356 12.9469 12.8412 12.8412C13.053 12.6295 13.053 12.2871 12.8412 12.0753ZM5.14579 9.20832C2.90547 9.20832 1.08333 7.38618 1.08333 5.14586C1.08333 2.90554 2.90547 1.0834 5.14579 1.0834C7.38611 1.0834 9.20825 2.90554 9.20825 5.14586C9.20825 7.38618 7.38609 9.20832 5.14579 9.20832Z" fill="white"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0">
                                            <rect width="13" height="13" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://sirenova.com.ua/wishlist/" class="h-like">

                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                    <path d="M7.06137 3.44614L7.49999 4.24773L7.93862 3.44615C8.16695 3.0289 8.54675 2.47166 9.10353 2.04106C9.67576 1.59851 10.3149 1.37891 11.0156 1.37891C12.9734 1.37891 14.5 2.97394 14.5 5.20061C14.5 6.37767 14.0343 7.38917 13.1422 8.46572C12.2373 9.55757 10.9328 10.6714 9.30391 12.0595L9.3039 12.0595L9.30343 12.0599C8.7599 12.5231 8.14246 13.0493 7.50002 13.6109C6.85797 13.0497 6.24082 12.5238 5.69781 12.061L5.69646 12.0598L5.69644 12.0598C4.06734 10.6715 2.76276 9.55764 1.85787 8.46576C0.965655 7.38916 0.5 6.37766 0.5 5.20061C0.5 2.97394 2.02655 1.37891 3.98438 1.37891C4.68506 1.37891 5.32424 1.59851 5.89647 2.04106L6.20235 1.64555L5.89647 2.04106C6.45325 2.47167 6.83305 3.02888 7.06137 3.44614ZM7.52084 13.6291L7.52059 13.6289L7.52084 13.6291Z" fill="transparent" stroke="white"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="h-cart <?php echo $cart_count > 0 ? 'has-something' : 'empty-cart'; ?>">
                                <?php if ($cart_count > 0) : ?>
                                    <span class="cart__counter-icon"><?php echo esc_html($cart_count); ?></span>
                                <?php endif; ?>
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.5001 12.9663L12.6412 3.29448C12.6228 3.07975 12.4419 2.91718 12.2302 2.91718H10.4633C10.4388 1.30368 9.11977 0 7.50014 0C5.88051 0 4.56149 1.30368 4.53695 2.91718H2.77008C2.55535 2.91718 2.37744 3.07975 2.35903 3.29448L1.50014 12.9663C1.50014 12.9785 1.49707 12.9908 1.49707 13.0031C1.49707 14.1043 2.50627 15 3.7486 15H11.2517C12.494 15 13.5032 14.1043 13.5032 13.0031C13.5032 12.9908 13.5032 12.9785 13.5001 12.9663ZM7.50014 0.828221C8.66271 0.828221 9.61057 1.76074 9.63511 2.91718H5.36517C5.38971 1.76074 6.33756 0.828221 7.50014 0.828221ZM11.2517 14.1718H3.7486C2.96946 14.1718 2.33756 13.6564 2.32529 13.0215L3.14738 3.74847H4.53388V5.00613C4.53388 5.2362 4.71793 5.42025 4.94799 5.42025C5.17805 5.42025 5.3621 5.2362 5.3621 5.00613V3.74847H9.63511V5.00613C9.63511 5.2362 9.81916 5.42025 10.0492 5.42025C10.2793 5.42025 10.4633 5.2362 10.4633 5.00613V3.74847H11.8498L12.675 13.0215C12.6627 13.6564 12.0277 14.1718 11.2517 14.1718Z" fill="white"></path>
                                </svg>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="find__block" id="findForm">
                <div class="wrapper">
                    <form role="search" method="get" class="find__form" action="https://sirenova.com.ua/">
                        <input type="search" class="find__form-inp" placeholder="Пошук..." value="" name="s" title="Search for:">
                        <div class="find__form-btns">
                            <a href="javascript:void(0);" id="formBtnCancel">Відміна</a>
                            <input type="submit" value="Пошук" class="btn">
                            <input type="hidden" name="post_type" value="product">
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Desktop header -->
        </header>


        <!-- Start Mobile header -->
        <div class="mobile__menu-wrap" id="mobileMenu">
            <div class="blur-line"></div>
            <a href="<?php echo home_url(); ?>" rel='nofollow' class="mobile__logo">
                <img src="<?php echo $header_logo['url']; ?>" alt="Sirenova">
            </a>
            <div class="header__top-hamburger" id="mobileMenuBtn">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="mobile__menu">

                <div class="mobile__menu-signin-wrap">
                    <a href="https://sirenova.com.ua/komplekt-bilyzny-seksualnyj-z-lypuchkamy/" class="mobile__menu-signin">
                        <img src="https://sirenova.com.ua/wp-content/themes/v2.3/img/i-user-black.svg" alt="">
                        Особистий кабінет
                    </a>
                </div>

                <ul>
                    <?php wp_nav_menu(
                        array(
                            "container" => false,
                            "walker" => new Sirenova_Header_Menu,
                            'theme_location' => 'header-menu',
                            'items_wrap' => '%3$s'
                        )
                    );
                    ?>
                </ul>
                <div class="mobile__menu-info">
                    <?php wp_nav_menu(
                        array(
                            "container" => false,
                            'menu_class' => false,
                            "walker" => new Sirenova_Header_Menu,
                            'theme_location' => 'mobile-sub-menu',
                            'items_wrap' => '%3$s'
                        )
                    );
                    ?>
                </div>
                <div class="mobile__menu-contacts">
                    <a href="<?php echo $instagram_url; ?>" target="_blank">
                        <img src="<?php echo $instagram_icon['url']; ?>" alt="">
                        <?php echo $instagram_text; ?>
                    </a>
                    <a href="tel:<?php echo esc_attr($phone_number); ?>">
                        <img src="<?php echo $phone_icon['url']; ?>" alt="">
                        <?php echo $phone_number; ?>
                    </a>
                </div>
            </div>
        </div>
        <!-- End Mobile header -->