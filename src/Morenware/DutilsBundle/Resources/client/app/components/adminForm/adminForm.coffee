template = require './adminForm.html'
mod = angular
  .module("adminForm-directive", [])
  .directive 'adminForm', ->
    template: template,
    restrict: 'E',
    replace: true,
    transclude: false,
    scope: {
      fields: '='
      submitText: '='
      formTitle: '=title'
      submitAction: '&'
    },
    link: (scope) ->
      console.log ("Calling link in the adminForm")
      # collectValues = (target) ->
      #   for field in scope.fields
      #     target[field.name] = field.value
      #   return
      #
      # clearForm = ->
      #   for field in scope.fields
      #     field.value = null
      #   return
      #
      # scope.submitForm = (target)->
      #   collectValues(target)
      #   scope.submitAction(target)
      #   return
      return

module.exports = mod.name
