$(document).ready(function () {
    var typingTimer;
    var doneTypingInterval = 2000;
    var $input = $('.find__form-inp');

    $input.on('keyup', function () {
        clearTimeout(typingTimer);

        if ($input.val().length >= 3) {
            typingTimer = setTimeout(function () {
                doneTyping($input.val());
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

            },
            error: function (xhr, status, error) {
                console.error('Сталася помилка:', error);
            }
        });
    }
});
