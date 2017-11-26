#############################################
### Jquery plug in
#############################################

###
  Only digit
###
jQuery.fn.onlyDigit = ->
  return this.each( ->
    $(this).on('keypress', (e) ->
      input = String.fromCharCode(e.which)
      return /^[\d\.]$/.test(input)
    )
  )

###
  Only number without period (.)
###
jQuery.fn.onlyNumber = ->
  return this.each(->
    jQuery(this).on('keypress', (e) ->
      input = String.fromCharCode(e.which)
      return /^[\d\s]+$/.test(input)
    )
  )

###
  DatePicker
###
$('.date-picker').datepicker({
  format: 'yyyy-mm-dd'
})

###
  Apply global format
###

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$('.only-digit').onlyDigit()

$('.only-number').onlyNumber()

$('.selectpicker').select2();

###
  List jquery datatable
###
$('.list-data').DataTable()

###
  Add preview image before uploading
###
previewImage = (input)->
  imagePreview = $(input).nextAll('.' + $(input).data('image-preview'))
  if input.files and input.files[0]
    reader = new FileReader()
    reader.onload = (e)->
      imagePreview.attr('src', e.target.result)
      imagePreview.removeClass('hide')
      return
    reader.readAsDataURL(input.files[0])
  else
    imagePreview.addClass('hide')
  return
###
  Clear gift recording status
###
giftMessage = (msg)->
  $('.message').html(msg)

###
  Image preview
###
$('.image-preview-option').on('change', ->
  previewImage(this)
  return
)

###
  Remove image button action
###
$('.btn-delete-image').on('click', ->
  self = $(this)
  storeDelete = self.nextAll('.store-delete')
  image = self.parent('.existImage').nextAll('.image-preview-option')
  if parseInt(storeDelete.val())
    storeDelete.val('0')
    image.addClass('hide')
    image.val('')
    self.children('i.fa').addClass('fa-times')
    self.children('i.fa').removeClass('fa-recycle')
    self.nextAll('.image-preview').removeClass('hide')
    $('.new-image-preview').addClass('hide')
    $('.new-image-preview').attr('src', '#')
  else
    storeDelete.val('1')
    image.removeClass('hide')
    self.children('i.fa').removeClass('fa-times')
    self.children('i.fa').addClass('fa-recycle')
    self.nextAll('.image-preview').addClass('hide')
  return
)

$('#formUserCreate').on('submit', (e)->
  password = $('#userPassword').val()
  confirmPassword = $('#userConfirmPassword').val()

  if password.length < 8 or confirmPassword < 8
    alert('You have to input at least 8 characters.')
    e.preventDefault()
    return false
  else if (password isnt confirmPassword)
    alert('Password and confirm password must be the same')
    e.preventDefault()
    return false
)

$('#formUserEdit').on('submit', (e)->
  password = $('#userPassword').val()
  confirmPassword = $('#userConfirmPassword').val()

  if password isnt '' or confirmPassword isnt ''
    if password.length < 8 or confirmPassword < 8
      alert('You have to input at least 8 characters.')
      e.preventDefault()
      return false
    else if (password isnt confirmPassword)
      alert('Password and confirm password must be the same')
      e.preventDefault()
      return false
)

$('#formUploadGuest').on('submit', ->
  $(this).find(":submit").prop('disabled', true)
)

$('.checkbox-all-guest').on('click', ->
  guests = $('.checkbox-guest')
  if $(this).is(':checked')
    guests.prop('checked', true)
  else
    guests.prop('checked', false)
)

$('#formInviteGuest').on('submit', (e)->
  if $('.checkbox-guest:checked').length is 0
    alert('Please select at least one guest.')
    e.preventDefault()
    return false
)

$('#isInviteImportingGuest').on('click', ->
  weddingForGuest = $('.wedding-for-guest')
  if $(this).is(':checked')
    weddingForGuest.removeClass('hide')
  else
    weddingForGuest.addClass('hide')
)

$('#weddingInvitation').on('change', ->
  giftMessage('')
)

$('#gift_khmer').on('blur', ->
  self = $(this)
  giftKhmer = self.val()
  if parseInt(self.val()) > 0
    self.val(self.val() + '0000')
)

$('#gift_khmer').on('focus', ->
  self = $(this)
  giftKhmer = self.val()
  if parseInt(self.val()) > 0
    self.val(giftKhmer.slice(0, -4))
)

$('#btnWeddingRecordAjax').on('click', ->
  weddingInvitation = $("#weddingInvitation option:selected").val()
  dollar = parseFloat('0' + $('#gift_dollar').val())
  khmer = parseInt('0' + $('#gift_khmer').val())
  other = $('#gift_other').val()

  if weddingInvitation is '' and dollar is 0 and khmer is 0 and other is ''
    alert('Please, input the information.')
  else
    giftMessage('')
    url = $(this).data('action')
    data = {
      weddingInvitation: weddingInvitation
      dollar: dollar,
      khmer: khmer,
      other: other
    }

    $.ajax({
      url: url,
      data: data,
      type: 'POST',
      datatype: 'JSON',
      success: (response)->
        if response.status is 200
          $("#weddingInvitation option:selected").remove()
          $('#gift_dollar').val('')
          $('#gift_khmer').val('')
          $('#gift_other').val('')
          giftMessage('The gift was saved successfully.')
        else
          alert('Something went wrong while trying to save gift from guest. Reload the page and try again.')
    })
)