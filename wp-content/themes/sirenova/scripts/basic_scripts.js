'use strict';

/**
* Check scroll-bar width
* exemple ->   let scroll = $.scrollbarWidth();
*/
$.scrollbarWidth = function () {
    var a, b, c;if (c === undefined) {
        a = $('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo('body');b = a.children();c = b.innerWidth() - b.height(99).innerWidth();a.remove();
    }return c;
};

/**
* Scroll to the block
* @param {block} str - For what we click
* @param {targetBlock} str - to what we should scroll
*/
function scrollUp(block, targetBlock) {
    $(block).click(function (e) {
        var target = $(targetBlock).offset().top;

        $('body,html').stop().animate({ scrollTop: target }, 800);
        return false;

        e.preventDefault();
    });
}

/**
* Scroll animation
* @param {item} jquery obj - Wrapper for class 'animate-it';
*/
function animationBlock(item) {

    $(window).scroll(function () {
        checkForAnimate();
    });

    function checkForAnimate() {
        var bottomCheck = $(window).height() + $(window).scrollTop();
        var windowTop = $(window).scrollTop() + $(window).height() / 1.5;
        item.each(function () {
            if (windowTop > $(this).offset().top || bottomCheck > $('body').height() * 0.98) {

                var itemSect = $(this);
                var point = 0;
                itemSect.find('.animate-it').addClass('animated');

                var timer = setInterval(function () {
                    itemSect.find('.animate-delay').eq(point).addClass('animated');
                    point++;
                    if (itemSect.find('.animate-delay').length == point) {
                        clearInterval(timer);
                    }
                }, 200);
            }
        });
    }
    checkForAnimate();
}

/**
* GO TO href (smooth)
*/
function goTo() {
    $('.header-menu a').click(function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var target = $(href).offset().top - 65;
        $('body,html').animate({ scrollTop: target }, 500);
    });
}

/**
* Cut text script
* (Add to  div class "cut-text" width data-attr "data-cut"(length letters to show) )
*/
function cutText() {
    var filler = '...';
    var filler_length = filler.length;
    $('.cut-text').each(function () {
        var value = $(this).data('cut') - filler_length;
        var text = $.trim($(this).text());
        if (text.length > value && value > 0) {
            var newText = text.substring(0, value) + filler;
            $(this).text(newText);
        }
    });
};

/**
* Functional header butter
* @param {menuMobile} jquery obj - For what we click
* @param {toggleMenu} jquery obj - to what menu we will slideToggle
*/
function headeButer(menuMobile, toggleMenu) {
    if (menuMobile) {
        menuMobile.click(function (event) {
            if ($(window).width() < 1024 - $.scrollbarWidth()) {
                $(this).toggleClass('active');
                toggleMenu.stop().slideToggle();
            }
        });

        $(document).on('click touchstart', function (event) {
            if ($(window).width() < 1024 - $.scrollbarWidth()) {
                var div = toggleMenu;
                if (!div.is(event.target) && div.has(event.target).length === 0 && !menuMobile.is(event.target) && menuMobile.has(event.target).length === 0) {
                    toggleMenu.slideUp();
                    menuMobile.removeClass('active');
                }
            }
        });
    }
}

/**
* Expresion for numbers with spaces
* @param {x} number
* @return {string}
*/
function numberWithSpaces(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    return parts.join(".");
}

$(document).ready(function () {

    $('.footer_placeholder').height($('.footer').outerHeight());

    goTo();
});

$(window).resize(function () {

    $('.footer_placeholder').height($('.footer').outerHeight());
});
//# sourceMappingURL=basic_scripts.js.map




/*=============================
  AJAX фильтрация товаров
==============================*/
	// опции сортировки товаров
	$( '.product-filter-sort a' ).click( function( event ) {
		const el = $(this);
		const val = el.attr( 'href' ).replace( '?orderby=', '' );

		$( '.product-filter-sort a' ).removeClass( 'active' );
		el.addClass( 'active' );

		$( 'input[name="orderby"]' ).val( val );

		$('#ajaxform').submit();
		event.preventDefault();
	} );
// асинхронный запрос при отправке формы
$('#ajaxform').submit(function (event) {
    event.preventDefault();

    const form = $(this);

    $.ajax({
        type: 'POST',
        url: woocommerce_params.ajax_url,
        data: form.serialize(),

        success: function (data) {
            // выводим отфильтрованные товары
            $('.catalog__main-products').html(data.products);
            // выводим счётчик количества товаров
            $('.woocommerce-result-count').text(data.count);

            $('.page-pagination-wrapper').html('');

            $('#shop-page-wrapper').unblock();
        }

    });

});

// отправляем форму при клике на чекбоксы также
$('#ajaxform input[type="checkbox"]').change(function () {
    $('#ajaxform').submit();
});



$(document).ready(function () {
    $(".single-sidebar-wrap").each(function () {
        $(this).find("h3").click(function () {
            $(this).parent().toggleClass("active");
        });
    });
});

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
        form.submit();
    }
});
amount.val(rangeSlider.slider("values", 0) +
    " UAH - " + rangeSlider.slider("values", 1) + " UAH");