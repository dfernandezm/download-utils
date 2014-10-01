
app.factory 'Feed', ['$resource', ($resource) ->
  Feed = $resource 'api/feeds/:feedId', {feedId: '@id'}, {
    query: { method: 'GET', params: {}, isArray: true },
    update: { method: 'PUT' }
  }

  feeds = {}
  feeds.getAll = ->
    return Feed.query()

  feeds.save = (feed) ->
    return feed.$save()

  feeds.remove = (feed) ->
    return feed.$delete()

  feeds.update = (feed) ->
    return feed.$update()

  feeds
]