
/* Jquery plug in
 */


/*
  Only digit
 */

(function() {
  var giftMessage, previewImage;

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
    Only number without period (.)
   */

  jQuery.fn.onlyNumber = function() {
    return this.each(function() {
      return jQuery(this).on('keypress', function(e) {
        var input;
        input = String.fromCharCode(e.which);
        return /^[\d\s]+$/.test(input);
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

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('.only-digit').onlyDigit();

  $('.only-number').onlyNumber();

  $('.selectpicker').select2();


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
    Clear gift recording status
   */

  giftMessage = function(msg) {
    return $('.message').html(msg);
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

  $('.checkbox-all-guest').on('click', function() {
    var guests;
    guests = $('.checkbox-guest');
    if ($(this).is(':checked')) {
      return guests.prop('checked', true);
    } else {
      return guests.prop('checked', false);
    }
  });

  $('#formInviteGuest').on('submit', function(e) {
    if ($('.checkbox-guest:checked').length === 0) {
      alert('Please select at least one guest.');
      e.preventDefault();
      return false;
    }
  });

  $('#isInviteImportingGuest').on('click', function() {
    var weddingForGuest;
    weddingForGuest = $('.wedding-for-guest');
    if ($(this).is(':checked')) {
      return weddingForGuest.removeClass('hide');
    } else {
      return weddingForGuest.addClass('hide');
    }
  });

  $('#weddingInvitation').on('change', function() {
    return giftMessage('');
  });

  $('#gift_khmer').on('blur', function() {
    var giftKhmer, self;
    self = $(this);
    giftKhmer = self.val();
    if (parseInt(self.val()) > 0) {
      return self.val(self.val() + '0000');
    }
  });

  $('#gift_khmer').on('focus', function() {
    var giftKhmer, self;
    self = $(this);
    giftKhmer = self.val();
    if (parseInt(self.val()) > 0) {
      return self.val(giftKhmer.slice(0, -4));
    }
  });

  $('#btnWeddingRecordAjax').on('click', function() {
    var data, dollar, khmer, other, url, weddingInvitation;
    weddingInvitation = $("#weddingInvitation option:selected").val();
    dollar = parseFloat('0' + $('#gift_dollar').val());
    khmer = parseInt('0' + $('#gift_khmer').val());
    other = $('#gift_other').val();
    if (weddingInvitation === '' && dollar === 0 && khmer === 0 && other === '') {
      return alert('Please, input the information.');
    } else {
      giftMessage('');
      url = $(this).data('action');
      data = {
        weddingInvitation: weddingInvitation,
        dollar: dollar,
        khmer: khmer,
        other: other
      };
      return $.ajax({
        url: url,
        data: data,
        type: 'POST',
        datatype: 'JSON',
        success: function(response) {
          if (response.status === 200) {
            $("#weddingInvitation option:selected").remove();
            $('#gift_dollar').val('');
            $('#gift_khmer').val('');
            $('#gift_other').val('');
            return giftMessage('The gift was saved successfully.');
          } else {
            return alert('Something went wrong while trying to save gift from guest. Reload the page and try again.');
          }
        }
      });
    }
  });

}).call(this);
