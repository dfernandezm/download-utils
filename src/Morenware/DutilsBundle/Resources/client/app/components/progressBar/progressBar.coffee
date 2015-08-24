template = require './progressBar.html'
app.directive 'progressBar', [ ->
  template: template,
  restrict: 'E',
  replace: true,
  transclude: true,
  scope: {
   percent: '='
  },
  link: (scope, iElement, iAttrs, controller) ->
    return
]
