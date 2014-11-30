template = require './adminForm.html'
app.directive 'adminForm', ->
  template: template,
  restrict: 'E',
  replace: true,
  transclude: true,
  scope: false,
  controller: 'feedsController',

  link: (scope, iElement, iAttrs, controller) ->
    fieldNames = iAttrs.fields.split ','
    fields = []

    for fieldName in fieldNames
      field = {
        name: _str.capitalize fieldName
        placeholder: fieldName
        value: null
      }
      fields.push field

    scope.fields = fields
    return
