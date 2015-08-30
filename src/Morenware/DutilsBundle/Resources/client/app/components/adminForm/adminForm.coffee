template = require './adminForm.html'
mod = angular
  .module("adminForm-directive", [])
  .directive 'adminForm', ->
    template: template,
    restrict: 'E',
    replace: true,
    transclude: true,
    scope: {
      fields: '='
      submitText: '='
      formTitle: '=title'
      submitAction: '&'
    },
    link: (scope) ->
        #    filledFields = []
        #      return

module.exports = mod.name
