app = window.app = angular.module 'dutilsApp', ['ngRoute', 'ngResource']

app.config ['$routeProvider','$httpProvider','$interpolateProvider', '$compileProvider', ($routeProvider, $httpProvider, $interpolateProvider, $compileProvider) ->

  $httpProvider.defaults.headers.common['Authorization'] = 'Basic YWRtaW46YWRtaW5wYXNz'
  $interpolateProvider.startSymbol('[[').endSymbol(']]')
  $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|magnet):/)

  $httpProvider.defaults.transformRequest = (data) ->
    if !data
      return data
    else
      json = angular.toJson data
      if data.name?
        json = "{" + data.name + ": " + JSON.stringify(json) + "}"
        return JSON.parse(json)
      else
        return json


]