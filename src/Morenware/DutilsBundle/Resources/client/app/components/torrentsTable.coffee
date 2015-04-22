template = require './torrentsTable.html'
app.directive 'torrentsTable', [ ->
  template: template,
  restrict: 'E',
  replace: true,
  transclude: true,
  scope: {
    torrents: '='
    fields: '@'
    actions: '@'
    filterState: '@'
  },
  controller: 'searchController'
  link: (scope, iElement, iAttrs, controller) ->
    # specific, private to the table
    scope.fieldLabels = scope.fields.split(',')
    scope.torrentsInState = []

    scope.processField = (torrent, fieldLabel) ->
      processedField = ""
      normalizedFieldLabel = fieldLabel.toLowerCase()

      if normalizedFieldLabel is 'size'
        processedField = if torrent.size? then torrent.size + " MB" else "N/A"
      else if normalizedFieldLabel is 'seeds'
        processedField = if torrent.seeds? then torrent.seeds else 'N/A'
      else if normalizedFieldLabel is 'date'
        processedField = moment(torrent.date, 'YYYY-MM-DD').format('YYYY-MM-DD')
      else
        processedField = torrent[normalizedFieldLabel]
      return processedField

    normalizedFilterState = scope.filterState.toLowerCase()
    negativeState = normalizedFilterState.indexOf("!") > -1
    acceptedStates = normalizedFilterState.split(",")

    angular.forEach scope.torrents.torrents, (value, key) ->
      value.startAction = controller.startDownload
      value.cancelAction = controller.cancelDownload
      return
    return
]
