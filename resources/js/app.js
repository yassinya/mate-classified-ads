require('./bootstrap');

import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;
var dropzone = new Dropzone("#dropzone", { url: "/"});

$(document).ready(function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

    $('.open-it').modal('show');

    $('#logout').on('click', function () {
        $.post("/logout", {
            _token: CSRF_TOKEN,
        }).done(function () {
            location.reload();
        }).fail(function () {
            location.reload();
        });
    });
});