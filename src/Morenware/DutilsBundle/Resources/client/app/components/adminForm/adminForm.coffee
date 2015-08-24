template = require './adminForm.html'
app.directive 'adminForm', ->
  template: template,
  restrict: 'E',
  replace: true,
  transclude: true,
  scope: {
    fields: '='
    submitText: '='
    formTitle: '=title'
    submitAction: '&'
  },

  link: (scope, iElement, iAttrs, controller) ->
    filledFields = []
    return