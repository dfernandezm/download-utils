

app.factory 'Torrent', ['$resource', ($resource) ->

  # Make use of the resource plugin: path, attribute - path override (feedId is the id field in the
  # resolved object), list of methods to override
  Torrent = $resource 'api/torrents/:guid', {guid: '@guid'}, {
    getTorrent: { method: 'GET'}
    #query: { method: 'GET', isArray: true }

  }

  # We attach the name of the attribute to send to the server to create a request like
  # { feed: {...} } (see setup.coffee)
  Torrent.prototype.name = 'torrent'

  # Coffescript syntax: return the above created "class"
  Torrent
]