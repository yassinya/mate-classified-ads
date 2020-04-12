require('./bootstrap');
require('slick-carousel/slick/slick')
import Dropzone from 'dropzone';
import Masonry from 'masonry-layout';

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

Dropzone.autoDiscover = false;

// ad creation form
if($('#ad-submission-form #dropzone').length){
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
                $('#ad-submission-form #submit-btn').prop('disabled', false);      
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

               if(response.validation){
                   showAdSubmissionFormErrors(response.validation)
               }else{
                   // ad was created, but there was an internal error probably in ad creation event listeners
                    $('form').hide();
                    $('form').parent().html('<p class="text-center">There was an internal error</p>')
               }
 
            });
        },
        success:function(file, response){
            console.log(response);
            this.createThumbnailFromUrl( file, response);

            //enable submit button again after img uploading
            console.log(response)
            $('form').hide();
            $('form').parent().html('<p class="text-center">Please check your email and click the link to confirm your ad</p>')
            // $('#ad-submission-form #submit-btn').prop('disabled', false);
        },
        removedfile: function(file) {
   
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
    });
}

// editing ad form
if($('#ad-updating-form #dropzone').length){
    var adId = $('input[name="ad_id"]').val();
    var updatingFormDropzone = new Dropzone("#dropzone", {
        url: "/posts/images/upload/single",
        params: { _token: CSRF_TOKEN, ad_id: adId},
        addRemoveLinks: true,
        autoProcessQueue: true,
        uploadMultiple: false,
        parallelUploads: 1,
        acceptedFiles: "image/*",
        dictRemoveFile: "Remove",
        dictDefaultMessage: "Click or drop images here",
        init: function(){

            var thisDropzone = this;
            $('#dropzone').html(`<div class="loading text-center" style="font-size:26px;">
            <i class="fa fa-spinner fa-spin"></i>
            </div>`)
            $.getJSON('/posts/images/for/'+adId, function(data) {
                $('#dropzone .loading').remove();
                // $('#img-dropzone .loading').remove();
                  $.each(data, function(key,file){  
                      thisDropzone.options.addedfile.call(thisDropzone, file);
                      thisDropzone.options.thumbnail.call(thisDropzone, file, file.url);
                      thisDropzone.emit('complete', file);
                      thisDropzone.files.push(file);
      
                  });
              });
    
        },
        success:function(file, response){
            console.log(response);
            file.serverId = response.id;
            this.createThumbnailFromUrl( file, response);

            $('#errors-wrapper').html('<div class="alert alert-success" id="error">Successfully saved image</div>')
            // $('#ad-submission-form #submit-btn').prop('disabled', false);
        },
        removedfile: function(file) {
   
            var thisDropzone = this;
            var name = file.name;
            console.log(file.additionalInfo);
            $.ajax({
              type: 'POST',
              url: '/posts/images/delete/single',
              data: {
                _token: CSRF_TOKEN,
                img_id: file.serverId
              },
              dataType: "JSON",
              success: function success(data) {
                console.log(data);
        
                if (data.status == 200) {
                    $('#errors-wrapper').html('<div class="alert alert-success" id="error">Successfully deleted image</div>')
                }
        
                if (data.status == 404) {
                  thisDropzone.options.addedfile.call(thisDropzone, file);
                  thisDropzone.options.thumbnail.call(thisDropzone, file, file.url);
                  thisDropzone.emit('complete', file);
                }
            },
            error: function error(er) {
              console.log(er);
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



    // ad submission
    $('#update-btn').on('click', function() {
        var $this = this;
        $($this).html('<i class="fa fa-spinner fa-spin"></i>Updating...')
        $($this).prop('disabled', true)
        console.log('updating ad...')
        var title = $('#ad-updating-form input[name="title"]').val();
        var description = $('#ad-updating-form textarea[name="description"]').val();
        var typeId = $('#ad-updating-form select[name="type_id"] option:selected').val();
        var categoryId = $('#ad-updating-form select[name="category_id"] option:selected').val();
        var cityId = $('#ad-updating-form select[name="city_id"] option:selected').val();
        var email = $('#ad-updating-form input[name="email"]').val();
        var phoneNumber = $('#ad-updating-form input[name="phone_number"]').val();
        var adId = $('#ad-updating-form input[name="ad_id"]').val();

        // console.log(title, description, typeId, categoryId, cityId, email, phoneNumber);

        $('#errors-wrapper #error').remove()


        $.ajax({
            url: "/ads/edit",
            type: "post",
            data: {
                title: title,
                description: description,
                type_id: typeId,
                category_id: categoryId,
                city_id: cityId,
                email: email,
                phone_number: phoneNumber,
                ad_id: adId,
                _token: CSRF_TOKEN
            },
            success: function(response) {
                $($this).html('Update')
                $($this).prop('disabled', false)
                console.log(response)
                if(response.updated){
                    $('#errors-wrapper').html('<div class="alert alert-success" id="error">Successfully updated</div>')
                }
            },
            error: function(error) {
                $($this).html('Update')
                $($this).prop('disabled', false)
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
    })
    
    $('#ad-submission-form #submit-btn').on('click', function() {
        console.log('submitting')
        var $this = this;
        $($this).html('<i class="fa fa-spinner fa-spin"></i>Submitting...')
        $($this).prop('disabled', true)
        var title = $('#ad-submission-form input[name="title"]').val();
        var description = $('#ad-submission-form textarea[name="description"]').val();
        var typeId = $('#ad-submission-form select[name="type_id"] option:selected').val();
        var categoryId = $('#ad-submission-form select[name="category_id"] option:selected').val();
        var cityId = $('#ad-submission-form select[name="city_id"] option:selected').val();
        var email = $('#ad-submission-form input[name="email"]').val();
        var phoneNumber = $('#ad-submission-form input[name="phone_number"]').val();

        console.log(title, description, typeId, categoryId, cityId, email, phoneNumber);

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
                    $($this).html('Submit')
                    $($this).prop('disabled', false)
                    if(response.created){
                        $('form').hide();
                        $('form').parent().append('<p class="text-center">Please check your email and click the link to confirm your ad</p>')
                    }
                },
                error: function(error) {
                    console.log(error)
                    $($this).html('Submit')
                    $($this).prop('disabled', false)
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

$('.list-group-item').on('click', function() {
    $('.fa', this)
      .toggleClass('fa-caret-right')
      .toggleClass('fa-caret-down');
  });