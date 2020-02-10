var app = (function () {
    var $input = document.getElementById('username');
    var $submit = document.getElementById('submit');

    function submit() {
        window.top.location.href = '/' + $input.value
    }

    $submit.addEventListener('click', submit);

    $input.addEventListener('keyup', function (e) {
        if (e.code && e.code.toLowerCase() === 'enter' || e.keyCode === 13) {
            submit();
        }
    });
});

app();