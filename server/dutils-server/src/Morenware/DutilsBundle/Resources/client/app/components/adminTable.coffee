template = require './adminTable.html'
app.directive 'adminTable', ->
  template: template,
  restrict: 'E',
  replace: true,
  transclude: true,
  scope: {
    items: '='
    fields: '=' # Maybe One way value

    # Pass in a function (Angular expression) which will be evaluated in the parent scope (see template)
    # With this we decouple the actual action to update (so we can put it in any controller) from this instance of table
    updateAction: '&'
  },
  controller: ($scope, $element, $attrs, $injector) ->
    # Here, behaviour common for all tables
    # Move this code to link!!
    return
  link: (scope, iElement, iAttrs, controller) ->
    # specific to this table
    scope.isUpdateActionDefined = iAttrs.updateAction?
    scope.isDeleteActionDefined = iAttrs.deleteAction?
    scope.select = (item) ->
      scope.selected = item
      return
    return