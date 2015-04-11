app.service 'utilsService', [ ->

  resolve = (promise, successCallback, errorCallback) ->
    promise.success(successCallback).error(errorCallback)
    return

  resolvePromiseWithCallbacks = (callPromise, successClosure, errorCallback, loadingAction, loadingActionStop) ->
    loadingAction() unless !loadingAction
    resolve callPromise,
      ((data) ->
        successClosure(data)
        loadingActionStop() unless !loadingActionStop
        return),
      ((data) ->
        errorCallback(data)
        loadingActionStop() unless !loadingActionStop
        return)
    return

  return  {
    resolvePromiseWithCallbacks: resolvePromiseWithCallbacks
  }

]