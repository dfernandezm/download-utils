template = require './torrentsElements.html'
app.directive 'torrentsElements', [ "$sce", ($sce) ->
  template: template,
  restrict: 'E',
  replace: true,
  transclude: true,
  scope: {
    torrents: '='
    filterState: '@'
  },
  link: (scope, iElement, iAttrs, controller) ->
    return
]
