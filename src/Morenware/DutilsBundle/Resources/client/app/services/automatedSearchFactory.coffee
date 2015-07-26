app.factory 'automatedSearchFactory', ['$resource', ($resource) ->

  # Make use of the resource plugin: path, attribute - path override (feedId is the id field in the
  # resolved object), list of methods to override
  AutomatedSearch = $resource 'api/automatedsearchs/:automatedSearchId', {automatedSearchId: '@id'}, {
    getAll: { method: 'GET', params: {}, isArray: true },
    update: { method: 'PUT' }
  }

  # We attach the name of the attribute to send to the server to create a request like
  # { feed: {...} } (see setup.coffee)
  AutomatedSearch.prototype.name = 'feed'

  # Coffescript syntax: return the above created "class"
  AutomatedSearch
]
