
/* Jquery plug in
 */


/*
  Only digit
 */

(function() {
  var previewImage;

  jQuery.fn.onlyDigit = function() {
    return this.each(function() {
      return $(this).on('keypress', function(e) {
        var input;
        input = String.fromCharCode(e.which);
        return /^[\d\.]$/.test(input);
      });
    });
  };


  /*
    DatePicker
   */

  $('.date-picker').datepicker({
    format: 'yyyy-mm-dd'
  });


  /*
    Apply global format
   */

  $('.only-digit').onlyDigit();


  /*
    List jquery datatable
   */

  $('.list-data').DataTable();


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

  $('#formUserCreate').on('submit', function(e) {
    var confirmPassword, password;
    password = $('#userPassword').val();
    confirmPassword = $('#userConfirmPassword').val();
    if (password.length < 8 || confirmPassword < 8) {
      alert('You have to input at least 8 characters.');
      e.preventDefault();
      return false;
    } else if (password !== confirmPassword) {
      alert('Password and confirm password must be the same');
      e.preventDefault();
      return false;
    }
  });

  $('#formUserEdit').on('submit', function(e) {
    var confirmPassword, password;
    password = $('#userPassword').val();
    confirmPassword = $('#userConfirmPassword').val();
    if (password !== '' || confirmPassword !== '') {
      if (password.length < 8 || confirmPassword < 8) {
        alert('You have to input at least 8 characters.');
        e.preventDefault();
        return false;
      } else if (password !== confirmPassword) {
        alert('Password and confirm password must be the same');
        e.preventDefault();
        return false;
      }
    }
  });

  $('#formUploadGuest').on('submit', function() {
    return $(this).find(":submit").prop('disabled', true);
  });

}).call(this);
