mod = angular.module('feedsApi', [])

mod.factory 'Feed', require './services/feedResource'
mod.factory 'feedService', require './services/feedService'

module.exports = mod.name
