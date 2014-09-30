feedsServices = angular.module 'feedsServices', ['ngResource']

feedsServices.factory 'Feed', ['$resource', ($resource) ->
    return $resource 'feeds/:feedId', {}, {
        query: { method: 'GET', params: {feedId: 'feeds'}, isArray: true}
    }
]