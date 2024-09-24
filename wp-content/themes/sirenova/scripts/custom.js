'use strict';
var isMobile = window.innerWidth < 768;
let currentPage = 1;

function closeMenu() {
    $('html, body').removeClass('overflow');
    $('.header__top').removeClass('open-menu');
    $('.black__bg').removeClass('show__bg');
    $('#mobileMenu').removeClass('open');
}
function menuFilters() {
    function openMenu() {
        closeFindForm();
        closeCart();
        burgerFilterCatalog(1);
        $('html, body').addClass('overflow');
        $('.header__top').addClass('open-menu');
        $('.black__bg').addClass('show__bg');
        $('#mobileMenu').addClass('open');
    }
    function openFilters() {
        $('#filtersMobileMenu').addClass('open');
        $('.header__top').addClass('open-menu');
        $('#mobileMenuBtn').addClass('mobile-filters');
        $('.black__bg').addClass('show__bg');
        $('html, body').addClass('overflow');
    };
    function closeFilters() {
        $('#filtersMobileMenu').removeClass('open');
        $('.header__top').removeClass('open-menu');
        $('#mobileMenuBtn').removeClass('mobile-filters');
        $('.black__bg').removeClass('show__bg');
        $('html, body').removeClass('overflow');
    }
    function openCloseByBurger() {
        if ($(this).hasClass('mobile-filters')) {
            closeFilters();
        } else {
            if ($('#mobileMenu').hasClass('open')) {
                closeMenu();
            } else {
                openMenu();
            }
        }
    }
    function outerClose(e) {
        if (e.target.classList.contains('hamburger-close-filter')) {
            closeMenu();
            closeFilters();
        }
    }

    $(document).on('click', '#mobileMenuBtn', openCloseByBurger);
    $(document).on('click', '#mobileFilters', openFilters);
    $(document).on('click', outerClose);
}
function closeFindForm() {
    $('#findForm').removeClass('open').slideUp('slow');
    $('.black__bg').removeClass('show__bg');
    $('html, body').removeClass('overflow');

}
function FindForm() {
    function openFindForm() {
        closeMenu();
        closeCart();
        burgerFilterCatalog(1);
        $('#findForm').addClass('open').slideDown('slow');
        $('.black__bg').addClass('show__bg');
        $('html, body').addClass('overflow');

    }

    function openCloseFind() {
        ($('#findForm').hasClass('open')) ? closeFindForm() : openFindForm();
    }
    function outerFindClose(e) {
        if (e.target.classList.contains('black__bg')) {
            closeFindForm();
        }
    }

    $(document).on('click', '#findFormBtn,#formBtnCancel', openCloseFind);
    $(document).on('click', outerFindClose);
}
function dropdownFilters() {
    var firtstElementText = $('#dropdownFilterContent li:first-child').text(),
        firtstElementAttr = $('#dropdownFilterContent li:first-child').attr('data-dropdown-filter'),
        resultBlock = $('#dropdownFilterResult');
    resultBlock.text(firtstElementText);
    resultBlock.attr('data-dropdown-filter', firtstElementAttr);
    function openCloseDropdown() {
        resultBlock.toggleClass('dropdown-open');
        $('#dropdownFilterContent').slideToggle(300);
    }
    resultBlock.on('click', function () {
        openCloseDropdown();
    });
    $('#dropdownFilterContent li').each(function () {
        $(this).on('click', function () {
            var elementText, elementAttr;
            elementText = $(this).text();
            elementAttr = $(this).data('dropdown-filter');
            resultBlock.text(elementText);
            resultBlock.attr('data-dropdown-filter', elementAttr);
            openCloseDropdown();
        });
    });
}
function burgerFilterCatalog(close) {
    if (close == 1) {
        $('html, body').removeClass('overflow');
        $('.wrapper-btn-select.mobile').hide();
        $('.catalog__main-filters').removeClass("open");
    }
    else {
        if ($('.catalog__main-filters').hasClass('open')) {
            $('html, body').toggleClass('overflow');
            $('.wrapper-btn-select.mobile').toggle();
        }
        else {
            $('.wrapper-btn-select_btn').addClass('btn-fixed');
            setTimeout(function () {
                $('html, body').toggleClass('overflow');
                $('html, body').animate({ scrollTop: 0 }, 0);

            }, 1000);
            setTimeout(function () {
                $('.wrapper-btn-select.mobile').toggle();
            }, 500);
        }
        $(this).toggleClass('active');
        $('.catalog__main-filters').toggleClass("open");
    }

}
function StartSlider() {
    $('#mainTopSlider').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 3
            }
        }, {
            breakpoint: 768,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 576,
            settings: {
                slidesToShow: 1,
            }
        }]
    });

}
function cartSetProductCount() {
    $('.cart__counter input[type="number"]').prop('readonly', true);

    var invalidChars = ["-", "e", "+", "E"];

    $(document).on('keydown', 'input[type="number"]', function (e) {
        if (invalidChars.includes(e.key)) {
            e.preventDefault();
        }
    });

    $(document).on('input', 'input[type="number"]', function () {
        var inputTypeValue = $(this).val();
        $(this).closest('.cart__counter').find('input[type="number"]').attr('value', inputTypeValue);
    });

    $(document).on('click', '.increase', function () {
        let quanProduct = 999;
        if ($(this).closest('.min-cart__product-wrapp').length > 0 || $(this).closest('.cart__product-wrapp').length > 0) {
            quanProduct = $(this).closest('.cart__counter').find('input[name="stock"]').val();
            if (quanProduct == undefined) quanProduct = 999;

        }

        var inputValue = $(this).closest('.cart__counter').find('input[type="number"]').attr('value');

        if (inputValue < parseInt(quanProduct)) inputValue++;
        else inputValue = parseInt(quanProduct);

        $(this).closest('.cart__counter').find('input[type="number"]').attr('value', inputValue);
        $(this).closest('.cart__counter').find('input[type="number"]').val(inputValue);

        if ($(this).closest('.min-cart__product-wrapp').length > 0 || $(this).closest('.cart__product-wrapp').length > 0) {
            var inputElement = $(this).closest('.cart__counter').find('input[type="number"]');

            if (inputElement.length > 0) {
                inputElement.val(inputValue);
                const event = new Event('change', { bubbles: true });
                inputElement[0].dispatchEvent(event);
            }
        }
    });
    $(document).on('click', '.decrease', function () {
        var inputValue = $(this).closest('.cart__counter').find('input[type="number"]').attr('value');
        if (1 >= inputValue) return;

        inputValue--;
        $(this).closest('.cart__counter').find('input[type="number"]').attr('value', inputValue);
        $(this).closest('.cart__counter').find('input[type="number"]').val(inputValue);
        if ($(this).closest('.min-cart__product-wrapp').length > 0 || $(this).closest('.cart__product-wrapp').length > 0) {
            $(this).closest('.cart__counter').find('input[type="number"]').val(inputValue).trigger('change');
        }
    });
}
function closeCart() {
    $('html, body').removeClass('overflow');
    $('.header__top').removeClass('open-cart');
    $('.black__bg').removeClass('show__bg');
    $('#mini-cart').removeClass('open');
}
function miniCartPopup() {
    function openCart() {
        closeMenu();
        closeFindForm();
        burgerFilterCatalog(1);
        $('html, body').addClass('overflow');
        $('.header__top').addClass('open-cart');
        $('.black__bg').addClass('show__bg');
        $('#mini-cart').addClass('open');

    }
    function openCloseByBurger() {
        if ($(this).hasClass('mobile-filters')) {
            closeFilters();
        } else {
            if ($('#mini-cart').hasClass('open')) {
                closeCart();
            } else {
                openCart();
            }
        }
    }


    $(document).on('click', '.h-cart', openCloseByBurger);
    $(document).on('click', '#closeMiniCart', closeCart);
    $(document).on('click', '.black__bg.show__bg', closeCart);

}

// --- catalog
function listFilters() {

    function openCloseList() {
        $(document).on('click', '.list__ttl', function () {

            if ($(this).hasClass('list-open')) {
                $(this).removeClass('list-open');
                $(this).next('.list__content').slideUp(300);
                $('#showAll').text('развернуть фильтр');
            } else {
                $(this).addClass('list-open');
                $(this).next('.list__content').slideDown(300);
                $('#showAll').text('скрыть фильтр');
            }

        });
    }
    openCloseList();

    function getFiltersColor() {
        var color;
        $('.list__content.colors').find('input').each(function () {
            color = $(this).attr('data-color');
            $(this).next('span').css('background', color);
            if (color === '#ffffff') {
                $(this).next('span').css('border', '1px solid #C4C4C4');
            }
            $(this).on('click', function () {
                if ($(this).is(":checked")) {
                    $(this).closest('label').css('border', '1px solid' + color);
                } else {
                    $(this).closest('label').css('border', '1px solid transparent');
                }
            });
        });
    }
    getFiltersColor();

    function showHideAll() {
        var counter;
        $('#showAll').on('click', function () {
            $('.list__ttl').each(function () {
                if ($(this).hasClass('list-open')) {
                    counter++;
                }
            });
            if (counter == 0) {
                $(this).text('скрыть фильтр');
                $('.list__ttl').addClass('list-open');
                $('.list__content').slideDown(300);
            }
            if (counter > 0) {
                counter = 0;
                $(this).text('развернуть фильтр');
                $('.list__ttl').removeClass('list-open');
                $('.list__content').slideUp(300);
            }
        });
    }
    showHideAll();
}
function renderPagination(countNumber) {
    $('.pagination.products__pagination').html('');
    let totalPages = Math.ceil(countNumber / 12);
    if (countNumber > 12) {

        // Показываем первую страницу
        if (currentPage !== 1) {
            $('.pagination.products__pagination').append(`<a class="page-numbers">1</a>`);

        }

        // Если текущая страница больше чем 3, добавляем "..."
        if (currentPage > 3) {
            $('.pagination.products__pagination').append(`<span class="dots">...</span>`);
        }

        // Показываем предыдущие страницы перед текущей
        if (currentPage > 2) {
            $('.pagination.products__pagination').append(`<a class="page-numbers">${currentPage - 1}</a>`);
        }

        // Показываем текущую страницу
        $('.pagination.products__pagination').append(`<a class="page-numbers current">${currentPage}</a>`);

        // Показываем следующую страницу после текущей
        if (currentPage < totalPages - 1) {
            $('.pagination.products__pagination').append(`<a class="page-numbers">${currentPage + 1}</a>`);
        }

        // Если текущая страница меньше чем totalPages - 2, добавляем "..."
        if (currentPage < totalPages - 2) {
            $('.pagination.products__pagination').append(`<span class="dots">...</span>`);
        }

        // Показываем последнюю страницу
        if (totalPages > 1 && currentPage !== totalPages) {
            $('.pagination.products__pagination').append(`<a class="page-numbers">${totalPages}</a>`);
        }
    }
}
function initRangeSlider() {
    var rangeSlider = $(".price-range"),
        amount = $("#amount"),
        minPrice = rangeSlider.data('min'),
        maxPrice = rangeSlider.data('max'),
        minPriceField = $("#min_price"),
        maxPriceField = $("#max_price"),
        form = $('#ajaxform');

    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        tooltips: true,
        values: [minPriceField.val(), maxPriceField.val()],
        slide: function (event, ui) {
            amount.val(ui.values[0] + " UAH - " + ui.values[1] + " UAH");
            minPriceField.val(ui.values[0]);
            maxPriceField.val(ui.values[1]);
        },
        stop: function (event, ui) {

        }
    });
    amount.val(rangeSlider.slider("values", 0) +
        " UAH - " + rangeSlider.slider("values", 1) + " UAH");
}
function ScrollBtnFilter() {
    var $block = $('.wrapper-btn-select_btn'); // Замените на ваш селектор
    var scrollPosition = $(window).height() + $(window).scrollTop();
    var documentHeight = $('.catalog__main-filters').height() + $('.wrapper.catalog h1').height() + $('.woocommerce-breadcrumb').height() + $('.header').height() + 100;
    if (documentHeight < scrollPosition) {
        $block.removeClass('btn-fixed');
    } else {
        $block.addClass('btn-fixed');
    }
    if (!isMobile) {
        if ($('.catalog__main-filters').length > 0) {
            $(window).on('scroll', function () {
                var scrollPosition = $(window).height() + $(window).scrollTop();
                var documentHeight = $('.catalog__main-filters').height() + $('.wrapper.catalog h1').height() + $('.woocommerce-breadcrumb').height() + $('.header').height() + 100;
                if (documentHeight < scrollPosition) {
                    $block.removeClass('btn-fixed');
                } else {
                    $block.addClass('btn-fixed');
                }
            });
        }
    }

}
function SendFilterClick() {
    $(document).on('click', '.wrapper-btn-select .btn ', function () {
        currentPage = 1;
        $('#ajaxform').find('[name="page"]').val(currentPage);
        ajaxSendFilter();

        if (isMobile) {
            burgerFilterCatalog();
        }
    });
    $(document).on('click', '.wrapper-btn-select .btn-link', function () {
        $('#ajaxform')[0].reset();
        currentPage = 1;
        $('#ajaxform').find('[name="page"]').val(currentPage);
        ajaxSendFilter();
        if (isMobile) {
            burgerFilterCatalog();
        }
    });
    $(document).on('click', '.filter-mobile-catalog', function () {
        currentPage = 1;
        burgerFilterCatalog();
    })
    $(document).on('click', '.pagination.products__pagination .page-numbers', function () {
        let curPage = parseInt($(this).text());
        $('#ajaxform').find('[name="page"]').val(curPage);
        currentPage = curPage;
        ajaxSendFilter();
    })
}
function checkRenderPagin() {
    if ($('.wrapper.catalog').length > 0) {
        let count = $('[name="product_count"]').val();
        renderPagination(count);
    }
}
function filterChangeSorting() {
    $(document).on('click', ' .filters__dropdown ul li', function () {
        var $form = $(this).closest('.filters__dropdown');
        var filter_type = $(this).attr('data-dropdown-filter');

        switch (filter_type) {
            case 'product-date': {
                $form.find('[name="order"]').val('up');
                $form.find('[name="orderby"]').val('new');
                break;
            }
            case 'price-up': {
                $form.find('[name="order"]').val('up');
                $form.find('[name="orderby"]').val('price_up');
                break;
            }
            case 'price-down': {
                $form.find('[name="order"]').val('down');
                $form.find('[name="orderby"]').val('price_down');
                break;
            }
            case 'popular': {
                $form.find('[name="order"]').val('up');
                $form.find('[name="orderby"]').val('popular');
                break;
            }

        }
        currentPage = 1;
        $('#ajaxform').find('[name="page"]').val(currentPage);
        ajaxSendFilter();
    });
}

// --- product-page
function StartVariationProduct() {

    hideUnavailableSizesOnStart();

    $('.sizes-single input').on('click', function () {
        var selectedSize = $(this).val();
        updateColors(selectedSize);
    });
}
function updateSizes(color) {
    $('.sizes-single').each(function () {
        var size = $(this).find('input').val();
        var available = false;

        // Проверяем количество для выбранного цвета и размера
        $.each(stockData, function (key, value) {
            console.log(value.color, color, 'color');
            console.log(value.size, size, 'size');
            console.log(value.stock_quantity, 'stock_quantity');

            if (value.color === color && value.size === size && value.stock_quantity > 0) {
                available = true;
            }
        });

        // Скрываем или показываем размер в зависимости от доступности
        if (available) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });

}
function updateColors(size) {
    $('.pallete-one').each(function () {
        var color = $(this).find('input').val();
        var available = false;

        // Проверяем количество для выбранного цвета и размера
        $.each(stockData, function (key, value) {
            if (value.size === size && value.color === color && (value.stock_quantity > 0 || value.stock_quantity == null)) {
                available = true;
            }
        });

        // Скрываем или показываем цвет в зависимости от доступности
        if (available) {
            $(this).show();
            $(this).addClass('available-product');
        } else {
            $(this).hide();
            $(this).removeClass('available-product');
        }
    });
    var firstAvailableColor = $('.pallete-one.available-product:first input');
    if (firstAvailableColor.length > 0) {
        firstAvailableColor.prop('checked', true);
        $('.pallete-one').removeClass('checked-color');
        firstAvailableColor.closest('.pallete-one').addClass('checked-color');
    }
}
function hideUnavailableSizesOnStart() {
    $('.sizes-single').each(function () {
        var size = $(this).find('input').val();
        var available = false;

        // Перевіряємо наявність розміру в будь-якому кольорі
        $.each(stockData, function (key, value) {
            if (value.size === size && (value.stock_quantity > 0 || value.stock_quantity == null)) {
                available = true;
            }
        });

        // Сховати розмір, якщо він недоступний в жодному кольорі
        if (!available) {
            $(this).hide();
        }
    });
    var firstAvailableSize = $('.sizes-single:visible:first input');
    if (firstAvailableSize.length > 0) {
        firstAvailableSize.prop('checked', true);
    }
    var initialColor = firstAvailableSize.val();
    updateColors(initialColor);
}
function TabProduct() {
    // Tabs functionality for desktop
    $('.sir-tab').click(function () {
        var tabId = $(this).data('tab');

        $('.sir-tab').removeClass('sir-active');
        $(this).addClass('sir-active');

        $('.sir-tab-content').removeClass('sir-active');
        $('#' + tabId).addClass('sir-active');
    });

    // Accordion functionality for mobile
    $('.sir-accordion-title').click(function () {
        var tabContent = $(this).next('.sir-accordion-content');
        $('.sir-accordion-title').removeClass('sir-title-active');
        if (tabContent.is(':visible')) {
            tabContent.slideUp();
        } else {
            $('.sir-accordion-content').slideUp();
            tabContent.slideDown();
            $(this).addClass('sir-title-active');

        }
    });
    if ($(window).width() <= 768) {
        $('.sir-tab-content.sir-active').find('.sir-accordion-content').addClass('sir-active').show();
        $('#tab-1 .sir-accordion-title').addClass('sir-title-active');

        $('.sir-tab-content').addClass('sir-active').show();

    }
}
function initSliderProduct() {
    var sliderNav = $('.slider-product-cart-nav');
    var sliderMain = $('.slider-product-cart');

    // Ініціалізуємо головний слайдер
    sliderMain.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-product-cart-nav'
    });

    // Ініціалізуємо навігаційний слайдер
    sliderNav.slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.slider-product-cart',
        dots: false,
        focusOnSelect: true,
        vertical: true,
        arrows: false
    });

    // Перевіряємо кількість слайдів
    var totalSlides = sliderNav.find('.slick-slide').length;

    // Стрілки будуть працювати навіть якщо слайдів менше 5
    $('.nav-up').click(function () {
        if (totalSlides > 1) {
            sliderMain.slick('slickPrev'); // Перемикаємо головний слайд
            sliderNav.slick('slickPrev'); // Перемикаємо навігаційний слайд
        }
    });

    $('.nav-down').click(function () {
        if (totalSlides > 1) {
            sliderMain.slick('slickNext'); // Перемикаємо головний слайд
            sliderNav.slick('slickNext'); // Перемикаємо навігаційний слайд
        }
    });
}

function getSingleProductColor() {
    $('.pallete').each(function () {
        $(this).children().first().attr('checked', 'checked');
    });
    $('.pallete > input').each(function () {
        var singleProdColor = $(this).val();
        $(this).css('background', singleProdColor);
    });
}


function AccFooter() {
    $('.js-catalog__footer').on('click', function () {
        $('.js-toggle-catalog__footer').toggleClass('hide show');
        $(this).toggleClass('active');
    });
    if (isMobile) {
        $('.js-footer-category-toggle-btn').on('click', function () {
            var $parentBlock = $(this).closest('.js-footer-category-block');
            var $list = $parentBlock.find('.js-footer-category-list');

            $list.toggleClass('hide show');
            $(this).find('.caret').toggleClass('active');
        });
    }
    else {
        $('.js-footer-category-list').removeClass('hide');
    }
}
function AnotherFunc() {
    $(document).on('click', '.catalog__main .single-sidebar-wrap:nth-child(4) .size-list li', function () {
        $(this).toggleClass('checked-color');
        $(this).find('input').prop('checked', !$(this).find('input').prop('checked'));
    })

    $(document).on('click', '.pallete-one', function () {
        $('.pallete-one').removeClass('checked-color');
        $(this).addClass('checked-color');
        $(this).find('input[type="radio"]').prop('checked', true);
    })

    $('[data-fancybox="productGallery"]').fancybox({
        buttons: [
            "close"
        ]
    });
    $(".single-sidebar-wrap").each(function () {
        $(this).find("h3").click(function () {
            $(this).parent().toggleClass("active");
        });
    });
    if ($('.wrapper.main__new').length > 0 || $('.wrapper.single__product').length > 0) {
        $('.wrapper.main__new .woocommerce.columns-4').contents().unwrap();
        StartSlider();
        initMainNewSlider();
    }
}
function scrollToElement() {
    $('.scroll').on('click', function (e) {
        e.preventDefault();
        var pathToScroll = $(this).attr('href'),
            headerHeight = $('.header').height();
        $('html, body').animate({
            scrollTop: $(pathToScroll).offset().top - headerHeight
        }, 1000);
    });
}


// --- favorite page

// Функція для отримання значення з куки
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

// Функція для встановлення куки
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// Функція для додавання/видалення ID товару з куки
function toggleFavorite(productId) {
    let favorites = getCookie('favorites');

    favorites = favorites ? JSON.parse(favorites) : [];

    if (favorites.includes(productId)) {
        favorites = favorites.filter(id => id !== productId);
    } else {
        favorites.push(productId);
    }

    setCookie('favorites', JSON.stringify(favorites), 30); // 30 днів зберігання
    console.log('Оновлений список улюблених:', favorites);
    updateCounterLike();
}
function updateCounterLike() {
    const favoriteIds = getFavoriteIds();
    let count = favoriteIds.length;
    $('.h-like .cart__counter-icon').remove();
    if (count !== 0) {
        $('.h-like').prepend(`<span class="cart__counter-icon">${count}</span>`);
    }
    else {
        $('.favorites__products > p').remove();
        $('.favorites__products').append(`<p>У вас немає улюблених товарів.</p>`)
    }
}

// Функція для отримання масиву ID з куки
function getFavoriteIds() {
    let favorites = getCookie('favorites');
    return favorites ? JSON.parse(favorites) : [];
}

// Функція рендерингу отриманих товарів (приклад)
function renderFavorites(products) {
    const productsArray = Object.values(products);
    console.log(productsArray, products);
    productsArray.forEach(product => {
        $('.favorites__products').append(product);
    });
    $('.product__img-wrap').append(`<button class="product__delete">
                    <svg viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.6416 17.5135H4.35845C4.17206 17.5125 3.99274 17.442 3.85555 17.3158C3.71836 17.1897 3.63314 17.0169 3.61656 16.8312L2.55602 4.16773C2.55322 4.13413 2.55743 4.10032 2.5684 4.06843C2.57936 4.03655 2.59684 4.0073 2.61971 3.98253C2.64258 3.95775 2.67035 3.93801 2.70126 3.92454C2.73217 3.91108 2.76554 3.90418 2.79926 3.9043H15.2027C15.2364 3.90418 15.2698 3.91108 15.3007 3.92454C15.3316 3.93801 15.3594 3.95775 15.3823 3.98253C15.4051 4.0073 15.4226 4.03655 15.4336 4.06843C15.4445 4.10032 15.4488 4.13413 15.446 4.16773L14.3854 16.8312C14.3688 17.0172 14.2833 17.1903 14.1457 17.3165C14.0081 17.4427 13.8283 17.513 13.6416 17.5135ZM3.06293 4.39078L4.10158 16.7906C4.10728 16.8549 4.13676 16.9148 4.18426 16.9585C4.23177 17.0022 4.29388 17.0267 4.35845 17.027H13.6416C13.7062 17.0267 13.7684 17.0023 13.8159 16.9586C13.8635 16.9149 13.893 16.855 13.8987 16.7906L14.9373 4.39078H3.06293Z" fill="black"></path>
                        <path d="M16.0958 4.39295H1.90406C1.76432 4.39276 1.63036 4.33716 1.53155 4.23835C1.43274 4.13954 1.37715 4.00558 1.37695 3.86585V2.63966C1.37708 2.4999 1.43266 2.3659 1.53148 2.26708C1.63031 2.16825 1.7643 2.11268 1.90406 2.11255H16.0958C16.2356 2.11268 16.3696 2.16825 16.4684 2.26708C16.5672 2.3659 16.6228 2.4999 16.623 2.63966V3.86609C16.6227 4.00579 16.5671 4.13968 16.4683 4.23844C16.3695 4.3372 16.2355 4.39276 16.0958 4.39295ZM1.90406 2.59904C1.89329 2.59904 1.88296 2.60332 1.87534 2.61093C1.86772 2.61855 1.86344 2.62888 1.86344 2.63966V3.86609C1.86344 3.87686 1.86772 3.8872 1.87534 3.89481C1.88296 3.90243 1.89329 3.90671 1.90406 3.90671H16.0958C16.1066 3.90671 16.117 3.90243 16.1246 3.89481C16.1322 3.8872 16.1365 3.87686 16.1365 3.86609V2.63966C16.1365 2.62888 16.1322 2.61855 16.1246 2.61093C16.117 2.60332 16.1066 2.59904 16.0958 2.59904H1.90406Z" fill="black"></path>
                        <path d="M11.144 2.59901H6.85701C6.7925 2.59901 6.73063 2.57339 6.68501 2.52777C6.6394 2.48215 6.61377 2.42028 6.61377 2.35577V1.12326C6.61396 0.954426 6.68112 0.792564 6.8005 0.673181C6.91989 0.553798 7.08175 0.486643 7.25058 0.48645H10.7504C10.9192 0.486643 11.0811 0.553798 11.2005 0.673181C11.3198 0.792564 11.387 0.954426 11.3872 1.12326V2.35577C11.3872 2.42028 11.3616 2.48215 11.316 2.52777C11.2703 2.57339 11.2085 2.59901 11.144 2.59901ZM7.10026 2.11253H10.9007V1.12326C10.9007 1.08339 10.8849 1.04516 10.8567 1.01696C10.8285 0.988773 10.7903 0.972936 10.7504 0.972936H7.25058C7.21071 0.972936 7.17248 0.988773 7.14429 1.01696C7.1161 1.04516 7.10026 1.08339 7.10026 1.12326V2.11253Z" fill="black"></path>
                        <path d="M11.5447 13.6289C11.5376 13.6289 11.5304 13.6289 11.5233 13.6289C11.459 13.6233 11.3997 13.5924 11.3582 13.543C11.3167 13.4936 11.2966 13.4298 11.3022 13.3655L11.859 7.00931C11.8612 6.97707 11.8699 6.9456 11.8844 6.91675C11.8989 6.88789 11.9191 6.86222 11.9437 6.84123C11.9682 6.82025 11.9967 6.80437 12.0275 6.79452C12.0583 6.78468 12.0907 6.78106 12.1229 6.78389C12.1551 6.78672 12.1864 6.79593 12.215 6.81099C12.2436 6.82605 12.2689 6.84666 12.2894 6.87161C12.31 6.89656 12.3253 6.92535 12.3346 6.9563C12.3439 6.98725 12.3469 7.01974 12.3435 7.05187L11.787 13.4071C11.7816 13.4677 11.7538 13.524 11.7089 13.5651C11.6641 13.6062 11.6055 13.6289 11.5447 13.6289Z" fill="black"></path>
                        <path d="M9.00008 13.6289C8.93557 13.6289 8.8737 13.6033 8.82808 13.5577C8.78246 13.5121 8.75684 13.4502 8.75684 13.3857V7.02974C8.75684 6.96523 8.78246 6.90336 8.82808 6.85774C8.8737 6.81213 8.93557 6.7865 9.00008 6.7865C9.0646 6.7865 9.12647 6.81213 9.17209 6.85774C9.21771 6.90336 9.24333 6.96523 9.24333 7.02974V13.3857C9.24333 13.4502 9.21771 13.5121 9.17209 13.5577C9.12647 13.6033 9.0646 13.6289 9.00008 13.6289Z" fill="black"></path>
                        <path d="M6.45496 13.629C6.39395 13.6293 6.33509 13.6066 6.29003 13.5654C6.24498 13.5243 6.21702 13.4677 6.21172 13.407L5.65614 7.05102C5.65273 7.01888 5.65576 6.98639 5.66505 6.95544C5.67433 6.92449 5.68969 6.8957 5.71023 6.87075C5.73077 6.84581 5.75607 6.8252 5.78466 6.81014C5.81325 6.79508 5.84455 6.78587 5.87674 6.78304C5.90893 6.78021 5.94136 6.78382 5.97214 6.79367C6.00292 6.80351 6.03143 6.81939 6.056 6.84038C6.08057 6.86136 6.10072 6.88704 6.11526 6.91589C6.1298 6.94475 6.13844 6.97622 6.14069 7.00845L6.69748 13.3646C6.70308 13.4289 6.68293 13.4927 6.64147 13.5421C6.6 13.5915 6.54062 13.6224 6.47637 13.6281C6.47004 13.6288 6.46202 13.629 6.45496 13.629Z" fill="black"></path>
                    </svg>
                </button>`);
    deleteFavorite();
}
function updateFavoriteIcons() {
    const favoriteIds = getFavoriteIds();

    if ($('.info__btns-like').length > 0) {
        $('.info__btns-like').each(function () {
            const productId = $(this).closest('.single__product-main').find('input[name="product_id"]').val();
            if (favoriteIds.includes(productId)) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
    }
    if ($('.like__icon').length > 0) {
        $('.like__icon').each(function () {
            const productId = $(this).closest('.product').find('input[name="product_id"]').val();
            if (favoriteIds.includes(productId)) {
                $(this).closest('.icons.like').find('input').prop('checked', true);
            } else {
                $(this).closest('.icons.like').find('input').prop('checked', false);
            }
        });
    }

}

function deleteFavorite() {
    $('.product__delete').on('click', function () {
        const productId = $(this).closest('.product').find('input[name="product_id"]').val();
        toggleFavorite(productId);
        $(this).closest('.product').fadeOut(400, function () {
            $(this).remove();
        });
        updateCounterLike();

    });
}

function StartAddFavorites() {
    $('.like__icon').on('click', function () {
        const productId = $(this).closest('.product').find('input[name="product_id"]').val();
        toggleFavorite(productId);
    });
    $('.info__btns-like').on('click', function () {
        const productId = $(this).closest('.single__product-main').find('input[name="product_id"]').val();
        toggleFavorite(productId);
        $(this).toggleClass('active');
    });
    updateFavoriteIcons();
    updateCounterLike();
}


$(document).ready(function () {
    menuFilters();
    FindForm();
    dropdownFilters();
    listFilters();
    scrollToElement();
    cartSetProductCount();
    miniCartPopup();
    ScrollBtnFilter();
    SendFilterClick();
    checkRenderPagin();
    StartVariationProduct();
    filterChangeSorting();
    initRangeSlider();
    TabProduct();
    AnotherFunc();
    AccFooter();
    StartAddFavorites();
    ajaxGetFavorites();
});
$(window).on('load', function () {
    initSliderProduct();
    setTimeout(function () {
        $('#billing_nova_poshta_warehouse_field label').html(`Відділення або поштомат <span class="optional"><span class="asterisk-color">*</span></span>`);
    }, 500);
})

// -- ajax
function ajaxSendFilter() {
    // асинхронный запрос при отправке формы
    const form = $('#ajaxform');
    $('.catalog__main-products').addClass('loading');
    $('.wrapper-btn-select .btn').addClass('disabledLink');
    $('.wrapper-btn-select .btn-link').addClass('disabledLink');
    $('html, body').animate({ scrollTop: 0 }, 'slow');

    $.ajax({
        type: 'POST',
        url: woocommerce_params.ajax_url,
        data: form.serialize(),

        success: function (data) {
            const response = JSON.parse(data);
            $('.catalog_products').html(response.products);
            // выводим отфильтрованные товары
            // выводим счётчик количества товаров

            renderPagination(response.count);
            $('.page-pagination-wrapper').html('');

            $('#shop-page-wrapper').unblock();
            $('.catalog__main-products').removeClass('loading');
            $('.wrapper-btn-select .btn').removeClass('disabledLink');
            $('.wrapper-btn-select .btn-link').removeClass('disabledLink');
            StartAddFavorites();

        }

    });

}

function ajaxGetFavorites() {
    if (location.pathname == '/wishlist/') {
        $('.favorites__products').addClass('loading');
        const favoriteIds = getFavoriteIds();
        if (favoriteIds.length > 0) {
            $.ajax({
                url: woocommerce_params.ajax_url,
                method: 'POST',
                data: { product_ids: favoriteIds, action: 'wishlist' },
                success: function (response) {
                    renderFavorites(response.data);
                    $('.favorites__products').removeClass('loading');

                },
                error: function (error) {
                    console.error('Помилка отримання улюблених товарів:', error);
                }
            });
        } else {
            $('.favorites__products').removeClass('loading');
            $('.favorites__products > p').remove();
            $('.favorites__products').append(`<p>У вас немає улюблених товарів.</p>`)
        }
    }
}