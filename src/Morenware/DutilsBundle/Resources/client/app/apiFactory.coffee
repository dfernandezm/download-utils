app.factory 'apiFactory', ['$http', ($http) ->

  # $http.defaults.headers.common = {"Access-Control-Request-Headers": "accept, origin, authorization"}
  $http.defaults.headers.common['Authorization'] = 'Basic YWRtaW46YWRtaW5wYXNz'

  urlBase = "api/instances"
  searchUrl = "api/search"
  apiFactory = {}

  apiFactory.getInstances = ->
    return $http.get urlBase + '/1'

  apiFactory.getInstance = (id) ->
    return $http.get(urlBase + '/' + id)

  apiFactory.createInstance = (instance) ->
    return $http.post urlBase, instance

  apiFactory.updateInstance = (instance) ->
    return $http.put(urlBase + instance.id, instance)

  apiFactory.deleteInstance = (id) ->
    return $http.delete(urlBase + "/" + id)

  apiFactory.searchTorrent = (searchQuery, sitesParam) ->
    req = {
      method: 'get',
      url: searchUrl
      params: { searchQuery : searchQuery, sitesParam: sitesParam }
    }
    return $http(req)

  return apiFactory
]