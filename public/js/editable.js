$(document).ready(function(){

    $("body").tooltip({
        selector: '[data-title]'
    });

    $.fn.editable.defaults.mode = 'inline';
    $.fn.editable.defaults.params = function (params) {
        params._token = $("#_token").data("token");
        return params;
    };
    $('.answer').editable({
        url: '/answer/update',
        type: 'textarea',
        name: 'answer',
        rows: 10,
        send:'always',
        ajaxOptions: {
            dataType: 'json'
        }
    });
})