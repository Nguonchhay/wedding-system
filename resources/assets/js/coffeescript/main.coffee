###
  DatePicker
###
$('.date-picker').datepicker({
  format: 'yyyy-mm-dd'
})

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