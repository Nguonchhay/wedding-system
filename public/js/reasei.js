
/*
  DatePicker
 */

(function() {
  var previewImage;

  $('.date-picker').datepicker({
    format: 'yyyy-mm-dd'
  });


  /*
    Add preview image before uploading
   */

  previewImage = function(input) {
    var imagePreview, reader;
    imagePreview = $(input).nextAll('.' + $(input).data('image-preview'));
    if (input.files && input.files[0]) {
      reader = new FileReader();
      reader.onload = function(e) {
        imagePreview.attr('src', e.target.result);
        imagePreview.removeClass('hide');
      };
      reader.readAsDataURL(input.files[0]);
    } else {
      imagePreview.addClass('hide');
    }
  };


  /*
    Image preview
   */

  $('.image-preview-option').on('change', function() {
    previewImage(this);
  });

}).call(this);
