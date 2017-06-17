
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


  /*
    Remove image button action
   */

  $('.btn-delete-image').on('click', function() {
    var image, self, storeDelete;
    self = $(this);
    storeDelete = self.nextAll('.store-delete');
    image = self.parent('.existImage').nextAll('.image-preview-option');
    if (parseInt(storeDelete.val())) {
      storeDelete.val('0');
      image.addClass('hide');
      image.val('');
      self.children('i.fa').addClass('fa-times');
      self.children('i.fa').removeClass('fa-recycle');
      self.nextAll('.image-preview').removeClass('hide');
      $('.new-image-preview').addClass('hide');
      $('.new-image-preview').attr('src', '#');
    } else {
      storeDelete.val('1');
      image.removeClass('hide');
      self.children('i.fa').removeClass('fa-times');
      self.children('i.fa').addClass('fa-recycle');
      self.nextAll('.image-preview').addClass('hide');
    }
  });

}).call(this);
