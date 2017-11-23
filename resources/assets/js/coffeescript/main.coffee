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
  DatePicker
###
$('.date-picker').datepicker({
  format: 'yyyy-mm-dd'
})

###
  Apply global format
###
$('.only-digit').onlyDigit()

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