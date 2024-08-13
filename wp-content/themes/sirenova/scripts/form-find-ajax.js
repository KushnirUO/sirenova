var wc_cart_params = typeof wc_cart_params !== 'undefined' ? wc_cart_params : {
    ajax_url: wc_add_to_cart_params ? wc_add_to_cart_params.ajax_url : ''
};

$(document).ready(function () {
    var typingTimer;
    var doneTypingInterval = 2000;
    var $input = $('.find__form-inp');

    $input.on('keyup', function () {
        clearTimeout(typingTimer);

        if ($input.val().length >= 3) {
            typingTimer = setTimeout(function () {
                doneTyping($input.val());
                $('.find__block').addClass('loading');
            }, doneTypingInterval);
        }
    });

    function doneTyping(query) {
        $.ajax({
            url: wc_cart_params.ajax_url,
            method: 'POST',
            data: { search: query, action: 'find_form' },
            success: function (response) {
                $('.result-form').html(response);
                console.log('Отримано дані:', response);
                $('.find__block').removeClass('loading');

            },
            error: function (xhr, status, error) {
                console.error('Сталася помилка:', error);
            }
        });
    }
});