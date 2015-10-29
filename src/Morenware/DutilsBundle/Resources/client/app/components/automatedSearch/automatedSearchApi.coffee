mod = angular.module('automatedSearchApi', [])

# Careful, if we try to inject in the automatedSearchResource through mod.inject it
# does not work after minification
mod.factory 'AutomatedSearch', ['$resource', require './services/automatedSearchResource']
mod.factory 'automatedSearchFactory', require './services/automatedSearchFactory'

module.exports = mod.name
