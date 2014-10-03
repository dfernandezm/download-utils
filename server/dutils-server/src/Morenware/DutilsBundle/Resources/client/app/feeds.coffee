
app.factory 'Feed', ['$resource', ($resource) ->
  Feed = $resource 'api/feeds/:feedId', {feedId: '@id'}, {
    getAll: { method: 'GET', params: {}, isArray: true },
    update: { method: 'PUT' }
  }

  Feed
]