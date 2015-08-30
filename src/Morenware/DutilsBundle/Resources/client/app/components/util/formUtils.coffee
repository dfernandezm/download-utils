formUtils = module.exports = {}

formUtils.fillForm = (fields, target) ->
  for field in fields
    field.value = target[field.name]
  return

formUtils.collectValues = (fields, target) ->
  for field in fields
    target[field.name] = field.value
  return

formUtils.clearForm = (fields) ->
  for field in fields
    field.value = null
  return
