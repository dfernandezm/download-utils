automatedSearch = require "./components/automatedSearch/automatedSearch"
feeds = require "./components/feeds/feeds"
torrentsStatus = require "./components/torrentsStatus/torrentsStatus"

console.log 'NAME ' + torrentsStatus
app = window.app = angular.module 'dutilsApp', ['ngRoute'
    'ngResource'
    'ui.bootstrap'
    automatedSearch
    feeds
    torrentsStatus
]

app.config ['$routeProvider','$httpProvider','$interpolateProvider', '$compileProvider', ($routeProvider, $httpProvider, $interpolateProvider, $compileProvider) ->
  # Avoid having this header here! - use cookies or token
  # $httpProvider.defaults.headers.common['Authorization'] = 'Basic YWRtaW46YWRtaW5wYXNz'
  $interpolateProvider.startSymbol('[[').endSymbol(']]')
  $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|magnet):/)

  $httpProvider.defaults.transformRequest = (data) ->
    if !data
      return data
    else
      json = angular.toJson data
      if data.name?
        json = "{" + "\"" + data.name + "\": " + json + "}"
        return json
      else
        return json


]
