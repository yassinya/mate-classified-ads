require('./bootstrap');
require('slick-carousel/slick/slick')
import Dropzone from 'dropzone';
import Masonry from 'masonry-layout';

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

Dropzone.autoDiscover = false;

if($('#dropzone').length){
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
}

$(document).ready(function () {
    $('.logout').on('click', function () {
        console.log('logging out...');
        $.post("/logout", {
            _token: CSRF_TOKEN,
        }).done(function () {
            location.reload();
        }).fail(function () {
            location.reload();
        });
    });

    $( "#filter-ads-btn" ).click(function() {
        $( ".filter-ads" ).slideToggle( "slow", function() {
            //
        });
      });

    $("#region-selector" ).click(function() {
        // get selected region slug
        var region = $(this).find('option:selected').val(); 
        // put back city options in #city-container under city selector
        $("#cities-container").children().appendTo("#city-selector");
        // get city options that doen't belong to the selected region
        var citiesToHide = $("#city-selector").children(".cities[data-region!='"+region+"']");
        // move them under #cities-container
        citiesToHide.appendTo("#cities-container"); 
        if(region != 'all'){
            $("#city-selector").removeAttr("disabled");
        }else{
            $("#city-selector").prop("disabled", true);
        }
      });

      $('.slider-for').slick({
        arrows: true,
        fade: true,
        mobileFirst: true
      });

      var elem = document.querySelector('.grid');
      var msnry = new Masonry( elem, {
        // options
        itemSelector: '.grid-item',
        columnWidth: 200,
      });

      // element argument can be a selector string
      //   for an individual element
      var msnry = new Masonry( '.grid', {
        // options
      });


      $('#category-selector').change(function() {
        var categorySlug = $(this).find('option:selected').val();
        if(categorySlug == '-'){
            window.location.href = window.location.origin+window.location.search;
        }else{
            window.location.href = window.location.origin+"/categories/show/"+categorySlug+window.location.search;
        }
    });

});
