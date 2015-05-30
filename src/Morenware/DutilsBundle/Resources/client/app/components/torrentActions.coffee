template = require './torrentActions.html'
app.directive 'torrentActions', [ ->
  template: template,
  restrict: 'E',
  replace: true,
  transclude: true,
  scope: {
    torrent: '='
  },
  controller: 'torrentController'
  link: (scope, iElement, iAttrs, controller) ->
    return
]
