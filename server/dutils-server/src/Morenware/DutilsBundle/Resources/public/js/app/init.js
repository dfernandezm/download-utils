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

	require(/*! ./incl.coffee */ 1);


/***/ },
/* 1 */
/*!*********************************************************************!*\
  !*** ./src/Morenware/DutilsBundle/Resources/client/app/incl.coffee ***!
  \*********************************************************************/
/***/ function(module, exports, require) {

	var myfunc;
	
	myfunc = function() {
	  var a, name, _i, _len, _ref, _results;
	  a = 1;
	  if (a === 1) {
	    _ref = ["Roger", "Roderick", "Brian"];
	    _results = [];
	    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
	      name = _ref[_i];
	      _results.push(alert("Release " + name + " dating someone - cool"));
	    }
	    return _results;
	  }
	};
	
	myfunc();


/***/ }
/******/ ])
/*
//@ sourceMappingURL=init.js.map
*/