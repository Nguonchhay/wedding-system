
/* Jquery plug in
 */


/*
  Only digit
 */

(function() {
  var convertKhmerToLatinNumber, isKhmerNumber, isLatinNumber, previewImage, weddingTotalGif;

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
    Image preview
   */

  $('.image-preview-option').on('change', function() {
    previewImage(this);
  });


  /*
    Check whether the input is latin (0-9)
   */

  isLatinNumber = function(keyCode) {
    if (keyCode >= 48 && keyCode <= 57) {
      return true;
    }
    return false;
  };


  /*
    Check whether the input is khmer (១-៩)
   */

  isKhmerNumber = function(keyCode) {
    if (keyCode >= 6112 && keyCode <= 6121) {
      return true;
    }
    return false;
  };


  /*
    Convert khmer number to latin number
   */

  convertKhmerToLatinNumber = function(number) {
    var latinNumber;
    latinNumber = (function() {
      switch (false) {
        case number !== '០':
          return 0;
        case number !== '១':
          return 1;
        case number !== '២':
          return 2;
        case number !== '៣':
          return 3;
        case number !== '៤':
          return 4;
        case number !== '៥':
          return 5;
        case number !== '៦':
          return 6;
        case number !== '៧':
          return 7;
        case number !== '៨':
          return 8;
        case number !== '៩':
          return 9;
        default:
          return '';
      }
    })();
    return latinNumber;
  };


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


  /*
    Recording gif
  
    Note: By apply this converter, it will restrict the default functionality of updating the between digit of text.
    It means it allows only update the character on the end of text.
   */

  $(document).find('input.gif-recording').keypress(function(e) {
    var char, self;
    self = $(this);
    char = String.fromCharCode(e.keyCode);
    if (isLatinNumber(e.keyCode)) {
      self.val(self.val() + char);
    } else {
      if (isKhmerNumber(e.keyCode)) {
        self.val(self.val() + convertKhmerToLatinNumber(char));
      } else {
        self.val(self.val() + '');
      }
    }
    return e.preventDefault();
  });

  $('#btnWeddingRecordAjax').on('click', function() {
    var data, dollar, khmer, other, self, url, weddingInvitation, weddingInvitationId;
    self = $(this);
    weddingInvitation = $("#weddingInvitation option:selected");
    dollar = parseFloat('0' + $('#gift_dollar').val());
    khmer = parseInt('0' + $('#gift_khmer').val());
    other = $('#gift_other').val().trim();
    weddingInvitationId = weddingInvitation.val();
    if (weddingInvitationId !== '' && (dollar !== 0 || khmer !== 0 || other !== '')) {
      url = $(this).data('action');
      data = {
        weddingInvitation: weddingInvitationId,
        dollar: dollar,
        khmer: khmer,
        other: other
      };
      self.attr('disabled', true);
      return $.ajax({
        url: url,
        data: data,
        type: 'POST',
        datatype: 'JSON',
        success: function(response) {
          var guestRecord;
          if (response.status === 200) {
            $("#weddingInvitation option:selected").remove();
            $('#gift_dollar').val('');
            $('#gift_khmer').val('');
            $('#gift_other').val('');
            guestRecord = '<tr id="' + weddingInvitationId + '">';
            guestRecord += '<td id="editGiftWedding' + weddingInvitationId + '">' + weddingInvitation.html() + '</td>';
            guestRecord += '<td id="editGiftDollar' + weddingInvitationId + '">' + dollar + '</td>';
            guestRecord += '<td id="editGiftKhmer' + weddingInvitationId + '">' + khmer + '</td>';
            guestRecord += '<td id="editGiftOther' + weddingInvitationId + '">' + other + '</td>';
            guestRecord += '<td><button type="button" class="btn btn-default edit-recorded-gift" id="' + weddingInvitationId + '" class="guest-edit-button btn btn-sm btn-default"><span class="glyphicon glyphicon-pencil"></span></button></td>';
            guestRecord += '</tr>';
            $('#recentRecordedGift tbody tr:first').before(guestRecord);
            self.removeAttr('disabled');
            if ($('#recentRecordedGift tbody tr').length > 5) {
              return $('#recentRecordedGift tbody tr:last').remove();
            }
          } else {
            return alert('Something went wrong while trying to save gift from guest. Reload the page and try again.');
          }
        }
      });
    } else {
      return alert('Please, input the information.');
    }
  });

  $('.btnEditGiftClose').on('click', function() {
    $('#edit_wedding_invitation').val('');
    $('#edit_gift_dollar').val('');
    $('#edit_gift_khmer').val('');
    $('#edit_gift_other').val('');
    return $('#modalEditGift').modal('hide');
  });

  $('#recentRecordedGift').on('click', '.edit-recorded-gift', function() {
    var selectedWeddingInvitationId, self;
    self = $(this);
    selectedWeddingInvitationId = self.attr('id');
    $('#editGuest').html($('#editGiftWedding' + selectedWeddingInvitationId).html());
    $('#edit_wedding_invitation').val(selectedWeddingInvitationId);
    $('#edit_gift_dollar').val($('#editGiftDollar' + selectedWeddingInvitationId).html());
    $('#edit_gift_khmer').val($('#editGiftKhmer' + selectedWeddingInvitationId).html());
    $('#edit_gift_other').val($('#editGiftOther' + selectedWeddingInvitationId).html());
    return $('#modalEditGift').modal('show');
  });

  $('#btnEditGift').on('click', function() {
    var data, dollar, khmer, other, url, weddingInvitationId;
    weddingInvitationId = $('#edit_wedding_invitation').val();
    dollar = parseFloat('0' + $('#edit_gift_dollar').val());
    khmer = parseInt('0' + $('#edit_gift_khmer').val());
    other = $('#edit_gift_other').val();
    if (dollar === 0 && khmer === 0 && other === '') {
      return alert('Please, input the information. If you do not want to keep the same value, just close this form.');
    } else {
      url = $(this).data('action');
      data = {
        weddingInvitation: weddingInvitationId,
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
            $('#editGiftDollar' + weddingInvitationId).html($('#edit_gift_dollar').val());
            $('#editGiftKhmer' + weddingInvitationId).html($('#edit_gift_khmer').val());
            $('#editGiftOther' + weddingInvitationId).html($('#edit_gift_other').val());
            return $('.btnEditGiftClose').click();
          } else {
            return alert('Something went wrong while trying to update gift from guest.');
          }
        }
      });
    }
  });


  /*
    Summary of wedding book
   */

  weddingTotalGif = function(dollarIndex, KhmerIndex, search) {
    var totalDollar, totalKhmer, weddingBook;
    totalDollar = 0.0;
    totalKhmer = 0;
    if ($('#weddingBook').length) {
      weddingBook = $('#weddingBook').DataTable();
      if (search === '') {
        weddingBook.column(dollarIndex).data().each(function(data) {
          return totalDollar += parseFloat(data);
        });
        weddingBook.column(KhmerIndex).data().each(function(data) {
          return totalKhmer += parseInt(data);
        });
      } else {
        weddingBook.column(dollarIndex, {
          'search': 'applied'
        }).data().each(function(data) {
          return totalDollar += parseFloat(data);
        });
        weddingBook.column(KhmerIndex, {
          'search': 'applied'
        }).data().each(function(data) {
          return totalKhmer += parseInt(data);
        });
      }
    }
    $('#totalDollar').html(totalDollar);
    return $('#totalKhmer').html(totalKhmer);
  };

  weddingTotalGif(4, 5, '');


  /*
    Trigger Search box event of wedding book DataTable
   */

  $('#weddingBook_filter input[type="search"]').on('keyup', function(event) {
    var searchValue;
    searchValue = $(this).val() + '';
    return weddingTotalGif(4, 5, searchValue);
  });

}).call(this);
