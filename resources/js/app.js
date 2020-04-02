require('./bootstrap');
require('slick-carousel/slick/slick')
import Dropzone from 'dropzone';
import Masonry from 'masonry-layout';

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

Dropzone.autoDiscover = false;

if($('#dropzone').length){
    var dropzone = new Dropzone("#dropzone", {
        url: "/ads/submit",
        params: { _token: CSRF_TOKEN},
        addRemoveLinks: true,
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 5,
        acceptedFiles: "image/*",
        dictRemoveFile: "Remove",
        dictDefaultMessage: "Click or drop images here",
        init: function(){
            this.on('sendingmultiple', function(file, xhr, formData) {
                // disable submit button while images are being uploaded
                $('#ad-submission-form #submit-btn').prop('disabled', true);    
                // Append all form inputs to the formData Dropzone will POST
                var data = $('#ad-submission-form').serializeArray();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
            });

            this.on('errormultiple',function(files, response){
                console.log(response)
                var dropzoneFilesCopy = files.slice(0);
                dropzone.removeAllFiles();
                $.each(dropzoneFilesCopy, function(_, file) {
                   if (file.status === Dropzone.ERROR) {
                        file.status = undefined;
                        file.accepted = undefined;
                   }
                   dropzone.addFile(file);
               });

               showAdSubmissionFormErrors(response.validation)
               $('#ad-submission-form #submit-btn').prop('disabled', false);       
            });
        },
        success:function(file, response){
            console.log(response);
            this.createThumbnailFromUrl( file, response);

            //enable submit button again after img uploading
            console.log(response)
            $('form').hide();
            $('form').parent().append('<p class="text-center">Please check your email and click the link to confirm your ad</p>')
            // $('#ad-submission-form #submit-btn').prop('disabled', false);
        },
        removedfile: function(file) {
   
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



    // ad submission
    $('#ad-submission-form #submit-btn').on('click', function() {
        console.log('submitting')
        var title = $('#ad-submission-form input[name="title"]').val();
        var description = $('#ad-submission-form textarea[name="description"]').val();
        var typeId = $('#ad-submission-form select[name="type_id"] option:selected').val();
        var categoryId = $('#ad-submission-form select[name="category_id"] option:selected').val();
        var cityId = $('#ad-submission-form select[name="city_id"] option:selected').val();
        var email = $('#ad-submission-form input[name="email"]').val();
        var phoneNumber = $('#ad-submission-form input[name="phone_number"]').val();

        // console.log(title, description, typeId, categoryId, cityId, email, phoneNumber);

        $('#errors-wrapper #error').remove()
        if(categoryId == '-'){
            $('#errors-wrapper').append('<div class="alert alert-danger" id="error"><i class="fas fa-info"></i> Please pick a category<br></div>');
            return;
        }

        if(cityId == '-'){
            $('#errors-wrapper').append('<div class="alert alert-danger" id="error"><i class="fas fa-info"></i> Please pick a city<br></div>');
            return;
        }

        if(typeId == '-'){
            $('#errors-wrapper').append('<div class="alert alert-danger" id="error"><i class="fas fa-info"></i> Please specify type of ad<br></div>');
            return;
        }


        if(dropzone.files.length > 0){
            dropzone.processQueue();
        }else{
            $.ajax({
                url: "/ads/submit",
                type: "post",
                data: {
                    title: title,
                    description: description,
                    type_id: typeId,
                    category_id: categoryId,
                    city_id: cityId,
                    email: email,
                    phone_number: phoneNumber,
                    _token: CSRF_TOKEN
                },
                success: function(response) {
                    console.log(response)
                    if(response.created){
                        $('form').hide();
                        $('form').parent().append('<p class="text-center">Please check your email and click the link to confirm your ad</p>')
                    }
                },
                error: function(error) {
                    console.log(error)
                    if(error.responseJSON.validation){
                        showAdSubmissionFormErrors(error.responseJSON.validation);
                    }
                    if(error.responseJSON.error){
                        // alert(error.responseJSON.error)
                        $('#errors-wrapper').append('<div class="alert alert-danger" id="error"><i class="fas fa-info"></i> '+error.responseJSON.error+'<br></div>')
                    }
                },
            });
        }
    })


    // img previewing
    $('.images img').on('mouseenter', function(evt){
        var originalImg = $(this).data('full-size');
        console.log(evt.pageX, evt.pageY);
        $('#thumb-preview').attr('src', originalImg);
        $('#thumb-preview').css({left: evt.pageX+30, top: evt.pageY-150}).show();
        $(this).on('mouseleave', function(){
            $('#thumb-preview').hide();
        });
    });

});


function showAdSubmissionFormErrors(errors){
    let elements = '';
    $('#errors-wrapper').append('<div class="alert alert-danger" id="error"></div>')
    Object.keys(errors).forEach(function(key) {
        elements += '<i class="fas fa-info"></i> '+errors[key][0]+'<br>';
    });
    $('#errors-wrapper #error').html(elements)
}