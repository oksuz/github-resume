var app = (function () {
    var $input = document.getElementById('username');
    var $submit = document.getElementById('submit');

    $submit.addEventListener('click', function () {
        window.top.location.href = '/' + $input.value
    });
});

app();