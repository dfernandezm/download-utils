mod = angular.module('automatedSearchApi', [])

mod.factory 'AutomatedSearch', require './services/automatedSearchResource'
mod.factory 'automatedSearchFactory', require './services/automatedSearchFactory'

module.exports = mod.name
