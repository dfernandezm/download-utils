template = require './adminForm.html'
app.directive 'adminForm', ->
  template: template,
  restrict: 'E',
  replace: true,
  transclude: true,
  scope: {
    object: '@'
  },
  controller: ($scope, $element, $attrs, $injector) ->
    $scope.submitText = "Add "
    $scope.title = "Admin " +  " Form"
    $scope.save = ->
      object = $scope.object
      toSave = $scope.obj
      return
  ,
  link: (scope, iElement, iAttrs, controller) ->
    fieldNames = iAttrs.fields.split ','
    fields = []

    for fieldName in fieldNames
      field = {
        name: _str.capitalize fieldName
        placeholder: fieldName + " Placeholder"
      }
      fields.push field

    scope.fields = fields
    return
