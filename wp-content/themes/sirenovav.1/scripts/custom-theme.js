function setCookie( cname, cvalue, exdays ) {
    var d = new Date();
    d.setTime( d.getTime() + ( exdays * 24 * 60 * 60 * 1000 ) );
    var expires = d.toGMTString();
    document.cookie = `${cname}=${cvalue}; expires=${expires}; path=/`;
}

function getCookie( cname ) {
    var name = `${cname}=`;
    var ca = document.cookie.split(';');
    for ( var i = 0; i < ca.length; i++ ) {
        var c = ca[ i ];
        while ( ' ' == c.charAt( 0 ) ) c = c.substring( 1 );
        if ( -1 != c.indexOf( name ) ) return c.substring( name.length, c.length );
    }
    return '';
}

$('.add-to-wishlist').not('.act').click(function(event) {
    $(this).addClass('act');
    var id = $(this).attr('data-id');
    if(getCookie('wishlist')!=''){
        var ids = new Array();
        ids.push(getCookie('wishlist'));
        ids.push(id);
        setCookie('wishlist',ids,3);
    } else {
        setCookie('wishlist',id,3);
    }

});
$('.wishlist-remove').click(function(event) {
    var id_r = $(this).attr('data-id');
    $('.temp-remove-button').attr('data-id',id_r);
});

$('.temp-remove-button').click(function(event) {
    var id = $(this).attr('data-id');
    var ids = new Array();
    $('.wishlist-entry').each(function(index, el) {
        var id_n = $(this).attr('data-id');
        if(id_n!=id){
            ids.push(id_n);
        }
    });
    console.log(ids);
   setCookie('wishlist',ids,3);
});

var booking_mini_selectors = [
    '.catalog__main-products .icons.booking',
    '.main__new-slider .icons.booking', /** front page */
    '.single__product-main .modal.info__btns-booking',
    '.single__product .info__btns-booking',
];

$( document ).on( 'click', booking_mini_selectors.join(', '), function ( e ) {
    e.preventDefault();

    var booking_data = JSON.parse( atob( $( this ).attr('data-bookingform') ) );
    var form_html = renderTemplate( booking_data );

    $.fancybox.open( {
        src: form_html,
        type: 'inline',
        opts: {
            afterLoad: function afterLoad() {
                $('#productSliderNavigationModal').slick( {
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    asNavFor: '#productSliderSingleModal',
                    dots: false,
                    focusOnSelect: true,
                    vertical: true,
                    responsive: [{
                        breakpoint: 576,
                        settings: {
                        slidesToShow: 3
                        }
                    }]
                });
                $('#productSliderSingleModal').slick( {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    asNavFor: '#productSliderNavigationModal'
                });
            }
        }
    });

    if(isLoggedIn) {
        $('[data-fancybox="popupGallery"]').fancybox({
            buttons: [
                "download",
                "close"
            ]
        });
    } else {
        $('[data-fancybox="popupGallery"]').fancybox({
            buttons: [
                "close"
            ]
        });
    }

    dropdownSizes();
    getSingleProductColor();
});



function dropdownSizes() {
    var resultBlock = $('.productDropdownSizesBtn');
    $('.productDropdownSizes').each(function () {
        var firtstElementText = $(this).children().first().text(),
            firtstElementAttr = $(this).children().first().attr('data-product-value');
        $(this).closest('.size__dropdown').find(resultBlock).text(firtstElementText);
        $(this).closest('.size__dropdown').find(resultBlock).attr('data-product-value', firtstElementAttr);
    });
    resultBlock.on('click', function () {
        $(this).closest('.size__dropdown').toggleClass('dropdown-open');
        $(this).next().slideToggle(300);
    });
    $('.productDropdownSizes li').each(function () {
        $(this).on('click', function () {
            var elementText, elementAttr;
            elementText = $(this).text();
            elementAttr = $(this).data('product-size');
            $(this).closest('.size__dropdown').find(resultBlock).text(elementText);
            $(this).closest('.size__dropdown').find(resultBlock).attr('data-product-value', elementAttr);
            $(this).closest('.size__dropdown').find(resultBlock).closest('.size__dropdown').removeClass('dropdown-open');
            $('.productDropdownSizes').slideUp(300);
        });
    });
    $(document).mouseup(function (e) {
        if (!resultBlock.is(e.target)) {
            resultBlock.closest('.size__dropdown').removeClass('dropdown-open');
            $('.productDropdownSizes').slideUp(300);
        }
    });
}

function renderTemplate( card ) {
    var slider_small = ( undefined !== card.slider['thumbnails-cart-small'] ) ? `
    <div class="slider__navigation" id="productSliderNavigationModal">
        ${card.slider['thumbnails-cart-small'].map( img => `
            <div>
                <div class="slider__navigation-wrap">
                    ${img}
                </div>
            </div>` ).join('')}
    </div>` : '';
    var slider_big = ( undefined !== card.slider['thumbnails-cart-big'] ) ? `
    <div class="slider__single" id="productSliderSingleModal">
        ${card.slider['thumbnails-cart-big'].map( ( img, ind )=> `
            <div>
                <a href="${card.slider['slider_url'][ind]}" data-fancybox class="slider__single-wrap">
                    ${img}
                </a>
            </div>` ).join('')}
    </div>` : '';
    var slider = ( 'string' == typeof card.slider ) ? card.slider : `${slider_small}${slider_big}`;

    var sizes = ( undefined !== card.sizes ) ? `
    <div class="size__dropdown">
        <span class="size__dropdown-ttl">РОЗМІР:</span>
        <div class="size__dropdown-content">
            ${card.sizes.map( ( size, i ) => `
            <label>
                <input type="radio" name="cartProductSize" value="${size.id}"${0 == i ? ' checked="checked"' : ''}>
                <span>${size.name}</span>
            </label>` ).join('')}
        </div>
    </div>` : '';

    var colors = ( undefined !== card.colors ) ? `
    <div class="info__colors">
        <span>КОЛІР</span>
        <div class="pallete">
            ${card.colors.map( color => `
                <input data-product-color="${color.id}" type="radio" name="productPalleteModal" value="${color.value}">` ).join('')}
        </div>
    </div>` : '';

    return `
        <form method="POST" action="/wp-admin/admin-ajax.php" class="modal__window modal__product" id="tableBookingModal-${card.product_id}">
            <input type="hidden" name="action" value="booking-add" />
            <input type="hidden" name="product_id" value="${card.product_id}" />
            <h2>Забронювати товар</h2>
            <div class="single__product-main">
                <div class="slider">${slider}</div>
                <div class="info">
                    ${card.sku}
                    ${card.title}
                    ${card.price}
                    <div class="info__count">
                        <div class="cart__counter">
                            <span>Кількість:</span>
                            <input type="number" name="bookingProductCounter" value="1" />
                            <span class="increase"></span>
                            <span class="decrease"></span>
                        </div>
                        <a data-fancybox data-src="#tableSizeModal" href="javascript:void(0);" class="modal info__count-size">Підібрати розмір</a>
                    </div>
                    ${colors}
                    ${sizes}
                    <div class="info__btns">
                        <button class="btn info__btns-cart">
                            забронювати
                            <div class="booking__caution">
                                <span>Бронювання здійснюється на період до 2 днів після чого буде автоматично деактивовано</span>
                                <img src="../img/i-caution-angle.svg" alt="">
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </form>`;
}

$( document ).on( 'submit', '.modal__window.modal__product', function ( e ) {
    e.preventDefault();
    var $form = $( this );
    var $button = $form.find('.info__btns-cart');

    $.ajax( {
        url: $form.attr('action'),
        data: {
            action: $form.find('[name="action"]').val(),
            product_id: $form.find('[name="product_id"]').val(),
            color: $form.find('[name="productPalleteModal"]:checked').attr('data-product-color'),
            size: $form.find('[name="cartProductSize"]:checked').val(),
            count: $form.find('[name="bookingProductCounter"]').val(),
        },
        method: $form.attr('method'),
        beforeSend: function () {
            $button.attr( 'disabled', 'disabled' );
        },
        success: function ( res ) {
            $button.removeAttr('disabled');

            $.fancybox.close();
            if ( undefined !== res.data.message ) $.fancybox.open( res.data.message );
            if ( undefined !== res.data.header ) $('.h-booking').closest('li').html( res.data.header );
        }
    })
});

$( document ).on( 'click', '.modal__window.modal__product .productDropdownSizes li', function () {
    $('.modal__window.modal__product [name="bookingProductSize"]').val( $( this ).attr('data-product-size') );
});

$(document).on('click', '#filtersMobileMenu .list__content.colors label', function(){
    $(this).css('border', '1px solid rgb(166, 110, 204)')
});

$(document).on('click', '#filtersMobileMenu .list__content._push label, #filtersMobileMenu  .list__content.size label', function(){
    $(this).find('input').prop('checked', !$(this).find('input').prop('checked'))
});

$( document ).on( 'submit', 'form.catalog__main-filters', function ( e ) {
    e.preventDefault();

    var $form = $( this );
    var formdata = serializeForm( $form );
    formdata.action = 'shop_filter';

    $.post( {
        url: '/wp-admin/admin-ajax.php',
        data: formdata,
        beforeSend: function () {
            $form.attr( 'disabled', 'disabled' );
            $('.catalog__main-products').addClass('loading');
        },
        success: function ( res ) {
            $form.removeAttr('disabled');
            $form.next().html( res.data.html );
            getProductColor();

            var query = get_filter_data( $form );
            app_history.push( res.data.html, 'title', `?${query}` );
            $('.catalog__main-products').removeClass('loading');

            $('.list__content.colors').find('input').each(function () {
                color = $(this).attr('data-color');
                $(this).next('span').css('background', color);
                if(color === '#ffffff') {
                    $(this).next('span').css('border', '1px solid #C4C4C4');
                }
                if ($(this).is(":checked")) {
                    var name = $(this).attr('data-color');

                    $('.list__content.colors input[data-color="' + name + '"]').closest('label').css('border', '1px solid ' + name);
                    $(this).closest('label').css('border', '1px solid' + color);
                } else {
                    $(this).closest('label').css('border', '1px solid transparent');
                }
            });
        }
    });
});

$(document).on('click', '.slider__single-wrap', function() {
    var htmlRender = $('.catalog__main-products').html();
    app_history.push( htmlRender, 'title', '' );
});

function serializeForm( $form ) {
    var res = {};
    $form.find('input').each( function ( i, node ) {
        var name = $( node ).attr('name');

        var value = '';
        switch ( $( node ).attr('type') ) {
            case 'checkbox' : {
                if ( node.checked ) {
                    value = $( node ).attr('value');
                }

                break;
            }
            default: {
                value = $( node ).attr('value');

                break;
            }
        }

        if ( value ) {
            if ( res[ name ] ) {
                res[ name ].push( value );
            } else {
                res[ name ] = [ value ];
            }
        }
    });

    return res;
}

function get_filter_data( $form ) {
    var names = Array.from( new Set( $form.find('[name]').toArray().map( node => $( node ).attr('name') ) ) );
    var data = names.reduce( function ( data, name ) {
        var nodes = $form.find(`[name=${name}]`).toArray();
        var query = ( 1 == nodes.length ) ? nodes.map( node => $( node ).val() ).join(',') : nodes.filter( node => $( node ).is(':checked') ).map( node => $( node ).val() ).join(',');

        if ( '' !== query ) data.push( name + '=' + query );
        return data;
    }, [] );

    return data.join('&');
}

$( document ).on( 'change', 'form.catalog__main-filters input', function () {
    $( this ).closest('form').trigger('submit');
});

var changeProductQuantity = debounce( function ( item_key ) {
    var $product = $(`[value="${item_key}"]`).closest('.cart__products-product-wrap');

    $.post( {
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'cart_user_update',
            card_item_key: item_key,
            quantity: $product.find('[name="quantity"]').val(),
        },
        beforeSend: function () {
            /** @todo add preloader */
        },
        success: function ( res ) {
            /** @todo remove preloader */

            if ( ! res.success ) {
                if ( undefined !== res.data.message ) $.fancybox.open( res.data.message );

                return;
            }

            if ( undefined !== res.data.html ) $product.closest('.cart__products').html( res.data.html );
            if ( undefined !== res.data.summary ) $('.cart .cart__total-price').html( res.data.summary );
            if ( undefined !== res.data.cart_icon ) $('.h-cart').closest('li').html( res.data.cart_icon );
        }
    });
}, 2000 );

$( document ).on( 'change', '.cart .cart__products-product-wrap [name="quantity"]', function () {
    var item_key = $( this ).closest('.cart__products-product').find('[name="card_item_key"]').val();
    changeProductQuantity( item_key );
});

$( document ).on( 'click', '.cart .cart__products-product-wrap .increase, .cart .cart__products-product-wrap .decrease', function () {
    $( this ).closest('.cart__counter').find('[name="quantity"]').trigger('change');
});

function debounce(f, t) {
    return function (args) {
        let previousCall = this.lastCall;
        this.lastCall = Date.now();
        if (previousCall && ((this.lastCall - previousCall) <= t)) {
            clearTimeout(this.lastCallTimer);
        }
        this.lastCallTimer = setTimeout(() => f(args), t);
    }
}

$( document ).on( 'click', '.cart .cart__delete', function () {
    var $product = $( this ).closest('.cart__products-product-wrap');

    $.post( {
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'cart_user_remove',
            card_item_key: $product.find('[name="card_item_key"]').val(),
        },
        beforeSend: function () {
            /** @todo add preloader */
            $( this ).attr( 'disabled', 'disabled' );
        },
        success: function ( res ) {
            /** @todo remove preloader */
            $( this ).removeAttr('disabled');

            if ( ! res.success ) {
                if ( undefined !== res.data.message ) $.fancybox.open( res.data.message );

                return;
            }

            $product.remove();
            if ( undefined !== res.data.summary ) $('.cart .cart__total-price').html( res.data.summary );
            if ( undefined !== res.data.cart_icon ) $('.h-cart').closest('li').html( res.data.cart_icon );
        }
    });
});

$( document ).on( 'click', '.reserve .product__delete', function ( e ) {
    e.preventDefault();

    var $card = $( this ).closest('.reserve__product');

    $.post( {
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'booking-remove',
            variation_id: $card.attr('id').split('product-')[ 1 ],
        },
        beforeSend: function () {
            $( this ).attr( 'disabled', 'disabled' );
        },
        success: function ( res ) {
            $( this ).attr('disabled');
            if ( undefined !== res.data.header ) $('.h-booking').closest('li').html( res.data.header );

            $.fancybox.open(`<div class="message">${res.data.message}</div>`);
            if ( ! res.success ) return;

            $card.remove();
        }
    })
});

$( document ).on( 'click', '.reserve .product__buy', function ( e ) {
    e.preventDefault();

    var $card = $( this ).closest('.reserve__product');
    var $button = $( this );

    $.post( {
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'booking-cart-add',
            product_id: $card.attr('id').split('product-')[ 1 ],
            quantity: $card.find('[data-quantity]').attr('data-quantity'),
        },
        beforeSend: function () {
            $button.attr( 'disabled', 'disabled' );
        },
        success: function ( res ) {
            $button.removeAttr('disabled');

            if ( res.success ) {
                $('.product__success-add').addClass('active');
                setTimeout( function () {
                    $('.product__success-add').removeClass('active');
                }, 3000 );
            }

            $button.text('Вже в кошику');
            if ( undefined !== res.data.header ) $('.h-booking').closest('li').html( res.data.header );
            if ( undefined !== res.data.cart ) $('.h-cart').closest('li').html( res.data.cart );
        }
    })
});

$( document ).on( 'click', '.favorites .product__buy', function ( e ) {
    var $card = $( this ).closest('.favorites__product').first();
    var quantity = $card.find('[name="quantity"]').val();
    var size = $card.find('[data-pa_size]').data('product-value');
    var color = $card.find('[data-pa_colors]').data('product-value');
    var product_id = $card.attr('id').replace( 'favorite-', '' );

    var data = {
        action: 'add_to_cart',
        quantity: quantity,
        size: size,
        color: color,
        product_id: product_id,
    };

    $.post( {
        data: data,
        url: '/wp-admin/admin-ajax.php',
        beforeSend: function () {
            $( this ).attr( 'disabled', 'disabled' );
        },
        success: function ( res ) {
            $( this ).removeAttr('disabled');

            if ( res.success ) {
                $('.product__success-add').addClass('active');
                setTimeout( function () {
                    $('.product__success-add').removeClass('active');
                }, 3000 );
            } else {
                if ( undefined !== res.data.message ) $.fancybox.open( res.data.message );
            }

            if ( undefined !== res.data.cart_html ) $('.h-cart').closest('li').html( res.data.cart_html );
        }
    });
});

$( document ).on( 'click', '.single__product .info__btns-cart', function () {
    var $product = $( document ).find('.single__product-main');

    $.post( {
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'cart_product_add',
            quantity: $product.find('[name="quantity"]').val(),
            product_id: $product.find('[name="product_id"]').val(),
            color: $product.find('[name="productPallete"]:checked').attr('data-product-color'),
            size: $product.find('[name="cartProductSize"]:checked').val(),
        },
        beforeSend: function () {
            $( this ).attr( 'disabled', 'disabled' );
        },
        success: function ( res ) {
            $( this ).removeAttr('disabled');

            if ( res.success ) {
                $('.product__success-add').addClass('active');
                setTimeout( function () {
                    $('.product__success-add').removeClass('active');
                }, 3000 );
            } else {
                if ( undefined !== res.data.message ) $.fancybox.open( res.data.message );
            }

            if ( undefined !== res.data.cart_html ) $('.h-cart').closest('li').html( res.data.cart_html );
        }
    });
});

var favorites_loop_checkbox_handlers = [
    '.main__new-slider .icons.like [type="checkbox"]', /** front page */
    '.catalog__main-products .icons.like [type="checkbox"]', /** page shop */
    '.single__product-more .icons.like [type="checkbox"]', /** single product - related */
];

$( document ).on( 'change', favorites_loop_checkbox_handlers.join(', '), function () {
    var $checkbox = $( this );
    var product_id = $checkbox.closest('.icons.like').attr('data-product');

    $.post( {
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'user-favorite',
            product_id: product_id,
        },
        beforeSend: function () {
            $checkbox.attr( 'disabled', 'disabled' );
        },
        success: function ( res ) {console.log( res );
            $checkbox.removeAttr('disabled');

            if ( undefined !== $checkbox.attr('checked') ) {
                $checkbox.removeAttr('checked');
            } else {
                $checkbox.attr( 'checked', 'checked' );
            }

            if ( undefined !== res.data.favorite_icon ) $('.h-like').closest('li').html( res.data.favorite_icon );
            dropdownSizes();
        },
    });
});

$( document ).on( 'click', '.favorites .favorites__product .product__delete', function () {
    var $card = $( this ).closest('.favorites__product');
    var product_id = $card.attr('id').replace( 'favorite-', '' );

    $.post( {
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'user-favorite',
            product_id: product_id,
        },
        beforeSend: function () {
            /** @todo add preloader */
        },
        success: function ( res ) {
            /** @todo remove preloader */

            $card.remove();

            if ( undefined !== res.data.favorite_icon ) $('.h-like').closest('li').html( res.data.favorite_icon );
            if ( undefined !== res.data.content ) $('.favorites__products').html( res.data.content );
            dropdownSizes();
        },
    })
});

$( document ).on( 'click', '.favorites .favorites__product .product__booking', function () {
    var $card = $( this ).closest('.favorites__product');

    var data = {
        action: 'booking-add',
        product_id: $card.attr('id').replace( 'favorite-', '' ),
        size: $card.find('[data-pa_size]').attr('data-product-value'),
        color: $card.find('[data-pa_colors]').attr('data-product-value'),
        count: $card.find('[name="quantity"]').val(),
    };

    $.post( {
        url: '/wp-admin/admin-ajax.php',
        data: data,
        beforeSend: function () {
            $( this ).attr( 'disabled', 'disabled' );
        },
        success: function ( res ) {
            $( this ).removeAttr('disabled');

            if ( undefined !== res.data.message ) $.fancybox.open( res.data.message );
        }
    });
});

$( document ).on( 'click', '.catalog .filters__dropdown ul li', function () {
    var $form = $( this ).closest('form');
    var filter_type = $( this ).attr('data-dropdown-filter');

    switch ( filter_type ) {
        case 'product-date' : {
            $form.find('[name="order"]').val('DESC');
            $form.find('[name="orderby"]').val('date');
            break;
        }
        case 'price-up' : {
            $form.find('[name="order"]').val('ASC');
            $form.find('[name="orderby"]').val('price');
            break;
        }
        case 'price-down' : {
            $form.find('[name="order"]').val('DESC');
            $form.find('[name="orderby"]').val('price');
            break;
        }
        case 'product-position' : {
            $form.find('[name="order"]').val('ASC');
            $form.find('[name="orderby"]').val('menu_order');
            break;
        }
        case 'product-naame' : {
            $form.find('[name="order"]').val('ASC');
            $form.find('[name="orderby"]').val('title');
            break;
        }
        case 'popular' : {
            $form.find('[name="order"]').val('ASC');
            $form.find('[name="orderby"]').val('menu_order');
            break;
        }

    }

    $form.trigger('submit');
});

$( document ).on( 'click', '.single__product-main .info__btns-like', function () {
    var $button = $( this );
    var product_id = $button.closest('.single__product').find('[name="product_id"]').val();

    $.post( {
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'user-favorite',
            product_id: product_id,
        },
        beforeSend: function () {
            $button.attr( 'disabled', 'disabled' );
        },
        success: function ( res ) {
            $button.removeAttr('disabled');

            if ( undefined !== res.data.favorite_icon ) $('.h-like').closest('li').html( res.data.favorite_icon );
        },
    });
});

$( document ).on( 'click', '.log-in.not, .mobile__menu-signin.not', function () {
    $.fancybox.open( {
        src: '#authorizationForm'
    });
});

$( document ).on( 'submit', '#authorizationForm form', function ( e ) {
    e.preventDefault();
    var $form = $( this );
    var data = $form.serialize();

    $.post( {
        url: $form.attr('action'),
        data: data,
        beforeSend: function () {
            /** @todo add placeholder */
            $( this ).attr( 'disabled', 'disabled' );
        },
        success: function ( res ) {
            /** @todo remove placeholder */
            $( this ).removeAttr('disabled');
            if ( res.success ) document.location.reload();

            if ( undefined !== res.data.message ) $.fancybox.open( res.data.message );
        },
    });
});


function dropdownSizes() {
    var resultBlock = $('.productDropdownSizesBtn');
    $('.productDropdownSizes').each(function () {
        var firtstElementText = $(this).children().first().text(),
            firtstElementAttr = $(this).children().first().attr('data-product-value');
        $(this).closest('.size__dropdown').find(resultBlock).text(firtstElementText);
        $(this).closest('.size__dropdown').find(resultBlock).attr('data-product-value', firtstElementAttr);
    });
    resultBlock.on('click', function () {
        $(this).closest('.size__dropdown').toggleClass('dropdown-open');
        $(this).next().slideToggle(300);
    });
    $('.productDropdownSizes li').each(function () {
        $(this).on('click', function () {
            var elementText, elementAttr;
            elementText = $(this).text();
            elementAttr = $(this).data('product-size');
            $(this).closest('.size__dropdown').find(resultBlock).text(elementText);
            $(this).closest('.size__dropdown').find(resultBlock).attr('data-product-value', elementAttr);
            $(this).closest('.size__dropdown').find(resultBlock).closest('.size__dropdown').removeClass('dropdown-open');
            $('.productDropdownSizes').slideUp(300);
        });
    });
    $(document).mouseup(function (e) {
        if (!resultBlock.is(e.target)) {
            resultBlock.closest('.size__dropdown').removeClass('dropdown-open');
            $('.productDropdownSizes').slideUp(300);
        }
    });
}

$( document ).on( 'click', '#filtersMobileMenu .filters__lists-list label', function ( e ) {
    e.preventDefault();

    var $target = $( e.target ).closest('label').find('[type="checkbox"]');
    $(`form.catalog__main-filters [value="${$target.val()}"]`).trigger('click');
});