
automatedSearchController = ($scope, automatedSearchFactory) ->


  $scope.init = ->
    console.log "init mod"
    return
  return

# do it with $inject to avoid problems with minification
automatedSearchController.$inject = ['$scope', 'automatedSearchFactory'];
#mod.controller('automatedSearchController', automatedSearchController);

#module.exports = automatedSearchController
