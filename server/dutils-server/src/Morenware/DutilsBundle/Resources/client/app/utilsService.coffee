app.service 'utilsService', [ ->

  resolve = (promise, successCallback, errorCallback) ->
    promise.success(successCallback).error(errorCallback)
    return

  resolvePromiseWithCallbacks = (callPromise, successClosure, loadingAction, loadingActionStop) ->
    loadingAction() unless !loadingAction
    resolve callPromise,
      ((data) ->
        successClosure(data)
        loadingActionStop() unless !loadingActionStop
        return),
      ((data) ->
        $scope.errors = "Error in the request"
        loadingActionStop() unless !loadingActionStop
        return)
    return

  return  {
    resolvePromiseWithCallbacks: resolvePromiseWithCallbacks
  }

]