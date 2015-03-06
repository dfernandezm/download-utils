/******/ (function(modules) { // webpackBootstrap
/******/ 	
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/ 	
/******/ 	// The require function
/******/ 	function require(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/ 		
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/ 		
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, require);
/******/ 		
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/ 		
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// The bundle contains no chunks. A empty chunk loading function.
/******/ 	require.e = function requireEnsure(_, callback) {
/******/ 		callback.call(null, this);
/******/ 	};
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	require.modules = modules;
/******/ 	
/******/ 	// expose the module cache
/******/ 	require.cache = installedModules;
/******/ 	
/******/ 	// __webpack_public_path__
/******/ 	require.p = "";
/******/ 	
/******/ 	
/******/ 	// Load entry module and return exports
/******/ 	return require(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/*!*********************************************************************!*\
  !*** ./src/Morenware/DutilsBundle/Resources/client/app/init.coffee ***!
  \*********************************************************************/
/***/ function(module, exports, require) {

	require(/*! ./setup.coffee */ 1);
	
	require(/*! ./apiFactory.coffee */ 2);
	
	require(/*! ./instanceController.coffee */ 3);


/***/ },
/* 1 */
/*!**********************************************************************!*\
  !*** ./src/Morenware/DutilsBundle/Resources/client/app/setup.coffee ***!
  \**********************************************************************/
/***/ function(module, exports, require) {

	var app;
	
	app = window.app = angular.module('dutilsApp', ['ngRoute']);
	
	app.config([
	  '$routeProvider', function($routeProvider) {
	    return $routeProvider.when('/instances', {
	      controller: 'instanceController',
	      templateUrl: '/dutils-server/client/html/instances.html'
	    }).otherwise({
	      redirectTo: '/instances'
	    });
	  }
	]);


/***/ },
/* 2 */
/*!***************************************************************************!*\
  !*** ./src/Morenware/DutilsBundle/Resources/client/app/apiFactory.coffee ***!
  \***************************************************************************/
/***/ function(module, exports, require) {

	angular.module('dutilsApp').factory('apiFactory', [
	  '$http', function($http) {
	    var apiFactory, urlBase;
	    $http.defaults.headers.common['Authorization'] = 'Basic YWRtaW46YWRtaW5wYXNz';
	    urlBase = "api/instances";
	    apiFactory = {};
	    apiFactory.getInstances = function() {
	      return $http.get(urlBase + '/1');
	    };
	    apiFactory.getInstance = function(id) {
	      return $http.get(urlBase + '/' + id);
	    };
	    apiFactory.createInstance = function(instance) {
	      return $http.post(urlBase, instance);
	    };
	    apiFactory.updateInstance = function(instance) {
	      return $http.put(urlBase + instance.id, instance);
	    };
	    apiFactory.deleteInstance = function(id) {
	      return $http["delete"](urlBase + "/" + id);
	    };
	    return apiFactory;
	  }
	]);


/***/ },
/* 3 */
/*!***********************************************************************************!*\
  !*** ./src/Morenware/DutilsBundle/Resources/client/app/instanceController.coffee ***!
  \***********************************************************************************/
/***/ function(module, exports, require) {

	angular.module('dutilsApp').controller('instanceController', [
	  '$scope', 'apiFactory', function($scope, apiFactory) {
	    var getInstances, resolve;
	    resolve = function(promise, successCallback, errorCallback) {
	      promise().success(successCallback).error(errorCallback);
	    };
	    getInstances = function() {
	      resolve(apiFactory.getInstances, (function(data) {
	        $scope.instances = data;
	      }), (function(data) {
	        $scope.errors = "Error in the request";
	      }));
	    };
	    getInstances();
	  }
	]);


/***/ }
/******/ ])
/*
//@ sourceMappingURL=init.js.map
*/