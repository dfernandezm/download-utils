searchApi = require '../searchApi'
searchUtils = require '../services/searchUtils'

template = require './search.html'
mod = angular
      .module('search-directive',[searchApi])
      .directive 'search', [ 'searchService', (searchService)  ->
        restrict: 'E'
        replace: true
        transclude: false
        template: template
        scope: {}
        link: (scope) ->

          scope.searchSites = (require './searchSites.json').searchSites
          scope.buttonText = "Download"

          scope.loading = false
          scopeUpdateClosures = {}

          scopeUpdateClosures.success = (torrentsInfo) ->
            scope.torrents = torrentsInfo.torrents
            scope.query = torrentsInfo.query
            scope.limit = torrentsInfo.limit
            scope.offset = torrentsInfo.offset
            scope.currentOffset = torrentsInfo.currentOffset
            scope.total = torrentsInfo.total
            scope.searchFinished = true
            scope.loading = false
            return

          scopeUpdateClosures.error = (responseData) ->
            scope.errors = { data: responseData }
            scope.loading = false
            scope.errored = true
            return

          scope.search = (searchQuery) ->
            scope.loading = true
            searchQuery = scope.query
            
            # returns objects on the list with the property indicated
            sites = _.where scope.searchSites, {selected: true}
            sitesParam = searchUtils.computeSitesParam(sites)

            searchService.searchTorrents(searchQuery, sitesParam, scopeUpdateClosures)
            return

          return

      ]

module.exports = mod.name
