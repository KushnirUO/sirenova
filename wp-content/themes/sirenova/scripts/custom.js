'use strict';

function menuFilters() {
    function openMenu() {
        $('html, body').addClass('overflow');
        $('.header__top').addClass('open-menu');
        $('.black__bg').addClass('show__bg');
        $('#mobileMenu').addClass('open');

    }
    function closeMenu() {
        $('html, body').removeClass('overflow');
        $('.header__top').removeClass('open-menu');
        $('.black__bg').removeClass('show__bg');
        $('#mobileMenu').removeClass('open');
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

function openFindForm() {
    function openFindForm() {
        $('#findForm').addClass('open').slideDown('slow');
        $('.black__bg').addClass('show__bg');
    }
    function closeFindForm() {
        $('#findForm').removeClass('open').slideUp('slow');
        $('.black__bg').removeClass('show__bg');
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

    $('.filter-mobile-catalog').on('click', function () {
        $(this).toggleClass('active');
        $('.catalog__main-filters').toggle("slow");
    })
}

function AccFooter() {
    var isMobile = window.innerWidth < 768;
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




window.addEventListener('DOMContentLoaded', function () {
    menuFilters();
    openFindForm();
    dropdownFilters();
    listFilters();
    scrollToElement();
    burgerFilterCatalog();
    AccFooter();
    addSlowScroll();

});
$(document).ready(function () {
    // Перевіряємо, чи існує елемент з класом .wrapper.main__new
    if ($('.wrapper.main__new').length > 0) {
        // Видаляємо div з класом woocommerce columns-4
        $('.wrapper.main__new .woocommerce.columns-4').contents().unwrap();
        StartSlider();
        initMainNewSlider();
    }
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
