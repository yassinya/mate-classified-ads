require('./bootstrap');

import Dropzone from 'dropzone';

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

Dropzone.autoDiscover = false;
var dropzone = new Dropzone("#dropzone", {
    url: "/images/upload/single",
    params: { _token: CSRF_TOKEN},
    addRemoveLinks: true,
    autoProcessQueue: true,
    parallelUploads: 1,
    acceptedFiles: "image/*",
    dictRemoveFile: "Remove",
    dictDefaultMessage: "Click or drop images here",
    success:function(file, response){
        console.log(response);
        file.serverId = response.id;

        $('#ad-submission-form').append('<input type="hidden" name="img_ids[]" value="'+response.id+'" class="ad-img-ids">');

        this.createThumbnailFromUrl( file, response);
    },
    removedfile: function(file) {
        var thisDropzone = this;
        var name = file.name; 
        console.log(file.additionalInfo);

        $.ajax({
          type: 'POST',
          url: 'images/remove/single',
          data: {_token: CSRF_TOKEN, img_id: file.serverId},
          dataType: "JSON",
          success: function(data){
            console.log(data);
            if(data.status == 200){
                $('#ad-submission-form').find('.ad-img-ids[value="'+file.serverId+'"').remove();
            }
             if(data.status == 404){
                thisDropzone.options.addedfile.call(thisDropzone, file);
                thisDropzone.options.thumbnail.call(thisDropzone, file, file.url);
                thisDropzone.emit('complete', file);
             }
          },
          error: function(er){
              console.log(er)
          }
        });

        var _ref;
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
    },
});

$(document).ready(function () {
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
