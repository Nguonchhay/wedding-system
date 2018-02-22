###################
### Jquery plug in
###################

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
  Image preview
###
$('.image-preview-option').on('change', ->
  previewImage(this)
  return
)

###
  Check whether the input is latin (0-9)
###
isLatinNumber = (keyCode)->
  if keyCode >= 48 and keyCode <= 57
    return true
  return false

###
  Check whether the input is khmer (១-៩)
###
isKhmerNumber = (keyCode)->
  if keyCode >= 6112 and keyCode <= 6121
    return true
  return false

###
  Convert khmer number to latin number
###
convertKhmerToLatinNumber = (number)->
  latinNumber = switch
    when number is '០' then 0
    when number is '១' then 1
    when number is '២' then 2
    when number is '៣' then 3
    when number is '៤' then 4
    when number is '៥' then 5
    when number is '៦' then 6
    when number is '៧' then 7
    when number is '៨' then 8
    when number is '៩' then 9
    else ''

  return latinNumber

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

###
  Recording gif

  Note: By apply this converter, it will restrict the default functionality of updating the between digit of text.
  It means it allows only update the character on the end of text.
###
$(document).find('input.gif-recording').keypress((e)->
  self = $(this)
  char = String.fromCharCode(e.keyCode)
  if isLatinNumber(e.keyCode)
    self.val(self.val() + char)
  else
    if isKhmerNumber(e.keyCode)
      self.val(self.val() + convertKhmerToLatinNumber(char))
    else
      self.val(self.val() + '')
  e.preventDefault()
)

$('#btnWeddingRecordAjax').on('click', ->
  self = $(this)
  weddingInvitation = $("#weddingInvitation option:selected")
  dollar = parseFloat('0' + $('#gift_dollar').val())
  khmer = parseInt('0' + $('#gift_khmer').val())
  other = $('#gift_other').val().trim()

  weddingInvitationId = weddingInvitation.val()
  if weddingInvitationId isnt '' and (dollar isnt 0 or khmer isnt 0 or other isnt '')
    url = $(this).data('action')
    data = {
      weddingInvitation: weddingInvitationId
      dollar: dollar,
      khmer: khmer,
      other: other
    }

    self.attr('disabled', true)

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

          guestRecord = '<tr id="' + weddingInvitationId + '">'
          guestRecord += '<td id="editGiftWedding' + weddingInvitationId + '">' + weddingInvitation.html() + '</td>'
          guestRecord += '<td id="editGiftDollar' + weddingInvitationId + '">' + dollar + '</td>'
          guestRecord += '<td id="editGiftKhmer' + weddingInvitationId + '">' + khmer + '</td>'
          guestRecord += '<td id="editGiftOther' + weddingInvitationId + '">' + other + '</td>'
          guestRecord += '<td><button type="button" class="btn btn-default edit-recorded-gift" id="' + weddingInvitationId + '" class="guest-edit-button btn btn-sm btn-default"><span class="glyphicon glyphicon-pencil"></span></button></td>'
          guestRecord += '</tr>'
          $('#recentRecordedGift tbody tr:first').before(guestRecord)

          self.removeAttr('disabled')

          # Keep only 5 rows in table
          if $('#recentRecordedGift tbody tr').length > 5
            $('#recentRecordedGift tbody tr:last').remove()
        else
          alert('Something went wrong while trying to save gift from guest. Reload the page and try again.')
    })
  else
    alert('Please, input the information.')
)

$('.btnEditGiftClose').on('click', ->
  $('#edit_wedding_invitation').val('')
  $('#edit_gift_dollar').val('')
  $('#edit_gift_khmer').val('')
  $('#edit_gift_other').val('')
  $('#modalEditGift').modal('hide')
)

$('#recentRecordedGift').on('click', '.edit-recorded-gift', ->
  self = $(this)
  selectedWeddingInvitationId = self.attr('id')
  $('#editGuest').html($('#editGiftWedding' + selectedWeddingInvitationId).html())
  $('#edit_wedding_invitation').val(selectedWeddingInvitationId)
  $('#edit_gift_dollar').val($('#editGiftDollar' + selectedWeddingInvitationId).html())
  $('#edit_gift_khmer').val($('#editGiftKhmer' + selectedWeddingInvitationId).html())
  $('#edit_gift_other').val($('#editGiftOther' + selectedWeddingInvitationId).html())
  $('#modalEditGift').modal('show')
)

$('#btnEditGift').on('click', ->
  weddingInvitationId = $('#edit_wedding_invitation').val()
  dollar = parseFloat('0' +  $('#edit_gift_dollar').val())
  khmer = parseInt('0' + $('#edit_gift_khmer').val())
  other = $('#edit_gift_other').val()
  if dollar is 0 and khmer is 0 and other is ''
    alert('Please, input the information. If you do not want to keep the same value, just close this form.')
  else
    url = $(this).data('action')
    data = {
      weddingInvitation: weddingInvitationId,
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
          $('#editGiftDollar' + weddingInvitationId).html($('#edit_gift_dollar').val())
          $('#editGiftKhmer' + weddingInvitationId).html($('#edit_gift_khmer').val())
          $('#editGiftOther' + weddingInvitationId).html($('#edit_gift_other').val())
          $('.btnEditGiftClose').click()
        else
          alert('Something went wrong while trying to update gift from guest.')
    })
)

###
  Summary of wedding book
###
weddingTotalGif = (dollarIndex, KhmerIndex, search)->
  totalDollar = 0.0
  totalKhmer = 0

  if $('#weddingBook').length
    weddingBook = $('#weddingBook').DataTable()

    if search is ''
      weddingBook.column(dollarIndex).data().each((data)->
        totalDollar += parseFloat(data)
      )

      weddingBook.column(KhmerIndex).data().each((data)->
        totalKhmer += parseInt(data)
      )
    else
      weddingBook.column(dollarIndex, {'search': 'applied'}).data().each((data)->
        totalDollar += parseFloat(data)
      )

      weddingBook.column(KhmerIndex, {'search': 'applied'}).data().each((data)->
        totalKhmer += parseInt(data)
      )

  $('#totalDollar').html(totalDollar)
  $('#totalKhmer').html(totalKhmer)

weddingTotalGif(4, 5, '')

###
  Trigger Search box event of wedding book DataTable
###
$('#weddingBook_filter input[type="search"]').on('keyup', (event)->
  searchValue = $(this).val() + ''
  weddingTotalGif(4,5, searchValue)
)