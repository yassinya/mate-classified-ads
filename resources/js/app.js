require('./bootstrap');

import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;
var dropzone = new Dropzone("#dropzone", { url: "/"});

$(document).ready(function(){
    $('.open-it').modal('show');
});