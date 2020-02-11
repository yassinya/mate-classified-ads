require('./bootstrap');

import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;
var dropzone = new Dropzone("#dropzone", { url: "/"});