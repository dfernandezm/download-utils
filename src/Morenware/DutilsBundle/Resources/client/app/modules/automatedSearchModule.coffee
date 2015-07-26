# require ui.bootstrap, angular
# require common admin directives
# require "common/bootstrap.coffee"
require '../controllers/automatedSearchController.coffee'

#automatedSearchController = require('automatedSearchController')

mod = angular.module 'automatedSearch', ['ngRoute', 'ngResource', 'ui.bootstrap']

# This should be in a common config module which it will be required from here
mod.config ['$routeProvider','$httpProvider','$interpolateProvider', '$compileProvider', ($routeProvider, $httpProvider, $interpolateProvider, $compileProvider) ->

  # Change {{}} with [[]] due to clash with twig templating
  $interpolateProvider.startSymbol('[[').endSymbol(']]')

  # Allow magnet links to be trusted by angular
  $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|magnet):/)

  # For resource CRUD, every json POST will be prepended with a 'name' for the entity
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

mod.controller('automatedSearchController', automatedSearchController);

module.exports = mod.name
