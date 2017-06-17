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