angular.module('dutilsApp').controller 'instanceController', ['$scope', 'apiFactory',  '$route', '$routeParams', ($scope, apiFactory) ->
  
  resolve = (promise, successCallback, errorCallback) ->
    promise().success(successCallback).error(errorCallback)
    return

  getInstances = ->
    resolve apiFactory.getInstances,
      ((data) ->
        $scope.instances = data
        return),
      ((data) ->
        $scope.errors = "Error in the request"
        return)
    return

 
  getInstances()

  return
]