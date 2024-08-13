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
            url: '/endpoint',
            method: 'POST',
            data: { search: query },
            success: function (response) {
                console.log('Отримано дані:', response);
                $('.find__block').removeClass('loading');

            },
            error: function (xhr, status, error) {
                console.error('Сталася помилка:', error);
            }
        });
    }
});
