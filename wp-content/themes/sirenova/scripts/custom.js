'use strict';
var isMobile = window.innerWidth < 768;
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


function getSingleProductColor() {
    $('.pallete').each(function () {
        $(this).children().first().attr('checked', 'checked');
    });
    $('.pallete > input').each(function () {
        var singleProdColor = $(this).val();
        $(this).css('background', singleProdColor);
    });
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





function burgerFilterCatalog() {
    if ($('.catalog__main-filters').hasClass('open')) {
        $('html, body').toggleClass('overflow');
        $('.wrapper-btn-select.mobile').toggle();
    }
    else {
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
function addSlowScroll() {
    // const scroll = new LocomotiveScroll({
    //     el: document.querySelector('[data-scroll-container]'),
    //     smooth: true
    // });
}

function cartSetProductCount() {
    var invalidChars = ["-", "e", "+", "E"];

    $(document).on('keydown', 'input[type="number"]', function (e) {
        if (invalidChars.includes(e.key)) {
            e.preventDefault();
        }
    });

    $(document).on('input', 'input[type="number"]', function () {
        var inputTypeValue = $(this).val();
        $(this).closest('.cart__counter').find('input').attr('value', inputTypeValue);
    });

    $(document).on('click', '.increase', function () {
        var inputValue = $(this).closest('.cart__counter').find('input').attr('value');
        inputValue++;
        $(this).closest('.cart__counter').find('input').attr('value', inputValue);
        $(this).closest('.cart__counter').find('input').val(inputValue);
    });
    $(document).on('click', '.decrease', function () {
        var inputValue = $(this).closest('.cart__counter').find('input').attr('value');
        if (1 >= inputValue) return;

        inputValue--;
        $(this).closest('.cart__counter').find('input').attr('value', inputValue);
        $(this).closest('.cart__counter').find('input').val(inputValue);
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
window.addEventListener('DOMContentLoaded', function () {
    menuFilters();
    FindForm();
    dropdownFilters();
    listFilters();
    scrollToElement();
    AccFooter();
    addSlowScroll();
    cartSetProductCount();
    miniCartPopup();
    ScrollBtnFilter();
    SendFilterClick();
    checkRenderPagin();
});
function checkRenderPagin() {
    if ($('.wrapper.catalog').length > 0) {
        let count = $('[name="product_count"]').val();
        renderPagination(count);
    }
}
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
    ajaxSendFilter();
});
$(document).ready(function () {
    $(document).on('click', '.catalog__main .single-sidebar-wrap:nth-child(4) .size-list li ', function () {
        $(this).toggleClass('checked-color');
        $(this).find('input').prop('checked', !$(this).find('input').prop('checked'));
    })
});
function SendFilterClick() {
    $(document).on('click', '.wrapper-btn-select .btn ', function () {
        ajaxSendFilter();
        currentPage = 1;
        if (isMobile) {
            burgerFilterCatalog();
        }
    });
    $(document).on('click', '.wrapper-btn-select .btn-link', function () {
        $('#ajaxform')[0].reset();
        currentPage = 1;
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
        }

    });

}

let currentPage = 1;
function renderPagination(countNumber) {
    $('.pagination.products__pagination').html('');
    let totalPages = Math.ceil(countNumber / 12);
    console.log(totalPages, countNumber);
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
$(document).ready(function () {
    $(".single-sidebar-wrap").each(function () {
        $(this).find("h3").click(function () {
            $(this).parent().toggleClass("active");
        });
    });
});
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
$(document).ready(function () {
    if ($('.wrapper.main__new').length > 0) {
        // Видаляємо div з класом woocommerce columns-4
        $('.wrapper.main__new .woocommerce.columns-4').contents().unwrap();
        StartSlider();
        initMainNewSlider();
    }
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
});

function ScrollBtnFilter() {
    var $block = $('.wrapper-btn-select_btn'); // Замените на ваш селектор
    var scrollPosition = $(window).height() + $(window).scrollTop();
    var documentHeight = $('.catalog__main-filters').height() + $('.woocommerce-products-header__title.page-title').height() + $('.woocommerce-breadcrumb').height() + $('.header').height() + 100;
    if (documentHeight < scrollPosition) {
        $block.removeClass('btn-fixed');
    } else {
        $block.addClass('btn-fixed');
    }
    if (!isMobile) {
        if ($('.catalog__main-filters').length > 0) {


            $(window).on('scroll', function () {
                var scrollPosition = $(window).height() + $(window).scrollTop();
                var documentHeight = $('.catalog__main-filters').height() + $('.woocommerce-products-header__title.page-title').height() + $('.woocommerce-breadcrumb').height() + $('.header').height() + 100;
                if (documentHeight < scrollPosition) {
                    $block.removeClass('btn-fixed');
                } else {
                    $block.addClass('btn-fixed');
                }
            });
        }
    }

}

