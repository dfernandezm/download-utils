template = require './torrentElement.html'
app.directive 'torrentElement', [ "$sce", ($sce) ->
  template: template,
  restrict: 'E',
  replace: true,
  transclude: true,
  scope: {
    torrent: '='
  },
  link: (scope, iElement, iAttrs, controller) ->
    scope.fieldFormat = (field,torrent) ->
      if field is 'size'
        processedField = if torrent.size? then torrent.size + " MB" else ""
      else if field is 'seeds'
        processedField = if torrent.seeds? then torrent.seeds else 'N/A'
      else if field is 'date'
        processedField = moment(torrent.date, 'YYYY-MM-DD').format('YYYY-MM-DD')
      else if field is 'title'
        processedField = torrent.title
      else
        processedField = torrent[field]
      return processedField
    return
]
