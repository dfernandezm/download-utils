app = window.app = angular.module 'dutilsApp', ['ngRoute']

app.config ['$routeProvider', ($routeProvider) ->
  $routeProvider.when('/instances', {
    controller: 'instanceController',
    templateUrl: '/dutils-server/client/html/instances.html'
  }).otherwise {redirectTo: '/instances'}
]