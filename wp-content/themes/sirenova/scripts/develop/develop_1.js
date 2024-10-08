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

function getProductColor() {
    var color;
    //$('.product__colors').each(function () {
    //    $(this).children().first().addClass('color-active');
    //});
    $('.product__colors > div').each(function () {
        color = $(this).data('color');
        $(this).find('span').css('background', color);
        //if ($(this).hasClass('color-active')) {
        //    $(this).css('border', '1px solid' + color);
        //}
    });
    //$('.product__colors > div').on('click', function () {
    //    color = $(this).data('color');
    //    $(this).closest('.product__colors').find('div').removeClass('color-active');
    //    $(this).closest('.product__colors').find('div').css('border', '1px solid transparent');
    //    $(this).css('border', '1px solid' + color);
    //    $(this).removeClass('color-active');
    //});
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

function openAutorizeForm() {
    $('.login__btn a').fancybox();
}




function showForgotPasswordForm() {
    $('.forgot__pass').on('click', function () {
        $('#authorizationForm').toggleClass('show__forgot-form');
    });
}
function burgerFilterCatalog() {

    $('.filter-mobile-catalog').on('click', function () {
        $(this).toggleClass('active');
        $('.catalog__main-filters').toggle("slow");
    })
}
function miniCartPopup() {
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

}

window.addEventListener('DOMContentLoaded', function () {
    menuFilters();
    openFindForm();
    dropdownFilters();
    listFilters();
    getProductColor();
    cartSetProductCount();
    getSingleProductColor();
    scrollToElement();
    openAutorizeForm();
    showForgotPasswordForm();
    burgerFilterCatalog();
});

