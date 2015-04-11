/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
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
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	window._str = __webpack_require__(1);
	
	window._ = __webpack_require__(2);
	
	window.moment = __webpack_require__(16);
	
	__webpack_require__(3);
	
	__webpack_require__(4);
	
	__webpack_require__(5);
	
	__webpack_require__(6);
	
	__webpack_require__(7);
	
	__webpack_require__(8);
	
	__webpack_require__(9);
	
	__webpack_require__(10);
	
	__webpack_require__(11);
	
	__webpack_require__(14);
	
	__webpack_require__(15);
	
	__webpack_require__(12);
	
	__webpack_require__(13);


/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	!function(e,t){"use strict";var n=t.prototype.trim,r=t.prototype.trimRight,i=t.prototype.trimLeft,s=function(e){return e*1||0},o=function(e,t){if(t<1)return"";var n="";while(t>0)t&1&&(n+=e),t>>=1,e+=e;return n},u=[].slice,a=function(e){return e==null?"\\s":e.source?e.source:"["+p.escapeRegExp(e)+"]"},f={lt:"<",gt:">",quot:'"',apos:"'",amp:"&"},l={};for(var c in f)l[f[c]]=c;var h=function(){function e(e){return Object.prototype.toString.call(e).slice(8,-1).toLowerCase()}var n=o,r=function(){return r.cache.hasOwnProperty(arguments[0])||(r.cache[arguments[0]]=r.parse(arguments[0])),r.format.call(null,r.cache[arguments[0]],arguments)};return r.format=function(r,i){var s=1,o=r.length,u="",a,f=[],l,c,p,d,v,m;for(l=0;l<o;l++){u=e(r[l]);if(u==="string")f.push(r[l]);else if(u==="array"){p=r[l];if(p[2]){a=i[s];for(c=0;c<p[2].length;c++){if(!a.hasOwnProperty(p[2][c]))throw new Error(h('[_.sprintf] property "%s" does not exist',p[2][c]));a=a[p[2][c]]}}else p[1]?a=i[p[1]]:a=i[s++];if(/[^s]/.test(p[8])&&e(a)!="number")throw new Error(h("[_.sprintf] expecting number but found %s",e(a)));switch(p[8]){case"b":a=a.toString(2);break;case"c":a=t.fromCharCode(a);break;case"d":a=parseInt(a,10);break;case"e":a=p[7]?a.toExponential(p[7]):a.toExponential();break;case"f":a=p[7]?parseFloat(a).toFixed(p[7]):parseFloat(a);break;case"o":a=a.toString(8);break;case"s":a=(a=t(a))&&p[7]?a.substring(0,p[7]):a;break;case"u":a=Math.abs(a);break;case"x":a=a.toString(16);break;case"X":a=a.toString(16).toUpperCase()}a=/[def]/.test(p[8])&&p[3]&&a>=0?"+"+a:a,v=p[4]?p[4]=="0"?"0":p[4].charAt(1):" ",m=p[6]-t(a).length,d=p[6]?n(v,m):"",f.push(p[5]?a+d:d+a)}}return f.join("")},r.cache={},r.parse=function(e){var t=e,n=[],r=[],i=0;while(t){if((n=/^[^\x25]+/.exec(t))!==null)r.push(n[0]);else if((n=/^\x25{2}/.exec(t))!==null)r.push("%");else{if((n=/^\x25(?:([1-9]\d*)\$|\(([^\)]+)\))?(\+)?(0|'[^$])?(-)?(\d+)?(?:\.(\d+))?([b-fosuxX])/.exec(t))===null)throw new Error("[_.sprintf] huh?");if(n[2]){i|=1;var s=[],o=n[2],u=[];if((u=/^([a-z_][a-z_\d]*)/i.exec(o))===null)throw new Error("[_.sprintf] huh?");s.push(u[1]);while((o=o.substring(u[0].length))!=="")if((u=/^\.([a-z_][a-z_\d]*)/i.exec(o))!==null)s.push(u[1]);else{if((u=/^\[(\d+)\]/.exec(o))===null)throw new Error("[_.sprintf] huh?");s.push(u[1])}n[2]=s}else i|=2;if(i===3)throw new Error("[_.sprintf] mixing positional and named placeholders is not (yet) supported");r.push(n)}t=t.substring(n[0].length)}return r},r}(),p={VERSION:"2.3.0",isBlank:function(e){return e==null&&(e=""),/^\s*$/.test(e)},stripTags:function(e){return e==null?"":t(e).replace(/<\/?[^>]+>/g,"")},capitalize:function(e){return e=e==null?"":t(e),e.charAt(0).toUpperCase()+e.slice(1)},chop:function(e,n){return e==null?[]:(e=t(e),n=~~n,n>0?e.match(new RegExp(".{1,"+n+"}","g")):[e])},clean:function(e){return p.strip(e).replace(/\s+/g," ")},count:function(e,n){return e==null||n==null?0:t(e).split(n).length-1},chars:function(e){return e==null?[]:t(e).split("")},swapCase:function(e){return e==null?"":t(e).replace(/\S/g,function(e){return e===e.toUpperCase()?e.toLowerCase():e.toUpperCase()})},escapeHTML:function(e){return e==null?"":t(e).replace(/[&<>"']/g,function(e){return"&"+l[e]+";"})},unescapeHTML:function(e){return e==null?"":t(e).replace(/\&([^;]+);/g,function(e,n){var r;return n in f?f[n]:(r=n.match(/^#x([\da-fA-F]+)$/))?t.fromCharCode(parseInt(r[1],16)):(r=n.match(/^#(\d+)$/))?t.fromCharCode(~~r[1]):e})},escapeRegExp:function(e){return e==null?"":t(e).replace(/([.*+?^=!:${}()|[\]\/\\])/g,"\\$1")},splice:function(e,t,n,r){var i=p.chars(e);return i.splice(~~t,~~n,r),i.join("")},insert:function(e,t,n){return p.splice(e,t,0,n)},include:function(e,n){return n===""?!0:e==null?!1:t(e).indexOf(n)!==-1},join:function(){var e=u.call(arguments),t=e.shift();return t==null&&(t=""),e.join(t)},lines:function(e){return e==null?[]:t(e).split("\n")},reverse:function(e){return p.chars(e).reverse().join("")},startsWith:function(e,n){return n===""?!0:e==null||n==null?!1:(e=t(e),n=t(n),e.length>=n.length&&e.slice(0,n.length)===n)},endsWith:function(e,n){return n===""?!0:e==null||n==null?!1:(e=t(e),n=t(n),e.length>=n.length&&e.slice(e.length-n.length)===n)},succ:function(e){return e==null?"":(e=t(e),e.slice(0,-1)+t.fromCharCode(e.charCodeAt(e.length-1)+1))},titleize:function(e){return e==null?"":t(e).replace(/(?:^|\s)\S/g,function(e){return e.toUpperCase()})},camelize:function(e){return p.trim(e).replace(/[-_\s]+(.)?/g,function(e,t){return t.toUpperCase()})},underscored:function(e){return p.trim(e).replace(/([a-z\d])([A-Z]+)/g,"$1_$2").replace(/[-\s]+/g,"_").toLowerCase()},dasherize:function(e){return p.trim(e).replace(/([A-Z])/g,"-$1").replace(/[-_\s]+/g,"-").toLowerCase()},classify:function(e){return p.titleize(t(e).replace(/_/g," ")).replace(/\s/g,"")},humanize:function(e){return p.capitalize(p.underscored(e).replace(/_id$/,"").replace(/_/g," "))},trim:function(e,r){return e==null?"":!r&&n?n.call(e):(r=a(r),t(e).replace(new RegExp("^"+r+"+|"+r+"+$","g"),""))},ltrim:function(e,n){return e==null?"":!n&&i?i.call(e):(n=a(n),t(e).replace(new RegExp("^"+n+"+"),""))},rtrim:function(e,n){return e==null?"":!n&&r?r.call(e):(n=a(n),t(e).replace(new RegExp(n+"+$"),""))},truncate:function(e,n,r){return e==null?"":(e=t(e),r=r||"...",n=~~n,e.length>n?e.slice(0,n)+r:e)},prune:function(e,n,r){if(e==null)return"";e=t(e),n=~~n,r=r!=null?t(r):"...";if(e.length<=n)return e;var i=function(e){return e.toUpperCase()!==e.toLowerCase()?"A":" "},s=e.slice(0,n+1).replace(/.(?=\W*\w*$)/g,i);return s.slice(s.length-2).match(/\w\w/)?s=s.replace(/\s*\S+$/,""):s=p.rtrim(s.slice(0,s.length-1)),(s+r).length>e.length?e:e.slice(0,s.length)+r},words:function(e,t){return p.isBlank(e)?[]:p.trim(e,t).split(t||/\s+/)},pad:function(e,n,r,i){e=e==null?"":t(e),n=~~n;var s=0;r?r.length>1&&(r=r.charAt(0)):r=" ";switch(i){case"right":return s=n-e.length,e+o(r,s);case"both":return s=n-e.length,o(r,Math.ceil(s/2))+e+o(r,Math.floor(s/2));default:return s=n-e.length,o(r,s)+e}},lpad:function(e,t,n){return p.pad(e,t,n)},rpad:function(e,t,n){return p.pad(e,t,n,"right")},lrpad:function(e,t,n){return p.pad(e,t,n,"both")},sprintf:h,vsprintf:function(e,t){return t.unshift(e),h.apply(null,t)},toNumber:function(e,n){if(e==null||e=="")return 0;e=t(e);var r=s(s(e).toFixed(~~n));return r===0&&!e.match(/^0+$/)?Number.NaN:r},numberFormat:function(e,t,n,r){if(isNaN(e)||e==null)return"";e=e.toFixed(~~t),r=r||",";var i=e.split("."),s=i[0],o=i[1]?(n||".")+i[1]:"";return s.replace(/(\d)(?=(?:\d{3})+$)/g,"$1"+r)+o},strRight:function(e,n){if(e==null)return"";e=t(e),n=n!=null?t(n):n;var r=n?e.indexOf(n):-1;return~r?e.slice(r+n.length,e.length):e},strRightBack:function(e,n){if(e==null)return"";e=t(e),n=n!=null?t(n):n;var r=n?e.lastIndexOf(n):-1;return~r?e.slice(r+n.length,e.length):e},strLeft:function(e,n){if(e==null)return"";e=t(e),n=n!=null?t(n):n;var r=n?e.indexOf(n):-1;return~r?e.slice(0,r):e},strLeftBack:function(e,t){if(e==null)return"";e+="",t=t!=null?""+t:t;var n=e.lastIndexOf(t);return~n?e.slice(0,n):e},toSentence:function(e,t,n,r){t=t||", ",n=n||" and ";var i=e.slice(),s=i.pop();return e.length>2&&r&&(n=p.rtrim(t)+n),i.length?i.join(t)+n+s:s},toSentenceSerial:function(){var e=u.call(arguments);return e[3]=!0,p.toSentence.apply(p,e)},slugify:function(e){if(e==null)return"";var n="ąàáäâãåæćęèéëêìíïîłńòóöôõøùúüûñçżź",r="aaaaaaaaceeeeeiiiilnoooooouuuunczz",i=new RegExp(a(n),"g");return e=t(e).toLowerCase().replace(i,function(e){var t=n.indexOf(e);return r.charAt(t)||"-"}),p.dasherize(e.replace(/[^\w\s-]/g,""))},surround:function(e,t){return[t,e,t].join("")},quote:function(e){return p.surround(e,'"')},exports:function(){var e={};for(var t in this){if(!this.hasOwnProperty(t)||t.match(/^(?:include|contains|reverse)$/))continue;e[t]=this[t]}return e},repeat:function(e,n,r){if(e==null)return"";n=~~n;if(r==null)return o(t(e),n);for(var i=[];n>0;i[--n]=e);return i.join(r)},levenshtein:function(e,n){if(e==null&&n==null)return 0;if(e==null)return t(n).length;if(n==null)return t(e).length;e=t(e),n=t(n);var r=[],i,s;for(var o=0;o<=n.length;o++)for(var u=0;u<=e.length;u++)o&&u?e.charAt(u-1)===n.charAt(o-1)?s=i:s=Math.min(r[u],r[u-1],i)+1:s=o+u,i=r[u],r[u]=s;return r.pop()}};p.strip=p.trim,p.lstrip=p.ltrim,p.rstrip=p.rtrim,p.center=p.lrpad,p.rjust=p.lpad,p.ljust=p.rpad,p.contains=p.include,p.q=p.quote,true?(typeof module!="undefined"&&module.exports&&(module.exports=p),exports._s=p):typeof define=="function"&&define.amd?define("underscore.string",[],function(){return p}):(e._=e._||{},e._.string=e._.str=p)}(this,String);

/***/ },
/* 2 */
/***/ function(module, exports, __webpack_require__) {

	var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;//     Underscore.js 1.7.0
	//     http://underscorejs.org
	//     (c) 2009-2014 Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
	//     Underscore may be freely distributed under the MIT license.
	(function(){var n=this,t=n._,r=Array.prototype,e=Object.prototype,u=Function.prototype,i=r.push,a=r.slice,o=r.concat,l=e.toString,c=e.hasOwnProperty,f=Array.isArray,s=Object.keys,p=u.bind,h=function(n){return n instanceof h?n:this instanceof h?void(this._wrapped=n):new h(n)};true?("undefined"!=typeof module&&module.exports&&(exports=module.exports=h),exports._=h):n._=h,h.VERSION="1.7.0";var g=function(n,t,r){if(t===void 0)return n;switch(null==r?3:r){case 1:return function(r){return n.call(t,r)};case 2:return function(r,e){return n.call(t,r,e)};case 3:return function(r,e,u){return n.call(t,r,e,u)};case 4:return function(r,e,u,i){return n.call(t,r,e,u,i)}}return function(){return n.apply(t,arguments)}};h.iteratee=function(n,t,r){return null==n?h.identity:h.isFunction(n)?g(n,t,r):h.isObject(n)?h.matches(n):h.property(n)},h.each=h.forEach=function(n,t,r){if(null==n)return n;t=g(t,r);var e,u=n.length;if(u===+u)for(e=0;u>e;e++)t(n[e],e,n);else{var i=h.keys(n);for(e=0,u=i.length;u>e;e++)t(n[i[e]],i[e],n)}return n},h.map=h.collect=function(n,t,r){if(null==n)return[];t=h.iteratee(t,r);for(var e,u=n.length!==+n.length&&h.keys(n),i=(u||n).length,a=Array(i),o=0;i>o;o++)e=u?u[o]:o,a[o]=t(n[e],e,n);return a};var v="Reduce of empty array with no initial value";h.reduce=h.foldl=h.inject=function(n,t,r,e){null==n&&(n=[]),t=g(t,e,4);var u,i=n.length!==+n.length&&h.keys(n),a=(i||n).length,o=0;if(arguments.length<3){if(!a)throw new TypeError(v);r=n[i?i[o++]:o++]}for(;a>o;o++)u=i?i[o]:o,r=t(r,n[u],u,n);return r},h.reduceRight=h.foldr=function(n,t,r,e){null==n&&(n=[]),t=g(t,e,4);var u,i=n.length!==+n.length&&h.keys(n),a=(i||n).length;if(arguments.length<3){if(!a)throw new TypeError(v);r=n[i?i[--a]:--a]}for(;a--;)u=i?i[a]:a,r=t(r,n[u],u,n);return r},h.find=h.detect=function(n,t,r){var e;return t=h.iteratee(t,r),h.some(n,function(n,r,u){return t(n,r,u)?(e=n,!0):void 0}),e},h.filter=h.select=function(n,t,r){var e=[];return null==n?e:(t=h.iteratee(t,r),h.each(n,function(n,r,u){t(n,r,u)&&e.push(n)}),e)},h.reject=function(n,t,r){return h.filter(n,h.negate(h.iteratee(t)),r)},h.every=h.all=function(n,t,r){if(null==n)return!0;t=h.iteratee(t,r);var e,u,i=n.length!==+n.length&&h.keys(n),a=(i||n).length;for(e=0;a>e;e++)if(u=i?i[e]:e,!t(n[u],u,n))return!1;return!0},h.some=h.any=function(n,t,r){if(null==n)return!1;t=h.iteratee(t,r);var e,u,i=n.length!==+n.length&&h.keys(n),a=(i||n).length;for(e=0;a>e;e++)if(u=i?i[e]:e,t(n[u],u,n))return!0;return!1},h.contains=h.include=function(n,t){return null==n?!1:(n.length!==+n.length&&(n=h.values(n)),h.indexOf(n,t)>=0)},h.invoke=function(n,t){var r=a.call(arguments,2),e=h.isFunction(t);return h.map(n,function(n){return(e?t:n[t]).apply(n,r)})},h.pluck=function(n,t){return h.map(n,h.property(t))},h.where=function(n,t){return h.filter(n,h.matches(t))},h.findWhere=function(n,t){return h.find(n,h.matches(t))},h.max=function(n,t,r){var e,u,i=-1/0,a=-1/0;if(null==t&&null!=n){n=n.length===+n.length?n:h.values(n);for(var o=0,l=n.length;l>o;o++)e=n[o],e>i&&(i=e)}else t=h.iteratee(t,r),h.each(n,function(n,r,e){u=t(n,r,e),(u>a||u===-1/0&&i===-1/0)&&(i=n,a=u)});return i},h.min=function(n,t,r){var e,u,i=1/0,a=1/0;if(null==t&&null!=n){n=n.length===+n.length?n:h.values(n);for(var o=0,l=n.length;l>o;o++)e=n[o],i>e&&(i=e)}else t=h.iteratee(t,r),h.each(n,function(n,r,e){u=t(n,r,e),(a>u||1/0===u&&1/0===i)&&(i=n,a=u)});return i},h.shuffle=function(n){for(var t,r=n&&n.length===+n.length?n:h.values(n),e=r.length,u=Array(e),i=0;e>i;i++)t=h.random(0,i),t!==i&&(u[i]=u[t]),u[t]=r[i];return u},h.sample=function(n,t,r){return null==t||r?(n.length!==+n.length&&(n=h.values(n)),n[h.random(n.length-1)]):h.shuffle(n).slice(0,Math.max(0,t))},h.sortBy=function(n,t,r){return t=h.iteratee(t,r),h.pluck(h.map(n,function(n,r,e){return{value:n,index:r,criteria:t(n,r,e)}}).sort(function(n,t){var r=n.criteria,e=t.criteria;if(r!==e){if(r>e||r===void 0)return 1;if(e>r||e===void 0)return-1}return n.index-t.index}),"value")};var m=function(n){return function(t,r,e){var u={};return r=h.iteratee(r,e),h.each(t,function(e,i){var a=r(e,i,t);n(u,e,a)}),u}};h.groupBy=m(function(n,t,r){h.has(n,r)?n[r].push(t):n[r]=[t]}),h.indexBy=m(function(n,t,r){n[r]=t}),h.countBy=m(function(n,t,r){h.has(n,r)?n[r]++:n[r]=1}),h.sortedIndex=function(n,t,r,e){r=h.iteratee(r,e,1);for(var u=r(t),i=0,a=n.length;a>i;){var o=i+a>>>1;r(n[o])<u?i=o+1:a=o}return i},h.toArray=function(n){return n?h.isArray(n)?a.call(n):n.length===+n.length?h.map(n,h.identity):h.values(n):[]},h.size=function(n){return null==n?0:n.length===+n.length?n.length:h.keys(n).length},h.partition=function(n,t,r){t=h.iteratee(t,r);var e=[],u=[];return h.each(n,function(n,r,i){(t(n,r,i)?e:u).push(n)}),[e,u]},h.first=h.head=h.take=function(n,t,r){return null==n?void 0:null==t||r?n[0]:0>t?[]:a.call(n,0,t)},h.initial=function(n,t,r){return a.call(n,0,Math.max(0,n.length-(null==t||r?1:t)))},h.last=function(n,t,r){return null==n?void 0:null==t||r?n[n.length-1]:a.call(n,Math.max(n.length-t,0))},h.rest=h.tail=h.drop=function(n,t,r){return a.call(n,null==t||r?1:t)},h.compact=function(n){return h.filter(n,h.identity)};var y=function(n,t,r,e){if(t&&h.every(n,h.isArray))return o.apply(e,n);for(var u=0,a=n.length;a>u;u++){var l=n[u];h.isArray(l)||h.isArguments(l)?t?i.apply(e,l):y(l,t,r,e):r||e.push(l)}return e};h.flatten=function(n,t){return y(n,t,!1,[])},h.without=function(n){return h.difference(n,a.call(arguments,1))},h.uniq=h.unique=function(n,t,r,e){if(null==n)return[];h.isBoolean(t)||(e=r,r=t,t=!1),null!=r&&(r=h.iteratee(r,e));for(var u=[],i=[],a=0,o=n.length;o>a;a++){var l=n[a];if(t)a&&i===l||u.push(l),i=l;else if(r){var c=r(l,a,n);h.indexOf(i,c)<0&&(i.push(c),u.push(l))}else h.indexOf(u,l)<0&&u.push(l)}return u},h.union=function(){return h.uniq(y(arguments,!0,!0,[]))},h.intersection=function(n){if(null==n)return[];for(var t=[],r=arguments.length,e=0,u=n.length;u>e;e++){var i=n[e];if(!h.contains(t,i)){for(var a=1;r>a&&h.contains(arguments[a],i);a++);a===r&&t.push(i)}}return t},h.difference=function(n){var t=y(a.call(arguments,1),!0,!0,[]);return h.filter(n,function(n){return!h.contains(t,n)})},h.zip=function(n){if(null==n)return[];for(var t=h.max(arguments,"length").length,r=Array(t),e=0;t>e;e++)r[e]=h.pluck(arguments,e);return r},h.object=function(n,t){if(null==n)return{};for(var r={},e=0,u=n.length;u>e;e++)t?r[n[e]]=t[e]:r[n[e][0]]=n[e][1];return r},h.indexOf=function(n,t,r){if(null==n)return-1;var e=0,u=n.length;if(r){if("number"!=typeof r)return e=h.sortedIndex(n,t),n[e]===t?e:-1;e=0>r?Math.max(0,u+r):r}for(;u>e;e++)if(n[e]===t)return e;return-1},h.lastIndexOf=function(n,t,r){if(null==n)return-1;var e=n.length;for("number"==typeof r&&(e=0>r?e+r+1:Math.min(e,r+1));--e>=0;)if(n[e]===t)return e;return-1},h.range=function(n,t,r){arguments.length<=1&&(t=n||0,n=0),r=r||1;for(var e=Math.max(Math.ceil((t-n)/r),0),u=Array(e),i=0;e>i;i++,n+=r)u[i]=n;return u};var d=function(){};h.bind=function(n,t){var r,e;if(p&&n.bind===p)return p.apply(n,a.call(arguments,1));if(!h.isFunction(n))throw new TypeError("Bind must be called on a function");return r=a.call(arguments,2),e=function(){if(!(this instanceof e))return n.apply(t,r.concat(a.call(arguments)));d.prototype=n.prototype;var u=new d;d.prototype=null;var i=n.apply(u,r.concat(a.call(arguments)));return h.isObject(i)?i:u}},h.partial=function(n){var t=a.call(arguments,1);return function(){for(var r=0,e=t.slice(),u=0,i=e.length;i>u;u++)e[u]===h&&(e[u]=arguments[r++]);for(;r<arguments.length;)e.push(arguments[r++]);return n.apply(this,e)}},h.bindAll=function(n){var t,r,e=arguments.length;if(1>=e)throw new Error("bindAll must be passed function names");for(t=1;e>t;t++)r=arguments[t],n[r]=h.bind(n[r],n);return n},h.memoize=function(n,t){var r=function(e){var u=r.cache,i=t?t.apply(this,arguments):e;return h.has(u,i)||(u[i]=n.apply(this,arguments)),u[i]};return r.cache={},r},h.delay=function(n,t){var r=a.call(arguments,2);return setTimeout(function(){return n.apply(null,r)},t)},h.defer=function(n){return h.delay.apply(h,[n,1].concat(a.call(arguments,1)))},h.throttle=function(n,t,r){var e,u,i,a=null,o=0;r||(r={});var l=function(){o=r.leading===!1?0:h.now(),a=null,i=n.apply(e,u),a||(e=u=null)};return function(){var c=h.now();o||r.leading!==!1||(o=c);var f=t-(c-o);return e=this,u=arguments,0>=f||f>t?(clearTimeout(a),a=null,o=c,i=n.apply(e,u),a||(e=u=null)):a||r.trailing===!1||(a=setTimeout(l,f)),i}},h.debounce=function(n,t,r){var e,u,i,a,o,l=function(){var c=h.now()-a;t>c&&c>0?e=setTimeout(l,t-c):(e=null,r||(o=n.apply(i,u),e||(i=u=null)))};return function(){i=this,u=arguments,a=h.now();var c=r&&!e;return e||(e=setTimeout(l,t)),c&&(o=n.apply(i,u),i=u=null),o}},h.wrap=function(n,t){return h.partial(t,n)},h.negate=function(n){return function(){return!n.apply(this,arguments)}},h.compose=function(){var n=arguments,t=n.length-1;return function(){for(var r=t,e=n[t].apply(this,arguments);r--;)e=n[r].call(this,e);return e}},h.after=function(n,t){return function(){return--n<1?t.apply(this,arguments):void 0}},h.before=function(n,t){var r;return function(){return--n>0?r=t.apply(this,arguments):t=null,r}},h.once=h.partial(h.before,2),h.keys=function(n){if(!h.isObject(n))return[];if(s)return s(n);var t=[];for(var r in n)h.has(n,r)&&t.push(r);return t},h.values=function(n){for(var t=h.keys(n),r=t.length,e=Array(r),u=0;r>u;u++)e[u]=n[t[u]];return e},h.pairs=function(n){for(var t=h.keys(n),r=t.length,e=Array(r),u=0;r>u;u++)e[u]=[t[u],n[t[u]]];return e},h.invert=function(n){for(var t={},r=h.keys(n),e=0,u=r.length;u>e;e++)t[n[r[e]]]=r[e];return t},h.functions=h.methods=function(n){var t=[];for(var r in n)h.isFunction(n[r])&&t.push(r);return t.sort()},h.extend=function(n){if(!h.isObject(n))return n;for(var t,r,e=1,u=arguments.length;u>e;e++){t=arguments[e];for(r in t)c.call(t,r)&&(n[r]=t[r])}return n},h.pick=function(n,t,r){var e,u={};if(null==n)return u;if(h.isFunction(t)){t=g(t,r);for(e in n){var i=n[e];t(i,e,n)&&(u[e]=i)}}else{var l=o.apply([],a.call(arguments,1));n=new Object(n);for(var c=0,f=l.length;f>c;c++)e=l[c],e in n&&(u[e]=n[e])}return u},h.omit=function(n,t,r){if(h.isFunction(t))t=h.negate(t);else{var e=h.map(o.apply([],a.call(arguments,1)),String);t=function(n,t){return!h.contains(e,t)}}return h.pick(n,t,r)},h.defaults=function(n){if(!h.isObject(n))return n;for(var t=1,r=arguments.length;r>t;t++){var e=arguments[t];for(var u in e)n[u]===void 0&&(n[u]=e[u])}return n},h.clone=function(n){return h.isObject(n)?h.isArray(n)?n.slice():h.extend({},n):n},h.tap=function(n,t){return t(n),n};var b=function(n,t,r,e){if(n===t)return 0!==n||1/n===1/t;if(null==n||null==t)return n===t;n instanceof h&&(n=n._wrapped),t instanceof h&&(t=t._wrapped);var u=l.call(n);if(u!==l.call(t))return!1;switch(u){case"[object RegExp]":case"[object String]":return""+n==""+t;case"[object Number]":return+n!==+n?+t!==+t:0===+n?1/+n===1/t:+n===+t;case"[object Date]":case"[object Boolean]":return+n===+t}if("object"!=typeof n||"object"!=typeof t)return!1;for(var i=r.length;i--;)if(r[i]===n)return e[i]===t;var a=n.constructor,o=t.constructor;if(a!==o&&"constructor"in n&&"constructor"in t&&!(h.isFunction(a)&&a instanceof a&&h.isFunction(o)&&o instanceof o))return!1;r.push(n),e.push(t);var c,f;if("[object Array]"===u){if(c=n.length,f=c===t.length)for(;c--&&(f=b(n[c],t[c],r,e)););}else{var s,p=h.keys(n);if(c=p.length,f=h.keys(t).length===c)for(;c--&&(s=p[c],f=h.has(t,s)&&b(n[s],t[s],r,e)););}return r.pop(),e.pop(),f};h.isEqual=function(n,t){return b(n,t,[],[])},h.isEmpty=function(n){if(null==n)return!0;if(h.isArray(n)||h.isString(n)||h.isArguments(n))return 0===n.length;for(var t in n)if(h.has(n,t))return!1;return!0},h.isElement=function(n){return!(!n||1!==n.nodeType)},h.isArray=f||function(n){return"[object Array]"===l.call(n)},h.isObject=function(n){var t=typeof n;return"function"===t||"object"===t&&!!n},h.each(["Arguments","Function","String","Number","Date","RegExp"],function(n){h["is"+n]=function(t){return l.call(t)==="[object "+n+"]"}}),h.isArguments(arguments)||(h.isArguments=function(n){return h.has(n,"callee")}),"function"!=typeof/./&&(h.isFunction=function(n){return"function"==typeof n||!1}),h.isFinite=function(n){return isFinite(n)&&!isNaN(parseFloat(n))},h.isNaN=function(n){return h.isNumber(n)&&n!==+n},h.isBoolean=function(n){return n===!0||n===!1||"[object Boolean]"===l.call(n)},h.isNull=function(n){return null===n},h.isUndefined=function(n){return n===void 0},h.has=function(n,t){return null!=n&&c.call(n,t)},h.noConflict=function(){return n._=t,this},h.identity=function(n){return n},h.constant=function(n){return function(){return n}},h.noop=function(){},h.property=function(n){return function(t){return t[n]}},h.matches=function(n){var t=h.pairs(n),r=t.length;return function(n){if(null==n)return!r;n=new Object(n);for(var e=0;r>e;e++){var u=t[e],i=u[0];if(u[1]!==n[i]||!(i in n))return!1}return!0}},h.times=function(n,t,r){var e=Array(Math.max(0,n));t=g(t,r,1);for(var u=0;n>u;u++)e[u]=t(u);return e},h.random=function(n,t){return null==t&&(t=n,n=0),n+Math.floor(Math.random()*(t-n+1))},h.now=Date.now||function(){return(new Date).getTime()};var _={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#x27;","`":"&#x60;"},w=h.invert(_),j=function(n){var t=function(t){return n[t]},r="(?:"+h.keys(n).join("|")+")",e=RegExp(r),u=RegExp(r,"g");return function(n){return n=null==n?"":""+n,e.test(n)?n.replace(u,t):n}};h.escape=j(_),h.unescape=j(w),h.result=function(n,t){if(null==n)return void 0;var r=n[t];return h.isFunction(r)?n[t]():r};var x=0;h.uniqueId=function(n){var t=++x+"";return n?n+t:t},h.templateSettings={evaluate:/<%([\s\S]+?)%>/g,interpolate:/<%=([\s\S]+?)%>/g,escape:/<%-([\s\S]+?)%>/g};var A=/(.)^/,k={"'":"'","\\":"\\","\r":"r","\n":"n","\u2028":"u2028","\u2029":"u2029"},O=/\\|'|\r|\n|\u2028|\u2029/g,F=function(n){return"\\"+k[n]};h.template=function(n,t,r){!t&&r&&(t=r),t=h.defaults({},t,h.templateSettings);var e=RegExp([(t.escape||A).source,(t.interpolate||A).source,(t.evaluate||A).source].join("|")+"|$","g"),u=0,i="__p+='";n.replace(e,function(t,r,e,a,o){return i+=n.slice(u,o).replace(O,F),u=o+t.length,r?i+="'+\n((__t=("+r+"))==null?'':_.escape(__t))+\n'":e?i+="'+\n((__t=("+e+"))==null?'':__t)+\n'":a&&(i+="';\n"+a+"\n__p+='"),t}),i+="';\n",t.variable||(i="with(obj||{}){\n"+i+"}\n"),i="var __t,__p='',__j=Array.prototype.join,"+"print=function(){__p+=__j.call(arguments,'');};\n"+i+"return __p;\n";try{var a=new Function(t.variable||"obj","_",i)}catch(o){throw o.source=i,o}var l=function(n){return a.call(this,n,h)},c=t.variable||"obj";return l.source="function("+c+"){\n"+i+"}",l},h.chain=function(n){var t=h(n);return t._chain=!0,t};var E=function(n){return this._chain?h(n).chain():n};h.mixin=function(n){h.each(h.functions(n),function(t){var r=h[t]=n[t];h.prototype[t]=function(){var n=[this._wrapped];return i.apply(n,arguments),E.call(this,r.apply(h,n))}})},h.mixin(h),h.each(["pop","push","reverse","shift","sort","splice","unshift"],function(n){var t=r[n];h.prototype[n]=function(){var r=this._wrapped;return t.apply(r,arguments),"shift"!==n&&"splice"!==n||0!==r.length||delete r[0],E.call(this,r)}}),h.each(["concat","join","slice"],function(n){var t=r[n];h.prototype[n]=function(){return E.call(this,t.apply(this._wrapped,arguments))}}),h.prototype.value=function(){return this._wrapped},"function"=="function"&&__webpack_require__(18)&&!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = function(){return h}.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__))}).call(this);
	//# sourceMappingURL=underscore-min.map

/***/ },
/* 3 */
/***/ function(module, exports, __webpack_require__) {

	/*
	 AngularJS v1.3.0-rc.1
	 (c) 2010-2014 Google, Inc. http://angularjs.org
	 License: MIT
	*/
	(function(t,Y,s){'use strict';function K(b){return function(){var a=arguments[0],c;c="["+(b?b+":":"")+a+"] http://errors.angularjs.org/1.3.0-rc.1/"+(b?b+"/":"")+a;for(a=1;a<arguments.length;a++){c=c+(1==a?"?":"&")+"p"+(a-1)+"=";var d=encodeURIComponent,e;e=arguments[a];e="function"==typeof e?e.toString().replace(/ \{[\s\S]*$/,""):"undefined"==typeof e?"undefined":"string"!=typeof e?JSON.stringify(e):e;c+=d(e)}return Error(c)}}function Na(b){if(null==b||Oa(b))return!1;var a=b.length;return 1===b.nodeType&&
	a?!0:C(b)||L(b)||0===a||"number"===typeof a&&0<a&&a-1 in b}function r(b,a,c){var d,e;if(b)if(D(b))for(d in b)"prototype"==d||"length"==d||"name"==d||b.hasOwnProperty&&!b.hasOwnProperty(d)||a.call(c,b[d],d,b);else if(L(b)||Na(b)){var f="object"!==typeof b;d=0;for(e=b.length;d<e;d++)(f||d in b)&&a.call(c,b[d],d,b)}else if(b.forEach&&b.forEach!==r)b.forEach(a,c,b);else for(d in b)b.hasOwnProperty(d)&&a.call(c,b[d],d,b);return b}function Zb(b){var a=[],c;for(c in b)b.hasOwnProperty(c)&&a.push(c);return a.sort()}
	function od(b,a,c){for(var d=Zb(b),e=0;e<d.length;e++)a.call(c,b[d[e]],d[e]);return d}function $b(b){return function(a,c){b(c,a)}}function pd(){return++bb}function ac(b,a){a?b.$$hashKey=a:delete b.$$hashKey}function E(b){for(var a=b.$$hashKey,c=1,d=arguments.length;c<d;c++){var e=arguments[c];if(e)for(var f=Object.keys(e),g=0,h=f.length;g<h;g++){var m=f[g];b[m]=e[m]}}ac(b,a);return b}function U(b){return parseInt(b,10)}function bc(b,a){return E(new (E(function(){},{prototype:b})),a)}function w(){}
	function Pa(b){return b}function da(b){return function(){return b}}function F(b){return"undefined"===typeof b}function B(b){return"undefined"!==typeof b}function S(b){return null!==b&&"object"===typeof b}function C(b){return"string"===typeof b}function ea(b){return"number"===typeof b}function fa(b){return"[object Date]"===Ga.call(b)}function D(b){return"function"===typeof b}function cb(b){return"[object RegExp]"===Ga.call(b)}function Oa(b){return b&&b.window===b}function Qa(b){return b&&b.$evalAsync&&
	b.$watch}function qd(b){return!(!b||!(b.nodeName||b.prop&&b.attr&&b.find))}function rd(b){var a={};b=b.split(",");var c;for(c=0;c<b.length;c++)a[b[c]]=!0;return a}function pa(b){return P(b.nodeName||b[0].nodeName)}function sd(b,a,c){var d=[];r(b,function(b,f,g){d.push(a.call(c,b,f,g))});return d}function Ra(b,a){var c=b.indexOf(a);0<=c&&b.splice(c,1);return a}function Ha(b,a,c,d){if(Oa(b)||Qa(b))throw Sa("cpws");if(a){if(b===a)throw Sa("cpi");c=c||[];d=d||[];if(S(b)){var e=c.indexOf(b);if(-1!==e)return d[e];
	c.push(b);d.push(a)}if(L(b))for(var f=a.length=0;f<b.length;f++)e=Ha(b[f],null,c,d),S(b[f])&&(c.push(b[f]),d.push(e)),a.push(e);else{var g=a.$$hashKey;L(a)?a.length=0:r(a,function(c,b){delete a[b]});for(f in b)b.hasOwnProperty(f)&&(e=Ha(b[f],null,c,d),S(b[f])&&(c.push(b[f]),d.push(e)),a[f]=e);ac(a,g)}}else if(a=b)L(b)?a=Ha(b,[],c,d):fa(b)?a=new Date(b.getTime()):cb(b)?(a=new RegExp(b.source,b.toString().match(/[^\/]*$/)[0]),a.lastIndex=b.lastIndex):S(b)&&(e=Object.create(Object.getPrototypeOf(b)),
	a=Ha(b,e,c,d));return a}function qa(b,a){if(L(b)){a=a||[];for(var c=0,d=b.length;c<d;c++)a[c]=b[c]}else if(S(b))for(c in a=a||{},b)if("$"!==c.charAt(0)||"$"!==c.charAt(1))a[c]=b[c];return a||b}function ra(b,a){if(b===a)return!0;if(null===b||null===a)return!1;if(b!==b&&a!==a)return!0;var c=typeof b,d;if(c==typeof a&&"object"==c)if(L(b)){if(!L(a))return!1;if((c=b.length)==a.length){for(d=0;d<c;d++)if(!ra(b[d],a[d]))return!1;return!0}}else{if(fa(b))return fa(a)?ra(b.getTime(),a.getTime()):!1;if(cb(b)&&
	cb(a))return b.toString()==a.toString();if(Qa(b)||Qa(a)||Oa(b)||Oa(a)||L(a))return!1;c={};for(d in b)if("$"!==d.charAt(0)&&!D(b[d])){if(!ra(b[d],a[d]))return!1;c[d]=!0}for(d in a)if(!c.hasOwnProperty(d)&&"$"!==d.charAt(0)&&a[d]!==s&&!D(a[d]))return!1;return!0}return!1}function db(b,a,c){return b.concat(Ta.call(a,c))}function cc(b,a){var c=2<arguments.length?Ta.call(arguments,2):[];return!D(a)||a instanceof RegExp?a:c.length?function(){return arguments.length?a.apply(b,c.concat(Ta.call(arguments,0))):
	a.apply(b,c)}:function(){return arguments.length?a.apply(b,arguments):a.call(b)}}function td(b,a){var c=a;"string"===typeof b&&"$"===b.charAt(0)&&"$"===b.charAt(1)?c=s:Oa(a)?c="$WINDOW":a&&Y===a?c="$DOCUMENT":Qa(a)&&(c="$SCOPE");return c}function sa(b,a){return"undefined"===typeof b?s:JSON.stringify(b,td,a?"  ":null)}function dc(b){return C(b)?JSON.parse(b):b}function ta(b){b=G(b).clone();try{b.empty()}catch(a){}var c=G("<div>").append(b).html();try{return 3===b[0].nodeType?P(c):c.match(/^(<[^>]+>)/)[1].replace(/^<([\w\-]+)/,
	function(a,c){return"<"+P(c)})}catch(d){return P(c)}}function ec(b){try{return decodeURIComponent(b)}catch(a){}}function fc(b){var a={},c,d;r((b||"").split("&"),function(b){b&&(c=b.replace(/\+/g,"%20").split("="),d=ec(c[0]),B(d)&&(b=B(c[1])?ec(c[1]):!0,Ab.call(a,d)?L(a[d])?a[d].push(b):a[d]=[a[d],b]:a[d]=b))});return a}function Bb(b){var a=[];r(b,function(b,d){L(b)?r(b,function(b){a.push(Da(d,!0)+(!0===b?"":"="+Da(b,!0)))}):a.push(Da(d,!0)+(!0===b?"":"="+Da(b,!0)))});return a.length?a.join("&"):""}
	function eb(b){return Da(b,!0).replace(/%26/gi,"&").replace(/%3D/gi,"=").replace(/%2B/gi,"+")}function Da(b,a){return encodeURIComponent(b).replace(/%40/gi,"@").replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%3B/gi,";").replace(/%20/g,a?"%20":"+")}function ud(b,a){var c,d,e=fb.length;b=G(b);for(d=0;d<e;++d)if(c=fb[d]+a,C(c=b.attr(c)))return c;return null}function vd(b,a){var c,d,e={};r(fb,function(a){a+="app";!c&&b.hasAttribute&&b.hasAttribute(a)&&(c=b,d=b.getAttribute(a))});
	r(fb,function(a){a+="app";var e;!c&&(e=b.querySelector("["+a.replace(":","\\:")+"]"))&&(c=e,d=e.getAttribute(a))});c&&(e.strictDi=null!==ud(c,"strict-di"),a(c,d?[d]:[],e))}function gc(b,a,c){S(c)||(c={});c=E({strictDi:!1},c);var d=function(){b=G(b);if(b.injector()){var d=b[0]===Y?"document":ta(b);throw Sa("btstrpd",d.replace(/</,"&lt;").replace(/>/,"&gt;"));}a=a||[];a.unshift(["$provide",function(a){a.value("$rootElement",b)}]);c.debugInfoEnabled&&a.push(["$compileProvider",function(a){a.debugInfoEnabled(!0)}]);
	a.unshift("ng");d=Cb(a,c.strictDi);d.invoke(["$rootScope","$rootElement","$compile","$injector",function(a,b,c,d){a.$apply(function(){b.data("$injector",d);c(b)(a)})}]);return d},e=/^NG_ENABLE_DEBUG_INFO!/,f=/^NG_DEFER_BOOTSTRAP!/;t&&e.test(t.name)&&(c.debugInfoEnabled=!0,t.name=t.name.replace(e,""));if(t&&!f.test(t.name))return d();t.name=t.name.replace(f,"");Ea.resumeBootstrap=function(b){r(b,function(b){a.push(b)});d()}}function wd(){t.name="NG_ENABLE_DEBUG_INFO!"+t.name;t.location.reload()}function xd(b){return Ea.element(b).injector().get("$$testability")}
	function Db(b,a){a=a||"_";return b.replace(yd,function(b,d){return(d?a:"")+b.toLowerCase()})}function zd(){var b;hc||((la=t.jQuery)&&la.fn.on?(G=la,E(la.fn,{scope:Ia.scope,isolateScope:Ia.isolateScope,controller:Ia.controller,injector:Ia.injector,inheritedData:Ia.inheritedData}),b=la.cleanData,la.cleanData=function(a){var c;if(Eb)Eb=!1;else for(var d=0,e;null!=(e=a[d]);d++)(c=la._data(e,"events"))&&c.$destroy&&la(e).triggerHandler("$destroy");b(a)}):G=V,Ea.element=G,hc=!0)}function Fb(b,a,c){if(!b)throw Sa("areq",
	a||"?",c||"required");return b}function gb(b,a,c){c&&L(b)&&(b=b[b.length-1]);Fb(D(b),a,"not a function, got "+(b&&"object"===typeof b?b.constructor.name||"Object":typeof b));return b}function Ja(b,a){if("hasOwnProperty"===b)throw Sa("badname",a);}function ic(b,a,c){if(!a)return b;a=a.split(".");for(var d,e=b,f=a.length,g=0;g<f;g++)d=a[g],b&&(b=(e=b)[d]);return!c&&D(b)?cc(e,b):b}function hb(b){var a=b[0];b=b[b.length-1];var c=[a];do{a=a.nextSibling;if(!a)break;c.push(a)}while(a!==b);return G(c)}function Ad(b){function a(a,
	b,c){return a[b]||(a[b]=c())}var c=K("$injector"),d=K("ng");b=a(b,"angular",Object);b.$$minErr=b.$$minErr||K;return a(b,"module",function(){var b={};return function(f,g,h){if("hasOwnProperty"===f)throw d("badname","module");g&&b.hasOwnProperty(f)&&(b[f]=null);return a(b,f,function(){function a(c,d,e,f){f||(f=b);return function(){f[e||"push"]([c,d,arguments]);return q}}if(!g)throw c("nomod",f);var b=[],d=[],e=[],l=a("$injector","invoke","push",d),q={_invokeQueue:b,_configBlocks:d,_runBlocks:e,requires:g,
	name:f,provider:a("$provide","provider"),factory:a("$provide","factory"),service:a("$provide","service"),value:a("$provide","value"),constant:a("$provide","constant","unshift"),animation:a("$animateProvider","register"),filter:a("$filterProvider","register"),controller:a("$controllerProvider","register"),directive:a("$compileProvider","directive"),config:l,run:function(a){e.push(a);return this}};h&&l(h);return q})}})}function Bd(b){E(b,{bootstrap:gc,copy:Ha,extend:E,equals:ra,element:G,forEach:r,
	injector:Cb,noop:w,bind:cc,toJson:sa,fromJson:dc,identity:Pa,isUndefined:F,isDefined:B,isString:C,isFunction:D,isObject:S,isNumber:ea,isElement:qd,isArray:L,version:Cd,isDate:fa,lowercase:P,uppercase:ib,callbacks:{counter:0},getTestability:xd,$$minErr:K,$$csp:Ua,reloadWithDebugInfo:wd,$$hasClass:jb});Va=Ad(t);try{Va("ngLocale")}catch(a){Va("ngLocale",[]).provider("$locale",Dd)}Va("ng",["ngLocale"],["$provide",function(a){a.provider({$$sanitizeUri:Ed});a.provider("$compile",jc).directive({a:Fd,input:kc,
	textarea:kc,form:Gd,script:Hd,select:Id,style:Jd,option:Kd,ngBind:Ld,ngBindHtml:Md,ngBindTemplate:Nd,ngClass:Od,ngClassEven:Pd,ngClassOdd:Qd,ngCloak:Rd,ngController:Sd,ngForm:Td,ngHide:Ud,ngIf:Vd,ngInclude:Wd,ngInit:Xd,ngNonBindable:Yd,ngPluralize:Zd,ngRepeat:$d,ngShow:ae,ngStyle:be,ngSwitch:ce,ngSwitchWhen:de,ngSwitchDefault:ee,ngOptions:fe,ngTransclude:ge,ngModel:he,ngList:ie,ngChange:je,pattern:lc,ngPattern:lc,required:mc,ngRequired:mc,minlength:nc,ngMinlength:nc,maxlength:oc,ngMaxlength:oc,ngValue:ke,
	ngModelOptions:le}).directive({ngInclude:me}).directive(kb).directive(pc);a.provider({$anchorScroll:ne,$animate:oe,$browser:pe,$cacheFactory:qe,$controller:re,$document:se,$exceptionHandler:te,$filter:qc,$interpolate:ue,$interval:ve,$http:we,$httpBackend:xe,$location:ye,$log:ze,$parse:Ae,$rootScope:Be,$q:Ce,$$q:De,$sce:Ee,$sceDelegate:Fe,$sniffer:Ge,$templateCache:He,$templateRequest:Ie,$$testability:Je,$timeout:Ke,$window:Le,$$rAF:Me,$$asyncCallback:Ne})}])}function Wa(b){return b.replace(Oe,function(a,
	b,d,e){return e?d.toUpperCase():d}).replace(Pe,"Moz$1")}function rc(b){b=b.nodeType;return 1===b||!b||9===b}function sc(b,a){var c,d,e=a.createDocumentFragment(),f=[];if(Gb.test(b)){c=c||e.appendChild(a.createElement("div"));d=(Qe.exec(b)||["",""])[1].toLowerCase();d=ia[d]||ia._default;c.innerHTML=d[1]+b.replace(Re,"<$1></$2>")+d[2];for(d=d[0];d--;)c=c.lastChild;f=db(f,c.childNodes);c=e.firstChild;c.textContent=""}else f.push(a.createTextNode(b));e.textContent="";e.innerHTML="";r(f,function(a){e.appendChild(a)});
	return e}function V(b){if(b instanceof V)return b;var a;C(b)&&(b=ba(b),a=!0);if(!(this instanceof V)){if(a&&"<"!=b.charAt(0))throw Hb("nosel");return new V(b)}if(a){a=Y;var c;b=(c=Se.exec(b))?[a.createElement(c[1])]:(c=sc(b,a))?c.childNodes:[]}tc(this,b)}function Ib(b){return b.cloneNode(!0)}function lb(b,a){a||mb(b);if(b.querySelectorAll)for(var c=b.querySelectorAll("*"),d=0,e=c.length;d<e;d++)mb(c[d])}function uc(b,a,c,d){if(B(d))throw Hb("offargs");var e=(d=nb(b))&&d.events;if(d&&d.handle)if(a)r(a.split(" "),
	function(a){F(c)?(b.removeEventListener(a,e[a],!1),delete e[a]):Ra(e[a]||[],c)});else for(a in e)"$destroy"!==a&&b.removeEventListener(a,e[a],!1),delete e[a]}function mb(b,a){var c=b.ng339,d=c&&ob[c];d&&(a?delete d.data[a]:(d.handle&&(d.events.$destroy&&d.handle({},"$destroy"),uc(b)),delete ob[c],b.ng339=s))}function nb(b,a){var c=b.ng339,c=c&&ob[c];a&&!c&&(b.ng339=c=++Te,c=ob[c]={events:{},data:{},handle:s});return c}function Jb(b,a,c){if(rc(b)){var d=B(c),e=!d&&a&&!S(a),f=!a;b=(b=nb(b,!e))&&b.data;
	if(d)b[a]=c;else{if(f)return b;if(e)return b&&b[a];E(b,a)}}}function jb(b,a){return b.getAttribute?-1<(" "+(b.getAttribute("class")||"")+" ").replace(/[\n\t]/g," ").indexOf(" "+a+" "):!1}function Kb(b,a){a&&b.setAttribute&&r(a.split(" "),function(a){b.setAttribute("class",ba((" "+(b.getAttribute("class")||"")+" ").replace(/[\n\t]/g," ").replace(" "+ba(a)+" "," ")))})}function Lb(b,a){if(a&&b.setAttribute){var c=(" "+(b.getAttribute("class")||"")+" ").replace(/[\n\t]/g," ");r(a.split(" "),function(a){a=
	ba(a);-1===c.indexOf(" "+a+" ")&&(c+=a+" ")});b.setAttribute("class",ba(c))}}function tc(b,a){if(a)if(a.nodeType)b[b.length++]=a;else{var c=a.length;if("number"===typeof c&&a.window!==a){if(c)for(var d=0;d<c;d++)b[b.length++]=a[d]}else b[b.length++]=a}}function vc(b,a){return pb(b,"$"+(a||"ngController")+"Controller")}function pb(b,a,c){9==b.nodeType&&(b=b.documentElement);for(a=L(a)?a:[a];b;){for(var d=0,e=a.length;d<e;d++)if((c=G.data(b,a[d]))!==s)return c;b=b.parentNode||11===b.nodeType&&b.host}}
	function wc(b){for(lb(b,!0);b.firstChild;)b.removeChild(b.firstChild)}function xc(b,a){a||lb(b);var c=b.parentNode;c&&c.removeChild(b)}function yc(b,a){var c=qb[a.toLowerCase()];return c&&zc[pa(b)]&&c}function Ue(b,a){var c=b.nodeName;return("INPUT"===c||"TEXTAREA"===c)&&Ac[a]}function Ve(b,a){var c=function(c,e){c.isDefaultPrevented=function(){return c.defaultPrevented};var f=a[e||c.type],g=f?f.length:0;if(g){1<g&&(f=qa(f));for(var h=0;h<g;h++)f[h].call(b,c)}};c.elem=b;return c}function Ka(b,a){var c=
	b&&b.$$hashKey;if(c)return"function"===typeof c&&(c=b.$$hashKey()),c;c=typeof b;return c="function"==c||"object"==c&&null!==b?b.$$hashKey=c+":"+(a||pd)():c+":"+b}function Xa(b,a){if(a){var c=0;this.nextUid=function(){return++c}}r(b,this.put,this)}function We(b){return(b=b.toString().replace(Bc,"").match(Cc))?"function("+(b[1]||"").replace(/[\s\r\n]+/," ")+")":"fn"}function Mb(b,a,c){var d;if("function"===typeof b){if(!(d=b.$inject)){d=[];if(b.length){if(a)throw C(c)&&c||(c=b.name||We(b)),La("strictdi",
	c);a=b.toString().replace(Bc,"");a=a.match(Cc);r(a[1].split(Xe),function(a){a.replace(Ye,function(a,b,c){d.push(c)})})}b.$inject=d}}else L(b)?(a=b.length-1,gb(b[a],"fn"),d=b.slice(0,a)):gb(b,"fn",!0);return d}function Cb(b,a){function c(a){return function(b,c){if(S(b))r(b,$b(a));else return a(b,c)}}function d(a,b){Ja(a,"service");if(D(b)||L(b))b=p.instantiate(b);if(!b.$get)throw La("pget",a);return n[a+"Provider"]=b}function e(a,b){return d(a,{$get:b})}function f(a){var b=[],c;r(a,function(a){function d(a){var b,
	c;b=0;for(c=a.length;b<c;b++){var e=a[b],f=p.get(e[0]);f[e[1]].apply(f,e[2])}}if(!k.get(a)){k.put(a,!0);try{C(a)?(c=Va(a),b=b.concat(f(c.requires)).concat(c._runBlocks),d(c._invokeQueue),d(c._configBlocks)):D(a)?b.push(p.invoke(a)):L(a)?b.push(p.invoke(a)):gb(a,"module")}catch(e){throw L(a)&&(a=a[a.length-1]),e.message&&e.stack&&-1==e.stack.indexOf(e.message)&&(e=e.message+"\n"+e.stack),La("modulerr",a,e.stack||e.message||e);}}});return b}function g(b,c){function d(a){if(b.hasOwnProperty(a)){if(b[a]===
	h)throw La("cdep",a+" <- "+m.join(" <- "));return b[a]}try{return m.unshift(a),b[a]=h,b[a]=c(a)}catch(e){throw b[a]===h&&delete b[a],e;}finally{m.shift()}}function e(b,c,f,h){"string"===typeof f&&(h=f,f=null);var g=[];h=Mb(b,a,h);var k,m,l;m=0;for(k=h.length;m<k;m++){l=h[m];if("string"!==typeof l)throw La("itkn",l);g.push(f&&f.hasOwnProperty(l)?f[l]:d(l))}L(b)&&(b=b[k]);return b.apply(c,g)}return{invoke:e,instantiate:function(a,b,c){var d=function(){};d.prototype=(L(a)?a[a.length-1]:a).prototype;
	d=new d;a=e(a,d,b,c);return S(a)||D(a)?a:d},get:d,annotate:Mb,has:function(a){return n.hasOwnProperty(a+"Provider")||b.hasOwnProperty(a)}}}a=!0===a;var h={},m=[],k=new Xa([],!0),n={$provide:{provider:c(d),factory:c(e),service:c(function(a,b){return e(a,["$injector",function(a){return a.instantiate(b)}])}),value:c(function(a,b){return e(a,da(b))}),constant:c(function(a,b){Ja(a,"constant");n[a]=b;l[a]=b}),decorator:function(a,b){var c=p.get(a+"Provider"),d=c.$get;c.$get=function(){var a=q.invoke(d,
	c);return q.invoke(b,null,{$delegate:a})}}}},p=n.$injector=g(n,function(){throw La("unpr",m.join(" <- "));}),l={},q=l.$injector=g(l,function(a){var b=p.get(a+"Provider");return q.invoke(b.$get,b,s,a)});r(f(b),function(a){q.invoke(a||w)});return q}function ne(){var b=!0;this.disableAutoScrolling=function(){b=!1};this.$get=["$window","$location","$rootScope",function(a,c,d){function e(a){var b=null;r(a,function(a){b||"a"!==pa(a)||(b=a)});return b}function f(){var b=c.hash(),d;b?(d=g.getElementById(b))?
	d.scrollIntoView():(d=e(g.getElementsByName(b)))?d.scrollIntoView():"top"===b&&a.scrollTo(0,0):a.scrollTo(0,0)}var g=a.document;b&&d.$watch(function(){return c.hash()},function(){d.$evalAsync(f)});return f}]}function Ne(){this.$get=["$$rAF","$timeout",function(b,a){return b.supported?function(a){return b(a)}:function(b){return a(b,0,!1)}}]}function Ze(b,a,c,d){function e(a){try{a.apply(null,Ta.call(arguments,1))}finally{if(A--,0===A)for(;u.length;)try{u.pop()()}catch(b){c.error(b)}}}function f(a,
	b){(function R(){r(x,function(a){a()});z=b(R,a)})()}function g(){y=null;T!=h.url()&&(T=h.url(),r(Q,function(a){a(h.url())}))}var h=this,m=a[0],k=b.location,n=b.history,p=b.setTimeout,l=b.clearTimeout,q={};h.isMock=!1;var A=0,u=[];h.$$completeOutstandingRequest=e;h.$$incOutstandingRequestCount=function(){A++};h.notifyWhenNoOutstandingRequests=function(a){r(x,function(a){a()});0===A?a():u.push(a)};var x=[],z;h.addPollFn=function(a){F(z)&&f(100,p);x.push(a);return a};var T=k.href,v=a.find("base"),y=
	null;h.url=function(a,c){k!==b.location&&(k=b.location);n!==b.history&&(n=b.history);if(a){if(T!=a)return T=a,d.history?c?n.replaceState(null,"",a):(n.pushState(null,"",a),v.attr("href",v.attr("href"))):(y=a,c?k.replace(a):k.href=a),h}else return y||k.href.replace(/%27/g,"'")};var Q=[],ca=!1;h.onUrlChange=function(a){if(!ca){if(d.history)G(b).on("popstate",g);if(d.hashchange)G(b).on("hashchange",g);else h.addPollFn(g);ca=!0}Q.push(a);return a};h.$$checkUrlChange=g;h.baseHref=function(){var a=v.attr("href");
	return a?a.replace(/^(https?\:)?\/\/[^\/]*/,""):""};var J={},N="",M=h.baseHref();h.cookies=function(a,b){var d,e,f,h;if(a)b===s?m.cookie=encodeURIComponent(a)+"=;path="+M+";expires=Thu, 01 Jan 1970 00:00:00 GMT":C(b)&&(d=(m.cookie=encodeURIComponent(a)+"="+encodeURIComponent(b)+";path="+M).length+1,4096<d&&c.warn("Cookie '"+a+"' possibly not set or overflowed because it was too large ("+d+" > 4096 bytes)!"));else{if(m.cookie!==N)for(N=m.cookie,d=N.split("; "),J={},f=0;f<d.length;f++)e=d[f],h=e.indexOf("="),
	0<h&&(a=decodeURIComponent(e.substring(0,h)),J[a]===s&&(J[a]=decodeURIComponent(e.substring(h+1))));return J}};h.defer=function(a,b){var c;A++;c=p(function(){delete q[c];e(a)},b||0);q[c]=!0;return c};h.defer.cancel=function(a){return q[a]?(delete q[a],l(a),e(w),!0):!1}}function pe(){this.$get=["$window","$log","$sniffer","$document",function(b,a,c,d){return new Ze(b,d,a,c)}]}function qe(){this.$get=function(){function b(b,d){function e(a){a!=p&&(l?l==a&&(l=a.n):l=a,f(a.n,a.p),f(a,p),p=a,p.n=null)}
	function f(a,b){a!=b&&(a&&(a.p=b),b&&(b.n=a))}if(b in a)throw K("$cacheFactory")("iid",b);var g=0,h=E({},d,{id:b}),m={},k=d&&d.capacity||Number.MAX_VALUE,n={},p=null,l=null;return a[b]={put:function(a,b){if(k<Number.MAX_VALUE){var c=n[a]||(n[a]={key:a});e(c)}if(!F(b))return a in m||g++,m[a]=b,g>k&&this.remove(l.key),b},get:function(a){if(k<Number.MAX_VALUE){var b=n[a];if(!b)return;e(b)}return m[a]},remove:function(a){if(k<Number.MAX_VALUE){var b=n[a];if(!b)return;b==p&&(p=b.p);b==l&&(l=b.n);f(b.n,
	b.p);delete n[a]}delete m[a];g--},removeAll:function(){m={};g=0;n={};p=l=null},destroy:function(){n=h=m=null;delete a[b]},info:function(){return E({},h,{size:g})}}}var a={};b.info=function(){var b={};r(a,function(a,e){b[e]=a.info()});return b};b.get=function(b){return a[b]};return b}}function He(){this.$get=["$cacheFactory",function(b){return b("templates")}]}function jc(b,a){var c={},d=/^\s*directive\:\s*([\d\w_\-]+)\s+(.*)$/,e=/(([\d\w_\-]+)(?:\:([^;]+))?;?)/,f=rd("ngSrc,ngSrcset,src,srcset"),g=
	/^(on[a-z]+|formaction)$/;this.directive=function k(a,d){Ja(a,"directive");C(a)?(Fb(d,"directiveFactory"),c.hasOwnProperty(a)||(c[a]=[],b.factory(a+"Directive",["$injector","$exceptionHandler",function(b,d){var e=[];r(c[a],function(c,f){try{var h=b.invoke(c);D(h)?h={compile:da(h)}:!h.compile&&h.link&&(h.compile=da(h.link));h.priority=h.priority||0;h.index=f;h.name=h.name||a;h.require=h.require||h.controller&&h.name;h.restrict=h.restrict||"EA";e.push(h)}catch(g){d(g)}});return e}])),c[a].push(d)):
	r(a,$b(k));return this};this.aHrefSanitizationWhitelist=function(b){return B(b)?(a.aHrefSanitizationWhitelist(b),this):a.aHrefSanitizationWhitelist()};this.imgSrcSanitizationWhitelist=function(b){return B(b)?(a.imgSrcSanitizationWhitelist(b),this):a.imgSrcSanitizationWhitelist()};var h=!0;this.debugInfoEnabled=function(a){return B(a)?(h=a,this):h};this.$get=["$injector","$interpolate","$exceptionHandler","$templateRequest","$parse","$controller","$rootScope","$document","$sce","$animate","$$sanitizeUri",
	function(a,b,p,l,q,A,u,x,z,T,v){function y(a,b){try{a.addClass(b)}catch(c){}}function Q(a,b,c,d,e){a instanceof G||(a=G(a));r(a,function(b,c){3==b.nodeType&&b.nodeValue.match(/\S+/)&&(a[c]=G(b).wrap("<span></span>").parent()[0])});var f=ca(a,b,a,c,d,e);Q.$$addScopeClass(a);var h=null,g=a,k;return function(b,c,d,e,l){Fb(b,"scope");h||(h=(l=l&&l[0])?"foreignobject"!==pa(l)&&l.toString().match(/SVG/)?"svg":"html":"html");"html"!==h&&a[0]!==k&&(g=G(Nb(h,G("<div>").append(a).html())));k=a[0];l=c?Ia.clone.call(g):
	g;if(d)for(var n in d)l.data("$"+n+"Controller",d[n].instance);Q.$$addScopeInfo(l,b);c&&c(l,b);f&&f(b,l,l,e);return l}}function ca(a,b,c,d,e,f){function h(a,c,d,e){var f,k,l,n,u,q,ua;if(p)for(ua=Array(c.length),n=0;n<g.length;n+=3)f=g[n],ua[f]=c[f];else ua=c;n=0;for(u=g.length;n<u;)k=ua[g[n++]],c=g[n++],f=g[n++],c?(c.scope?(l=a.$new(),Q.$$addScopeInfo(G(k),l)):l=a,q=c.transcludeOnThisElement?J(a,c.transclude,e,c.elementTranscludeOnThisElement):!c.templateOnThisElement&&e?e:!e&&b?J(a,b):null,c(f,l,
	k,d,q)):f&&f(a,k.childNodes,s,e)}for(var g=[],k,l,n,u,p,q=0;q<a.length;q++){k=new Ob;l=N(a[q],[],k,0===q?d:s,e);(f=l.length?H(l,a[q],k,b,c,null,[],[],f):null)&&f.scope&&Q.$$addScopeClass(k.$$element);k=f&&f.terminal||!(n=a[q].childNodes)||!n.length?null:ca(n,f?(f.transcludeOnThisElement||!f.templateOnThisElement)&&f.transclude:b);if(f||k)g.push(q,f,k),u=!0,p=p||f;f=null}return u?h:null}function J(a,b,c,d){return function(e,f,h,g){var k=!1;e||(e=a.$new(),k=e.$$transcluded=!0);f=b(e,f,h,c,g);if(k&&
	!d)f.on("$destroy",function(){e.$destroy()});return f}}function N(b,f,h,g,l){var n=h.$attr,u;switch(b.nodeType){case 1:R(f,va(pa(b)),"E",g,l);for(var p,q,T,A=b.attributes,z=0,v=A&&A.length;z<v;z++){var x=!1,J=!1;p=A[z];if(!X||8<=X||p.specified){u=p.name;p=ba(p.value);q=va(u);if(T=U.test(q))u=Db(q.substr(6),"-");var W=q.replace(/(Start|End)$/,""),r;a:{var H=W;if(c.hasOwnProperty(H)){r=void 0;for(var H=a.get(H+"Directive"),O=0,Q=H.length;O<Q;O++)if(r=H[O],r.multiElement){r=!0;break a}}r=!1}r&&q===W+
	"Start"&&(x=u,J=u.substr(0,u.length-5)+"end",u=u.substr(0,u.length-6));q=va(u.toLowerCase());n[q]=u;if(T||!h.hasOwnProperty(q))h[q]=p,yc(b,q)&&(h[q]=!0);ya(b,f,p,q,T);R(f,q,"A",g,l,x,J)}}b=b.className;if(C(b)&&""!==b)for(;u=e.exec(b);)q=va(u[2]),R(f,q,"C",g,l)&&(h[q]=ba(u[3])),b=b.substr(u.index+u[0].length);break;case 3:t(f,b.nodeValue);break;case 8:try{if(u=d.exec(b.nodeValue))q=va(u[1]),R(f,q,"M",g,l)&&(h[q]=ba(u[2]))}catch(M){}}f.sort(F);return f}function M(a,b,c){var d=[],e=0;if(b&&a.hasAttribute&&
	a.hasAttribute(b)){do{if(!a)throw ja("uterdir",b,c);1==a.nodeType&&(a.hasAttribute(b)&&e++,a.hasAttribute(c)&&e--);d.push(a);a=a.nextSibling}while(0<e)}else d.push(a);return G(d)}function O(a,b,c){return function(d,e,f,h,g){e=M(e[0],b,c);return a(d,e,f,h,g)}}function H(a,c,d,e,f,h,g,k,l){function u(a,b,c,d){if(a){c&&(a=O(a,c,d));a.require=I.require;a.directiveName=ha;if(y===I||I.$$isolateScope)a=ga(a,{isolateScope:!0});g.push(a)}if(b){c&&(b=O(b,c,d));b.require=I.require;b.directiveName=ha;if(y===
	I||I.$$isolateScope)b=ga(b,{isolateScope:!0});k.push(b)}}function T(a,b,c,d){var e,f="data",h=!1;if(C(b)){for(;"^"==(e=b.charAt(0))||"?"==e;)b=b.substr(1),"^"==e&&(f="inheritedData"),h=h||"?"==e;e=null;d&&"data"===f&&(e=d[b])&&(e=e.instance);e=e||c[f]("$"+b+"Controller");if(!e&&!h)throw ja("ctreq",b,a);}else L(b)&&(e=[],r(b,function(b){e.push(T(a,b,c,d))}));return e}function z(a,e,f,h,l){function u(a,b,c){var d;Qa(a)||(c=b,b=a,a=s);E&&(d=W);c||(c=E?M.parent():M);return l(a,b,d,c)}var p,v,ua,x,W,O,
	M,R;c===f?(R=d,M=d.$$element):(M=G(f),R=new Ob(M,d));y&&(x=e.$new(!0));O=l&&u;J&&(H={},W={},r(J,function(a){var b={$scope:a===y||a.$$isolateScope?x:e,$element:M,$attrs:R,$transclude:O};ua=a.controller;"@"==ua&&(ua=R[a.name]);b=A(ua,b,!0,a.controllerAs);W[a.name]=b;E||M.data("$"+a.name+"Controller",b.instance);H[a.name]=b}));if(y){var N=/^\s*([@=&])(\??)\s*(\w*)\s*$/;Q.$$addScopeInfo(M,x,!0,!(ca&&(ca===y||ca===y.$$originalDirective)));Q.$$addScopeClass(M,!0);h=H&&H[y.name];var xa=x;h&&h.identifier&&
	!0===y.bindToController&&(xa=h.instance);r(y.scope,function(a,c){var d=a.match(N)||[],f=d[3]||c,h="?"==d[2],d=d[1],g,k,l,u;x.$$isolateBindings[c]=d+f;switch(d){case "@":R.$observe(f,function(a){x[c]=a});R.$$observers[f].$$scope=e;R[f]&&(xa[c]=b(R[f])(e));break;case "=":if(h&&!R[f])break;k=q(R[f]);u=k.literal?ra:function(a,b){return a===b||a!==a&&b!==b};l=k.assign||function(){g=xa[c]=k(e);throw ja("nonassign",R[f],y.name);};g=xa[c]=k(e);h=e.$watch(q(R[f],function(a){u(a,xa[c])||(u(a,g)?l(e,a=xa[c]):
	xa[c]=a);return g=a}),null,k.literal);x.$on("$destroy",h);break;case "&":k=q(R[f]);xa[c]=function(a){return k(e,a)};break;default:throw ja("iscp",y.name,c,a);}})}H&&(r(H,function(a){a()}),H=null);h=0;for(p=g.length;h<p;h++)v=g[h],Dc(v,v.isolateScope?x:e,M,R,v.require&&T(v.directiveName,v.require,M,W),O);h=e;y&&(y.template||null===y.templateUrl)&&(h=x);a&&a(h,f.childNodes,s,l);for(h=k.length-1;0<=h;h--)v=k[h],Dc(v,v.isolateScope?x:e,M,R,v.require&&T(v.directiveName,v.require,M,W),O)}l=l||{};for(var v=
	-Number.MAX_VALUE,x,J=l.controllerDirectives,H,y=l.newIsolateScopeDirective,ca=l.templateDirective,R=l.nonTlbTranscludeDirective,w=!1,F=!1,E=l.hasElementTranscludeDirective,aa=d.$$element=G(c),I,ha,t,P=e,za,ma=0,ya=a.length;ma<ya;ma++){I=a[ma];var U=I.$$start,X=I.$$end;U&&(aa=M(c,U,X));t=s;if(v>I.priority)break;if(t=I.scope)I.templateUrl||(S(t)?(K("new/isolated scope",y||x,I,aa),y=I):K("new/isolated scope",y,I,aa)),x=x||I;ha=I.name;!I.templateUrl&&I.controller&&(t=I.controller,J=J||{},K("'"+ha+"' controller",
	J[ha],I,aa),J[ha]=I);if(t=I.transclude)w=!0,I.$$tlb||(K("transclusion",R,I,aa),R=I),"element"==t?(E=!0,v=I.priority,t=aa,aa=d.$$element=G(Y.createComment(" "+ha+": "+d[ha]+" ")),c=aa[0],rb(f,Ta.call(t,0),c),P=Q(t,e,v,h&&h.name,{nonTlbTranscludeDirective:R})):(t=G(Ib(c)).contents(),aa.empty(),P=Q(t,e));if(I.template)if(F=!0,K("template",ca,I,aa),ca=I,t=D(I.template)?I.template(aa,d):I.template,t=V(t),I.replace){h=I;t=Gb.test(t)?G(Nb(I.templateNamespace,ba(t))):[];c=t[0];if(1!=t.length||1!==c.nodeType)throw ja("tplrt",
	ha,"");rb(f,aa,c);ya={$attr:{}};t=N(c,[],ya);var Z=a.splice(ma+1,a.length-(ma+1));y&&W(t);a=a.concat(t).concat(Z);B(d,ya);ya=a.length}else aa.html(t);if(I.templateUrl)F=!0,K("template",ca,I,aa),ca=I,I.replace&&(h=I),z=$e(a.splice(ma,a.length-ma),aa,d,f,w&&P,g,k,{controllerDirectives:J,newIsolateScopeDirective:y,templateDirective:ca,nonTlbTranscludeDirective:R}),ya=a.length;else if(I.compile)try{za=I.compile(aa,d,P),D(za)?u(null,za,U,X):za&&u(za.pre,za.post,U,X)}catch($){p($,ta(aa))}I.terminal&&(z.terminal=
	!0,v=Math.max(v,I.priority))}z.scope=x&&!0===x.scope;z.transcludeOnThisElement=w;z.elementTranscludeOnThisElement=E;z.templateOnThisElement=F;z.transclude=P;l.hasElementTranscludeDirective=E;return z}function W(a){for(var b=0,c=a.length;b<c;b++)a[b]=bc(a[b],{$$isolateScope:!0})}function R(b,d,e,f,h,g,l){if(d===h)return null;h=null;if(c.hasOwnProperty(d)){var n;d=a.get(d+"Directive");for(var u=0,q=d.length;u<q;u++)try{n=d[u],(f===s||f>n.priority)&&-1!=n.restrict.indexOf(e)&&(g&&(n=bc(n,{$$start:g,
	$$end:l})),b.push(n),h=n)}catch(T){p(T)}}return h}function B(a,b){var c=b.$attr,d=a.$attr,e=a.$$element;r(a,function(d,e){"$"!=e.charAt(0)&&(b[e]&&b[e]!==d&&(d+=("style"===e?";":" ")+b[e]),a.$set(e,d,!0,c[e]))});r(b,function(b,f){"class"==f?(y(e,b),a["class"]=(a["class"]?a["class"]+" ":"")+b):"style"==f?(e.attr("style",e.attr("style")+";"+b),a.style=(a.style?a.style+";":"")+b):"$"==f.charAt(0)||a.hasOwnProperty(f)||(a[f]=b,d[f]=c[f])})}function $e(a,b,c,d,e,f,h,g){var k=[],n,u,p=b[0],q=a.shift(),
	T=E({},q,{templateUrl:null,transclude:null,replace:null,$$originalDirective:q}),v=D(q.templateUrl)?q.templateUrl(b,c):q.templateUrl,A=q.templateNamespace;b.empty();l(z.getTrustedResourceUrl(v)).then(function(l){var z,x;l=V(l);if(q.replace){l=Gb.test(l)?G(Nb(A,ba(l))):[];z=l[0];if(1!=l.length||1!==z.nodeType)throw ja("tplrt",q.name,v);l={$attr:{}};rb(d,b,z);var O=N(z,[],l);S(q.scope)&&W(O);a=O.concat(a);B(c,l)}else z=p,b.html(l);a.unshift(T);n=H(a,z,c,e,b,q,f,h,g);r(d,function(a,c){a==z&&(d[c]=b[0])});
	for(u=ca(b[0].childNodes,e);k.length;){l=k.shift();x=k.shift();var M=k.shift(),Q=k.shift(),O=b[0];if(x!==p){var R=x.className;g.hasElementTranscludeDirective&&q.replace||(O=Ib(z));rb(M,G(x),O);y(G(O),R)}x=n.transcludeOnThisElement?J(l,n.transclude,Q):Q;n(u,l,O,d,x)}k=null});return function(a,b,c,d,e){a=e;k?(k.push(b),k.push(c),k.push(d),k.push(a)):(n.transcludeOnThisElement&&(a=J(b,n.transclude,e)),n(u,b,c,d,a))}}function F(a,b){var c=b.priority-a.priority;return 0!==c?c:a.name!==b.name?a.name<b.name?
	-1:1:a.index-b.index}function K(a,b,c,d){if(b)throw ja("multidir",b.name,c.name,a,ta(d));}function t(a,c){var d=b(c,!0);d&&a.push({priority:0,compile:function(a){a=a.parent();var b=!!a.length;b&&Q.$$addBindingClass(a);return function(a,c){var e=c.parent();b||Q.$$addBindingClass(e);Q.$$addBindingInfo(e,d.expressions);a.$watch(d,function(a){c[0].nodeValue=a})}}})}function Nb(a,b){a=P(a||"html");switch(a){case "svg":case "math":var c=Y.createElement("div");c.innerHTML="<"+a+">"+b+"</"+a+">";return c.childNodes[0].childNodes;
	default:return b}}function za(a,b){if("srcdoc"==b)return z.HTML;var c=pa(a);if("xlinkHref"==b||"form"==c&&"action"==b||"img"!=c&&("src"==b||"ngSrc"==b))return z.RESOURCE_URL}function ya(a,c,d,e,h){var k=b(d,!0);if(k){if("multiple"===e&&"select"===pa(a))throw ja("selmulti",ta(a));c.push({priority:100,compile:function(){return{pre:function(c,d,l){d=l.$$observers||(l.$$observers={});if(g.test(e))throw ja("nodomevents");if(k=b(l[e],!0,za(a,e),f[e]||h))l[e]=k(c),(d[e]||(d[e]=[])).$$inter=!0,(l.$$observers&&
	l.$$observers[e].$$scope||c).$watch(k,function(a,b){"class"===e&&a!=b?l.$updateClass(a,b):l.$set(e,a)})}}}})}}function rb(a,b,c){var d=b[0],e=b.length,f=d.parentNode,h,g;if(a)for(h=0,g=a.length;h<g;h++)if(a[h]==d){a[h++]=c;g=h+e-1;for(var k=a.length;h<k;h++,g++)g<k?a[h]=a[g]:delete a[h];a.length-=e-1;a.context===d&&(a.context=c);break}f&&f.replaceChild(c,d);a=Y.createDocumentFragment();a.appendChild(d);G(c).data(G(d).data());la?(Eb=!0,la.cleanData([d])):delete G.cache[d[G.expando]];d=1;for(e=b.length;d<
	e;d++)f=b[d],G(f).remove(),a.appendChild(f),delete b[d];b[0]=c;b.length=1}function ga(a,b){return E(function(){return a.apply(null,arguments)},a,b)}function Dc(a,b,c,d,e,f){try{a(b,c,d,e,f)}catch(h){p(h,ta(c))}}var Ob=function(a,b){if(b){var c=Object.keys(b),d,e,f;d=0;for(e=c.length;d<e;d++)f=c[d],this[f]=b[f]}else this.$attr={};this.$$element=a};Ob.prototype={$normalize:va,$addClass:function(a){a&&0<a.length&&T.addClass(this.$$element,a)},$removeClass:function(a){a&&0<a.length&&T.removeClass(this.$$element,
	a)},$updateClass:function(a,b){var c=Ec(a,b);c&&c.length&&T.addClass(this.$$element,c);(c=Ec(b,a))&&c.length&&T.removeClass(this.$$element,c)},$set:function(a,b,c,d){var e=this.$$element[0],f=yc(e,a),h=Ue(e,a),e=a;f?(this.$$element.prop(a,b),d=f):h&&(this[h]=b,e=h);this[a]=b;d?this.$attr[a]=d:(d=this.$attr[a])||(this.$attr[a]=d=Db(a,"-"));f=pa(this.$$element);if("a"===f&&"href"===a||"img"===f&&"src"===a)this[a]=b=v(b,"src"===a);!1!==c&&(null===b||b===s?this.$$element.removeAttr(d):this.$$element.attr(d,
	b));(a=this.$$observers)&&r(a[e],function(a){try{a(b)}catch(c){p(c)}})},$observe:function(a,b){var c=this,d=c.$$observers||(c.$$observers={}),e=d[a]||(d[a]=[]);e.push(b);u.$evalAsync(function(){e.$$inter||b(c[a])});return function(){Ra(e,b)}}};var ma=b.startSymbol(),ha=b.endSymbol(),V="{{"==ma||"}}"==ha?Pa:function(a){return a.replace(/\{\{/g,ma).replace(/}}/g,ha)},U=/^ngAttr[A-Z]/;Q.$$addBindingInfo=h?function(a,b){var c=a.data("$binding")||[];L(b)?c=c.concat(b):c.push(b);a.data("$binding",c)}:w;
	Q.$$addBindingClass=h?function(a){y(a,"ng-binding")}:w;Q.$$addScopeInfo=h?function(a,b,c,d){a.data(c?d?"$isolateScopeNoTemplate":"$isolateScope":"$scope",b)}:w;Q.$$addScopeClass=h?function(a,b){y(a,b?"ng-isolate-scope":"ng-scope")}:w;return Q}]}function va(b){return Wa(b.replace(af,""))}function Ec(b,a){var c="",d=b.split(/\s+/),e=a.split(/\s+/),f=0;a:for(;f<d.length;f++){for(var g=d[f],h=0;h<e.length;h++)if(g==e[h])continue a;c+=(0<c.length?" ":"")+g}return c}function re(){var b={},a=!1,c=/^(\S+)(\s+as\s+(\w+))?$/;
	this.register=function(a,c){Ja(a,"controller");S(a)?E(b,a):b[a]=c};this.allowGlobals=function(){a=!0};this.$get=["$injector","$window",function(d,e){function f(a,b,c,d){if(!a||!S(a.$scope))throw K("$controller")("noscp",d,b);a.$scope[b]=c}return function(g,h,m,k){var n,p,l;m=!0===m;k&&C(k)&&(l=k);C(g)&&(k=g.match(c),p=k[1],l=l||k[3],g=b.hasOwnProperty(p)?b[p]:ic(h.$scope,p,!0)||(a?ic(e,p,!0):s),gb(g,p,!0));if(m)return m=function(){},m.prototype=(L(g)?g[g.length-1]:g).prototype,n=new m,l&&f(h,l,n,
	p||g.name),E(function(){d.invoke(g,n,h,p);return n},{instance:n,identifier:l});n=d.instantiate(g,h,p);l&&f(h,l,n,p||g.name);return n}}]}function se(){this.$get=["$window",function(b){return G(b.document)}]}function te(){this.$get=["$log",function(b){return function(a,c){b.error.apply(b,arguments)}}]}function Fc(b){var a={},c,d,e;if(!b)return a;r(b.split("\n"),function(b){e=b.indexOf(":");c=P(ba(b.substr(0,e)));d=ba(b.substr(e+1));c&&(a[c]=a[c]?a[c]+", "+d:d)});return a}function Gc(b){var a=S(b)?b:
	s;return function(c){a||(a=Fc(b));return c?a[P(c)]||null:a}}function Hc(b,a,c){if(D(c))return c(b,a);r(c,function(c){b=c(b,a)});return b}function we(){var b=/^\s*(\[|\{[^\{])/,a=/[\}\]]\s*$/,c=/^\)\]\}',?\n/,d={"Content-Type":"application/json;charset=utf-8"},e=this.defaults={transformResponse:[function(d){C(d)&&(d=d.replace(c,""),b.test(d)&&a.test(d)&&(d=dc(d)));return d}],transformRequest:[function(a){return S(a)&&"[object File]"!==Ga.call(a)&&"[object Blob]"!==Ga.call(a)?sa(a):a}],headers:{common:{Accept:"application/json, text/plain, */*"},
	post:qa(d),put:qa(d),patch:qa(d)},xsrfCookieName:"XSRF-TOKEN",xsrfHeaderName:"X-XSRF-TOKEN"},f=!1;this.useApplyAsync=function(a){return B(a)?(f=!!a,this):f};var g=this.interceptors=[];this.$get=["$httpBackend","$browser","$cacheFactory","$rootScope","$q","$injector",function(a,b,c,d,p,l){function q(a){function b(a){var d=E({},a,{data:Hc(a.data,a.headers,c.transformResponse)});a=a.status;return 200<=a&&300>a?d:p.reject(d)}var c={method:"get",transformRequest:e.transformRequest,transformResponse:e.transformResponse},
	d=function(a){var b=e.headers,c=E({},a.headers),d,f,b=E({},b.common,b[P(a.method)]);a:for(d in b){a=P(d);for(f in c)if(P(f)===a)continue a;c[d]=b[d]}(function(a){var b;r(a,function(c,d){D(c)&&(b=c(),null!=b?a[d]=b:delete a[d])})})(c);return c}(a);E(c,a);c.headers=d;c.method=ib(c.method);var f=[function(a){d=a.headers;var c=Hc(a.data,Gc(d),a.transformRequest);F(c)&&r(d,function(a,b){"content-type"===P(b)&&delete d[b]});F(a.withCredentials)&&!F(e.withCredentials)&&(a.withCredentials=e.withCredentials);
	return A(a,c,d).then(b,b)},s],h=p.when(c);for(r(z,function(a){(a.request||a.requestError)&&f.unshift(a.request,a.requestError);(a.response||a.responseError)&&f.push(a.response,a.responseError)});f.length;){a=f.shift();var g=f.shift(),h=h.then(a,g)}h.success=function(a){h.then(function(b){a(b.data,b.status,b.headers,c)});return h};h.error=function(a){h.then(null,function(b){a(b.data,b.status,b.headers,c)});return h};return h}function A(c,g,k){function l(a,b,c,e){function h(){z(b,a,c,e)}O&&(200<=a&&
	300>a?O.put(W,[a,b,Fc(c),e]):O.remove(W));f?d.$applyAsync(h):(h(),d.$$phase||d.$apply())}function z(a,b,d,e){b=Math.max(b,0);(200<=b&&300>b?r.resolve:r.reject)({data:a,status:b,headers:Gc(d),config:c,statusText:e})}function A(){var a=q.pendingRequests.indexOf(c);-1!==a&&q.pendingRequests.splice(a,1)}var r=p.defer(),M=r.promise,O,H,W=u(c.url,c.params);q.pendingRequests.push(c);M.then(A,A);!c.cache&&!e.cache||!1===c.cache||"GET"!==c.method&&"JSONP"!==c.method||(O=S(c.cache)?c.cache:S(e.cache)?e.cache:
	x);if(O)if(H=O.get(W),B(H)){if(H&&D(H.then))return H.then(A,A),H;L(H)?z(H[1],H[0],qa(H[2]),H[3]):z(H,200,{},"OK")}else O.put(W,M);F(H)&&((H=Ic(c.url)?b.cookies()[c.xsrfCookieName||e.xsrfCookieName]:s)&&(k[c.xsrfHeaderName||e.xsrfHeaderName]=H),a(c.method,W,g,l,k,c.timeout,c.withCredentials,c.responseType));return M}function u(a,b){if(!b)return a;var c=[];od(b,function(a,b){null===a||F(a)||(L(a)||(a=[a]),r(a,function(a){S(a)&&(a=fa(a)?a.toISOString():sa(a));c.push(Da(b)+"="+Da(a))}))});0<c.length&&
	(a+=(-1==a.indexOf("?")?"?":"&")+c.join("&"));return a}var x=c("$http"),z=[];r(g,function(a){z.unshift(C(a)?l.get(a):l.invoke(a))});q.pendingRequests=[];(function(a){r(arguments,function(a){q[a]=function(b,c){return q(E(c||{},{method:a,url:b}))}})})("get","delete","head","jsonp");(function(a){r(arguments,function(a){q[a]=function(b,c,d){return q(E(d||{},{method:a,url:b,data:c}))}})})("post","put","patch");q.defaults=e;return q}]}function bf(b){if(8>=X&&(!b.match(/^(get|post|head|put|delete|options)$/i)||
	!t.XMLHttpRequest))return new t.ActiveXObject("Microsoft.XMLHTTP");if(t.XMLHttpRequest)return new t.XMLHttpRequest;throw K("$httpBackend")("noxhr");}function xe(){this.$get=["$browser","$window","$document",function(b,a,c){return cf(b,bf,b.defer,a.angular.callbacks,c[0])}]}function cf(b,a,c,d,e){function f(a,b,c){var f=e.createElement("script"),n=null;f.type="text/javascript";f.src=a;f.async=!0;n=function(a){f.removeEventListener("load",n,!1);f.removeEventListener("error",n,!1);e.body.removeChild(f);
	f=null;var g=-1,q="unknown";a&&("load"!==a.type||d[b].called||(a={type:"error"}),q=a.type,g="error"===a.type?404:200);c&&c(g,q)};f.addEventListener("load",n,!1);f.addEventListener("error",n,!1);e.body.appendChild(f);return n}return function(e,h,m,k,n,p,l,q){function A(){x=-1;T&&T();v&&v.abort()}function u(a,d,e,f,g){Q&&c.cancel(Q);T=v=null;0===d&&(d=e?200:"file"==Aa(h).protocol?404:0);a(1223===d?204:d,e,f,g||"");b.$$completeOutstandingRequest(w)}var x;b.$$incOutstandingRequestCount();h=h||b.url();
	if("jsonp"==P(e)){var z="_"+(d.counter++).toString(36);d[z]=function(a){d[z].data=a;d[z].called=!0};var T=f(h.replace("JSON_CALLBACK","angular.callbacks."+z),z,function(a,b){u(k,a,d[z].data,"",b);d[z]=w})}else{var v=a(e);v.open(e,h,!0);r(n,function(a,b){B(a)&&v.setRequestHeader(b,a)});v.onreadystatechange=function(){if(v&&4==v.readyState){var a=null,b=null,c="";-1!==x&&(a=v.getAllResponseHeaders(),b="response"in v?v.response:v.responseText);-1===x&&10>X||(c=v.statusText);u(k,x||v.status,b,a,c)}};
	l&&(v.withCredentials=!0);if(q)try{v.responseType=q}catch(y){if("json"!==q)throw y;}v.send(m||null)}if(0<p)var Q=c(A,p);else p&&D(p.then)&&p.then(A)}}function ue(){var b="{{",a="}}";this.startSymbol=function(a){return a?(b=a,this):b};this.endSymbol=function(b){return b?(a=b,this):a};this.$get=["$parse","$exceptionHandler","$sce",function(c,d,e){function f(a){return"\\\\\\"+a}function g(f,g,q,A){function u(c){return c.replace(k,b).replace(n,a)}function x(a){try{var b;var c=q?e.getTrusted(q,a):e.valueOf(a);
	if(null==c)b="";else{switch(typeof c){case "string":break;case "number":c=""+c;break;default:c=sa(c)}b=c}return b}catch(h){a=Pb("interr",f,h.toString()),d(a)}}A=!!A;for(var z,T,v=0,r=[],Q=[],s=f.length,J=[],N=[];v<s;)if(-1!=(z=f.indexOf(b,v))&&-1!=(T=f.indexOf(a,z+h)))v!==z&&J.push(u(f.substring(v,z))),v=f.substring(z+h,T),r.push(v),Q.push(c(v,x)),v=T+m,N.push(J.length),J.push("");else{v!==s&&J.push(u(f.substring(v)));break}if(q&&1<J.length)throw Pb("noconcat",f);if(!g||r.length){var M=function(a){for(var b=
	0,c=r.length;b<c;b++){if(A&&F(a[b]))return;J[N[b]]=a[b]}return J.join("")};return E(function(a){var b=0,c=r.length,e=Array(c);try{for(;b<c;b++)e[b]=Q[b](a);return M(e)}catch(h){a=Pb("interr",f,h.toString()),d(a)}},{exp:f,expressions:r,$$watchDelegate:function(a,b,c){var d;return a.$watchGroup(Q,function(c,e){var f=M(c);D(b)&&b.call(this,f,c!==e?d:f,a);d=f},c)}})}}var h=b.length,m=a.length,k=new RegExp(b.replace(/./g,f),"g"),n=new RegExp(a.replace(/./g,f),"g");g.startSymbol=function(){return b};g.endSymbol=
	function(){return a};return g}]}function ve(){this.$get=["$rootScope","$window","$q","$$q",function(b,a,c,d){function e(e,h,m,k){var n=a.setInterval,p=a.clearInterval,l=0,q=B(k)&&!k,A=(q?d:c).defer(),u=A.promise;m=B(m)?m:0;u.then(null,null,e);u.$$intervalId=n(function(){A.notify(l++);0<m&&l>=m&&(A.resolve(l),p(u.$$intervalId),delete f[u.$$intervalId]);q||b.$apply()},h);f[u.$$intervalId]=A;return u}var f={};e.cancel=function(b){return b&&b.$$intervalId in f?(f[b.$$intervalId].reject("canceled"),a.clearInterval(b.$$intervalId),
	delete f[b.$$intervalId],!0):!1};return e}]}function Dd(){this.$get=function(){return{id:"en-us",NUMBER_FORMATS:{DECIMAL_SEP:".",GROUP_SEP:",",PATTERNS:[{minInt:1,minFrac:0,maxFrac:3,posPre:"",posSuf:"",negPre:"-",negSuf:"",gSize:3,lgSize:3},{minInt:1,minFrac:2,maxFrac:2,posPre:"\u00a4",posSuf:"",negPre:"(\u00a4",negSuf:")",gSize:3,lgSize:3}],CURRENCY_SYM:"$"},DATETIME_FORMATS:{MONTH:"January February March April May June July August September October November December".split(" "),SHORTMONTH:"Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" "),
	DAY:"Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "),SHORTDAY:"Sun Mon Tue Wed Thu Fri Sat".split(" "),AMPMS:["AM","PM"],medium:"MMM d, y h:mm:ss a",short:"M/d/yy h:mm a",fullDate:"EEEE, MMMM d, y",longDate:"MMMM d, y",mediumDate:"MMM d, y",shortDate:"M/d/yy",mediumTime:"h:mm:ss a",shortTime:"h:mm a"},pluralCat:function(b){return 1===b?"one":"other"}}}}function Qb(b){b=b.split("/");for(var a=b.length;a--;)b[a]=eb(b[a]);return b.join("/")}function Jc(b,a,c){b=Aa(b,c);a.$$protocol=
	b.protocol;a.$$host=b.hostname;a.$$port=U(b.port)||df[b.protocol]||null}function Kc(b,a,c){var d="/"!==b.charAt(0);d&&(b="/"+b);b=Aa(b,c);a.$$path=decodeURIComponent(d&&"/"===b.pathname.charAt(0)?b.pathname.substring(1):b.pathname);a.$$search=fc(b.search);a.$$hash=decodeURIComponent(b.hash);a.$$path&&"/"!=a.$$path.charAt(0)&&(a.$$path="/"+a.$$path)}function wa(b,a){if(0===a.indexOf(b))return a.substr(b.length)}function Ya(b){var a=b.indexOf("#");return-1==a?b:b.substr(0,a)}function Rb(b){return b.substr(0,
	Ya(b).lastIndexOf("/")+1)}function Lc(b,a){this.$$html5=!0;a=a||"";var c=Rb(b);Jc(b,this,b);this.$$parse=function(a){var e=wa(c,a);if(!C(e))throw sb("ipthprfx",a,c);Kc(e,this,b);this.$$path||(this.$$path="/");this.$$compose()};this.$$compose=function(){var a=Bb(this.$$search),b=this.$$hash?"#"+eb(this.$$hash):"";this.$$url=Qb(this.$$path)+(a?"?"+a:"")+b;this.$$absUrl=c+this.$$url.substr(1)};this.$$parseLinkUrl=function(d,e){if(e&&"#"===e[0])return this.hash(e.slice(1)),!0;var f,g;(f=wa(b,d))!==s?
	(g=f,g=(f=wa(a,f))!==s?c+(wa("/",f)||f):b+g):(f=wa(c,d))!==s?g=c+f:c==d+"/"&&(g=c);g&&this.$$parse(g);return!!g}}function Sb(b,a){var c=Rb(b);Jc(b,this,b);this.$$parse=function(d){var e=wa(b,d)||wa(c,d),e="#"==e.charAt(0)?wa(a,e):this.$$html5?e:"";if(!C(e))throw sb("ihshprfx",d,a);Kc(e,this,b);d=this.$$path;var f=/^\/[A-Z]:(\/.*)/;0===e.indexOf(b)&&(e=e.replace(b,""));f.exec(e)||(d=(e=f.exec(d))?e[1]:d);this.$$path=d;this.$$compose()};this.$$compose=function(){var c=Bb(this.$$search),e=this.$$hash?
	"#"+eb(this.$$hash):"";this.$$url=Qb(this.$$path)+(c?"?"+c:"")+e;this.$$absUrl=b+(this.$$url?a+this.$$url:"")};this.$$parseLinkUrl=function(a,c){return Ya(b)==Ya(a)?(this.$$parse(a),!0):!1}}function Mc(b,a){this.$$html5=!0;Sb.apply(this,arguments);var c=Rb(b);this.$$parseLinkUrl=function(d,e){if(e&&"#"===e[0])return this.hash(e.slice(1)),!0;var f,g;b==Ya(d)?f=d:(g=wa(c,d))?f=b+a+g:c===d+"/"&&(f=c);f&&this.$$parse(f);return!!f};this.$$compose=function(){var c=Bb(this.$$search),e=this.$$hash?"#"+eb(this.$$hash):
	"";this.$$url=Qb(this.$$path)+(c?"?"+c:"")+e;this.$$absUrl=b+a+this.$$url}}function tb(b){return function(){return this[b]}}function Nc(b,a){return function(c){if(F(c))return this[b];this[b]=a(c);this.$$compose();return this}}function ye(){var b="",a=!1;this.hashPrefix=function(a){return B(a)?(b=a,this):b};this.html5Mode=function(b){return B(b)?(a=b,this):a};this.$get=["$rootScope","$browser","$sniffer","$rootElement",function(c,d,e,f){function g(a){c.$broadcast("$locationChangeSuccess",h.absUrl(),
	a)}var h,m=d.baseHref(),k=d.url();if(a){if(!m)throw sb("nobase");m=k.substring(0,k.indexOf("/",k.indexOf("//")+2))+(m||"/");e=e.history?Lc:Mc}else m=Ya(k),e=Sb;h=new e(m,"#"+b);h.$$parseLinkUrl(k,k);var n=/^\s*(javascript|mailto):/i;f.on("click",function(a){if(!a.ctrlKey&&!a.metaKey&&2!=a.which){for(var b=G(a.target);"a"!==pa(b[0]);)if(b[0]===f[0]||!(b=b.parent())[0])return;var e=b.prop("href"),g=b.attr("href")||b.attr("xlink:href");S(e)&&"[object SVGAnimatedString]"===e.toString()&&(e=Aa(e.animVal).href);
	n.test(e)||!e||b.attr("target")||a.isDefaultPrevented()||!h.$$parseLinkUrl(e,g)||(a.preventDefault(),h.absUrl()!=d.url()&&(c.$apply(),t.angular["ff-684208-preventDefault"]=!0))}});h.absUrl()!=k&&d.url(h.absUrl(),!0);d.onUrlChange(function(a){h.absUrl()!=a&&(c.$evalAsync(function(){var b=h.absUrl();h.$$parse(a);c.$broadcast("$locationChangeStart",a,b).defaultPrevented?(h.$$parse(b),d.url(b)):g(b)}),c.$$phase||c.$digest())});var p=0;c.$watch(function(){var a=d.url(),b=h.$$replace;p&&a==h.absUrl()||
	(p++,c.$evalAsync(function(){c.$broadcast("$locationChangeStart",h.absUrl(),a).defaultPrevented?h.$$parse(a):(d.url(h.absUrl(),b),g(a))}));h.$$replace=!1;return p});return h}]}function ze(){var b=!0,a=this;this.debugEnabled=function(a){return B(a)?(b=a,this):b};this.$get=["$window",function(c){function d(a){a instanceof Error&&(a.stack?a=a.message&&-1===a.stack.indexOf(a.message)?"Error: "+a.message+"\n"+a.stack:a.stack:a.sourceURL&&(a=a.message+"\n"+a.sourceURL+":"+a.line));return a}function e(a){var b=
	c.console||{},e=b[a]||b.log||w;a=!1;try{a=!!e.apply}catch(m){}return a?function(){var a=[];r(arguments,function(b){a.push(d(b))});return e.apply(b,a)}:function(a,b){e(a,null==b?"":b)}}return{log:e("log"),info:e("info"),warn:e("warn"),error:e("error"),debug:function(){var c=e("debug");return function(){b&&c.apply(a,arguments)}}()}}]}function na(b,a){if("__defineGetter__"===b||"__defineSetter__"===b||"__lookupGetter__"===b||"__lookupSetter__"===b||"__proto__"===b)throw oa("isecfld",a);return b}function Ba(b,
	a){if(b){if(b.constructor===b)throw oa("isecfn",a);if(b.window===b)throw oa("isecwindow",a);if(b.children&&(b.nodeName||b.prop&&b.attr&&b.find))throw oa("isecdom",a);if(b===Object)throw oa("isecobj",a);}return b}function ub(b,a,c,d){Ba(b,d);a=a.split(".");for(var e,f=0;1<a.length;f++){e=na(a.shift(),d);var g=Ba(b[e],d);g||(g={},b[e]=g);b=g}e=na(a.shift(),d);Ba(b[e],d);return b[e]=c}function Oc(b,a,c,d,e,f){na(b,f);na(a,f);na(c,f);na(d,f);na(e,f);return function(f,h){var m=h&&h.hasOwnProperty(b)?h:
	f;if(null==m)return m;m=m[b];if(!a)return m;if(null==m)return s;m=m[a];if(!c)return m;if(null==m)return s;m=m[c];if(!d)return m;if(null==m)return s;m=m[d];return e?null==m?s:m=m[e]:m}}function Pc(b,a,c){var d=Qc[b];if(d)return d;var e=b.split("."),f=e.length;if(a.csp)d=6>f?Oc(e[0],e[1],e[2],e[3],e[4],c):function(a,b){var d=0,g;do g=Oc(e[d++],e[d++],e[d++],e[d++],e[d++],c)(a,b),b=s,a=g;while(d<f);return g};else{var g="";r(e,function(a,b){na(a,c);g+="if(s == null) return undefined;\ns="+(b?"s":'((l&&l.hasOwnProperty("'+
	a+'"))?l:s)')+"."+a+";\n"});g+="return s;";a=new Function("s","l",g);a.toString=da(g);a.assign=function(a,c){return ub(a,b,c,b)};d=a}d.sharedGetter=!0;return Qc[b]=d}function Ae(){var b=Object.create(null),a={csp:!1};this.$get=["$filter","$sniffer",function(c,d){function e(a){var b=a;a.sharedGetter&&(b=function(b,c){return a(b,c)},b.literal=a.literal,b.constant=a.constant,b.assign=a.assign);return b}function f(a,b,c,d){var e,f;return e=a.$watch(function(a){return d(a)},function(a,c,d){f=a;D(b)&&b.apply(this,
	arguments);B(a)&&d.$$postDigest(function(){B(f)&&e()})},c)}function g(a,b,c,d){function e(a){var b=!0;r(a,function(a){B(a)||(b=!1)});return b}var f;return f=a.$watch(function(a){return d(a)},function(a,c,d){D(b)&&b.call(this,a,c,d);e(a)&&d.$$postDigest(function(){e(a)&&f()})},c)}function h(a,b,c,d){var e;return e=a.$watch(function(a){return d(a)},function(a,c,d){D(b)&&b.apply(this,arguments);e()},c)}function m(a,b){if(!b)return a;var c=function(c,d){var e=a(c,d),f=b(e,c,d);return B(e)?f:e};c.$$watchDelegate=
	a.$$watchDelegate;return c}a.csp=d.csp;return function(d,n){var p,l,q;switch(typeof d){case "string":return q=d=d.trim(),p=b[q],p||(":"===d.charAt(0)&&":"===d.charAt(1)&&(l=!0,d=d.substring(2)),p=new Tb(a),p=(new Za(p,c,a)).parse(d),p.constant?p.$$watchDelegate=h:l&&(p=e(p),p.$$watchDelegate=p.literal?g:f),b[q]=p),m(p,n);case "function":return m(d,n);default:return m(w,n)}}}]}function Ce(){this.$get=["$rootScope","$exceptionHandler",function(b,a){return Rc(function(a){b.$evalAsync(a)},a)}]}function De(){this.$get=
	["$browser","$exceptionHandler",function(b,a){return Rc(function(a){b.defer(a)},a)}]}function Rc(b,a){function c(a,b,c){function d(b){return function(c){e||(e=!0,b.call(a,c))}}var e=!1;return[d(b),d(c)]}function d(){this.$$state={status:0}}function e(a,b){return function(c){b.call(a,c)}}function f(c){!c.processScheduled&&c.pending&&(c.processScheduled=!0,b(function(){var b,d,e;e=c.pending;c.processScheduled=!1;c.pending=s;for(var f=0,h=e.length;f<h;++f){d=e[f][0];b=e[f][c.status];try{D(b)?d.resolve(b(c.value)):
	1===c.status?d.resolve(c.value):d.reject(c.value)}catch(g){d.reject(g),a(g)}}}))}function g(){this.promise=new d;this.resolve=e(this,this.resolve);this.reject=e(this,this.reject);this.notify=e(this,this.notify)}var h=K("$q",TypeError);d.prototype={then:function(a,b,c){var d=new g;this.$$state.pending=this.$$state.pending||[];this.$$state.pending.push([d,a,b,c]);0<this.$$state.status&&f(this.$$state);return d.promise},"catch":function(a){return this.then(null,a)},"finally":function(a,b){return this.then(function(b){return k(b,
	!0,a)},function(b){return k(b,!1,a)},b)}};g.prototype={resolve:function(a){this.promise.$$state.status||(a===this.promise?this.$$reject(h("qcycle",a)):this.$$resolve(a))},$$resolve:function(b){var d,e;e=c(this,this.$$resolve,this.$$reject);try{if(S(b)||D(b))d=b&&b.then;D(d)?(this.promise.$$state.status=-1,d.call(b,e[0],e[1],this.notify)):(this.promise.$$state.value=b,this.promise.$$state.status=1,f(this.promise.$$state))}catch(h){e[1](h),a(h)}},reject:function(a){this.promise.$$state.status||this.$$reject(a)},
	$$reject:function(a){this.promise.$$state.value=a;this.promise.$$state.status=2;f(this.promise.$$state)},notify:function(c){var d=this.promise.$$state.pending;0>=this.promise.$$state.status&&d&&d.length&&b(function(){for(var b,e,f=0,h=d.length;f<h;f++){e=d[f][0];b=d[f][3];try{e.notify(D(b)?b(c):c)}catch(g){a(g)}}})}};var m=function(a,b){var c=new g;b?c.resolve(a):c.reject(a);return c.promise},k=function(a,b,c){var d=null;try{D(c)&&(d=c())}catch(e){return m(e,!1)}return d&&D(d.then)?d.then(function(){return m(a,
	b)},function(a){return m(a,!1)}):m(a,b)},n=function(a,b,c,d){var e=new g;e.resolve(a);return e.promise.then(b,c,d)},p=function q(a){if(!D(a))throw h("norslvr",a);if(!(this instanceof q))return new q(a);var b=new g;a(function(a){b.resolve(a)},function(a){b.reject(a)});return b.promise};p.defer=function(){return new g};p.reject=function(a){var b=new g;b.reject(a);return b.promise};p.when=n;p.all=function(a){var b=new g,c=0,d=L(a)?[]:{};r(a,function(a,e){c++;n(a).then(function(a){d.hasOwnProperty(e)||
	(d[e]=a,--c||b.resolve(d))},function(a){d.hasOwnProperty(e)||b.reject(a)})});0===c&&b.resolve(d);return b.promise};return p}function Me(){this.$get=["$window","$timeout",function(b,a){var c=b.requestAnimationFrame||b.webkitRequestAnimationFrame||b.mozRequestAnimationFrame,d=b.cancelAnimationFrame||b.webkitCancelAnimationFrame||b.mozCancelAnimationFrame||b.webkitCancelRequestAnimationFrame,e=!!c,f=e?function(a){var b=c(a);return function(){d(b)}}:function(b){var c=a(b,16.66,!1);return function(){a.cancel(c)}};
	f.supported=e;return f}]}function Be(){var b=10,a=K("$rootScope"),c=null,d=null;this.digestTtl=function(a){arguments.length&&(b=a);return b};this.$get=["$injector","$exceptionHandler","$parse","$browser",function(e,f,g,h){function m(){this.$id=++bb;this.$$phase=this.$parent=this.$$watchers=this.$$nextSibling=this.$$prevSibling=this.$$childHead=this.$$childTail=null;this["this"]=this.$root=this;this.$$destroyed=!1;this.$$asyncQueue=[];this.$$postDigestQueue=[];this.$$listeners={};this.$$listenerCount=
	{};this.$$isolateBindings={};this.$$applyAsyncQueue=[]}function k(b){if(A.$$phase)throw a("inprog",A.$$phase);A.$$phase=b}function n(a,b,c){do a.$$listenerCount[c]-=b,0===a.$$listenerCount[c]&&delete a.$$listenerCount[c];while(a=a.$parent)}function p(){}function l(){for(var a=A.$$applyAsyncQueue;a.length;)try{a.shift()()}catch(b){f(b)}d=null}function q(){null===d&&(d=h.defer(function(){A.$apply(l)}))}m.prototype={constructor:m,$new:function(a){a?(a=new m,a.$root=this.$root,a.$$asyncQueue=this.$$asyncQueue,
	a.$$postDigestQueue=this.$$postDigestQueue):(this.$$ChildScope||(this.$$ChildScope=function(){this.$$watchers=this.$$nextSibling=this.$$childHead=this.$$childTail=null;this.$$listeners={};this.$$listenerCount={};this.$id=++bb;this.$$ChildScope=null},this.$$ChildScope.prototype=this),a=new this.$$ChildScope);a["this"]=a;a.$parent=this;a.$$prevSibling=this.$$childTail;this.$$childHead?this.$$childTail=this.$$childTail.$$nextSibling=a:this.$$childHead=this.$$childTail=a;return a},$watch:function(a,b,
	d){var e=g(a);if(e.$$watchDelegate)return e.$$watchDelegate(this,b,d,e);var f=this.$$watchers,h={fn:b,last:p,get:e,exp:a,eq:!!d};c=null;D(b)||(h.fn=w);f||(f=this.$$watchers=[]);f.unshift(h);return function(){Ra(f,h);c=null}},$watchGroup:function(a,b){function c(){g=!1;k?(k=!1,b(e,e,h)):b(e,d,h)}var d=Array(a.length),e=Array(a.length),f=[],h=this,g=!1,k=!0;if(!a.length){var m=!0;h.$evalAsync(function(){m&&b(e,e,h)});return function(){m=!1}}if(1===a.length)return this.$watch(a[0],function(a,c,f){e[0]=
	a;d[0]=c;b(e,a===c?e:d,f)});r(a,function(a,b){var k=h.$watch(a,function(a,f){e[b]=a;d[b]=f;g||(g=!0,h.$evalAsync(c))});f.push(k)});return function(){for(;f.length;)f.shift()()}},$watchCollection:function(a,b){var c=this,d,e,f,h=1<b.length,k=0,m=g(a,function(a){d=a;var b,c,f,h;if(S(d))if(Na(d))for(e!==l&&(e=l,q=e.length=0,k++),a=d.length,q!==a&&(k++,e.length=q=a),b=0;b<a;b++)h=e[b],f=d[b],c=h!==h&&f!==f,c||h===f||(k++,e[b]=f);else{e!==n&&(e=n={},q=0,k++);a=0;for(b in d)d.hasOwnProperty(b)&&(a++,f=
	d[b],h=e[b],b in e?(c=h!==h&&f!==f,c||h===f||(k++,e[b]=f)):(q++,e[b]=f,k++));if(q>a)for(b in k++,e)d.hasOwnProperty(b)||(q--,delete e[b])}else e!==d&&(e=d,k++);return k}),l=[],n={},p=!0,q=0;return this.$watch(m,function(){p?(p=!1,b(d,d,c)):b(d,f,c);if(h)if(S(d))if(Na(d)){f=Array(d.length);for(var a=0;a<d.length;a++)f[a]=d[a]}else for(a in f={},d)Ab.call(d,a)&&(f[a]=d[a]);else f=d})},$digest:function(){var e,g,m,n,q=this.$$asyncQueue,r=this.$$postDigestQueue,s,B,J=b,N,M=[],O,H,W;k("$digest");h.$$checkUrlChange();
	this===A&&null!==d&&(h.defer.cancel(d),l());c=null;do{B=!1;for(N=this;q.length;){try{W=q.shift(),W.scope.$eval(W.expression)}catch(R){f(R)}c=null}a:do{if(n=N.$$watchers)for(s=n.length;s--;)try{if(e=n[s])if((g=e.get(N))!==(m=e.last)&&!(e.eq?ra(g,m):"number"===typeof g&&"number"===typeof m&&isNaN(g)&&isNaN(m)))B=!0,c=e,e.last=e.eq?Ha(g,null):g,e.fn(g,m===p?g:m,N),5>J&&(O=4-J,M[O]||(M[O]=[]),H=D(e.exp)?"fn: "+(e.exp.name||e.exp.toString()):e.exp,H+="; newVal: "+sa(g)+"; oldVal: "+sa(m),M[O].push(H));
	else if(e===c){B=!1;break a}}catch(t){f(t)}if(!(n=N.$$childHead||N!==this&&N.$$nextSibling))for(;N!==this&&!(n=N.$$nextSibling);)N=N.$parent}while(N=n);if((B||q.length)&&!J--)throw A.$$phase=null,a("infdig",b,sa(M));}while(B||q.length);for(A.$$phase=null;r.length;)try{r.shift()()}catch(G){f(G)}},$destroy:function(){if(!this.$$destroyed){var a=this.$parent;this.$broadcast("$destroy");this.$$destroyed=!0;if(this!==A){for(var b in this.$$listenerCount)n(this,this.$$listenerCount[b],b);a.$$childHead==
	this&&(a.$$childHead=this.$$nextSibling);a.$$childTail==this&&(a.$$childTail=this.$$prevSibling);this.$$prevSibling&&(this.$$prevSibling.$$nextSibling=this.$$nextSibling);this.$$nextSibling&&(this.$$nextSibling.$$prevSibling=this.$$prevSibling);this.$parent=this.$$nextSibling=this.$$prevSibling=this.$$childHead=this.$$childTail=this.$root=null;this.$$listeners={};this.$$watchers=this.$$asyncQueue=this.$$postDigestQueue=[];this.$destroy=this.$digest=this.$apply=w;this.$on=this.$watch=this.$watchGroup=
	function(){return w}}}},$eval:function(a,b){return g(a)(this,b)},$evalAsync:function(a){A.$$phase||A.$$asyncQueue.length||h.defer(function(){A.$$asyncQueue.length&&A.$digest()});this.$$asyncQueue.push({scope:this,expression:a})},$$postDigest:function(a){this.$$postDigestQueue.push(a)},$apply:function(a){try{return k("$apply"),this.$eval(a)}catch(b){f(b)}finally{A.$$phase=null;try{A.$digest()}catch(c){throw f(c),c;}}},$applyAsync:function(a){function b(){c.$eval(a)}var c=this;a&&A.$$applyAsyncQueue.push(b);
	q()},$on:function(a,b){var c=this.$$listeners[a];c||(this.$$listeners[a]=c=[]);c.push(b);var d=this;do d.$$listenerCount[a]||(d.$$listenerCount[a]=0),d.$$listenerCount[a]++;while(d=d.$parent);var e=this;return function(){c[c.indexOf(b)]=null;n(e,1,a)}},$emit:function(a,b){var c=[],d,e=this,h=!1,g={name:a,targetScope:e,stopPropagation:function(){h=!0},preventDefault:function(){g.defaultPrevented=!0},defaultPrevented:!1},k=db([g],arguments,1),m,l;do{d=e.$$listeners[a]||c;g.currentScope=e;m=0;for(l=
	d.length;m<l;m++)if(d[m])try{d[m].apply(null,k)}catch(n){f(n)}else d.splice(m,1),m--,l--;if(h)return g.currentScope=null,g;e=e.$parent}while(e);g.currentScope=null;return g},$broadcast:function(a,b){var c=this,d=this,e={name:a,targetScope:this,preventDefault:function(){e.defaultPrevented=!0},defaultPrevented:!1};if(!this.$$listenerCount[a])return e;for(var h=db([e],arguments,1),g,k;c=d;){e.currentScope=c;d=c.$$listeners[a]||[];g=0;for(k=d.length;g<k;g++)if(d[g])try{d[g].apply(null,h)}catch(m){f(m)}else d.splice(g,
	1),g--,k--;if(!(d=c.$$listenerCount[a]&&c.$$childHead||c!==this&&c.$$nextSibling))for(;c!==this&&!(d=c.$$nextSibling);)c=c.$parent}e.currentScope=null;return e}};var A=new m;return A}]}function Ed(){var b=/^\s*(https?|ftp|mailto|tel|file):/,a=/^\s*((https?|ftp|file|blob):|data:image\/)/;this.aHrefSanitizationWhitelist=function(a){return B(a)?(b=a,this):b};this.imgSrcSanitizationWhitelist=function(b){return B(b)?(a=b,this):a};this.$get=function(){return function(c,d){var e=d?a:b,f;if(!X||8<=X)if(f=
	Aa(c).href,""!==f&&!f.match(e))return"unsafe:"+f;return c}}}function ef(b){if("self"===b)return b;if(C(b)){if(-1<b.indexOf("***"))throw Ca("iwcard",b);b=b.replace(/([-()\[\]{}+?*.$\^|,:#<!\\])/g,"\\$1").replace(/\x08/g,"\\x08").replace("\\*\\*",".*").replace("\\*","[^:/.?&;]*");return new RegExp("^"+b+"$")}if(cb(b))return new RegExp("^"+b.source+"$");throw Ca("imatcher");}function Sc(b){var a=[];B(b)&&r(b,function(b){a.push(ef(b))});return a}function Fe(){this.SCE_CONTEXTS=ka;var b=["self"],a=[];
	this.resourceUrlWhitelist=function(a){arguments.length&&(b=Sc(a));return b};this.resourceUrlBlacklist=function(b){arguments.length&&(a=Sc(b));return a};this.$get=["$injector",function(c){function d(a,b){return"self"===a?Ic(b):!!a.exec(b.href)}function e(a){var b=function(a){this.$$unwrapTrustedValue=function(){return a}};a&&(b.prototype=new a);b.prototype.valueOf=function(){return this.$$unwrapTrustedValue()};b.prototype.toString=function(){return this.$$unwrapTrustedValue().toString()};return b}
	var f=function(a){throw Ca("unsafe");};c.has("$sanitize")&&(f=c.get("$sanitize"));var g=e(),h={};h[ka.HTML]=e(g);h[ka.CSS]=e(g);h[ka.URL]=e(g);h[ka.JS]=e(g);h[ka.RESOURCE_URL]=e(h[ka.URL]);return{trustAs:function(a,b){var c=h.hasOwnProperty(a)?h[a]:null;if(!c)throw Ca("icontext",a,b);if(null===b||b===s||""===b)return b;if("string"!==typeof b)throw Ca("itype",a);return new c(b)},getTrusted:function(c,e){if(null===e||e===s||""===e)return e;var g=h.hasOwnProperty(c)?h[c]:null;if(g&&e instanceof g)return e.$$unwrapTrustedValue();
	if(c===ka.RESOURCE_URL){var g=Aa(e.toString()),p,l,q=!1;p=0;for(l=b.length;p<l;p++)if(d(b[p],g)){q=!0;break}if(q)for(p=0,l=a.length;p<l;p++)if(d(a[p],g)){q=!1;break}if(q)return e;throw Ca("insecurl",e.toString());}if(c===ka.HTML)return f(e);throw Ca("unsafe");},valueOf:function(a){return a instanceof g?a.$$unwrapTrustedValue():a}}}]}function Ee(){var b=!0;this.enabled=function(a){arguments.length&&(b=!!a);return b};this.$get=["$parse","$sniffer","$sceDelegate",function(a,c,d){if(b&&c.msie&&8>c.msieDocumentMode)throw Ca("iequirks");
	var e=qa(ka);e.isEnabled=function(){return b};e.trustAs=d.trustAs;e.getTrusted=d.getTrusted;e.valueOf=d.valueOf;b||(e.trustAs=e.getTrusted=function(a,b){return b},e.valueOf=Pa);e.parseAs=function(b,c){var d=a(c);return d.literal&&d.constant?d:a(c,function(a){return e.getTrusted(b,a)})};var f=e.parseAs,g=e.getTrusted,h=e.trustAs;r(ka,function(a,b){var c=P(b);e[Wa("parse_as_"+c)]=function(b){return f(a,b)};e[Wa("get_trusted_"+c)]=function(b){return g(a,b)};e[Wa("trust_as_"+c)]=function(b){return h(a,
	b)}});return e}]}function Ge(){this.$get=["$window","$document",function(b,a){var c={},d=U((/android (\d+)/.exec(P((b.navigator||{}).userAgent))||[])[1]),e=/Boxee/i.test((b.navigator||{}).userAgent),f=a[0]||{},g=f.documentMode,h,m=/^(Moz|webkit|O|ms)(?=[A-Z])/,k=f.body&&f.body.style,n=!1,p=!1;if(k){for(var l in k)if(n=m.exec(l)){h=n[0];h=h.substr(0,1).toUpperCase()+h.substr(1);break}h||(h="WebkitOpacity"in k&&"webkit");n=!!("transition"in k||h+"Transition"in k);p=!!("animation"in k||h+"Animation"in
	k);!d||n&&p||(n=C(f.body.style.webkitTransition),p=C(f.body.style.webkitAnimation))}return{history:!(!b.history||!b.history.pushState||4>d||e),hashchange:"onhashchange"in b&&(!g||7<g),hasEvent:function(a){if("input"==a&&9==X)return!1;if(F(c[a])){var b=f.createElement("div");c[a]="on"+a in b}return c[a]},csp:Ua(),vendorPrefix:h,transitions:n,animations:p,android:d,msie:X,msieDocumentMode:g}}]}function Ie(){this.$get=["$templateCache","$http","$q",function(b,a,c){function d(e,f){function g(){h.totalPendingRequests--;
	if(!f)throw ja("tpload",e);return c.reject()}var h=d;h.totalPendingRequests++;return a.get(e,{cache:b}).then(function(a){a=a.data;if(!a||0===a.length)return g();h.totalPendingRequests--;b.put(e,a);return a},g)}d.totalPendingRequests=0;return d}]}function Je(){this.$get=["$rootScope","$browser","$location",function(b,a,c){return{findBindings:function(a,b,c){a=a.getElementsByClassName("ng-binding");var g=[];r(a,function(a){var d=Ea.element(a).data("$binding");d&&r(d,function(d){c?(new RegExp("(^|\\s)"+
	b+"(\\s|\\||$)")).test(d)&&g.push(a):-1!=d.indexOf(b)&&g.push(a)})});return g},findModels:function(a,b,c){for(var g=["ng-","data-ng-","ng\\:"],h=0;h<g.length;++h){var m=a.querySelectorAll("["+g[h]+"model"+(c?"=":"*=")+'"'+b+'"]');if(m.length)return m}},getLocation:function(){return c.url()},setLocation:function(a){a!==c.url()&&(c.url(a),b.$digest())},whenStable:function(b){a.notifyWhenNoOutstandingRequests(b)}}}]}function Ke(){this.$get=["$rootScope","$browser","$q","$$q","$exceptionHandler",function(b,
	a,c,d,e){function f(f,m,k){var n=B(k)&&!k,p=(n?d:c).defer(),l=p.promise;m=a.defer(function(){try{p.resolve(f())}catch(a){p.reject(a),e(a)}finally{delete g[l.$$timeoutId]}n||b.$apply()},m);l.$$timeoutId=m;g[m]=p;return l}var g={};f.cancel=function(b){return b&&b.$$timeoutId in g?(g[b.$$timeoutId].reject("canceled"),delete g[b.$$timeoutId],a.defer.cancel(b.$$timeoutId)):!1};return f}]}function Aa(b,a){var c=b;X&&(Z.setAttribute("href",c),c=Z.href);Z.setAttribute("href",c);return{href:Z.href,protocol:Z.protocol?
	Z.protocol.replace(/:$/,""):"",host:Z.host,search:Z.search?Z.search.replace(/^\?/,""):"",hash:Z.hash?Z.hash.replace(/^#/,""):"",hostname:Z.hostname,port:Z.port,pathname:"/"===Z.pathname.charAt(0)?Z.pathname:"/"+Z.pathname}}function Ic(b){b=C(b)?Aa(b):b;return b.protocol===Tc.protocol&&b.host===Tc.host}function Le(){this.$get=da(t)}function qc(b){function a(c,d){if(S(c)){var e={};r(c,function(b,c){e[c]=a(c,b)});return e}return b.factory(c+"Filter",d)}this.register=a;this.$get=["$injector",function(a){return function(b){return a.get(b+
	"Filter")}}];a("currency",Uc);a("date",Vc);a("filter",ff);a("json",gf);a("limitTo",hf);a("lowercase",jf);a("number",Wc);a("orderBy",Xc);a("uppercase",kf)}function ff(){return function(b,a,c){if(!L(b))return b;var d=typeof c,e=[];e.check=function(a,b){for(var c=0;c<e.length;c++)if(!e[c](a,b))return!1;return!0};"function"!==d&&(c="boolean"===d&&c?function(a,b){return Ea.equals(a,b)}:function(a,b){if(a&&b&&"object"===typeof a&&"object"===typeof b){for(var d in a)if("$"!==d.charAt(0)&&Ab.call(a,d)&&c(a[d],
	b[d]))return!0;return!1}b=(""+b).toLowerCase();return-1<(""+a).toLowerCase().indexOf(b)});var f=function(a,b){if("string"==typeof b&&"!"===b.charAt(0))return!f(a,b.substr(1));switch(typeof a){case "boolean":case "number":case "string":return c(a,b);case "object":switch(typeof b){case "object":return c(a,b);default:for(var d in a)if("$"!==d.charAt(0)&&f(a[d],b))return!0}return!1;case "array":for(d=0;d<a.length;d++)if(f(a[d],b))return!0;return!1;default:return!1}};switch(typeof a){case "boolean":case "number":case "string":a=
	{$:a};case "object":for(var g in a)(function(b){"undefined"!==typeof a[b]&&e.push(function(c){return f("$"==b?c:c&&c[b],a[b])})})(g);break;case "function":e.push(a);break;default:return b}d=[];for(g=0;g<b.length;g++){var h=b[g];e.check(h,g)&&d.push(h)}return d}}function Uc(b){var a=b.NUMBER_FORMATS;return function(b,d){F(d)&&(d=a.CURRENCY_SYM);return null==b?b:Yc(b,a.PATTERNS[1],a.GROUP_SEP,a.DECIMAL_SEP,2).replace(/\u00A4/g,d)}}function Wc(b){var a=b.NUMBER_FORMATS;return function(b,d){return null==
	b?b:Yc(b,a.PATTERNS[0],a.GROUP_SEP,a.DECIMAL_SEP,d)}}function Yc(b,a,c,d,e){if(!isFinite(b)||S(b))return"";var f=0>b;b=Math.abs(b);var g=b+"",h="",m=[],k=!1;if(-1!==g.indexOf("e")){var n=g.match(/([\d\.]+)e(-?)(\d+)/);n&&"-"==n[2]&&n[3]>e+1?(g="0",b=0):(h=g,k=!0)}if(k)0<e&&-1<b&&1>b&&(h=b.toFixed(e));else{g=(g.split(Zc)[1]||"").length;F(e)&&(e=Math.min(Math.max(a.minFrac,g),a.maxFrac));b=+(Math.round(+(b.toString()+"e"+e)).toString()+"e"+-e);0===b&&(f=!1);b=(""+b).split(Zc);g=b[0];b=b[1]||"";var n=
	0,p=a.lgSize,l=a.gSize;if(g.length>=p+l)for(n=g.length-p,k=0;k<n;k++)0===(n-k)%l&&0!==k&&(h+=c),h+=g.charAt(k);for(k=n;k<g.length;k++)0===(g.length-k)%p&&0!==k&&(h+=c),h+=g.charAt(k);for(;b.length<e;)b+="0";e&&"0"!==e&&(h+=d+b.substr(0,e))}m.push(f?a.negPre:a.posPre);m.push(h);m.push(f?a.negSuf:a.posSuf);return m.join("")}function vb(b,a,c){var d="";0>b&&(d="-",b=-b);for(b=""+b;b.length<a;)b="0"+b;c&&(b=b.substr(b.length-a));return d+b}function $(b,a,c,d){c=c||0;return function(e){e=e["get"+b]();
	if(0<c||e>-c)e+=c;0===e&&-12==c&&(e=12);return vb(e,a,d)}}function wb(b,a){return function(c,d){var e=c["get"+b](),f=ib(a?"SHORT"+b:b);return d[f][e]}}function $c(b){var a=(new Date(b,0,1)).getDay();return new Date(b,0,(4>=a?5:12)-a)}function ad(b){return function(a){var c=$c(a.getFullYear());a=+new Date(a.getFullYear(),a.getMonth(),a.getDate()+(4-a.getDay()))-+c;a=1+Math.round(a/6048E5);return vb(a,b)}}function Vc(b){function a(a){var b;if(b=a.match(c)){a=new Date(0);var f=0,g=0,h=b[8]?a.setUTCFullYear:
	a.setFullYear,m=b[8]?a.setUTCHours:a.setHours;b[9]&&(f=U(b[9]+b[10]),g=U(b[9]+b[11]));h.call(a,U(b[1]),U(b[2])-1,U(b[3]));f=U(b[4]||0)-f;g=U(b[5]||0)-g;h=U(b[6]||0);b=Math.round(1E3*parseFloat("0."+(b[7]||0)));m.call(a,f,g,h,b)}return a}var c=/^(\d{4})-?(\d\d)-?(\d\d)(?:T(\d\d)(?::?(\d\d)(?::?(\d\d)(?:\.(\d+))?)?)?(Z|([+-])(\d\d):?(\d\d))?)?$/;return function(c,e,f){var g="",h=[],m,k;e=e||"mediumDate";e=b.DATETIME_FORMATS[e]||e;C(c)&&(c=lf.test(c)?U(c):a(c));ea(c)&&(c=new Date(c));if(!fa(c))return c;
	for(;e;)(k=mf.exec(e))?(h=db(h,k,1),e=h.pop()):(h.push(e),e=null);f&&"UTC"===f&&(c=new Date(c.getTime()),c.setMinutes(c.getMinutes()+c.getTimezoneOffset()));r(h,function(a){m=nf[a];g+=m?m(c,b.DATETIME_FORMATS):a.replace(/(^'|'$)/g,"").replace(/''/g,"'")});return g}}function gf(){return function(b){return sa(b,!0)}}function hf(){return function(b,a){if(!L(b)&&!C(b))return b;a=Infinity===Math.abs(Number(a))?Number(a):U(a);if(C(b))return a?0<=a?b.slice(0,a):b.slice(a,b.length):"";var c=[],d,e;a>b.length?
	a=b.length:a<-b.length&&(a=-b.length);0<a?(d=0,e=a):(d=b.length+a,e=b.length);for(;d<e;d++)c.push(b[d]);return c}}function Xc(b){return function(a,c,d){function e(a,b){return b?function(b,c){return a(c,b)}:a}function f(a,b){var c=typeof a,d=typeof b;return c==d?(fa(a)&&fa(b)&&(a=a.valueOf(),b=b.valueOf()),"string"==c&&(a=a.toLowerCase(),b=b.toLowerCase()),a===b?0:a<b?-1:1):c<d?-1:1}if(!Na(a)||!c)return a;c=L(c)?c:[c];c=sd(c,function(a){var c=!1,d=a||Pa;if(C(a)){if("+"==a.charAt(0)||"-"==a.charAt(0))c=
	"-"==a.charAt(0),a=a.substring(1);d=b(a);if(d.constant){var h=d();return e(function(a,b){return f(a[h],b[h])},c)}}return e(function(a,b){return f(d(a),d(b))},c)});for(var g=[],h=0;h<a.length;h++)g.push(a[h]);return g.sort(e(function(a,b){for(var d=0;d<c.length;d++){var e=c[d](a,b);if(0!==e)return e}return 0},d))}}function Fa(b){D(b)&&(b={link:b});b.restrict=b.restrict||"AC";return da(b)}function bd(b,a,c,d){var e=this,f=b.parent().controller("form")||xb,g=[];e.$error={};e.$$success={};e.$pending=
	s;e.$name=a.name||a.ngForm;e.$dirty=!1;e.$pristine=!0;e.$valid=!0;e.$invalid=!1;e.$submitted=!1;f.$addControl(e);b.addClass(Ma);e.$rollbackViewValue=function(){r(g,function(a){a.$rollbackViewValue()})};e.$commitViewValue=function(){r(g,function(a){a.$commitViewValue()})};e.$addControl=function(a){Ja(a.$name,"input");g.push(a);a.$name&&(e[a.$name]=a)};e.$removeControl=function(a){a.$name&&e[a.$name]===a&&delete e[a.$name];r(e.$pending,function(b,c){e.$setValidity(c,null,a)});r(e.$error,function(b,
	c){e.$setValidity(c,null,a)});Ra(g,a)};cd({ctrl:this,$element:b,set:function(a,b,c){var d=a[b];d?-1===d.indexOf(c)&&d.push(c):a[b]=[c]},unset:function(a,b,c){var d=a[b];d&&(Ra(d,c),0===d.length&&delete a[b])},parentForm:f,$animate:d});e.$setDirty=function(){d.removeClass(b,Ma);d.addClass(b,yb);e.$dirty=!0;e.$pristine=!1;f.$setDirty()};e.$setPristine=function(){d.setClass(b,Ma,yb+" ng-submitted");e.$dirty=!1;e.$pristine=!0;e.$submitted=!1;r(g,function(a){a.$setPristine()})};e.$setSubmitted=function(){d.addClass(b,
	"ng-submitted");e.$submitted=!0;f.$setSubmitted()}}function Ub(b){b.$formatters.push(function(a){return b.$isEmpty(a)?a:a.toString()})}function $a(b,a,c,d,e,f){a.prop("validity");var g=a[0].placeholder,h={},m=P(a[0].type);if(!e.android){var k=!1;a.on("compositionstart",function(a){k=!0});a.on("compositionend",function(){k=!1;n()})}var n=function(b){if(!k){var e=a.val(),f=b&&b.type;X&&"input"===(b||h).type&&a[0].placeholder!==g?g=a[0].placeholder:("password"===m||c.ngTrim&&"false"===c.ngTrim||(e=ba(e)),
	(d.$viewValue!==e||""===e&&d.$$hasNativeValidators)&&d.$setViewValue(e,f))}};if(e.hasEvent("input"))a.on("input",n);else{var p,l=function(a){p||(p=f.defer(function(){n(a);p=null}))};a.on("keydown",function(a){var b=a.keyCode;91===b||15<b&&19>b||37<=b&&40>=b||l(a)});if(e.hasEvent("paste"))a.on("paste cut",l)}a.on("change",n);d.$render=function(){a.val(d.$isEmpty(d.$viewValue)?"":d.$viewValue)}}function zb(b,a){return function(c){var d;if(fa(c))return c;if(C(c)){'"'==c.charAt(0)&&'"'==c.charAt(c.length-
	1)&&(c=c.substring(1,c.length-1));if(of.test(c))return new Date(c);b.lastIndex=0;if(c=b.exec(c))return c.shift(),d={yyyy:1970,MM:1,dd:1,HH:0,mm:0,ss:0},r(c,function(b,c){c<a.length&&(d[a[c]]=+b)}),new Date(d.yyyy,d.MM-1,d.dd,d.HH,d.mm,d.ss||0)}return NaN}}function ab(b,a,c,d){return function(e,f,g,h,m,k,n){function p(a){return B(a)?fa(a)?a:c(a):s}dd(e,f,g,h);$a(e,f,g,h,m,k);var l=h&&h.$options&&h.$options.timezone;h.$$parserName=b;h.$parsers.push(function(b){return h.$isEmpty(b)?null:a.test(b)?(b=
	c(b),"UTC"===l&&b.setMinutes(b.getMinutes()-b.getTimezoneOffset()),b):s});h.$formatters.push(function(a){return fa(a)?n("date")(a,d,l):""});if(B(g.min)||g.ngMin){var q;h.$validators.min=function(a){return h.$isEmpty(a)||F(q)||c(a)>=q};g.$observe("min",function(a){q=p(a);h.$validate()})}if(B(g.max)||g.ngMax){var r;h.$validators.max=function(a){return h.$isEmpty(a)||F(r)||c(a)<=r};g.$observe("max",function(a){r=p(a);h.$validate()})}}}function dd(b,a,c,d){(d.$$hasNativeValidators=S(a[0].validity))&&
	d.$parsers.push(function(b){var c=a.prop("validity")||{};return c.badInput&&!c.typeMismatch?s:b})}function ed(b,a,c,d,e){if(B(d)){b=b(d);if(!b.constant)throw K("ngModel")("constexpr",c,d);return b(a)}return e}function cd(b){function a(a,b){b&&!f[a]?(k.addClass(e,a),f[a]=!0):!b&&f[a]&&(k.removeClass(e,a),f[a]=!1)}function c(b,c){b=b?"-"+Db(b,"-"):"";a(pf+b,!0===c);a(qf+b,!1===c)}var d=b.ctrl,e=b.$element,f={},g=b.set,h=b.unset,m=b.parentForm,k=b.$animate;d.$setValidity=function(b,e,f){e===s?(d.$pending||
	(d.$pending={}),g(d.$pending,b,f)):(d.$pending&&h(d.$pending,b,f),fd(d.$pending)&&(d.$pending=s));"boolean"!==typeof e?(h(d.$error,b,f),h(d.$$success,b,f)):e?(h(d.$error,b,f),g(d.$$success,b,f)):(g(d.$error,b,f),h(d.$$success,b,f));d.$pending?(a(gd,!0),d.$valid=d.$invalid=s,c("",null)):(a(gd,!1),d.$valid=fd(d.$error),d.$invalid=!d.$valid,c("",d.$valid));e=d.$pending&&d.$pending[b]?s:d.$error[b]?!1:d.$$success[b]?!0:null;c(b,e);m.$setValidity(b,e,d)};c("",!0)}function fd(b){if(b)for(var a in b)return!1;
	return!0}function Vb(b,a){b="ngClass"+b;return["$animate",function(c){function d(a,b){var c=[],d=0;a:for(;d<a.length;d++){for(var e=a[d],n=0;n<b.length;n++)if(e==b[n])continue a;c.push(e)}return c}function e(a){if(!L(a)){if(C(a))return a.split(" ");if(S(a)){var b=[];r(a,function(a,c){a&&(b=b.concat(c.split(" ")))});return b}}return a}return{restrict:"AC",link:function(f,g,h){function m(a,b){var c=g.data("$classCounts")||{},d=[];r(a,function(a){if(0<b||c[a])c[a]=(c[a]||0)+b,c[a]===+(0<b)&&d.push(a)});
	g.data("$classCounts",c);return d.join(" ")}function k(b){if(!0===a||f.$index%2===a){var k=e(b||[]);if(!n){var q=m(k,1);h.$addClass(q)}else if(!ra(b,n)){var r=e(n),q=d(k,r),k=d(r,k),q=m(q,1),k=m(k,-1);q&&q.length&&c.addClass(g,q);k&&k.length&&c.removeClass(g,k)}}n=qa(b)}var n;f.$watch(h[b],k,!0);h.$observe("class",function(a){k(f.$eval(h[b]))});"ngClass"!==b&&f.$watch("$index",function(c,d){var g=c&1;if(g!==(d&1)){var k=e(f.$eval(h[b]));g===a?(g=m(k,1),h.$addClass(g)):(g=m(k,-1),h.$removeClass(g))}})}}}]}
	var rf=/^\/(.+)\/([a-z]*)$/,P=function(b){return C(b)?b.toLowerCase():b},Ab=Object.prototype.hasOwnProperty,ib=function(b){return C(b)?b.toUpperCase():b},X,G,la,Ta=[].slice,sf=[].push,Ga=Object.prototype.toString,Sa=K("ng"),Ea=t.angular||(t.angular={}),Va,bb=0;X=U((/msie (\d+)/.exec(P(navigator.userAgent))||[])[1]);isNaN(X)&&(X=U((/trident\/.*; rv:(\d+)/.exec(P(navigator.userAgent))||[])[1]));w.$inject=[];Pa.$inject=[];var L=Array.isArray,ba=function(b){return C(b)?b.trim():b},Ua=function(){if(B(Ua.isActive_))return Ua.isActive_;
	var b=!(!Y.querySelector("[ng-csp]")&&!Y.querySelector("[data-ng-csp]"));if(!b)try{new Function("")}catch(a){b=!0}return Ua.isActive_=b},fb=["ng-","data-ng-","ng:","x-ng-"],yd=/[A-Z]/g,hc=!1,Eb,Cd={full:"1.3.0-rc.1",major:1,minor:3,dot:0,codeName:"backyard-atomicity"};V.expando="ng339";var ob=V.cache={},Te=1;V._data=function(b){return this.cache[b[this.expando]]||{}};var Oe=/([\:\-\_]+(.))/g,Pe=/^moz([A-Z])/,tf={mouseleave:"mouseout",mouseenter:"mouseover"},Hb=K("jqLite"),Se=/^<(\w+)\s*\/?>(?:<\/\1>|)$/,
	Gb=/<|&#?\w+;/,Qe=/<([\w:]+)/,Re=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,ia={option:[1,'<select multiple="multiple">',"</select>"],thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};ia.optgroup=ia.option;ia.tbody=ia.tfoot=ia.colgroup=ia.caption=ia.thead;ia.th=ia.td;var Ia=V.prototype={ready:function(b){function a(){c||(c=
	!0,b())}var c=!1;"complete"===Y.readyState?setTimeout(a):(this.on("DOMContentLoaded",a),V(t).on("load",a),this.on("DOMContentLoaded",a))},toString:function(){var b=[];r(this,function(a){b.push(""+a)});return"["+b.join(", ")+"]"},eq:function(b){return 0<=b?G(this[b]):G(this[this.length+b])},length:0,push:sf,sort:[].sort,splice:[].splice},qb={};r("multiple selected checked disabled readOnly required open".split(" "),function(b){qb[P(b)]=b});var zc={};r("input select option textarea button form details".split(" "),
	function(b){zc[b]=!0});var Ac={ngMinlength:"minlength",ngMaxlength:"maxlength",ngMin:"min",ngMax:"max",ngPattern:"pattern"};r({data:Jb,removeData:mb},function(b,a){V[a]=b});r({data:Jb,inheritedData:pb,scope:function(b){return G.data(b,"$scope")||pb(b.parentNode||b,["$isolateScope","$scope"])},isolateScope:function(b){return G.data(b,"$isolateScope")||G.data(b,"$isolateScopeNoTemplate")},controller:vc,injector:function(b){return pb(b,"$injector")},removeAttr:function(b,a){b.removeAttribute(a)},hasClass:jb,
	css:function(b,a,c){a=Wa(a);if(B(c))b.style[a]=c;else return b.style[a]},attr:function(b,a,c){var d=P(a);if(qb[d])if(B(c))c?(b[a]=!0,b.setAttribute(a,d)):(b[a]=!1,b.removeAttribute(d));else return b[a]||(b.attributes.getNamedItem(a)||w).specified?d:s;else if(B(c))b.setAttribute(a,c);else if(b.getAttribute)return b=b.getAttribute(a,2),null===b?s:b},prop:function(b,a,c){if(B(c))b[a]=c;else return b[a]},text:function(){function b(a,b){if(F(b)){var d=a.nodeType;return 1===d||3===d?a.textContent:""}a.textContent=
	b}b.$dv="";return b}(),val:function(b,a){if(F(a)){if(b.multiple&&"select"===pa(b)){var c=[];r(b.options,function(a){a.selected&&c.push(a.value||a.text)});return 0===c.length?null:c}return b.value}b.value=a},html:function(b,a){if(F(a))return b.innerHTML;lb(b,!0);b.innerHTML=a},empty:wc},function(b,a){V.prototype[a]=function(a,d){var e,f,g=this.length;if(b!==wc&&(2==b.length&&b!==jb&&b!==vc?a:d)===s){if(S(a)){for(e=0;e<g;e++)if(b===Jb)b(this[e],a);else for(f in a)b(this[e],f,a[f]);return this}e=b.$dv;
	g=e===s?Math.min(g,1):g;for(f=0;f<g;f++){var h=b(this[f],a,d);e=e?e+h:h}return e}for(e=0;e<g;e++)b(this[e],a,d);return this}});r({removeData:mb,on:function a(c,d,e,f){if(B(f))throw Hb("onargs");if(rc(c)){var g=nb(c,!0);f=g.events;var h=g.handle;h||(h=g.handle=Ve(c,f));for(var g=0<=d.indexOf(" ")?d.split(" "):[d],m=g.length;m--;){d=g[m];var k=f[d];k||(f[d]=[],"mouseenter"===d||"mouseleave"===d?a(c,tf[d],function(a){var c=a.relatedTarget;c&&(c===this||this.contains(c))||h(a,d)}):"$destroy"!==d&&c.addEventListener(d,
	h,!1),k=f[d]);k.push(e)}}},off:uc,one:function(a,c,d){a=G(a);a.on(c,function f(){a.off(c,d);a.off(c,f)});a.on(c,d)},replaceWith:function(a,c){var d,e=a.parentNode;lb(a);r(new V(c),function(c){d?e.insertBefore(c,d.nextSibling):e.replaceChild(c,a);d=c})},children:function(a){var c=[];r(a.childNodes,function(a){1===a.nodeType&&c.push(a)});return c},contents:function(a){return a.contentDocument||a.childNodes||[]},append:function(a,c){var d=a.nodeType;if(1===d||11===d){c=new V(c);for(var d=0,e=c.length;d<
	e;d++)a.appendChild(c[d])}},prepend:function(a,c){if(1===a.nodeType){var d=a.firstChild;r(new V(c),function(c){a.insertBefore(c,d)})}},wrap:function(a,c){c=G(c).eq(0).clone()[0];var d=a.parentNode;d&&d.replaceChild(c,a);c.appendChild(a)},remove:xc,detach:function(a){xc(a,!0)},after:function(a,c){var d=a,e=a.parentNode;c=new V(c);for(var f=0,g=c.length;f<g;f++){var h=c[f];e.insertBefore(h,d.nextSibling);d=h}},addClass:Lb,removeClass:Kb,toggleClass:function(a,c,d){c&&r(c.split(" "),function(c){var f=
	d;F(f)&&(f=!jb(a,c));(f?Lb:Kb)(a,c)})},parent:function(a){return(a=a.parentNode)&&11!==a.nodeType?a:null},next:function(a){return a.nextElementSibling},find:function(a,c){return a.getElementsByTagName?a.getElementsByTagName(c):[]},clone:Ib,triggerHandler:function(a,c,d){var e,f;e=c.type||c;var g=nb(a);if(g=(g=g&&g.events)&&g[e])e={preventDefault:function(){this.defaultPrevented=!0},isDefaultPrevented:function(){return!0===this.defaultPrevented},stopPropagation:w,type:e,target:a},c.type&&(e=E(e,c)),
	c=qa(g),f=d?[e].concat(d):[e],r(c,function(c){c.apply(a,f)})}},function(a,c){V.prototype[c]=function(c,e,f){for(var g,h=0,m=this.length;h<m;h++)F(g)?(g=a(this[h],c,e,f),B(g)&&(g=G(g))):tc(g,a(this[h],c,e,f));return B(g)?g:this};V.prototype.bind=V.prototype.on;V.prototype.unbind=V.prototype.off});Xa.prototype={put:function(a,c){this[Ka(a,this.nextUid)]=c},get:function(a){return this[Ka(a,this.nextUid)]},remove:function(a){var c=this[a=Ka(a,this.nextUid)];delete this[a];return c}};var Cc=/^function\s*[^\(]*\(\s*([^\)]*)\)/m,
	Xe=/,/,Ye=/^\s*(_?)(\S+?)\1\s*$/,Bc=/((\/\/.*$)|(\/\*[\s\S]*?\*\/))/mg,La=K("$injector");Cb.$$annotate=Mb;var uf=K("$animate"),oe=["$provide",function(a){this.$$selectors={};this.register=function(c,d){var e=c+"-animation";if(c&&"."!=c.charAt(0))throw uf("notcsel",c);this.$$selectors[c.substr(1)]=e;a.factory(e,d)};this.classNameFilter=function(a){1===arguments.length&&(this.$$classNameFilter=a instanceof RegExp?a:null);return this.$$classNameFilter};this.$get=["$$q","$$asyncCallback",function(a,d){function e(){f||
	(f=a.defer(),d(function(){f.resolve();f=null}));return f.promise}var f;return{enter:function(a,c,d){d?d.after(a):c.prepend(a);return e()},leave:function(a){a.remove();return e()},move:function(a,c,d){return this.enter(a,c,d)},addClass:function(a,c){c=C(c)?c:L(c)?c.join(" "):"";r(a,function(a){Lb(a,c)});return e()},removeClass:function(a,c){c=C(c)?c:L(c)?c.join(" "):"";r(a,function(a){Kb(a,c)});return e()},setClass:function(a,c,d){this.addClass(a,c);this.removeClass(a,d);return e()},enabled:w,cancel:w}}]}],
	ja=K("$compile");jc.$inject=["$provide","$$sanitizeUriProvider"];var af=/^(x[\:\-_]|data[\:\-_])/i,Pb=K("$interpolate"),vf=/^([^\?#]*)(\?([^#]*))?(#(.*))?$/,df={http:80,https:443,ftp:21},sb=K("$location");Mc.prototype=Sb.prototype=Lc.prototype={$$html5:!1,$$replace:!1,absUrl:tb("$$absUrl"),url:function(a){if(F(a))return this.$$url;a=vf.exec(a);a[1]&&this.path(decodeURIComponent(a[1]));(a[2]||a[1])&&this.search(a[3]||"");this.hash(a[5]||"");return this},protocol:tb("$$protocol"),host:tb("$$host"),
	port:tb("$$port"),path:Nc("$$path",function(a){a=a?a.toString():"";return"/"==a.charAt(0)?a:"/"+a}),search:function(a,c){switch(arguments.length){case 0:return this.$$search;case 1:if(C(a)||ea(a))a=a.toString(),this.$$search=fc(a);else if(S(a))r(a,function(c,e){null==c&&delete a[e]}),this.$$search=a;else throw sb("isrcharg");break;default:F(c)||null===c?delete this.$$search[a]:this.$$search[a]=c}this.$$compose();return this},hash:Nc("$$hash",function(a){return a?a.toString():""}),replace:function(){this.$$replace=
	!0;return this}};var oa=K("$parse"),wf=Function.prototype.call,xf=Function.prototype.apply,yf=Function.prototype.bind,hd=Object.create(null);r({"null":function(){return null},"true":function(){return!0},"false":function(){return!1},undefined:function(){}},function(a,c){a.constant=a.literal=a.sharedGetter=!0;hd[c]=a});var Wb=E(Object.create(null),{"+":function(a,c,d,e){d=d(a,c);e=e(a,c);return B(d)?B(e)?d+e:d:B(e)?e:s},"-":function(a,c,d,e){d=d(a,c);e=e(a,c);return(B(d)?d:0)-(B(e)?e:0)},"*":function(a,
	c,d,e){return d(a,c)*e(a,c)},"/":function(a,c,d,e){return d(a,c)/e(a,c)},"%":function(a,c,d,e){return d(a,c)%e(a,c)},"^":function(a,c,d,e){return d(a,c)^e(a,c)},"=":w,"===":function(a,c,d,e){return d(a,c)===e(a,c)},"!==":function(a,c,d,e){return d(a,c)!==e(a,c)},"==":function(a,c,d,e){return d(a,c)==e(a,c)},"!=":function(a,c,d,e){return d(a,c)!=e(a,c)},"<":function(a,c,d,e){return d(a,c)<e(a,c)},">":function(a,c,d,e){return d(a,c)>e(a,c)},"<=":function(a,c,d,e){return d(a,c)<=e(a,c)},">=":function(a,
	c,d,e){return d(a,c)>=e(a,c)},"&&":function(a,c,d,e){return d(a,c)&&e(a,c)},"||":function(a,c,d,e){return d(a,c)||e(a,c)},"&":function(a,c,d,e){return d(a,c)&e(a,c)},"|":function(a,c,d,e){return e(a,c)(a,c,d(a,c))},"!":function(a,c,d){return!d(a,c)}}),zf={n:"\n",f:"\f",r:"\r",t:"\t",v:"\v","'":"'",'"':'"'},Tb=function(a){this.options=a};Tb.prototype={constructor:Tb,lex:function(a){this.text=a;this.index=0;this.ch=s;for(this.tokens=[];this.index<this.text.length;)if(this.ch=this.text.charAt(this.index),
	this.is("\"'"))this.readString(this.ch);else if(this.isNumber(this.ch)||this.is(".")&&this.isNumber(this.peek()))this.readNumber();else if(this.isIdent(this.ch))this.readIdent();else if(this.is("(){}[].,;:?"))this.tokens.push({index:this.index,text:this.ch}),this.index++;else if(this.isWhitespace(this.ch))this.index++;else{a=this.ch+this.peek();var c=a+this.peek(2),d=Wb[this.ch],e=Wb[a],f=Wb[c];f?(this.tokens.push({index:this.index,text:c,fn:f}),this.index+=3):e?(this.tokens.push({index:this.index,
	text:a,fn:e}),this.index+=2):d?(this.tokens.push({index:this.index,text:this.ch,fn:d}),this.index+=1):this.throwError("Unexpected next character ",this.index,this.index+1)}return this.tokens},is:function(a){return-1!==a.indexOf(this.ch)},peek:function(a){a=a||1;return this.index+a<this.text.length?this.text.charAt(this.index+a):!1},isNumber:function(a){return"0"<=a&&"9">=a},isWhitespace:function(a){return" "===a||"\r"===a||"\t"===a||"\n"===a||"\v"===a||"\u00a0"===a},isIdent:function(a){return"a"<=
	a&&"z">=a||"A"<=a&&"Z">=a||"_"===a||"$"===a},isExpOperator:function(a){return"-"===a||"+"===a||this.isNumber(a)},throwError:function(a,c,d){d=d||this.index;c=B(c)?"s "+c+"-"+this.index+" ["+this.text.substring(c,d)+"]":" "+d;throw oa("lexerr",a,c,this.text);},readNumber:function(){for(var a="",c=this.index;this.index<this.text.length;){var d=P(this.text.charAt(this.index));if("."==d||this.isNumber(d))a+=d;else{var e=this.peek();if("e"==d&&this.isExpOperator(e))a+=d;else if(this.isExpOperator(d)&&
	e&&this.isNumber(e)&&"e"==a.charAt(a.length-1))a+=d;else if(!this.isExpOperator(d)||e&&this.isNumber(e)||"e"!=a.charAt(a.length-1))break;else this.throwError("Invalid exponent")}this.index++}a*=1;this.tokens.push({index:c,text:a,constant:!0,fn:function(){return a}})},readIdent:function(){for(var a=this.text,c="",d=this.index,e,f,g,h;this.index<this.text.length;){h=this.text.charAt(this.index);if("."===h||this.isIdent(h)||this.isNumber(h))"."===h&&(e=this.index),c+=h;else break;this.index++}e&&"."===
	c[c.length-1]&&(this.index--,c=c.slice(0,-1),e=c.lastIndexOf("."),-1===e&&(e=s));if(e)for(f=this.index;f<this.text.length;){h=this.text.charAt(f);if("("===h){g=c.substr(e-d+1);c=c.substr(0,e-d);this.index=f;break}if(this.isWhitespace(h))f++;else break}this.tokens.push({index:d,text:c,fn:hd[c]||Pc(c,this.options,a)});g&&(this.tokens.push({index:e,text:"."}),this.tokens.push({index:e+1,text:g}))},readString:function(a){var c=this.index;this.index++;for(var d="",e=a,f=!1;this.index<this.text.length;){var g=
	this.text.charAt(this.index),e=e+g;if(f)"u"===g?(f=this.text.substring(this.index+1,this.index+5),f.match(/[\da-f]{4}/i)||this.throwError("Invalid unicode escape [\\u"+f+"]"),this.index+=4,d+=String.fromCharCode(parseInt(f,16))):d+=zf[g]||g,f=!1;else if("\\"===g)f=!0;else{if(g===a){this.index++;this.tokens.push({index:c,text:e,string:d,constant:!0,fn:function(){return d}});return}d+=g}this.index++}this.throwError("Unterminated quote",c)}};var Za=function(a,c,d){this.lexer=a;this.$filter=c;this.options=
	d};Za.ZERO=E(function(){return 0},{sharedGetter:!0,constant:!0});Za.prototype={constructor:Za,parse:function(a){this.text=a;this.tokens=this.lexer.lex(a);a=this.statements();0!==this.tokens.length&&this.throwError("is an unexpected token",this.tokens[0]);a.literal=!!a.literal;a.constant=!!a.constant;return a},primary:function(){var a;if(this.expect("("))a=this.filterChain(),this.consume(")");else if(this.expect("["))a=this.arrayDeclaration();else if(this.expect("{"))a=this.object();else{var c=this.expect();
	(a=c.fn)||this.throwError("not a primary expression",c);c.constant&&(a.constant=!0,a.literal=!0)}for(var d;c=this.expect("(","[",".");)"("===c.text?(a=this.functionCall(a,d),d=null):"["===c.text?(d=a,a=this.objectIndex(a)):"."===c.text?(d=a,a=this.fieldAccess(a)):this.throwError("IMPOSSIBLE");return a},throwError:function(a,c){throw oa("syntax",c.text,a,c.index+1,this.text,this.text.substring(c.index));},peekToken:function(){if(0===this.tokens.length)throw oa("ueoe",this.text);return this.tokens[0]},
	peek:function(a,c,d,e){if(0<this.tokens.length){var f=this.tokens[0],g=f.text;if(g===a||g===c||g===d||g===e||!(a||c||d||e))return f}return!1},expect:function(a,c,d,e){return(a=this.peek(a,c,d,e))?(this.tokens.shift(),a):!1},consume:function(a){this.expect(a)||this.throwError("is unexpected, expecting ["+a+"]",this.peek())},unaryFn:function(a,c){return E(function(d,e){return a(d,e,c)},{constant:c.constant})},ternaryFn:function(a,c,d){return E(function(e,f){return a(e,f)?c(e,f):d(e,f)},{constant:a.constant&&
	c.constant&&d.constant})},binaryFn:function(a,c,d){return E(function(e,f){return c(e,f,a,d)},{constant:a.constant&&d.constant})},statements:function(){for(var a=[];;)if(0<this.tokens.length&&!this.peek("}",")",";","]")&&a.push(this.filterChain()),!this.expect(";"))return 1===a.length?a[0]:function(c,d){for(var e,f=0,g=a.length;f<g;f++)e=a[f](c,d);return e}},filterChain:function(){for(var a=this.expression(),c;c=this.expect("|");)a=this.binaryFn(a,c.fn,this.filter());return a},filter:function(){var a=
	this.expect(),c=this.$filter(a.text),d,e;if(this.peek(":"))for(d=[],e=[];this.expect(":");)d.push(this.expression());return da(function(a,g,h){if(e){e[0]=h;for(h=d.length;h--;)e[h+1]=d[h](a,g);return c.apply(s,e)}return c(h)})},expression:function(){return this.assignment()},assignment:function(){var a=this.ternary(),c,d;return(d=this.expect("="))?(a.assign||this.throwError("implies assignment but ["+this.text.substring(0,d.index)+"] can not be assigned to",d),c=this.ternary(),function(d,f){return a.assign(d,
	c(d,f),f)}):a},ternary:function(){var a=this.logicalOR(),c,d;if(this.expect("?")){c=this.assignment();if(d=this.expect(":"))return this.ternaryFn(a,c,this.assignment());this.throwError("expected :",d)}else return a},logicalOR:function(){for(var a=this.logicalAND(),c;c=this.expect("||");)a=this.binaryFn(a,c.fn,this.logicalAND());return a},logicalAND:function(){var a=this.equality(),c;if(c=this.expect("&&"))a=this.binaryFn(a,c.fn,this.logicalAND());return a},equality:function(){var a=this.relational(),
	c;if(c=this.expect("==","!=","===","!=="))a=this.binaryFn(a,c.fn,this.equality());return a},relational:function(){var a=this.additive(),c;if(c=this.expect("<",">","<=",">="))a=this.binaryFn(a,c.fn,this.relational());return a},additive:function(){for(var a=this.multiplicative(),c;c=this.expect("+","-");)a=this.binaryFn(a,c.fn,this.multiplicative());return a},multiplicative:function(){for(var a=this.unary(),c;c=this.expect("*","/","%");)a=this.binaryFn(a,c.fn,this.unary());return a},unary:function(){var a;
	return this.expect("+")?this.primary():(a=this.expect("-"))?this.binaryFn(Za.ZERO,a.fn,this.unary()):(a=this.expect("!"))?this.unaryFn(a.fn,this.unary()):this.primary()},fieldAccess:function(a){var c=this.text,d=this.expect().text,e=Pc(d,this.options,c);return E(function(c,d,h){return e(h||a(c,d))},{assign:function(e,g,h){(h=a(e,h))||a.assign(e,h={});return ub(h,d,g,c)}})},objectIndex:function(a){var c=this.text,d=this.expression();this.consume("]");return E(function(e,f){var g=a(e,f),h=d(e,f);na(h,
	c);return g?Ba(g[h],c):s},{assign:function(e,f,g){var h=na(d(e,g),c);(g=Ba(a(e,g),c))||a.assign(e,g={});return g[h]=f}})},functionCall:function(a,c){var d=[];if(")"!==this.peekToken().text){do d.push(this.expression());while(this.expect(","))}this.consume(")");var e=this.text,f=d.length?[]:null;return function(g,h){var m=c?c(g,h):g,k=a(g,h,m)||w;if(f)for(var n=d.length;n--;)f[n]=Ba(d[n](g,h),e);Ba(m,e);if(k){if(k.constructor===k)throw oa("isecfn",e);if(k===wf||k===xf||k===yf)throw oa("isecff",e);
	}m=k.apply?k.apply(m,f):k(f[0],f[1],f[2],f[3],f[4]);return Ba(m,e)}},arrayDeclaration:function(){var a=[],c=!0;if("]"!==this.peekToken().text){do{if(this.peek("]"))break;var d=this.expression();a.push(d);d.constant||(c=!1)}while(this.expect(","))}this.consume("]");return E(function(c,d){for(var g=[],h=0,m=a.length;h<m;h++)g.push(a[h](c,d));return g},{literal:!0,constant:c})},object:function(){var a=[],c=!0;if("}"!==this.peekToken().text){do{if(this.peek("}"))break;var d=this.expect(),d=d.string||
	d.text;this.consume(":");var e=this.expression();a.push({key:d,value:e});e.constant||(c=!1)}while(this.expect(","))}this.consume("}");return E(function(c,d){for(var e={},m=0,k=a.length;m<k;m++){var n=a[m];e[n.key]=n.value(c,d)}return e},{literal:!0,constant:c})}};var Qc=Object.create(null),Ca=K("$sce"),ka={HTML:"html",CSS:"css",URL:"url",RESOURCE_URL:"resourceUrl",JS:"js"},ja=K("$compile"),Z=Y.createElement("a"),Tc=Aa(t.location.href,!0);qc.$inject=["$provide"];Uc.$inject=["$locale"];Wc.$inject=["$locale"];
	var Zc=".",nf={yyyy:$("FullYear",4),yy:$("FullYear",2,0,!0),y:$("FullYear",1),MMMM:wb("Month"),MMM:wb("Month",!0),MM:$("Month",2,1),M:$("Month",1,1),dd:$("Date",2),d:$("Date",1),HH:$("Hours",2),H:$("Hours",1),hh:$("Hours",2,-12),h:$("Hours",1,-12),mm:$("Minutes",2),m:$("Minutes",1),ss:$("Seconds",2),s:$("Seconds",1),sss:$("Milliseconds",3),EEEE:wb("Day"),EEE:wb("Day",!0),a:function(a,c){return 12>a.getHours()?c.AMPMS[0]:c.AMPMS[1]},Z:function(a){a=-1*a.getTimezoneOffset();return a=(0<=a?"+":"")+(vb(Math[0<
	a?"floor":"ceil"](a/60),2)+vb(Math.abs(a%60),2))},ww:ad(2),w:ad(1)},mf=/((?:[^yMdHhmsaZEw']+)|(?:'(?:[^']|'')*')|(?:E+|y+|M+|d+|H+|h+|m+|s+|a|Z|w+))(.*)/,lf=/^\-?\d+$/;Vc.$inject=["$locale"];var jf=da(P),kf=da(ib);Xc.$inject=["$parse"];var Fd=da({restrict:"E",compile:function(a,c){8>=X&&(c.href||c.name||c.$set("href",""),a.append(Y.createComment("IE fix")));if(!c.href&&!c.xlinkHref&&!c.name)return function(a,c){var f="[object SVGAnimatedString]"===Ga.call(c.prop("href"))?"xlink:href":"href";c.on("click",
	function(a){c.attr(f)||a.preventDefault()})}}}),kb={};r(qb,function(a,c){if("multiple"!=a){var d=va("ng-"+c);kb[d]=function(){return{restrict:"A",priority:100,link:function(a,f,g){a.$watch(g[d],function(a){g.$set(c,!!a)})}}}}});r(Ac,function(a,c){kb[c]=function(){return{priority:100,link:function(a,e,f){if("ngPattern"===c&&"/"==f.ngPattern.charAt(0)&&(e=f.ngPattern.match(rf))){f.$set("ngPattern",new RegExp(e[1],e[2]));return}a.$watch(f[c],function(a){f.$set(c,a)})}}}});r(["src","srcset","href"],function(a){var c=
	va("ng-"+a);kb[c]=function(){return{priority:99,link:function(d,e,f){var g=a,h=a;"href"===a&&"[object SVGAnimatedString]"===Ga.call(e.prop("href"))&&(h="xlinkHref",f.$attr[h]="xlink:href",g=null);f.$observe(c,function(c){c?(f.$set(h,c),X&&g&&e.prop(g,f[h])):"href"===a&&f.$set(h,null)})}}}});var xb={$addControl:w,$removeControl:w,$setValidity:w,$$setPending:w,$setDirty:w,$setPristine:w,$setSubmitted:w,$$clearControlValidity:w};bd.$inject=["$element","$attrs","$scope","$animate"];var id=function(a){return["$timeout",
	function(c){return{name:"form",restrict:a?"EAC":"E",controller:bd,compile:function(){return{pre:function(a,e,f,g){if(!f.action){var h=function(c){a.$apply(function(){g.$commitViewValue();g.$setSubmitted()});c.preventDefault?c.preventDefault():c.returnValue=!1};e[0].addEventListener("submit",h,!1);e.on("$destroy",function(){c(function(){e[0].removeEventListener("submit",h,!1)},0,!1)})}var m=e.parent().controller("form"),k=f.name||f.ngForm;k&&ub(a,k,g,k);if(m)e.on("$destroy",function(){m.$removeControl(g);
	k&&ub(a,k,s,k);E(g,xb)})}}}}}]},Gd=id(),Td=id(!0),of=/\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)/,Af=/^(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?$/,Bf=/^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$/i,Cf=/^\s*(\-|\+)?(\d+|(\d*(\.\d*)))\s*$/,jd=/^(\d{4})-(\d{2})-(\d{2})$/,kd=/^(\d{4})-(\d\d)-(\d\d)T(\d\d):(\d\d)(?::(\d\d))?$/,Xb=/^(\d{4})-W(\d\d)$/,ld=/^(\d{4})-(\d\d)$/,md=/^(\d\d):(\d\d)(?::(\d\d))?$/,
	Df=/(\s+|^)default(\s+|$)/,Yb=new K("ngModel"),nd={text:function(a,c,d,e,f,g){$a(a,c,d,e,f,g);Ub(e)},date:ab("date",jd,zb(jd,["yyyy","MM","dd"]),"yyyy-MM-dd"),"datetime-local":ab("datetimelocal",kd,zb(kd,"yyyy MM dd HH mm ss".split(" ")),"yyyy-MM-ddTHH:mm:ss"),time:ab("time",md,zb(md,["HH","mm","ss"]),"HH:mm:ss"),week:ab("week",Xb,function(a){if(fa(a))return a;if(C(a)){Xb.lastIndex=0;var c=Xb.exec(a);if(c){a=+c[1];var d=+c[2],c=$c(a),d=7*(d-1);return new Date(a,0,c.getDate()+d)}}return NaN},"yyyy-Www"),
	month:ab("month",ld,zb(ld,["yyyy","MM"]),"yyyy-MM"),number:function(a,c,d,e,f,g){dd(a,c,d,e);$a(a,c,d,e,f,g);e.$$parserName="number";e.$parsers.push(function(a){return e.$isEmpty(a)?null:Cf.test(a)?parseFloat(a):s});e.$formatters.push(function(a){if(!e.$isEmpty(a)){if(!ea(a))throw Yb("numfmt",a);a=a.toString()}return a});if(d.min||d.ngMin){var h;e.$validators.min=function(a){return e.$isEmpty(a)||F(h)||a>=h};d.$observe("min",function(a){B(a)&&!ea(a)&&(a=parseFloat(a,10));h=ea(a)&&!isNaN(a)?a:s;e.$validate()})}if(d.max||
	d.ngMax){var m;e.$validators.max=function(a){return e.$isEmpty(a)||F(m)||a<=m};d.$observe("max",function(a){B(a)&&!ea(a)&&(a=parseFloat(a,10));m=ea(a)&&!isNaN(a)?a:s;e.$validate()})}},url:function(a,c,d,e,f,g){$a(a,c,d,e,f,g);Ub(e);e.$$parserName="url";e.$validators.url=function(a,c){var d=a||c;return e.$isEmpty(d)||Af.test(d)}},email:function(a,c,d,e,f,g){$a(a,c,d,e,f,g);Ub(e);e.$$parserName="email";e.$validators.email=function(a,c){var d=a||c;return e.$isEmpty(d)||Bf.test(d)}},radio:function(a,
	c,d,e){F(d.name)&&c.attr("name",++bb);c.on("click",function(a){c[0].checked&&e.$setViewValue(d.value,a&&a.type)});e.$render=function(){c[0].checked=d.value==e.$viewValue};d.$observe("value",e.$render)},checkbox:function(a,c,d,e,f,g,h,m){var k=ed(m,a,"ngTrueValue",d.ngTrueValue,!0),n=ed(m,a,"ngFalseValue",d.ngFalseValue,!1);c.on("click",function(a){e.$setViewValue(c[0].checked,a&&a.type)});e.$render=function(){c[0].checked=e.$viewValue};e.$isEmpty=function(a){return a!==k};e.$formatters.push(function(a){return ra(a,
	k)});e.$parsers.push(function(a){return a?k:n})},hidden:w,button:w,submit:w,reset:w,file:w},kc=["$browser","$sniffer","$filter","$parse",function(a,c,d,e){return{restrict:"E",require:["?ngModel"],link:function(f,g,h,m){m[0]&&(nd[P(h.type)]||nd.text)(f,g,h,m[0],c,a,d,e)}}}],pf="ng-valid",qf="ng-invalid",Ma="ng-pristine",yb="ng-dirty",gd="ng-pending",Ef=["$scope","$exceptionHandler","$attrs","$element","$parse","$animate","$timeout","$rootScope","$q",function(a,c,d,e,f,g,h,m,k){this.$modelValue=this.$viewValue=
	Number.NaN;this.$validators={};this.$asyncValidators={};this.$parsers=[];this.$formatters=[];this.$viewChangeListeners=[];this.$untouched=!0;this.$touched=!1;this.$pristine=!0;this.$dirty=!1;this.$valid=!0;this.$invalid=!1;this.$error={};this.$$success={};this.$pending=s;this.$name=d.name;var n=f(d.ngModel),p=null,l=this,q=function(){var c=n(a);l.$options&&l.$options.getterSetter&&D(c)&&(c=c());return c},A=function(c){var d;l.$options&&l.$options.getterSetter&&D(d=n(a))?d(l.$modelValue):n.assign(a,
	l.$modelValue)};this.$$setOptions=function(a){l.$options=a;if(!(n.assign||a&&a.getterSetter))throw Yb("nonassign",d.ngModel,ta(e));};this.$render=w;this.$isEmpty=function(a){return F(a)||""===a||null===a||a!==a};var u=e.inheritedData("$formController")||xb,x=0;e.addClass(Ma).addClass("ng-untouched");cd({ctrl:this,$element:e,set:function(a,c){a[c]=!0},unset:function(a,c){delete a[c]},parentForm:u,$animate:g});this.$setPristine=function(){l.$dirty=!1;l.$pristine=!0;g.removeClass(e,yb);g.addClass(e,
	Ma)};this.$setUntouched=function(){l.$touched=!1;l.$untouched=!0;g.setClass(e,"ng-untouched","ng-touched")};this.$setTouched=function(){l.$touched=!0;l.$untouched=!1;g.setClass(e,"ng-touched","ng-untouched")};this.$rollbackViewValue=function(){h.cancel(p);l.$viewValue=l.$$lastCommittedViewValue;l.$render()};this.$validate=function(){ea(l.$modelValue)&&isNaN(l.$modelValue)||this.$$parseAndValidate()};this.$$runValidators=function(a,c,d,e){function f(){var a=!0;r(l.$validators,function(e,f){var h=e(c,
	d);a=a&&h;g(f,h)});return a?!0:(r(l.$asyncValidators,function(a,c){g(c,null)}),m(),!1)}function h(){var a=[];r(l.$asyncValidators,function(e,f){var h=e(c,d);if(!h||!D(h.then))throw Yb("$asyncValidators",h);g(f,s);a.push(h.then(function(){g(f,!0)},function(a){g(f,!1)}))});a.length?k.all(a).then(m):m()}function g(a,c){n===x&&l.$setValidity(a,c)}function m(){n===x&&e()}x++;var n=x;(function(a){var c=l.$$parserName||"parse";if(a===s)g(c,null);else if(g(c,a),!a)return r(l.$validators,function(a,c){g(c,
	null)}),r(l.$asyncValidators,function(a,c){g(c,null)}),m(),!1;return!0})(a)&&f()&&h()};this.$commitViewValue=function(){var a=l.$viewValue;h.cancel(p);if(l.$$lastCommittedViewValue!==a||""===a&&l.$$hasNativeValidators)l.$$lastCommittedViewValue=a,l.$pristine&&(l.$dirty=!0,l.$pristine=!1,g.removeClass(e,Ma),g.addClass(e,yb),u.$setDirty()),this.$$parseAndValidate()};this.$$parseAndValidate=function(){for(var a=!0,c=l.$$lastCommittedViewValue,d=c,e=0;e<l.$parsers.length;e++)if(d=l.$parsers[e](d),F(d)){a=
	!1;break}ea(l.$modelValue)&&isNaN(l.$modelValue)&&(l.$modelValue=q());var f=l.$modelValue,h=l.$options&&l.$options.allowInvalid;h&&(l.$modelValue=d,l.$modelValue!==f&&l.$$writeModelToScope());l.$$runValidators(a,d,c,function(){h||(l.$modelValue=l.$valid?d:s,l.$modelValue!==f&&l.$$writeModelToScope())})};this.$$writeModelToScope=function(){A(l.$modelValue);r(l.$viewChangeListeners,function(a){try{a()}catch(d){c(d)}})};this.$setViewValue=function(a,c){l.$viewValue=a;l.$options&&!l.$options.updateOnDefault||
	l.$$debounceViewValueCommit(c)};this.$$debounceViewValueCommit=function(c){var d=0,e=l.$options;e&&B(e.debounce)&&(e=e.debounce,ea(e)?d=e:ea(e[c])?d=e[c]:ea(e["default"])&&(d=e["default"]));h.cancel(p);d?p=h(function(){l.$commitViewValue()},d):m.$$phase?l.$commitViewValue():a.$apply(function(){l.$commitViewValue()})};a.$watch(function(){var a=q();if(a!==l.$modelValue){l.$modelValue=a;for(var c=l.$formatters,d=c.length,e=a;d--;)e=c[d](e);l.$viewValue!==e&&(l.$viewValue=l.$$lastCommittedViewValue=e,
	l.$render(),l.$$runValidators(s,a,e,w))}return a})}],he=function(){return{restrict:"A",require:["ngModel","^?form","^?ngModelOptions"],controller:Ef,link:{pre:function(a,c,d,e){var f=e[0],g=e[1]||xb;f.$$setOptions(e[2]&&e[2].$options);g.$addControl(f);a.$on("$destroy",function(){g.$removeControl(f)})},post:function(a,c,d,e){var f=e[0];if(f.$options&&f.$options.updateOn)c.on(f.$options.updateOn,function(a){f.$$debounceViewValueCommit(a&&a.type)});c.on("blur",function(c){f.$touched||a.$apply(function(){f.$setTouched()})})}}}},
	je=da({restrict:"A",require:"ngModel",link:function(a,c,d,e){e.$viewChangeListeners.push(function(){a.$eval(d.ngChange)})}}),mc=function(){return{restrict:"A",require:"?ngModel",link:function(a,c,d,e){e&&(d.required=!0,e.$validators.required=function(a,c){return!d.required||!e.$isEmpty(c)},d.$observe("required",function(){e.$validate()}))}}},lc=function(){return{restrict:"A",require:"?ngModel",link:function(a,c,d,e){if(e){var f,g=d.ngPattern||d.pattern;d.$observe("pattern",function(a){C(a)&&0<a.length&&
	(a=new RegExp(a));if(a&&!a.test)throw K("ngPattern")("noregexp",g,a,ta(c));f=a||s;e.$validate()});e.$validators.pattern=function(a){return e.$isEmpty(a)||F(f)||f.test(a)}}}}},oc=function(){return{restrict:"A",require:"?ngModel",link:function(a,c,d,e){if(e){var f=0;d.$observe("maxlength",function(a){f=U(a)||0;e.$validate()});e.$validators.maxlength=function(a,c){return e.$isEmpty(c)||c.length<=f}}}}},nc=function(){return{restrict:"A",require:"?ngModel",link:function(a,c,d,e){if(e){var f=0;d.$observe("minlength",
	function(a){f=U(a)||0;e.$validate()});e.$validators.minlength=function(a,c){return e.$isEmpty(c)||c.length>=f}}}}},ie=function(){return{restrict:"A",priority:100,require:"ngModel",link:function(a,c,d,e){var f=c.attr(d.$attr.ngList)||", ",g="false"!==d.ngTrim,h=g?ba(f):f;e.$parsers.push(function(a){if(!F(a)){var c=[];a&&r(a.split(h),function(a){a&&c.push(g?ba(a):a)});return c}});e.$formatters.push(function(a){return L(a)?a.join(f):s});e.$isEmpty=function(a){return!a||!a.length}}}},Ff=/^(true|false|\d+)$/,
	ke=function(){return{restrict:"A",priority:100,compile:function(a,c){return Ff.test(c.ngValue)?function(a,c,f){f.$set("value",a.$eval(f.ngValue))}:function(a,c,f){a.$watch(f.ngValue,function(a){f.$set("value",a)})}}}},le=function(){return{restrict:"A",controller:["$scope","$attrs",function(a,c){var d=this;this.$options=a.$eval(c.ngModelOptions);this.$options.updateOn!==s?(this.$options.updateOnDefault=!1,this.$options.updateOn=ba(this.$options.updateOn.replace(Df,function(){d.$options.updateOnDefault=
	!0;return" "}))):this.$options.updateOnDefault=!0}]}},Ld=["$compile",function(a){return{restrict:"AC",compile:function(c){a.$$addBindingClass(c);return function(c,e,f){a.$$addBindingInfo(e,f.ngBind);c.$watch(f.ngBind,function(a){e.text(a==s?"":a)})}}}}],Nd=["$interpolate","$compile",function(a,c){return{compile:function(d){c.$$addBindingClass(d);return function(d,f,g){d=a(f.attr(g.$attr.ngBindTemplate));c.$$addBindingInfo(f,d.expressions);g.$observe("ngBindTemplate",function(a){f.text(a)})}}}}],Md=
	["$sce","$parse","$compile",function(a,c,d){return{restrict:"A",compile:function(e,f){var g=c(f.ngBindHtml),h=c(f.ngBindHtml,function(a){return(a||"").toString()});d.$$addBindingClass(e);return function(c,e,f){d.$$addBindingInfo(e,f.ngBindHtml);c.$watch(h,function(){e.html(a.getTrustedHtml(g(c))||"")})}}}}],Od=Vb("",!0),Qd=Vb("Odd",0),Pd=Vb("Even",1),Rd=Fa({compile:function(a,c){c.$set("ngCloak",s);a.removeClass("ng-cloak")}}),Sd=[function(){return{restrict:"A",scope:!0,controller:"@",priority:500}}],
	pc={},Gf={blur:!0,focus:!0};r("click dblclick mousedown mouseup mouseover mouseout mousemove mouseenter mouseleave keydown keyup keypress submit focus blur copy cut paste".split(" "),function(a){var c=va("ng-"+a);pc[c]=["$parse","$rootScope",function(d,e){return{restrict:"A",compile:function(f,g){var h=d(g[c]);return function(c,d){var f=P(a);d.on(f,function(a){var d=function(){h(c,{$event:a})};Gf[f]&&e.$$phase?c.$evalAsync(d):c.$apply(d)})}}}}]});var Vd=["$animate",function(a){return{multiElement:!0,
	transclude:"element",priority:600,terminal:!0,restrict:"A",$$tlb:!0,link:function(c,d,e,f,g){var h,m,k;c.$watch(e.ngIf,function(c){c?m||g(function(c,f){m=f;c[c.length++]=Y.createComment(" end ngIf: "+e.ngIf+" ");h={clone:c};a.enter(c,d.parent(),d)}):(k&&(k.remove(),k=null),m&&(m.$destroy(),m=null),h&&(k=hb(h.clone),a.leave(k).then(function(){k=null}),h=null))})}}}],Wd=["$templateRequest","$anchorScroll","$animate","$sce",function(a,c,d,e){return{restrict:"ECA",priority:400,terminal:!0,transclude:"element",
	controller:Ea.noop,compile:function(f,g){var h=g.ngInclude||g.src,m=g.onload||"",k=g.autoscroll;return function(f,g,l,q,r){var u=0,s,z,t,v=function(){z&&(z.remove(),z=null);s&&(s.$destroy(),s=null);t&&(d.leave(t).then(function(){z=null}),z=t,t=null)};f.$watch(e.parseAsResourceUrl(h),function(e){var h=function(){!B(k)||k&&!f.$eval(k)||c()},l=++u;e?(a(e,!0).then(function(a){if(l===u){var c=f.$new();q.template=a;a=r(c,function(a){v();d.enter(a,null,g).then(h)});s=c;t=a;s.$emit("$includeContentLoaded");
	f.$eval(m)}},function(){l===u&&(v(),f.$emit("$includeContentError"))}),f.$emit("$includeContentRequested")):(v(),q.template=null)})}}}}],me=["$compile",function(a){return{restrict:"ECA",priority:-400,require:"ngInclude",link:function(c,d,e,f){/SVG/.test(d[0].toString())?(d.empty(),a(sc(f.template,Y).childNodes)(c,function(a){d.append(a)},s,s,d)):(d.html(f.template),a(d.contents())(c))}}}],Xd=Fa({priority:450,compile:function(){return{pre:function(a,c,d){a.$eval(d.ngInit)}}}}),Yd=Fa({terminal:!0,priority:1E3}),
	Zd=["$locale","$interpolate",function(a,c){var d=/{}/g;return{restrict:"EA",link:function(e,f,g){var h=g.count,m=g.$attr.when&&f.attr(g.$attr.when),k=g.offset||0,n=e.$eval(m)||{},p={},l=c.startSymbol(),q=c.endSymbol(),s=/^when(Minus)?(.+)$/;r(g,function(a,c){s.test(c)&&(n[P(c.replace("when","").replace("Minus","-"))]=f.attr(g.$attr[c]))});r(n,function(a,e){p[e]=c(a.replace(d,l+h+"-"+k+q))});e.$watch(function(){var c=parseFloat(e.$eval(h));if(isNaN(c))return"";c in n||(c=a.pluralCat(c-k));return p[c](e)},
	function(a){f.text(a)})}}}],$d=["$parse","$animate",function(a,c){var d=K("ngRepeat"),e=function(a,c,d,e,k,n,p){a[d]=e;k&&(a[k]=n);a.$index=c;a.$first=0===c;a.$last=c===p-1;a.$middle=!(a.$first||a.$last);a.$odd=!(a.$even=0===(c&1))};return{restrict:"A",multiElement:!0,transclude:"element",priority:1E3,terminal:!0,$$tlb:!0,compile:function(f,g){var h=g.ngRepeat,m=Y.createComment(" end ngRepeat: "+h+" "),k=h.match(/^\s*([\s\S]+?)\s+in\s+([\s\S]+?)(?:\s+as\s+([\s\S]+?))?(?:\s+track\s+by\s+([\s\S]+?))?\s*$/);
	if(!k)throw d("iexp",h);var n=k[1],p=k[2],l=k[3],q=k[4],k=n.match(/^(?:([\$\w]+)|\(([\$\w]+)\s*,\s*([\$\w]+)\))$/);if(!k)throw d("iidexp",n);var A=k[3]||k[1],u=k[2];if(l&&(!/^[$a-zA-Z_][$a-zA-Z0-9_]*$/.test(l)||/^(null|undefined|this|\$index|\$first|\$middle|\$last|\$even|\$odd|\$parent)$/.test(l)))throw d("badident",l);var t,z,B,v,w={$id:Ka};q?t=a(q):(B=function(a,c){return Ka(c)},v=function(a){return a});return function(a,f,g,k,n){t&&(z=function(c,d,e){u&&(w[u]=c);w[A]=d;w.$index=e;return t(a,w)});
	var q=Object.create(null);a.$watchCollection(p,function(g){var k,p,t=f[0],J,x=Object.create(null),w,N,E,F,y,C,ga;l&&(a[l]=g);if(Na(g))y=g,p=z||B;else{p=z||v;y=[];for(ga in g)g.hasOwnProperty(ga)&&"$"!=ga.charAt(0)&&y.push(ga);y.sort()}w=y.length;ga=Array(w);for(k=0;k<w;k++)if(N=g===y?k:y[k],E=g[N],F=p(N,E,k),q[F])C=q[F],delete q[F],x[F]=C,ga[k]=C;else{if(x[F])throw r(ga,function(a){a&&a.scope&&(q[a.id]=a)}),d("dupes",h,F,sa(E));ga[k]={id:F,scope:s,clone:s};x[F]=!0}for(J in q){C=q[J];F=hb(C.clone);
	c.leave(F);if(F[0].parentNode)for(k=0,p=F.length;k<p;k++)F[k].$$NG_REMOVED=!0;C.scope.$destroy()}for(k=0;k<w;k++)if(N=g===y?k:y[k],E=g[N],C=ga[k],C.scope){J=t;do J=J.nextSibling;while(J&&J.$$NG_REMOVED);C.clone[0]!=J&&c.move(hb(C.clone),null,G(t));t=C.clone[C.clone.length-1];e(C.scope,k,A,E,u,N,w)}else n(function(a,d){C.scope=d;var f=m.cloneNode(!1);a[a.length++]=f;c.enter(a,null,G(t));t=f;C.clone=a;x[C.id]=C;e(C.scope,k,A,E,u,N,w)});q=x})}}}}],ae=["$animate",function(a){return{restrict:"A",multiElement:!0,
	link:function(c,d,e){c.$watch(e.ngShow,function(c){a[c?"removeClass":"addClass"](d,"ng-hide")})}}}],Ud=["$animate",function(a){return{restrict:"A",multiElement:!0,link:function(c,d,e){c.$watch(e.ngHide,function(c){a[c?"addClass":"removeClass"](d,"ng-hide")})}}}],be=Fa(function(a,c,d){a.$watch(d.ngStyle,function(a,d){d&&a!==d&&r(d,function(a,d){c.css(d,"")});a&&c.css(a)},!0)}),ce=["$animate",function(a){return{restrict:"EA",require:"ngSwitch",controller:["$scope",function(){this.cases={}}],link:function(c,
	d,e,f){var g=[],h=[],m=[],k=[],n=function(a,c){return function(){a.splice(c,1)}};c.$watch(e.ngSwitch||e.on,function(c){var d,e;d=0;for(e=m.length;d<e;++d)a.cancel(m[d]);d=m.length=0;for(e=k.length;d<e;++d){var s=hb(h[d].clone);k[d].$destroy();(m[d]=a.leave(s)).then(n(m,d))}h.length=0;k.length=0;(g=f.cases["!"+c]||f.cases["?"])&&r(g,function(c){c.transclude(function(d,e){k.push(e);var f=c.element;d[d.length++]=Y.createComment(" end ngSwitchWhen: ");h.push({clone:d});a.enter(d,f.parent(),f)})})})}}}],
	de=Fa({transclude:"element",priority:1200,require:"^ngSwitch",multiElement:!0,link:function(a,c,d,e,f){e.cases["!"+d.ngSwitchWhen]=e.cases["!"+d.ngSwitchWhen]||[];e.cases["!"+d.ngSwitchWhen].push({transclude:f,element:c})}}),ee=Fa({transclude:"element",priority:1200,require:"^ngSwitch",multiElement:!0,link:function(a,c,d,e,f){e.cases["?"]=e.cases["?"]||[];e.cases["?"].push({transclude:f,element:c})}}),ge=Fa({restrict:"EAC",link:function(a,c,d,e,f){if(!f)throw K("ngTransclude")("orphan",ta(c));f(function(a){c.empty();
	c.append(a)})}}),Hd=["$templateCache",function(a){return{restrict:"E",terminal:!0,compile:function(c,d){"text/ng-template"==d.type&&a.put(d.id,c[0].text)}}}],Hf=K("ngOptions"),fe=da({restrict:"A",terminal:!0}),Id=["$compile","$parse",function(a,c){var d=/^\s*([\s\S]+?)(?:\s+as\s+([\s\S]+?))?(?:\s+group\s+by\s+([\s\S]+?))?\s+for\s+(?:([\$\w][\$\w]*)|(?:\(\s*([\$\w][\$\w]*)\s*,\s*([\$\w][\$\w]*)\s*\)))\s+in\s+([\s\S]+?)(?:\s+track\s+by\s+([\s\S]+?))?$/,e={$setViewValue:w};return{restrict:"E",require:["select",
	"?ngModel"],controller:["$element","$scope","$attrs",function(a,c,d){var m=this,k={},n=e,p;m.databound=d.ngModel;m.init=function(a,c,d){n=a;p=d};m.addOption=function(c,d){Ja(c,'"option value"');k[c]=!0;n.$viewValue==c&&(a.val(c),p.parent()&&p.remove());d[0].hasAttribute("selected")&&(d[0].selected=!0)};m.removeOption=function(a){this.hasOption(a)&&(delete k[a],n.$viewValue==a&&this.renderUnknownOption(a))};m.renderUnknownOption=function(c){c="? "+Ka(c)+" ?";p.val(c);a.prepend(p);a.val(c);p.prop("selected",
	!0)};m.hasOption=function(a){return k.hasOwnProperty(a)};c.$on("$destroy",function(){m.renderUnknownOption=w})}],link:function(e,g,h,m){function k(a,c,d,e){d.$render=function(){var a=d.$viewValue;e.hasOption(a)?(y.parent()&&y.remove(),c.val(a),""===a&&w.prop("selected",!0)):F(a)&&w?c.val(""):e.renderUnknownOption(a)};c.on("change",function(){a.$apply(function(){y.parent()&&y.remove();d.$setViewValue(c.val())})})}function n(a,c,d){var e;d.$render=function(){var a=new Xa(d.$viewValue);r(c.find("option"),
	function(c){c.selected=B(a.get(c.value))})};a.$watch(function(){ra(e,d.$viewValue)||(e=qa(d.$viewValue),d.$render())});c.on("change",function(){a.$apply(function(){var a=[];r(c.find("option"),function(c){c.selected&&a.push(c.value)});d.$setViewValue(a)})})}function p(e,f,h){function g(){z||(e.$$postDigest(k),z=!0)}function k(){z=!1;var a={"":[]},c=[""],d,g,l,s,t;l=h.$modelValue;s=F(e)||[];var A=p?Zb(s):s,G,y,D;y={};D=!1;if(q)if(g=h.$modelValue,x&&L(g))for(D=new Xa([]),d={},t=0;t<g.length;t++)d[n]=
	g[t],D.put(x(e,d),g[t]);else D=new Xa(g);t=D;var H,K;for(D=0;G=A.length,D<G;D++){g=D;if(p){g=A[D];if("$"===g.charAt(0))continue;y[p]=g}y[n]=s[g];d=r(e,y)||"";(g=a[d])||(g=a[d]=[],c.push(d));q?d=B(t.remove(x?x(e,y):w(e,y))):(x?(d={},d[n]=l,d=x(e,d)===x(e,y)):d=l===w(e,y),t=t||d);H=m(e,y);H=B(H)?H:"";g.push({id:x?x(e,y):p?A[D]:D,label:H,selected:d})}q||(u||null===l?a[""].unshift({id:"",label:"",selected:!t}):t||a[""].unshift({id:"?",label:"",selected:!0}));y=0;for(A=c.length;y<A;y++){d=c[y];g=a[d];
	E.length<=y?(l={element:v.clone().attr("label",d),label:g.label},s=[l],E.push(s),f.append(l.element)):(s=E[y],l=s[0],l.label!=d&&l.element.attr("label",l.label=d));H=null;D=0;for(G=g.length;D<G;D++)d=g[D],(t=s[D+1])?(H=t.element,t.label!==d.label&&H.text(t.label=d.label),t.id!==d.id&&H.val(t.id=d.id),H[0].selected!==d.selected&&(H.prop("selected",t.selected=d.selected),X&&H.prop("selected",t.selected))):(""===d.id&&u?K=u:(K=C.clone()).val(d.id).prop("selected",d.selected).attr("selected",d.selected).text(d.label),
	s.push({element:K,label:d.label,id:d.id,selected:d.selected}),H?H.after(K):l.element.append(K),H=K);for(D++;s.length>D;)s.pop().element.remove()}for(;E.length>y;)E.pop()[0].element.remove()}var l;if(!(l=t.match(d)))throw Hf("iexp",t,ta(f));var m=c(l[2]||l[1]),n=l[4]||l[6],p=l[5],r=c(l[3]||""),w=c(l[2]?l[1]:n),F=c(l[7]),x=l[8]?c(l[8]):null,E=[[{element:f,label:""}]];u&&(a(u)(e),u.removeClass("ng-scope"),u.remove());f.empty();f.on("change",function(){e.$apply(function(){var a,c=F(e)||[],d={},g,l,m,
	r,t,u,v;if(q)for(l=[],r=0,u=E.length;r<u;r++)for(a=E[r],m=1,t=a.length;m<t;m++){if((g=a[m].element)[0].selected){g=g.val();p&&(d[p]=g);if(x)for(v=0;v<c.length&&(d[n]=c[v],x(e,d)!=g);v++);else d[n]=c[g];l.push(w(e,d))}}else if(g=f.val(),"?"==g)l=s;else if(""===g)l=null;else if(x)for(v=0;v<c.length;v++){if(d[n]=c[v],x(e,d)==g){l=w(e,d);break}}else d[n]=c[g],p&&(d[p]=g),l=w(e,d);h.$setViewValue(l);k()})});h.$render=k;e.$watchCollection(F,g);q&&e.$watchCollection(function(){return h.$modelValue},g)}if(m[1]){var l=
	m[0];m=m[1];var q=h.multiple,t=h.ngOptions,u=!1,w,z=!1,C=G(Y.createElement("option")),v=G(Y.createElement("optgroup")),y=C.clone();h=0;for(var E=g.children(),D=E.length;h<D;h++)if(""===E[h].value){w=u=E.eq(h);break}l.init(m,u,y);q&&(m.$isEmpty=function(a){return!a||0===a.length});t?p(e,g,m):q?n(e,g,m):k(e,g,m,l)}}}}],Kd=["$interpolate",function(a){var c={addOption:w,removeOption:w};return{restrict:"E",priority:100,compile:function(d,e){if(F(e.value)){var f=a(d.text(),!0);f||e.$set("value",d.text())}return function(a,
	d,e){var k=d.parent(),n=k.data("$selectController")||k.parent().data("$selectController");n&&n.databound?d.prop("selected",!1):n=c;f?a.$watch(f,function(a,c){e.$set("value",a);c!==a&&n.removeOption(c);n.addOption(a,d)}):n.addOption(e.value,d);d.on("$destroy",function(){n.removeOption(e.value)})}}}}],Jd=da({restrict:"E",terminal:!1});t.angular.bootstrap?console.log("WARNING: Tried to load angular more than once."):(zd(),Bd(Ea),G(Y).ready(function(){vd(Y,gc)}))})(window,document);
	!window.angular.$$csp()&&window.angular.element(document).find("head").prepend('<style type="text/css">@charset "UTF-8";[ng\\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-animate){display:none !important;}ng\\:form{display:block;}</style>');
	//# sourceMappingURL=angular.min.js.map


/***/ },
/* 4 */
/***/ function(module, exports, __webpack_require__) {

	/*
	 AngularJS v1.3.0-rc.1
	 (c) 2010-2014 Google, Inc. http://angularjs.org
	 License: MIT
	*/
	(function(r,d,z){'use strict';function v(s,h,f){return{restrict:"ECA",terminal:!0,priority:400,transclude:"element",link:function(a,e,b,g,u){function w(){k&&(k.remove(),k=null);l&&(l.$destroy(),l=null);n&&(f.leave(n).then(function(){k=null}),k=n,n=null)}function t(){var c=s.current&&s.current.locals;if(d.isDefined(c&&c.$template)){var c=a.$new(),m=s.current;n=u(c,function(c){f.enter(c,null,n||e).then(function(){!d.isDefined(p)||p&&!a.$eval(p)||h()});w()});l=m.scope=c;l.$emit("$viewContentLoaded");
	l.$eval(q)}else w()}var l,n,k,p=b.autoscroll,q=b.onload||"";a.$on("$routeChangeSuccess",t);t()}}}function x(d,h,f){return{restrict:"ECA",priority:-400,link:function(a,e){var b=f.current,g=b.locals;e.html(g.$template);var u=d(e.contents());b.controller&&(g.$scope=a,g=h(b.controller,g),b.controllerAs&&(a[b.controllerAs]=g),e.data("$ngControllerController",g),e.children().data("$ngControllerController",g));u(a)}}}r=d.module("ngRoute",["ng"]).provider("$route",function(){function s(a,e){return d.extend(new (d.extend(function(){},
	{prototype:a})),e)}function h(a,d){var b=d.caseInsensitiveMatch,g={originalPath:a,regexp:a},f=g.keys=[];a=a.replace(/([().])/g,"\\$1").replace(/(\/)?:(\w+)([\?\*])?/g,function(a,d,e,b){a="?"===b?b:null;b="*"===b?b:null;f.push({name:e,optional:!!a});d=d||"";return""+(a?"":d)+"(?:"+(a?d:"")+(b&&"(.+?)"||"([^/]+)")+(a||"")+")"+(a||"")}).replace(/([\/$\*])/g,"\\$1");g.regexp=new RegExp("^"+a+"$",b?"i":"");return g}var f={};this.when=function(a,e){f[a]=d.extend({reloadOnSearch:!0},e,a&&h(a,e));if(a){var b=
	"/"==a[a.length-1]?a.substr(0,a.length-1):a+"/";f[b]=d.extend({redirectTo:a},h(b,e))}return this};this.otherwise=function(a){"string"===typeof a&&(a={redirectTo:a});this.when(null,a);return this};this.$get=["$rootScope","$location","$routeParams","$q","$injector","$templateRequest","$sce",function(a,e,b,g,h,r,t){function l(){var c=n(),m=q.current;if(c&&m&&c.$$route===m.$$route&&d.equals(c.pathParams,m.pathParams)&&!c.reloadOnSearch&&!p)m.params=c.params,d.copy(m.params,b),a.$broadcast("$routeUpdate",
	m);else if(c||m)p=!1,a.$broadcast("$routeChangeStart",c,m),(q.current=c)&&c.redirectTo&&(d.isString(c.redirectTo)?e.path(k(c.redirectTo,c.params)).search(c.params).replace():e.url(c.redirectTo(c.pathParams,e.path(),e.search())).replace()),g.when(c).then(function(){if(c){var a=d.extend({},c.resolve),e,b;d.forEach(a,function(c,b){a[b]=d.isString(c)?h.get(c):h.invoke(c,null,null,b)});d.isDefined(e=c.template)?d.isFunction(e)&&(e=e(c.params)):d.isDefined(b=c.templateUrl)&&(d.isFunction(b)&&(b=b(c.params)),
	b=t.getTrustedResourceUrl(b),d.isDefined(b)&&(c.loadedTemplateUrl=b,e=r(b)));d.isDefined(e)&&(a.$template=e);return g.all(a)}}).then(function(e){c==q.current&&(c&&(c.locals=e,d.copy(c.params,b)),a.$broadcast("$routeChangeSuccess",c,m))},function(d){c==q.current&&a.$broadcast("$routeChangeError",c,m,d)})}function n(){var c,a;d.forEach(f,function(b,g){var f;if(f=!a){var h=e.path();f=b.keys;var l={};if(b.regexp)if(h=b.regexp.exec(h)){for(var k=1,n=h.length;k<n;++k){var p=f[k-1],q=h[k];p&&q&&(l[p.name]=
	q)}f=l}else f=null;else f=null;f=c=f}f&&(a=s(b,{params:d.extend({},e.search(),c),pathParams:c}),a.$$route=b)});return a||f[null]&&s(f[null],{params:{},pathParams:{}})}function k(a,b){var e=[];d.forEach((a||"").split(":"),function(a,c){if(0===c)e.push(a);else{var d=a.match(/(\w+)(.*)/),f=d[1];e.push(b[f]);e.push(d[2]||"");delete b[f]}});return e.join("")}var p=!1,q={routes:f,reload:function(){p=!0;a.$evalAsync(l)},updateParams:function(a){if(this.current&&this.current.$$route){var b={},f=this;d.forEach(Object.keys(a),
	function(d){f.current.pathParams[d]||(b[d]=a[d])});a=d.extend({},this.current.params,a);e.path(k(this.current.$$route.originalPath,a));e.search(d.extend({},e.search(),b))}else throw y("norout");}};a.$on("$locationChangeSuccess",l);return q}]});var y=d.$$minErr("ngRoute");r.provider("$routeParams",function(){this.$get=function(){return{}}});r.directive("ngView",v);r.directive("ngView",x);v.$inject=["$route","$anchorScroll","$animate"];x.$inject=["$compile","$controller","$route"]})(window,window.angular);
	//# sourceMappingURL=angular-route.min.js.map


/***/ },
/* 5 */
/***/ function(module, exports, __webpack_require__) {

	/*
	 AngularJS v1.3.0-rc.3
	 (c) 2010-2014 Google, Inc. http://angularjs.org
	 License: MIT
	*/
	(function(I,d,B){'use strict';function D(f,q){q=q||{};d.forEach(q,function(d,h){delete q[h]});for(var h in f)!f.hasOwnProperty(h)||"$"===h.charAt(0)&&"$"===h.charAt(1)||(q[h]=f[h]);return q}var w=d.$$minErr("$resource"),C=/^(\.[a-zA-Z_$][0-9a-zA-Z_$]*)+$/;d.module("ngResource",["ng"]).provider("$resource",function(){var f=this;this.defaults={stripTrailingSlashes:!0,actions:{get:{method:"GET"},save:{method:"POST"},query:{method:"GET",isArray:!0},remove:{method:"DELETE"},"delete":{method:"DELETE"}}};
	this.$get=["$http","$q",function(q,h){function t(d,g){this.template=d;this.defaults=s({},f.defaults,g);this.urlParams={}}function v(x,g,l,m){function c(b,k){var c={};k=s({},g,k);r(k,function(a,k){u(a)&&(a=a());var d;if(a&&a.charAt&&"@"==a.charAt(0)){d=b;var e=a.substr(1);if(null==e||""===e||"hasOwnProperty"===e||!C.test("."+e))throw w("badmember",e);for(var e=e.split("."),n=0,g=e.length;n<g&&d!==B;n++){var h=e[n];d=null!==d?d[h]:B}}else d=a;c[k]=d});return c}function F(b){return b.resource}function e(b){D(b||
	{},this)}var G=new t(x,m);l=s({},f.defaults.actions,l);e.prototype.toJSON=function(){var b=s({},this);delete b.$promise;delete b.$resolved;return b};r(l,function(b,k){var g=/^(POST|PUT|PATCH)$/i.test(b.method);e[k]=function(a,y,m,x){var n={},f,l,z;switch(arguments.length){case 4:z=x,l=m;case 3:case 2:if(u(y)){if(u(a)){l=a;z=y;break}l=y;z=m}else{n=a;f=y;l=m;break}case 1:u(a)?l=a:g?f=a:n=a;break;case 0:break;default:throw w("badargs",arguments.length);}var t=this instanceof e,p=t?f:b.isArray?[]:new e(f),
	A={},v=b.interceptor&&b.interceptor.response||F,C=b.interceptor&&b.interceptor.responseError||B;r(b,function(b,a){"params"!=a&&"isArray"!=a&&"interceptor"!=a&&(A[a]=H(b))});g&&(A.data=f);G.setUrlParams(A,s({},c(f,b.params||{}),n),b.url);n=q(A).then(function(a){var c=a.data,g=p.$promise;if(c){if(d.isArray(c)!==!!b.isArray)throw w("badcfg",k,b.isArray?"array":"object",d.isArray(c)?"array":"object");b.isArray?(p.length=0,r(c,function(a){"object"===typeof a?p.push(new e(a)):p.push(a)})):(D(c,p),p.$promise=
	g)}p.$resolved=!0;a.resource=p;return a},function(a){p.$resolved=!0;(z||E)(a);return h.reject(a)});n=n.then(function(a){var b=v(a);(l||E)(b,a.headers);return b},C);return t?n:(p.$promise=n,p.$resolved=!1,p)};e.prototype["$"+k]=function(a,b,c){u(a)&&(c=b,b=a,a={});a=e[k].call(this,a,this,b,c);return a.$promise||a}});e.bind=function(b){return v(x,s({},g,b),l)};return e}var E=d.noop,r=d.forEach,s=d.extend,H=d.copy,u=d.isFunction;t.prototype={setUrlParams:function(f,g,l){var m=this,c=l||m.template,h,
	e,q=m.urlParams={};r(c.split(/\W/),function(b){if("hasOwnProperty"===b)throw w("badname");!/^\d+$/.test(b)&&b&&(new RegExp("(^|[^\\\\]):"+b+"(\\W|$)")).test(c)&&(q[b]=!0)});c=c.replace(/\\:/g,":");g=g||{};r(m.urlParams,function(b,k){h=g.hasOwnProperty(k)?g[k]:m.defaults[k];d.isDefined(h)&&null!==h?(e=encodeURIComponent(h).replace(/%40/gi,"@").replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%20/g,"%20").replace(/%26/gi,"&").replace(/%3D/gi,"=").replace(/%2B/gi,"+"),c=c.replace(new RegExp(":"+
	k+"(\\W|$)","g"),function(b,a){return e+a})):c=c.replace(new RegExp("(/?):"+k+"(\\W|$)","g"),function(b,a,c){return"/"==c.charAt(0)?c:a+c})});m.defaults.stripTrailingSlashes&&(c=c.replace(/\/+$/,"")||"/");c=c.replace(/\/\.(?=\w+($|\?))/,".");f.url=c.replace(/\/\\\./,"/.");r(g,function(b,c){m.urlParams[c]||(f.params=f.params||{},f.params[c]=b)})}};return v}]})})(window,window.angular);
	//# sourceMappingURL=angular-resource.min.js.map


/***/ },
/* 6 */
/***/ function(module, exports, __webpack_require__) {

	var app;
	
	app = window.app = angular.module('dutilsApp', ['ngRoute', 'ngResource']);
	
	app.config([
	  '$routeProvider', '$httpProvider', '$interpolateProvider', '$compileProvider', function($routeProvider, $httpProvider, $interpolateProvider, $compileProvider) {
	    $httpProvider.defaults.headers.common['Authorization'] = 'Basic YWRtaW46YWRtaW5wYXNz';
	    $interpolateProvider.startSymbol('[[').endSymbol(']]');
	    $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|magnet):/);
	    return $httpProvider.defaults.transformRequest = function(data) {
	      var json;
	      if (!data) {
	        return data;
	      } else {
	        json = angular.toJson(data);
	        if (data.name != null) {
	          json = "{" + "\"" + data.name + "\": " + json + "}";
	          return json;
	        } else {
	          return json;
	        }
	      }
	    };
	  }
	]);


/***/ },
/* 7 */
/***/ function(module, exports, __webpack_require__) {

	app.factory('apiFactory', [
	  '$http', function($http) {
	    var apiFactory, searchUrl, urlBase;
	    $http.defaults.headers.common['Authorization'] = 'Basic YWRtaW46YWRtaW5wYXNz';
	    urlBase = "api/instances";
	    searchUrl = "api/search";
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
	    apiFactory.searchTorrent = function(searchQuery, sitesParam) {
	      var req;
	      req = {
	        method: 'get',
	        url: searchUrl,
	        params: {
	          searchQuery: searchQuery,
	          sitesParam: sitesParam
	        }
	      };
	      return $http(req);
	    };
	    return apiFactory;
	  }
	]);


/***/ },
/* 8 */
/***/ function(module, exports, __webpack_require__) {

	app.service('utilsService', [
	  function() {
	    var resolve, resolvePromiseWithCallbacks;
	    resolve = function(promise, successCallback, errorCallback) {
	      promise.success(successCallback).error(errorCallback);
	    };
	    resolvePromiseWithCallbacks = function(callPromise, successClosure, errorCallback, loadingAction, loadingActionStop) {
	      if (!!loadingAction) {
	        loadingAction();
	      }
	      resolve(callPromise, (function(data) {
	        successClosure(data);
	        if (!!loadingActionStop) {
	          loadingActionStop();
	        }
	      }), (function(data) {
	        errorCallback(data);
	        if (!!loadingActionStop) {
	          loadingActionStop();
	        }
	      }));
	    };
	    return {
	      resolvePromiseWithCallbacks: resolvePromiseWithCallbacks
	    };
	  }
	]);


/***/ },
/* 9 */
/***/ function(module, exports, __webpack_require__) {

	app.controller('instanceController', [
	  '$scope', 'apiFactory', '$route', '$routeParams', function($scope, apiFactory) {
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


/***/ },
/* 10 */
/***/ function(module, exports, __webpack_require__) {

	app.factory('Feed', [
	  '$resource', function($resource) {
	    var Feed;
	    Feed = $resource('api/feeds/:feedId', {
	      feedId: '@id'
	    }, {
	      getAll: {
	        method: 'GET',
	        params: {},
	        isArray: true
	      },
	      update: {
	        method: 'PUT'
	      },
	      deleteFeed: {
	        method: 'DELETE'
	      }
	    });
	    Feed.prototype.name = 'feed';
	    return Feed;
	  }
	]);


/***/ },
/* 11 */
/***/ function(module, exports, __webpack_require__) {

	app.controller('feedsController', [
	  '$scope', 'Feed', function($scope, Feed) {
	    var collectValues, deleteFeed, init, save, update;
	    init = function() {
	      $scope.loading = true;
	      $scope.feeds = Feed.getAll(function(data) {
	        $scope.loading = false;
	        return console.log("Feeds loaded");
	      });
	      $scope.showFeedsForm = false;
	      $scope.submitText = "Add";
	      $scope.formTitle = "Add new feed";
	      $scope.actionToPerform = "add";
	      $scope.feedsFields = [
	        {
	          label: "Url",
	          name: "url",
	          type: "text",
	          value: null
	        }, {
	          label: "Description",
	          name: "description",
	          type: "text",
	          value: null
	        }, {
	          label: "Active",
	          name: "active",
	          type: "boolean",
	          value: null
	        }
	      ];
	    };
	    $scope.action = function() {
	      collectValues();
	      if ($scope.actionToPerform === "add") {
	        save();
	      } else {
	        update();
	      }
	    };
	    save = function() {
	      $scope.feed.$save(function(feed) {
	        console.log("Feed saved " + feed);
	        init();
	      });
	    };
	    update = function() {
	      $scope.formTitle = "Updating...";
	      $scope.feed.$update(function(feed) {
	        console.log("Updated " + feed);
	        $scope.feed = null;
	        $scope.showFeedsForm = false;
	      });
	    };
	    deleteFeed = function() {
	      return $scope.feed.$delete(function(feed) {
	        return console.log("Feed deleted!");
	      });
	    };
	    $scope.newFeed = function() {
	      $scope.submitText = "Add";
	      $scope.formTitle = "Add new feed";
	      $scope.actionToPerform = "add";
	      $scope.showFeedsForm = true;
	      $scope.feed = new Feed();
	    };
	    $scope.editFeed = function(feed) {
	      var field, i, len, ref;
	      $scope.formTitle = "Update feed";
	      $scope.submitText = "Update";
	      $scope.actionToPerform = "update";
	      $scope.showFeedsForm = true;
	      $scope.feed = feed;
	      ref = $scope.feedsFields;
	      for (i = 0, len = ref.length; i < len; i++) {
	        field = ref[i];
	        field.value = feed[field.name];
	      }
	    };
	    collectValues = function() {
	      var field, i, len, ref, results;
	      ref = $scope.feedsFields;
	      results = [];
	      for (i = 0, len = ref.length; i < len; i++) {
	        field = ref[i];
	        results.push($scope.feed[field.name] = field.value);
	      }
	      return results;
	    };
	    init();
	  }
	]);


/***/ },
/* 12 */
/***/ function(module, exports, __webpack_require__) {

	app.controller('searchController', [
	  '$scope', 'apiFactory', 'utilsService', '$window', '$location', 'Torrent', function($scope, apiFactory, utilsService, $window, $location, Torrent) {
	    var onError, onSuccess, populateScopeWithTorrents, promise, reloadPage;
	    promise = null;
	    reloadPage = false;
	    $scope.searchSites = [
	      {
	        id: "KT",
	        name: 'Kickass Torrents'
	      }, {
	        id: "DT",
	        name: 'Divx Total',
	        selected: true
	      }
	    ];
	    $scope.buttonText = "Download";
	    $scope.search = function() {
	      var searchQuery, searchSites, sitesParam, url;
	      if (reloadPage) {
	        url = _str.strLeft($location.$$absUrl, '?');
	        $window.location.href = url + "?searchQuery=" + $scope.query;
	      } else {
	        searchQuery = $scope.query;
	        searchSites = _.where($scope.searchSites, {
	          selected: true
	        });
	        sitesParam = "";
	        _.each(searchSites, function(elem, index, list) {
	          sitesParam = sitesParam + elem.id + ",";
	        });
	        sitesParam = sitesParam.replace(/,$/, "");
	        $scope.loading = true;
	        promise = apiFactory.searchTorrent(searchQuery, sitesParam);
	        utilsService.resolvePromiseWithCallbacks(promise, onSuccess, onError, null, null);
	      }
	    };
	    $scope.initTorrents = function(torrentsInfo) {
	      $scope.buttonText = "Download";
	      $scope.searchSites = [
	        {
	          id: "KT",
	          name: 'Kickass Torrents'
	        }, {
	          id: "DT",
	          name: 'Divx Total',
	          selected: true
	        }
	      ];
	      if (torrentsInfo != null) {
	        populateScopeWithTorrents(torrentsInfo);
	      }
	    };
	    $scope.startDownload = function(torrentDefinition) {
	      var torrentDownload;
	      torrentDownload = new Torrent();
	      torrentDefinition.date = moment(torrentDefinition.date).format('YYYY-MM-DD[T]HH:mm:ssZZ');
	      _.extend(torrentDownload, torrentDefinition);
	      torrentDefinition.state = "Starting...";
	      torrentDefinition.buttonText = "Starting...";
	      return torrentDownload.$save(function(data) {
	        var ref;
	        data.torrent.state = _str.capitalize((ref = data.torrent.state) != null ? ref.toLowerCase() : void 0);
	        data.torrent.date = moment(data.torrent.date).format('YYYY-MM-DD');
	        _.extend(torrentDefinition, data.torrent);
	        torrentDefinition.buttonText = torrentDefinition.state;
	      });
	    };
	    $scope.cancelDownload = function(torrent) {
	      torrent.$delete(function(data) {
	        torrent.state = "Cleared";
	      });
	    };
	    populateScopeWithTorrents = function(torrentsInfo) {
	      _.map(torrentsInfo.torrents, function(torrent) {
	        torrent.state = _str.capitalize(torrent.state.toLowerCase());
	        torrent.date = moment(torrent.date, 'YYYY-MM-DD').format('YYYY-MM-DD');
	        return torrent.buttonText = "Download";
	      });
	      $scope.torrents = torrentsInfo.torrents;
	      $scope.query = torrentsInfo.query;
	      $scope.limit = torrentsInfo.limit;
	      $scope.offset = torrentsInfo.offset;
	      $scope.currentOffset = torrentsInfo.currentOffset;
	      $scope.total = torrentsInfo.total;
	      $scope.searchFinished = true;
	      return $scope.loading = false;
	    };
	    onSuccess = function(responseData) {
	      populateScopeWithTorrents(responseData.torrentsInfo);
	    };
	    onError = function(responseData) {
	      $scope.errors = "Error in request";
	      console.log($scope.errors);
	    };
	  }
	]);


/***/ },
/* 13 */
/***/ function(module, exports, __webpack_require__) {

	app.factory('Torrent', [
	  '$resource', function($resource) {
	    var Torrent;
	    Torrent = $resource('api/torrents/:guid', {
	      guid: '@guid'
	    }, {
	      getTorrent: {
	        method: 'GET'
	      }
	    });
	    Torrent.prototype.name = 'torrent';
	    return Torrent;
	  }
	]);


/***/ },
/* 14 */
/***/ function(module, exports, __webpack_require__) {

	var template;
	
	template = __webpack_require__(20);
	
	app.directive('adminForm', function() {
	  return {
	    template: template,
	    restrict: 'E',
	    replace: true,
	    transclude: true,
	    scope: {
	      fields: '=',
	      submitText: '=',
	      formTitle: '=title',
	      submitAction: '&'
	    },
	    link: function(scope, iElement, iAttrs, controller) {
	      var filledFields;
	      filledFields = [];
	    }
	  };
	});


/***/ },
/* 15 */
/***/ function(module, exports, __webpack_require__) {

	var template;
	
	template = __webpack_require__(21);
	
	app.directive('adminTable', function() {
	  return {
	    template: template,
	    restrict: 'E',
	    replace: true,
	    transclude: true,
	    scope: {
	      items: '=',
	      fields: '=',
	      updateAction: '&'
	    },
	    controller: function($scope, $element, $attrs, $injector) {},
	    link: function(scope, iElement, iAttrs, controller) {
	      scope.isUpdateActionDefined = iAttrs.updateAction != null;
	      scope.isDeleteActionDefined = iAttrs.deleteAction != null;
	      scope.select = function(item) {
	        scope.selected = item;
	      };
	    }
	  };
	});


/***/ },
/* 16 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(module) {//! moment.js
	//! version : 2.10.2
	//! authors : Tim Wood, Iskren Chernev, Moment.js contributors
	//! license : MIT
	//! momentjs.com
	
	(function (global, factory) {
	    true ? module.exports = factory() :
	    typeof define === 'function' && define.amd ? define(factory) :
	    global.moment = factory()
	}(this, function () { 'use strict';
	
	    var hookCallback;
	
	    function utils_hooks__hooks () {
	        return hookCallback.apply(null, arguments);
	    }
	
	    // This is done to register the method called with moment()
	    // without creating circular dependencies.
	    function setHookCallback (callback) {
	        hookCallback = callback;
	    }
	
	    function defaultParsingFlags() {
	        // We need to deep clone this object.
	        return {
	            empty           : false,
	            unusedTokens    : [],
	            unusedInput     : [],
	            overflow        : -2,
	            charsLeftOver   : 0,
	            nullInput       : false,
	            invalidMonth    : null,
	            invalidFormat   : false,
	            userInvalidated : false,
	            iso             : false
	        };
	    }
	
	    function isArray(input) {
	        return Object.prototype.toString.call(input) === '[object Array]';
	    }
	
	    function isDate(input) {
	        return Object.prototype.toString.call(input) === '[object Date]' || input instanceof Date;
	    }
	
	    function map(arr, fn) {
	        var res = [], i;
	        for (i = 0; i < arr.length; ++i) {
	            res.push(fn(arr[i], i));
	        }
	        return res;
	    }
	
	    function hasOwnProp(a, b) {
	        return Object.prototype.hasOwnProperty.call(a, b);
	    }
	
	    function extend(a, b) {
	        for (var i in b) {
	            if (hasOwnProp(b, i)) {
	                a[i] = b[i];
	            }
	        }
	
	        if (hasOwnProp(b, 'toString')) {
	            a.toString = b.toString;
	        }
	
	        if (hasOwnProp(b, 'valueOf')) {
	            a.valueOf = b.valueOf;
	        }
	
	        return a;
	    }
	
	    function create_utc__createUTC (input, format, locale, strict) {
	        return createLocalOrUTC(input, format, locale, strict, true).utc();
	    }
	
	    function valid__isValid(m) {
	        if (m._isValid == null) {
	            m._isValid = !isNaN(m._d.getTime()) &&
	                m._pf.overflow < 0 &&
	                !m._pf.empty &&
	                !m._pf.invalidMonth &&
	                !m._pf.nullInput &&
	                !m._pf.invalidFormat &&
	                !m._pf.userInvalidated;
	
	            if (m._strict) {
	                m._isValid = m._isValid &&
	                    m._pf.charsLeftOver === 0 &&
	                    m._pf.unusedTokens.length === 0 &&
	                    m._pf.bigHour === undefined;
	            }
	        }
	        return m._isValid;
	    }
	
	    function valid__createInvalid (flags) {
	        var m = create_utc__createUTC(NaN);
	        if (flags != null) {
	            extend(m._pf, flags);
	        }
	        else {
	            m._pf.userInvalidated = true;
	        }
	
	        return m;
	    }
	
	    var momentProperties = utils_hooks__hooks.momentProperties = [];
	
	    function copyConfig(to, from) {
	        var i, prop, val;
	
	        if (typeof from._isAMomentObject !== 'undefined') {
	            to._isAMomentObject = from._isAMomentObject;
	        }
	        if (typeof from._i !== 'undefined') {
	            to._i = from._i;
	        }
	        if (typeof from._f !== 'undefined') {
	            to._f = from._f;
	        }
	        if (typeof from._l !== 'undefined') {
	            to._l = from._l;
	        }
	        if (typeof from._strict !== 'undefined') {
	            to._strict = from._strict;
	        }
	        if (typeof from._tzm !== 'undefined') {
	            to._tzm = from._tzm;
	        }
	        if (typeof from._isUTC !== 'undefined') {
	            to._isUTC = from._isUTC;
	        }
	        if (typeof from._offset !== 'undefined') {
	            to._offset = from._offset;
	        }
	        if (typeof from._pf !== 'undefined') {
	            to._pf = from._pf;
	        }
	        if (typeof from._locale !== 'undefined') {
	            to._locale = from._locale;
	        }
	
	        if (momentProperties.length > 0) {
	            for (i in momentProperties) {
	                prop = momentProperties[i];
	                val = from[prop];
	                if (typeof val !== 'undefined') {
	                    to[prop] = val;
	                }
	            }
	        }
	
	        return to;
	    }
	
	    var updateInProgress = false;
	
	    // Moment prototype object
	    function Moment(config) {
	        copyConfig(this, config);
	        this._d = new Date(+config._d);
	        // Prevent infinite loop in case updateOffset creates new moment
	        // objects.
	        if (updateInProgress === false) {
	            updateInProgress = true;
	            utils_hooks__hooks.updateOffset(this);
	            updateInProgress = false;
	        }
	    }
	
	    function isMoment (obj) {
	        return obj instanceof Moment || (obj != null && hasOwnProp(obj, '_isAMomentObject'));
	    }
	
	    function toInt(argumentForCoercion) {
	        var coercedNumber = +argumentForCoercion,
	            value = 0;
	
	        if (coercedNumber !== 0 && isFinite(coercedNumber)) {
	            if (coercedNumber >= 0) {
	                value = Math.floor(coercedNumber);
	            } else {
	                value = Math.ceil(coercedNumber);
	            }
	        }
	
	        return value;
	    }
	
	    function compareArrays(array1, array2, dontConvert) {
	        var len = Math.min(array1.length, array2.length),
	            lengthDiff = Math.abs(array1.length - array2.length),
	            diffs = 0,
	            i;
	        for (i = 0; i < len; i++) {
	            if ((dontConvert && array1[i] !== array2[i]) ||
	                (!dontConvert && toInt(array1[i]) !== toInt(array2[i]))) {
	                diffs++;
	            }
	        }
	        return diffs + lengthDiff;
	    }
	
	    function Locale() {
	    }
	
	    var locales = {};
	    var globalLocale;
	
	    function normalizeLocale(key) {
	        return key ? key.toLowerCase().replace('_', '-') : key;
	    }
	
	    // pick the locale from the array
	    // try ['en-au', 'en-gb'] as 'en-au', 'en-gb', 'en', as in move through the list trying each
	    // substring from most specific to least, but move to the next array item if it's a more specific variant than the current root
	    function chooseLocale(names) {
	        var i = 0, j, next, locale, split;
	
	        while (i < names.length) {
	            split = normalizeLocale(names[i]).split('-');
	            j = split.length;
	            next = normalizeLocale(names[i + 1]);
	            next = next ? next.split('-') : null;
	            while (j > 0) {
	                locale = loadLocale(split.slice(0, j).join('-'));
	                if (locale) {
	                    return locale;
	                }
	                if (next && next.length >= j && compareArrays(split, next, true) >= j - 1) {
	                    //the next array item is better than a shallower substring of this one
	                    break;
	                }
	                j--;
	            }
	            i++;
	        }
	        return null;
	    }
	
	    function loadLocale(name) {
	        var oldLocale = null;
	        // TODO: Find a better way to register and load all the locales in Node
	        if (!locales[name] && typeof module !== 'undefined' &&
	                module && module.exports) {
	            try {
	                oldLocale = globalLocale._abbr;
	                __webpack_require__(17)("./" + name);
	                // because defineLocale currently also sets the global locale, we
	                // want to undo that for lazy loaded locales
	                locale_locales__getSetGlobalLocale(oldLocale);
	            } catch (e) { }
	        }
	        return locales[name];
	    }
	
	    // This function will load locale and then set the global locale.  If
	    // no arguments are passed in, it will simply return the current global
	    // locale key.
	    function locale_locales__getSetGlobalLocale (key, values) {
	        var data;
	        if (key) {
	            if (typeof values === 'undefined') {
	                data = locale_locales__getLocale(key);
	            }
	            else {
	                data = defineLocale(key, values);
	            }
	
	            if (data) {
	                // moment.duration._locale = moment._locale = data;
	                globalLocale = data;
	            }
	        }
	
	        return globalLocale._abbr;
	    }
	
	    function defineLocale (name, values) {
	        if (values !== null) {
	            values.abbr = name;
	            if (!locales[name]) {
	                locales[name] = new Locale();
	            }
	            locales[name].set(values);
	
	            // backwards compat for now: also set the locale
	            locale_locales__getSetGlobalLocale(name);
	
	            return locales[name];
	        } else {
	            // useful for testing
	            delete locales[name];
	            return null;
	        }
	    }
	
	    // returns locale data
	    function locale_locales__getLocale (key) {
	        var locale;
	
	        if (key && key._locale && key._locale._abbr) {
	            key = key._locale._abbr;
	        }
	
	        if (!key) {
	            return globalLocale;
	        }
	
	        if (!isArray(key)) {
	            //short-circuit everything else
	            locale = loadLocale(key);
	            if (locale) {
	                return locale;
	            }
	            key = [key];
	        }
	
	        return chooseLocale(key);
	    }
	
	    var aliases = {};
	
	    function addUnitAlias (unit, shorthand) {
	        var lowerCase = unit.toLowerCase();
	        aliases[lowerCase] = aliases[lowerCase + 's'] = aliases[shorthand] = unit;
	    }
	
	    function normalizeUnits(units) {
	        return typeof units === 'string' ? aliases[units] || aliases[units.toLowerCase()] : undefined;
	    }
	
	    function normalizeObjectUnits(inputObject) {
	        var normalizedInput = {},
	            normalizedProp,
	            prop;
	
	        for (prop in inputObject) {
	            if (hasOwnProp(inputObject, prop)) {
	                normalizedProp = normalizeUnits(prop);
	                if (normalizedProp) {
	                    normalizedInput[normalizedProp] = inputObject[prop];
	                }
	            }
	        }
	
	        return normalizedInput;
	    }
	
	    function makeGetSet (unit, keepTime) {
	        return function (value) {
	            if (value != null) {
	                get_set__set(this, unit, value);
	                utils_hooks__hooks.updateOffset(this, keepTime);
	                return this;
	            } else {
	                return get_set__get(this, unit);
	            }
	        };
	    }
	
	    function get_set__get (mom, unit) {
	        return mom._d['get' + (mom._isUTC ? 'UTC' : '') + unit]();
	    }
	
	    function get_set__set (mom, unit, value) {
	        return mom._d['set' + (mom._isUTC ? 'UTC' : '') + unit](value);
	    }
	
	    // MOMENTS
	
	    function getSet (units, value) {
	        var unit;
	        if (typeof units === 'object') {
	            for (unit in units) {
	                this.set(unit, units[unit]);
	            }
	        } else {
	            units = normalizeUnits(units);
	            if (typeof this[units] === 'function') {
	                return this[units](value);
	            }
	        }
	        return this;
	    }
	
	    function zeroFill(number, targetLength, forceSign) {
	        var output = '' + Math.abs(number),
	            sign = number >= 0;
	
	        while (output.length < targetLength) {
	            output = '0' + output;
	        }
	        return (sign ? (forceSign ? '+' : '') : '-') + output;
	    }
	
	    var formattingTokens = /(\[[^\[]*\])|(\\)?(Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Q|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|mm?|ss?|S{1,4}|x|X|zz?|ZZ?|.)/g;
	
	    var localFormattingTokens = /(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g;
	
	    var formatFunctions = {};
	
	    var formatTokenFunctions = {};
	
	    // token:    'M'
	    // padded:   ['MM', 2]
	    // ordinal:  'Mo'
	    // callback: function () { this.month() + 1 }
	    function addFormatToken (token, padded, ordinal, callback) {
	        var func = callback;
	        if (typeof callback === 'string') {
	            func = function () {
	                return this[callback]();
	            };
	        }
	        if (token) {
	            formatTokenFunctions[token] = func;
	        }
	        if (padded) {
	            formatTokenFunctions[padded[0]] = function () {
	                return zeroFill(func.apply(this, arguments), padded[1], padded[2]);
	            };
	        }
	        if (ordinal) {
	            formatTokenFunctions[ordinal] = function () {
	                return this.localeData().ordinal(func.apply(this, arguments), token);
	            };
	        }
	    }
	
	    function removeFormattingTokens(input) {
	        if (input.match(/\[[\s\S]/)) {
	            return input.replace(/^\[|\]$/g, '');
	        }
	        return input.replace(/\\/g, '');
	    }
	
	    function makeFormatFunction(format) {
	        var array = format.match(formattingTokens), i, length;
	
	        for (i = 0, length = array.length; i < length; i++) {
	            if (formatTokenFunctions[array[i]]) {
	                array[i] = formatTokenFunctions[array[i]];
	            } else {
	                array[i] = removeFormattingTokens(array[i]);
	            }
	        }
	
	        return function (mom) {
	            var output = '';
	            for (i = 0; i < length; i++) {
	                output += array[i] instanceof Function ? array[i].call(mom, format) : array[i];
	            }
	            return output;
	        };
	    }
	
	    // format date using native date object
	    function formatMoment(m, format) {
	        if (!m.isValid()) {
	            return m.localeData().invalidDate();
	        }
	
	        format = expandFormat(format, m.localeData());
	
	        if (!formatFunctions[format]) {
	            formatFunctions[format] = makeFormatFunction(format);
	        }
	
	        return formatFunctions[format](m);
	    }
	
	    function expandFormat(format, locale) {
	        var i = 5;
	
	        function replaceLongDateFormatTokens(input) {
	            return locale.longDateFormat(input) || input;
	        }
	
	        localFormattingTokens.lastIndex = 0;
	        while (i >= 0 && localFormattingTokens.test(format)) {
	            format = format.replace(localFormattingTokens, replaceLongDateFormatTokens);
	            localFormattingTokens.lastIndex = 0;
	            i -= 1;
	        }
	
	        return format;
	    }
	
	    var match1         = /\d/;            //       0 - 9
	    var match2         = /\d\d/;          //      00 - 99
	    var match3         = /\d{3}/;         //     000 - 999
	    var match4         = /\d{4}/;         //    0000 - 9999
	    var match6         = /[+-]?\d{6}/;    // -999999 - 999999
	    var match1to2      = /\d\d?/;         //       0 - 99
	    var match1to3      = /\d{1,3}/;       //       0 - 999
	    var match1to4      = /\d{1,4}/;       //       0 - 9999
	    var match1to6      = /[+-]?\d{1,6}/;  // -999999 - 999999
	
	    var matchUnsigned  = /\d+/;           //       0 - inf
	    var matchSigned    = /[+-]?\d+/;      //    -inf - inf
	
	    var matchOffset    = /Z|[+-]\d\d:?\d\d/gi; // +00:00 -00:00 +0000 -0000 or Z
	
	    var matchTimestamp = /[+-]?\d+(\.\d{1,3})?/; // 123456789 123456789.123
	
	    // any word (or two) characters or numbers including two/three word month in arabic.
	    var matchWord = /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i;
	
	    var regexes = {};
	
	    function addRegexToken (token, regex, strictRegex) {
	        regexes[token] = typeof regex === 'function' ? regex : function (isStrict) {
	            return (isStrict && strictRegex) ? strictRegex : regex;
	        };
	    }
	
	    function getParseRegexForToken (token, config) {
	        if (!hasOwnProp(regexes, token)) {
	            return new RegExp(unescapeFormat(token));
	        }
	
	        return regexes[token](config._strict, config._locale);
	    }
	
	    // Code from http://stackoverflow.com/questions/3561493/is-there-a-regexp-escape-function-in-javascript
	    function unescapeFormat(s) {
	        return s.replace('\\', '').replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g, function (matched, p1, p2, p3, p4) {
	            return p1 || p2 || p3 || p4;
	        }).replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
	    }
	
	    var tokens = {};
	
	    function addParseToken (token, callback) {
	        var i, func = callback;
	        if (typeof token === 'string') {
	            token = [token];
	        }
	        if (typeof callback === 'number') {
	            func = function (input, array) {
	                array[callback] = toInt(input);
	            };
	        }
	        for (i = 0; i < token.length; i++) {
	            tokens[token[i]] = func;
	        }
	    }
	
	    function addWeekParseToken (token, callback) {
	        addParseToken(token, function (input, array, config, token) {
	            config._w = config._w || {};
	            callback(input, config._w, config, token);
	        });
	    }
	
	    function addTimeToArrayFromToken(token, input, config) {
	        if (input != null && hasOwnProp(tokens, token)) {
	            tokens[token](input, config._a, config, token);
	        }
	    }
	
	    var YEAR = 0;
	    var MONTH = 1;
	    var DATE = 2;
	    var HOUR = 3;
	    var MINUTE = 4;
	    var SECOND = 5;
	    var MILLISECOND = 6;
	
	    function daysInMonth(year, month) {
	        return new Date(Date.UTC(year, month + 1, 0)).getUTCDate();
	    }
	
	    // FORMATTING
	
	    addFormatToken('M', ['MM', 2], 'Mo', function () {
	        return this.month() + 1;
	    });
	
	    addFormatToken('MMM', 0, 0, function (format) {
	        return this.localeData().monthsShort(this, format);
	    });
	
	    addFormatToken('MMMM', 0, 0, function (format) {
	        return this.localeData().months(this, format);
	    });
	
	    // ALIASES
	
	    addUnitAlias('month', 'M');
	
	    // PARSING
	
	    addRegexToken('M',    match1to2);
	    addRegexToken('MM',   match1to2, match2);
	    addRegexToken('MMM',  matchWord);
	    addRegexToken('MMMM', matchWord);
	
	    addParseToken(['M', 'MM'], function (input, array) {
	        array[MONTH] = toInt(input) - 1;
	    });
	
	    addParseToken(['MMM', 'MMMM'], function (input, array, config, token) {
	        var month = config._locale.monthsParse(input, token, config._strict);
	        // if we didn't find a month name, mark the date as invalid.
	        if (month != null) {
	            array[MONTH] = month;
	        } else {
	            config._pf.invalidMonth = input;
	        }
	    });
	
	    // LOCALES
	
	    var defaultLocaleMonths = 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_');
	    function localeMonths (m) {
	        return this._months[m.month()];
	    }
	
	    var defaultLocaleMonthsShort = 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_');
	    function localeMonthsShort (m) {
	        return this._monthsShort[m.month()];
	    }
	
	    function localeMonthsParse (monthName, format, strict) {
	        var i, mom, regex;
	
	        if (!this._monthsParse) {
	            this._monthsParse = [];
	            this._longMonthsParse = [];
	            this._shortMonthsParse = [];
	        }
	
	        for (i = 0; i < 12; i++) {
	            // make the regex if we don't have it already
	            mom = create_utc__createUTC([2000, i]);
	            if (strict && !this._longMonthsParse[i]) {
	                this._longMonthsParse[i] = new RegExp('^' + this.months(mom, '').replace('.', '') + '$', 'i');
	                this._shortMonthsParse[i] = new RegExp('^' + this.monthsShort(mom, '').replace('.', '') + '$', 'i');
	            }
	            if (!strict && !this._monthsParse[i]) {
	                regex = '^' + this.months(mom, '') + '|^' + this.monthsShort(mom, '');
	                this._monthsParse[i] = new RegExp(regex.replace('.', ''), 'i');
	            }
	            // test the regex
	            if (strict && format === 'MMMM' && this._longMonthsParse[i].test(monthName)) {
	                return i;
	            } else if (strict && format === 'MMM' && this._shortMonthsParse[i].test(monthName)) {
	                return i;
	            } else if (!strict && this._monthsParse[i].test(monthName)) {
	                return i;
	            }
	        }
	    }
	
	    // MOMENTS
	
	    function setMonth (mom, value) {
	        var dayOfMonth;
	
	        // TODO: Move this out of here!
	        if (typeof value === 'string') {
	            value = mom.localeData().monthsParse(value);
	            // TODO: Another silent failure?
	            if (typeof value !== 'number') {
	                return mom;
	            }
	        }
	
	        dayOfMonth = Math.min(mom.date(), daysInMonth(mom.year(), value));
	        mom._d['set' + (mom._isUTC ? 'UTC' : '') + 'Month'](value, dayOfMonth);
	        return mom;
	    }
	
	    function getSetMonth (value) {
	        if (value != null) {
	            setMonth(this, value);
	            utils_hooks__hooks.updateOffset(this, true);
	            return this;
	        } else {
	            return get_set__get(this, 'Month');
	        }
	    }
	
	    function getDaysInMonth () {
	        return daysInMonth(this.year(), this.month());
	    }
	
	    function checkOverflow (m) {
	        var overflow;
	        var a = m._a;
	
	        if (a && m._pf.overflow === -2) {
	            overflow =
	                a[MONTH]       < 0 || a[MONTH]       > 11  ? MONTH :
	                a[DATE]        < 1 || a[DATE]        > daysInMonth(a[YEAR], a[MONTH]) ? DATE :
	                a[HOUR]        < 0 || a[HOUR]        > 24 || (a[HOUR] === 24 && (a[MINUTE] !== 0 || a[SECOND] !== 0 || a[MILLISECOND] !== 0)) ? HOUR :
	                a[MINUTE]      < 0 || a[MINUTE]      > 59  ? MINUTE :
	                a[SECOND]      < 0 || a[SECOND]      > 59  ? SECOND :
	                a[MILLISECOND] < 0 || a[MILLISECOND] > 999 ? MILLISECOND :
	                -1;
	
	            if (m._pf._overflowDayOfYear && (overflow < YEAR || overflow > DATE)) {
	                overflow = DATE;
	            }
	
	            m._pf.overflow = overflow;
	        }
	
	        return m;
	    }
	
	    function warn(msg) {
	        if (utils_hooks__hooks.suppressDeprecationWarnings === false && typeof console !== 'undefined' && console.warn) {
	            console.warn('Deprecation warning: ' + msg);
	        }
	    }
	
	    function deprecate(msg, fn) {
	        var firstTime = true;
	        return extend(function () {
	            if (firstTime) {
	                warn(msg);
	                firstTime = false;
	            }
	            return fn.apply(this, arguments);
	        }, fn);
	    }
	
	    var deprecations = {};
	
	    function deprecateSimple(name, msg) {
	        if (!deprecations[name]) {
	            warn(msg);
	            deprecations[name] = true;
	        }
	    }
	
	    utils_hooks__hooks.suppressDeprecationWarnings = false;
	
	    var from_string__isoRegex = /^\s*(?:[+-]\d{6}|\d{4})-(?:(\d\d-\d\d)|(W\d\d$)|(W\d\d-\d)|(\d\d\d))((T| )(\d\d(:\d\d(:\d\d(\.\d+)?)?)?)?([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/;
	
	    var isoDates = [
	        ['YYYYYY-MM-DD', /[+-]\d{6}-\d{2}-\d{2}/],
	        ['YYYY-MM-DD', /\d{4}-\d{2}-\d{2}/],
	        ['GGGG-[W]WW-E', /\d{4}-W\d{2}-\d/],
	        ['GGGG-[W]WW', /\d{4}-W\d{2}/],
	        ['YYYY-DDD', /\d{4}-\d{3}/]
	    ];
	
	    // iso time formats and regexes
	    var isoTimes = [
	        ['HH:mm:ss.SSSS', /(T| )\d\d:\d\d:\d\d\.\d+/],
	        ['HH:mm:ss', /(T| )\d\d:\d\d:\d\d/],
	        ['HH:mm', /(T| )\d\d:\d\d/],
	        ['HH', /(T| )\d\d/]
	    ];
	
	    var aspNetJsonRegex = /^\/?Date\((\-?\d+)/i;
	
	    // date from iso format
	    function configFromISO(config) {
	        var i, l,
	            string = config._i,
	            match = from_string__isoRegex.exec(string);
	
	        if (match) {
	            config._pf.iso = true;
	            for (i = 0, l = isoDates.length; i < l; i++) {
	                if (isoDates[i][1].exec(string)) {
	                    // match[5] should be 'T' or undefined
	                    config._f = isoDates[i][0] + (match[6] || ' ');
	                    break;
	                }
	            }
	            for (i = 0, l = isoTimes.length; i < l; i++) {
	                if (isoTimes[i][1].exec(string)) {
	                    config._f += isoTimes[i][0];
	                    break;
	                }
	            }
	            if (string.match(matchOffset)) {
	                config._f += 'Z';
	            }
	            configFromStringAndFormat(config);
	        } else {
	            config._isValid = false;
	        }
	    }
	
	    // date from iso format or fallback
	    function configFromString(config) {
	        var matched = aspNetJsonRegex.exec(config._i);
	
	        if (matched !== null) {
	            config._d = new Date(+matched[1]);
	            return;
	        }
	
	        configFromISO(config);
	        if (config._isValid === false) {
	            delete config._isValid;
	            utils_hooks__hooks.createFromInputFallback(config);
	        }
	    }
	
	    utils_hooks__hooks.createFromInputFallback = deprecate(
	        'moment construction falls back to js Date. This is ' +
	        'discouraged and will be removed in upcoming major ' +
	        'release. Please refer to ' +
	        'https://github.com/moment/moment/issues/1407 for more info.',
	        function (config) {
	            config._d = new Date(config._i + (config._useUTC ? ' UTC' : ''));
	        }
	    );
	
	    function createDate (y, m, d, h, M, s, ms) {
	        //can't just apply() to create a date:
	        //http://stackoverflow.com/questions/181348/instantiating-a-javascript-object-by-calling-prototype-constructor-apply
	        var date = new Date(y, m, d, h, M, s, ms);
	
	        //the date constructor doesn't accept years < 1970
	        if (y < 1970) {
	            date.setFullYear(y);
	        }
	        return date;
	    }
	
	    function createUTCDate (y) {
	        var date = new Date(Date.UTC.apply(null, arguments));
	        if (y < 1970) {
	            date.setUTCFullYear(y);
	        }
	        return date;
	    }
	
	    addFormatToken(0, ['YY', 2], 0, function () {
	        return this.year() % 100;
	    });
	
	    addFormatToken(0, ['YYYY',   4],       0, 'year');
	    addFormatToken(0, ['YYYYY',  5],       0, 'year');
	    addFormatToken(0, ['YYYYYY', 6, true], 0, 'year');
	
	    // ALIASES
	
	    addUnitAlias('year', 'y');
	
	    // PARSING
	
	    addRegexToken('Y',      matchSigned);
	    addRegexToken('YY',     match1to2, match2);
	    addRegexToken('YYYY',   match1to4, match4);
	    addRegexToken('YYYYY',  match1to6, match6);
	    addRegexToken('YYYYYY', match1to6, match6);
	
	    addParseToken(['YYYY', 'YYYYY', 'YYYYYY'], YEAR);
	    addParseToken('YY', function (input, array) {
	        array[YEAR] = utils_hooks__hooks.parseTwoDigitYear(input);
	    });
	
	    // HELPERS
	
	    function daysInYear(year) {
	        return isLeapYear(year) ? 366 : 365;
	    }
	
	    function isLeapYear(year) {
	        return (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0;
	    }
	
	    // HOOKS
	
	    utils_hooks__hooks.parseTwoDigitYear = function (input) {
	        return toInt(input) + (toInt(input) > 68 ? 1900 : 2000);
	    };
	
	    // MOMENTS
	
	    var getSetYear = makeGetSet('FullYear', false);
	
	    function getIsLeapYear () {
	        return isLeapYear(this.year());
	    }
	
	    addFormatToken('w', ['ww', 2], 'wo', 'week');
	    addFormatToken('W', ['WW', 2], 'Wo', 'isoWeek');
	
	    // ALIASES
	
	    addUnitAlias('week', 'w');
	    addUnitAlias('isoWeek', 'W');
	
	    // PARSING
	
	    addRegexToken('w',  match1to2);
	    addRegexToken('ww', match1to2, match2);
	    addRegexToken('W',  match1to2);
	    addRegexToken('WW', match1to2, match2);
	
	    addWeekParseToken(['w', 'ww', 'W', 'WW'], function (input, week, config, token) {
	        week[token.substr(0, 1)] = toInt(input);
	    });
	
	    // HELPERS
	
	    // firstDayOfWeek       0 = sun, 6 = sat
	    //                      the day of the week that starts the week
	    //                      (usually sunday or monday)
	    // firstDayOfWeekOfYear 0 = sun, 6 = sat
	    //                      the first week is the week that contains the first
	    //                      of this day of the week
	    //                      (eg. ISO weeks use thursday (4))
	    function weekOfYear(mom, firstDayOfWeek, firstDayOfWeekOfYear) {
	        var end = firstDayOfWeekOfYear - firstDayOfWeek,
	            daysToDayOfWeek = firstDayOfWeekOfYear - mom.day(),
	            adjustedMoment;
	
	
	        if (daysToDayOfWeek > end) {
	            daysToDayOfWeek -= 7;
	        }
	
	        if (daysToDayOfWeek < end - 7) {
	            daysToDayOfWeek += 7;
	        }
	
	        adjustedMoment = local__createLocal(mom).add(daysToDayOfWeek, 'd');
	        return {
	            week: Math.ceil(adjustedMoment.dayOfYear() / 7),
	            year: adjustedMoment.year()
	        };
	    }
	
	    // LOCALES
	
	    function localeWeek (mom) {
	        return weekOfYear(mom, this._week.dow, this._week.doy).week;
	    }
	
	    var defaultLocaleWeek = {
	        dow : 0, // Sunday is the first day of the week.
	        doy : 6  // The week that contains Jan 1st is the first week of the year.
	    };
	
	    function localeFirstDayOfWeek () {
	        return this._week.dow;
	    }
	
	    function localeFirstDayOfYear () {
	        return this._week.doy;
	    }
	
	    // MOMENTS
	
	    function getSetWeek (input) {
	        var week = this.localeData().week(this);
	        return input == null ? week : this.add((input - week) * 7, 'd');
	    }
	
	    function getSetISOWeek (input) {
	        var week = weekOfYear(this, 1, 4).week;
	        return input == null ? week : this.add((input - week) * 7, 'd');
	    }
	
	    addFormatToken('DDD', ['DDDD', 3], 'DDDo', 'dayOfYear');
	
	    // ALIASES
	
	    addUnitAlias('dayOfYear', 'DDD');
	
	    // PARSING
	
	    addRegexToken('DDD',  match1to3);
	    addRegexToken('DDDD', match3);
	    addParseToken(['DDD', 'DDDD'], function (input, array, config) {
	        config._dayOfYear = toInt(input);
	    });
	
	    // HELPERS
	
	    //http://en.wikipedia.org/wiki/ISO_week_date#Calculating_a_date_given_the_year.2C_week_number_and_weekday
	    function dayOfYearFromWeeks(year, week, weekday, firstDayOfWeekOfYear, firstDayOfWeek) {
	        var d = createUTCDate(year, 0, 1).getUTCDay();
	        var daysToAdd;
	        var dayOfYear;
	
	        d = d === 0 ? 7 : d;
	        weekday = weekday != null ? weekday : firstDayOfWeek;
	        daysToAdd = firstDayOfWeek - d + (d > firstDayOfWeekOfYear ? 7 : 0) - (d < firstDayOfWeek ? 7 : 0);
	        dayOfYear = 7 * (week - 1) + (weekday - firstDayOfWeek) + daysToAdd + 1;
	
	        return {
	            year      : dayOfYear > 0 ? year      : year - 1,
	            dayOfYear : dayOfYear > 0 ? dayOfYear : daysInYear(year - 1) + dayOfYear
	        };
	    }
	
	    // MOMENTS
	
	    function getSetDayOfYear (input) {
	        var dayOfYear = Math.round((this.clone().startOf('day') - this.clone().startOf('year')) / 864e5) + 1;
	        return input == null ? dayOfYear : this.add((input - dayOfYear), 'd');
	    }
	
	    // Pick the first defined of two or three arguments.
	    function defaults(a, b, c) {
	        if (a != null) {
	            return a;
	        }
	        if (b != null) {
	            return b;
	        }
	        return c;
	    }
	
	    function currentDateArray(config) {
	        var now = new Date();
	        if (config._useUTC) {
	            return [now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate()];
	        }
	        return [now.getFullYear(), now.getMonth(), now.getDate()];
	    }
	
	    // convert an array to a date.
	    // the array should mirror the parameters below
	    // note: all values past the year are optional and will default to the lowest possible value.
	    // [year, month, day , hour, minute, second, millisecond]
	    function configFromArray (config) {
	        var i, date, input = [], currentDate, yearToUse;
	
	        if (config._d) {
	            return;
	        }
	
	        currentDate = currentDateArray(config);
	
	        //compute day of the year from weeks and weekdays
	        if (config._w && config._a[DATE] == null && config._a[MONTH] == null) {
	            dayOfYearFromWeekInfo(config);
	        }
	
	        //if the day of the year is set, figure out what it is
	        if (config._dayOfYear) {
	            yearToUse = defaults(config._a[YEAR], currentDate[YEAR]);
	
	            if (config._dayOfYear > daysInYear(yearToUse)) {
	                config._pf._overflowDayOfYear = true;
	            }
	
	            date = createUTCDate(yearToUse, 0, config._dayOfYear);
	            config._a[MONTH] = date.getUTCMonth();
	            config._a[DATE] = date.getUTCDate();
	        }
	
	        // Default to current date.
	        // * if no year, month, day of month are given, default to today
	        // * if day of month is given, default month and year
	        // * if month is given, default only year
	        // * if year is given, don't default anything
	        for (i = 0; i < 3 && config._a[i] == null; ++i) {
	            config._a[i] = input[i] = currentDate[i];
	        }
	
	        // Zero out whatever was not defaulted, including time
	        for (; i < 7; i++) {
	            config._a[i] = input[i] = (config._a[i] == null) ? (i === 2 ? 1 : 0) : config._a[i];
	        }
	
	        // Check for 24:00:00.000
	        if (config._a[HOUR] === 24 &&
	                config._a[MINUTE] === 0 &&
	                config._a[SECOND] === 0 &&
	                config._a[MILLISECOND] === 0) {
	            config._nextDay = true;
	            config._a[HOUR] = 0;
	        }
	
	        config._d = (config._useUTC ? createUTCDate : createDate).apply(null, input);
	        // Apply timezone offset from input. The actual utcOffset can be changed
	        // with parseZone.
	        if (config._tzm != null) {
	            config._d.setUTCMinutes(config._d.getUTCMinutes() - config._tzm);
	        }
	
	        if (config._nextDay) {
	            config._a[HOUR] = 24;
	        }
	    }
	
	    function dayOfYearFromWeekInfo(config) {
	        var w, weekYear, week, weekday, dow, doy, temp;
	
	        w = config._w;
	        if (w.GG != null || w.W != null || w.E != null) {
	            dow = 1;
	            doy = 4;
	
	            // TODO: We need to take the current isoWeekYear, but that depends on
	            // how we interpret now (local, utc, fixed offset). So create
	            // a now version of current config (take local/utc/offset flags, and
	            // create now).
	            weekYear = defaults(w.GG, config._a[YEAR], weekOfYear(local__createLocal(), 1, 4).year);
	            week = defaults(w.W, 1);
	            weekday = defaults(w.E, 1);
	        } else {
	            dow = config._locale._week.dow;
	            doy = config._locale._week.doy;
	
	            weekYear = defaults(w.gg, config._a[YEAR], weekOfYear(local__createLocal(), dow, doy).year);
	            week = defaults(w.w, 1);
	
	            if (w.d != null) {
	                // weekday -- low day numbers are considered next week
	                weekday = w.d;
	                if (weekday < dow) {
	                    ++week;
	                }
	            } else if (w.e != null) {
	                // local weekday -- counting starts from begining of week
	                weekday = w.e + dow;
	            } else {
	                // default to begining of week
	                weekday = dow;
	            }
	        }
	        temp = dayOfYearFromWeeks(weekYear, week, weekday, doy, dow);
	
	        config._a[YEAR] = temp.year;
	        config._dayOfYear = temp.dayOfYear;
	    }
	
	    utils_hooks__hooks.ISO_8601 = function () {};
	
	    // date from string and format string
	    function configFromStringAndFormat(config) {
	        // TODO: Move this to another part of the creation flow to prevent circular deps
	        if (config._f === utils_hooks__hooks.ISO_8601) {
	            configFromISO(config);
	            return;
	        }
	
	        config._a = [];
	        config._pf.empty = true;
	
	        // This array is used to make a Date, either with `new Date` or `Date.UTC`
	        var string = '' + config._i,
	            i, parsedInput, tokens, token, skipped,
	            stringLength = string.length,
	            totalParsedInputLength = 0;
	
	        tokens = expandFormat(config._f, config._locale).match(formattingTokens) || [];
	
	        for (i = 0; i < tokens.length; i++) {
	            token = tokens[i];
	            parsedInput = (string.match(getParseRegexForToken(token, config)) || [])[0];
	            if (parsedInput) {
	                skipped = string.substr(0, string.indexOf(parsedInput));
	                if (skipped.length > 0) {
	                    config._pf.unusedInput.push(skipped);
	                }
	                string = string.slice(string.indexOf(parsedInput) + parsedInput.length);
	                totalParsedInputLength += parsedInput.length;
	            }
	            // don't parse if it's not a known token
	            if (formatTokenFunctions[token]) {
	                if (parsedInput) {
	                    config._pf.empty = false;
	                }
	                else {
	                    config._pf.unusedTokens.push(token);
	                }
	                addTimeToArrayFromToken(token, parsedInput, config);
	            }
	            else if (config._strict && !parsedInput) {
	                config._pf.unusedTokens.push(token);
	            }
	        }
	
	        // add remaining unparsed input length to the string
	        config._pf.charsLeftOver = stringLength - totalParsedInputLength;
	        if (string.length > 0) {
	            config._pf.unusedInput.push(string);
	        }
	
	        // clear _12h flag if hour is <= 12
	        if (config._pf.bigHour === true && config._a[HOUR] <= 12) {
	            config._pf.bigHour = undefined;
	        }
	        // handle meridiem
	        config._a[HOUR] = meridiemFixWrap(config._locale, config._a[HOUR], config._meridiem);
	
	        configFromArray(config);
	        checkOverflow(config);
	    }
	
	
	    function meridiemFixWrap (locale, hour, meridiem) {
	        var isPm;
	
	        if (meridiem == null) {
	            // nothing to do
	            return hour;
	        }
	        if (locale.meridiemHour != null) {
	            return locale.meridiemHour(hour, meridiem);
	        } else if (locale.isPM != null) {
	            // Fallback
	            isPm = locale.isPM(meridiem);
	            if (isPm && hour < 12) {
	                hour += 12;
	            }
	            if (!isPm && hour === 12) {
	                hour = 0;
	            }
	            return hour;
	        } else {
	            // this is not supposed to happen
	            return hour;
	        }
	    }
	
	    function configFromStringAndArray(config) {
	        var tempConfig,
	            bestMoment,
	
	            scoreToBeat,
	            i,
	            currentScore;
	
	        if (config._f.length === 0) {
	            config._pf.invalidFormat = true;
	            config._d = new Date(NaN);
	            return;
	        }
	
	        for (i = 0; i < config._f.length; i++) {
	            currentScore = 0;
	            tempConfig = copyConfig({}, config);
	            if (config._useUTC != null) {
	                tempConfig._useUTC = config._useUTC;
	            }
	            tempConfig._pf = defaultParsingFlags();
	            tempConfig._f = config._f[i];
	            configFromStringAndFormat(tempConfig);
	
	            if (!valid__isValid(tempConfig)) {
	                continue;
	            }
	
	            // if there is any input that was not parsed add a penalty for that format
	            currentScore += tempConfig._pf.charsLeftOver;
	
	            //or tokens
	            currentScore += tempConfig._pf.unusedTokens.length * 10;
	
	            tempConfig._pf.score = currentScore;
	
	            if (scoreToBeat == null || currentScore < scoreToBeat) {
	                scoreToBeat = currentScore;
	                bestMoment = tempConfig;
	            }
	        }
	
	        extend(config, bestMoment || tempConfig);
	    }
	
	    function configFromObject(config) {
	        if (config._d) {
	            return;
	        }
	
	        var i = normalizeObjectUnits(config._i);
	        config._a = [i.year, i.month, i.day || i.date, i.hour, i.minute, i.second, i.millisecond];
	
	        configFromArray(config);
	    }
	
	    function createFromConfig (config) {
	        var input = config._i,
	            format = config._f,
	            res;
	
	        config._locale = config._locale || locale_locales__getLocale(config._l);
	
	        if (input === null || (format === undefined && input === '')) {
	            return valid__createInvalid({nullInput: true});
	        }
	
	        if (typeof input === 'string') {
	            config._i = input = config._locale.preparse(input);
	        }
	
	        if (isMoment(input)) {
	            return new Moment(checkOverflow(input));
	        } else if (isArray(format)) {
	            configFromStringAndArray(config);
	        } else if (format) {
	            configFromStringAndFormat(config);
	        } else {
	            configFromInput(config);
	        }
	
	        res = new Moment(checkOverflow(config));
	        if (res._nextDay) {
	            // Adding is smart enough around DST
	            res.add(1, 'd');
	            res._nextDay = undefined;
	        }
	
	        return res;
	    }
	
	    function configFromInput(config) {
	        var input = config._i;
	        if (input === undefined) {
	            config._d = new Date();
	        } else if (isDate(input)) {
	            config._d = new Date(+input);
	        } else if (typeof input === 'string') {
	            configFromString(config);
	        } else if (isArray(input)) {
	            config._a = map(input.slice(0), function (obj) {
	                return parseInt(obj, 10);
	            });
	            configFromArray(config);
	        } else if (typeof(input) === 'object') {
	            configFromObject(config);
	        } else if (typeof(input) === 'number') {
	            // from milliseconds
	            config._d = new Date(input);
	        } else {
	            utils_hooks__hooks.createFromInputFallback(config);
	        }
	    }
	
	    function createLocalOrUTC (input, format, locale, strict, isUTC) {
	        var c = {};
	
	        if (typeof(locale) === 'boolean') {
	            strict = locale;
	            locale = undefined;
	        }
	        // object construction must be done this way.
	        // https://github.com/moment/moment/issues/1423
	        c._isAMomentObject = true;
	        c._useUTC = c._isUTC = isUTC;
	        c._l = locale;
	        c._i = input;
	        c._f = format;
	        c._strict = strict;
	        c._pf = defaultParsingFlags();
	
	        return createFromConfig(c);
	    }
	
	    function local__createLocal (input, format, locale, strict) {
	        return createLocalOrUTC(input, format, locale, strict, false);
	    }
	
	    var prototypeMin = deprecate(
	         'moment().min is deprecated, use moment.min instead. https://github.com/moment/moment/issues/1548',
	         function () {
	             var other = local__createLocal.apply(null, arguments);
	             return other < this ? this : other;
	         }
	     );
	
	    var prototypeMax = deprecate(
	        'moment().max is deprecated, use moment.max instead. https://github.com/moment/moment/issues/1548',
	        function () {
	            var other = local__createLocal.apply(null, arguments);
	            return other > this ? this : other;
	        }
	    );
	
	    // Pick a moment m from moments so that m[fn](other) is true for all
	    // other. This relies on the function fn to be transitive.
	    //
	    // moments should either be an array of moment objects or an array, whose
	    // first element is an array of moment objects.
	    function pickBy(fn, moments) {
	        var res, i;
	        if (moments.length === 1 && isArray(moments[0])) {
	            moments = moments[0];
	        }
	        if (!moments.length) {
	            return local__createLocal();
	        }
	        res = moments[0];
	        for (i = 1; i < moments.length; ++i) {
	            if (moments[i][fn](res)) {
	                res = moments[i];
	            }
	        }
	        return res;
	    }
	
	    // TODO: Use [].sort instead?
	    function min () {
	        var args = [].slice.call(arguments, 0);
	
	        return pickBy('isBefore', args);
	    }
	
	    function max () {
	        var args = [].slice.call(arguments, 0);
	
	        return pickBy('isAfter', args);
	    }
	
	    function Duration (duration) {
	        var normalizedInput = normalizeObjectUnits(duration),
	            years = normalizedInput.year || 0,
	            quarters = normalizedInput.quarter || 0,
	            months = normalizedInput.month || 0,
	            weeks = normalizedInput.week || 0,
	            days = normalizedInput.day || 0,
	            hours = normalizedInput.hour || 0,
	            minutes = normalizedInput.minute || 0,
	            seconds = normalizedInput.second || 0,
	            milliseconds = normalizedInput.millisecond || 0;
	
	        // representation for dateAddRemove
	        this._milliseconds = +milliseconds +
	            seconds * 1e3 + // 1000
	            minutes * 6e4 + // 1000 * 60
	            hours * 36e5; // 1000 * 60 * 60
	        // Because of dateAddRemove treats 24 hours as different from a
	        // day when working around DST, we need to store them separately
	        this._days = +days +
	            weeks * 7;
	        // It is impossible translate months into days without knowing
	        // which months you are are talking about, so we have to store
	        // it separately.
	        this._months = +months +
	            quarters * 3 +
	            years * 12;
	
	        this._data = {};
	
	        this._locale = locale_locales__getLocale();
	
	        this._bubble();
	    }
	
	    function isDuration (obj) {
	        return obj instanceof Duration;
	    }
	
	    function offset (token, separator) {
	        addFormatToken(token, 0, 0, function () {
	            var offset = this.utcOffset();
	            var sign = '+';
	            if (offset < 0) {
	                offset = -offset;
	                sign = '-';
	            }
	            return sign + zeroFill(~~(offset / 60), 2) + separator + zeroFill(~~(offset) % 60, 2);
	        });
	    }
	
	    offset('Z', ':');
	    offset('ZZ', '');
	
	    // PARSING
	
	    addRegexToken('Z',  matchOffset);
	    addRegexToken('ZZ', matchOffset);
	    addParseToken(['Z', 'ZZ'], function (input, array, config) {
	        config._useUTC = true;
	        config._tzm = offsetFromString(input);
	    });
	
	    // HELPERS
	
	    // timezone chunker
	    // '+10:00' > ['10',  '00']
	    // '-1530'  > ['-15', '30']
	    var chunkOffset = /([\+\-]|\d\d)/gi;
	
	    function offsetFromString(string) {
	        var matches = ((string || '').match(matchOffset) || []);
	        var chunk   = matches[matches.length - 1] || [];
	        var parts   = (chunk + '').match(chunkOffset) || ['-', 0, 0];
	        var minutes = +(parts[1] * 60) + toInt(parts[2]);
	
	        return parts[0] === '+' ? minutes : -minutes;
	    }
	
	    // Return a moment from input, that is local/utc/zone equivalent to model.
	    function cloneWithOffset(input, model) {
	        var res, diff;
	        if (model._isUTC) {
	            res = model.clone();
	            diff = (isMoment(input) || isDate(input) ? +input : +local__createLocal(input)) - (+res);
	            // Use low-level api, because this fn is low-level api.
	            res._d.setTime(+res._d + diff);
	            utils_hooks__hooks.updateOffset(res, false);
	            return res;
	        } else {
	            return local__createLocal(input).local();
	        }
	        return model._isUTC ? local__createLocal(input).zone(model._offset || 0) : local__createLocal(input).local();
	    }
	
	    function getDateOffset (m) {
	        // On Firefox.24 Date#getTimezoneOffset returns a floating point.
	        // https://github.com/moment/moment/pull/1871
	        return -Math.round(m._d.getTimezoneOffset() / 15) * 15;
	    }
	
	    // HOOKS
	
	    // This function will be called whenever a moment is mutated.
	    // It is intended to keep the offset in sync with the timezone.
	    utils_hooks__hooks.updateOffset = function () {};
	
	    // MOMENTS
	
	    // keepLocalTime = true means only change the timezone, without
	    // affecting the local hour. So 5:31:26 +0300 --[utcOffset(2, true)]-->
	    // 5:31:26 +0200 It is possible that 5:31:26 doesn't exist with offset
	    // +0200, so we adjust the time as needed, to be valid.
	    //
	    // Keeping the time actually adds/subtracts (one hour)
	    // from the actual represented time. That is why we call updateOffset
	    // a second time. In case it wants us to change the offset again
	    // _changeInProgress == true case, then we have to adjust, because
	    // there is no such time in the given timezone.
	    function getSetOffset (input, keepLocalTime) {
	        var offset = this._offset || 0,
	            localAdjust;
	        if (input != null) {
	            if (typeof input === 'string') {
	                input = offsetFromString(input);
	            }
	            if (Math.abs(input) < 16) {
	                input = input * 60;
	            }
	            if (!this._isUTC && keepLocalTime) {
	                localAdjust = getDateOffset(this);
	            }
	            this._offset = input;
	            this._isUTC = true;
	            if (localAdjust != null) {
	                this.add(localAdjust, 'm');
	            }
	            if (offset !== input) {
	                if (!keepLocalTime || this._changeInProgress) {
	                    add_subtract__addSubtract(this, create__createDuration(input - offset, 'm'), 1, false);
	                } else if (!this._changeInProgress) {
	                    this._changeInProgress = true;
	                    utils_hooks__hooks.updateOffset(this, true);
	                    this._changeInProgress = null;
	                }
	            }
	            return this;
	        } else {
	            return this._isUTC ? offset : getDateOffset(this);
	        }
	    }
	
	    function getSetZone (input, keepLocalTime) {
	        if (input != null) {
	            if (typeof input !== 'string') {
	                input = -input;
	            }
	
	            this.utcOffset(input, keepLocalTime);
	
	            return this;
	        } else {
	            return -this.utcOffset();
	        }
	    }
	
	    function setOffsetToUTC (keepLocalTime) {
	        return this.utcOffset(0, keepLocalTime);
	    }
	
	    function setOffsetToLocal (keepLocalTime) {
	        if (this._isUTC) {
	            this.utcOffset(0, keepLocalTime);
	            this._isUTC = false;
	
	            if (keepLocalTime) {
	                this.subtract(getDateOffset(this), 'm');
	            }
	        }
	        return this;
	    }
	
	    function setOffsetToParsedOffset () {
	        if (this._tzm) {
	            this.utcOffset(this._tzm);
	        } else if (typeof this._i === 'string') {
	            this.utcOffset(offsetFromString(this._i));
	        }
	        return this;
	    }
	
	    function hasAlignedHourOffset (input) {
	        if (!input) {
	            input = 0;
	        }
	        else {
	            input = local__createLocal(input).utcOffset();
	        }
	
	        return (this.utcOffset() - input) % 60 === 0;
	    }
	
	    function isDaylightSavingTime () {
	        return (
	            this.utcOffset() > this.clone().month(0).utcOffset() ||
	            this.utcOffset() > this.clone().month(5).utcOffset()
	        );
	    }
	
	    function isDaylightSavingTimeShifted () {
	        if (this._a) {
	            var other = this._isUTC ? create_utc__createUTC(this._a) : local__createLocal(this._a);
	            return this.isValid() && compareArrays(this._a, other.toArray()) > 0;
	        }
	
	        return false;
	    }
	
	    function isLocal () {
	        return !this._isUTC;
	    }
	
	    function isUtcOffset () {
	        return this._isUTC;
	    }
	
	    function isUtc () {
	        return this._isUTC && this._offset === 0;
	    }
	
	    var aspNetRegex = /(\-)?(?:(\d*)\.)?(\d+)\:(\d+)(?:\:(\d+)\.?(\d{3})?)?/;
	
	    // from http://docs.closure-library.googlecode.com/git/closure_goog_date_date.js.source.html
	    // somewhat more in line with 4.4.3.2 2004 spec, but allows decimal anywhere
	    var create__isoRegex = /^(-)?P(?:(?:([0-9,.]*)Y)?(?:([0-9,.]*)M)?(?:([0-9,.]*)D)?(?:T(?:([0-9,.]*)H)?(?:([0-9,.]*)M)?(?:([0-9,.]*)S)?)?|([0-9,.]*)W)$/;
	
	    function create__createDuration (input, key) {
	        var duration = input,
	            // matching against regexp is expensive, do it on demand
	            match = null,
	            sign,
	            ret,
	            diffRes;
	
	        if (isDuration(input)) {
	            duration = {
	                ms : input._milliseconds,
	                d  : input._days,
	                M  : input._months
	            };
	        } else if (typeof input === 'number') {
	            duration = {};
	            if (key) {
	                duration[key] = input;
	            } else {
	                duration.milliseconds = input;
	            }
	        } else if (!!(match = aspNetRegex.exec(input))) {
	            sign = (match[1] === '-') ? -1 : 1;
	            duration = {
	                y  : 0,
	                d  : toInt(match[DATE])        * sign,
	                h  : toInt(match[HOUR])        * sign,
	                m  : toInt(match[MINUTE])      * sign,
	                s  : toInt(match[SECOND])      * sign,
	                ms : toInt(match[MILLISECOND]) * sign
	            };
	        } else if (!!(match = create__isoRegex.exec(input))) {
	            sign = (match[1] === '-') ? -1 : 1;
	            duration = {
	                y : parseIso(match[2], sign),
	                M : parseIso(match[3], sign),
	                d : parseIso(match[4], sign),
	                h : parseIso(match[5], sign),
	                m : parseIso(match[6], sign),
	                s : parseIso(match[7], sign),
	                w : parseIso(match[8], sign)
	            };
	        } else if (duration == null) {// checks for null or undefined
	            duration = {};
	        } else if (typeof duration === 'object' && ('from' in duration || 'to' in duration)) {
	            diffRes = momentsDifference(local__createLocal(duration.from), local__createLocal(duration.to));
	
	            duration = {};
	            duration.ms = diffRes.milliseconds;
	            duration.M = diffRes.months;
	        }
	
	        ret = new Duration(duration);
	
	        if (isDuration(input) && hasOwnProp(input, '_locale')) {
	            ret._locale = input._locale;
	        }
	
	        return ret;
	    }
	
	    create__createDuration.fn = Duration.prototype;
	
	    function parseIso (inp, sign) {
	        // We'd normally use ~~inp for this, but unfortunately it also
	        // converts floats to ints.
	        // inp may be undefined, so careful calling replace on it.
	        var res = inp && parseFloat(inp.replace(',', '.'));
	        // apply sign while we're at it
	        return (isNaN(res) ? 0 : res) * sign;
	    }
	
	    function positiveMomentsDifference(base, other) {
	        var res = {milliseconds: 0, months: 0};
	
	        res.months = other.month() - base.month() +
	            (other.year() - base.year()) * 12;
	        if (base.clone().add(res.months, 'M').isAfter(other)) {
	            --res.months;
	        }
	
	        res.milliseconds = +other - +(base.clone().add(res.months, 'M'));
	
	        return res;
	    }
	
	    function momentsDifference(base, other) {
	        var res;
	        other = cloneWithOffset(other, base);
	        if (base.isBefore(other)) {
	            res = positiveMomentsDifference(base, other);
	        } else {
	            res = positiveMomentsDifference(other, base);
	            res.milliseconds = -res.milliseconds;
	            res.months = -res.months;
	        }
	
	        return res;
	    }
	
	    function createAdder(direction, name) {
	        return function (val, period) {
	            var dur, tmp;
	            //invert the arguments, but complain about it
	            if (period !== null && !isNaN(+period)) {
	                deprecateSimple(name, 'moment().' + name  + '(period, number) is deprecated. Please use moment().' + name + '(number, period).');
	                tmp = val; val = period; period = tmp;
	            }
	
	            val = typeof val === 'string' ? +val : val;
	            dur = create__createDuration(val, period);
	            add_subtract__addSubtract(this, dur, direction);
	            return this;
	        };
	    }
	
	    function add_subtract__addSubtract (mom, duration, isAdding, updateOffset) {
	        var milliseconds = duration._milliseconds,
	            days = duration._days,
	            months = duration._months;
	        updateOffset = updateOffset == null ? true : updateOffset;
	
	        if (milliseconds) {
	            mom._d.setTime(+mom._d + milliseconds * isAdding);
	        }
	        if (days) {
	            get_set__set(mom, 'Date', get_set__get(mom, 'Date') + days * isAdding);
	        }
	        if (months) {
	            setMonth(mom, get_set__get(mom, 'Month') + months * isAdding);
	        }
	        if (updateOffset) {
	            utils_hooks__hooks.updateOffset(mom, days || months);
	        }
	    }
	
	    var add_subtract__add      = createAdder(1, 'add');
	    var add_subtract__subtract = createAdder(-1, 'subtract');
	
	    function moment_calendar__calendar (time) {
	        // We want to compare the start of today, vs this.
	        // Getting start-of-today depends on whether we're local/utc/offset or not.
	        var now = time || local__createLocal(),
	            sod = cloneWithOffset(now, this).startOf('day'),
	            diff = this.diff(sod, 'days', true),
	            format = diff < -6 ? 'sameElse' :
	                diff < -1 ? 'lastWeek' :
	                diff < 0 ? 'lastDay' :
	                diff < 1 ? 'sameDay' :
	                diff < 2 ? 'nextDay' :
	                diff < 7 ? 'nextWeek' : 'sameElse';
	        return this.format(this.localeData().calendar(format, this, local__createLocal(now)));
	    }
	
	    function clone () {
	        return new Moment(this);
	    }
	
	    function isAfter (input, units) {
	        var inputMs;
	        units = normalizeUnits(typeof units !== 'undefined' ? units : 'millisecond');
	        if (units === 'millisecond') {
	            input = isMoment(input) ? input : local__createLocal(input);
	            return +this > +input;
	        } else {
	            inputMs = isMoment(input) ? +input : +local__createLocal(input);
	            return inputMs < +this.clone().startOf(units);
	        }
	    }
	
	    function isBefore (input, units) {
	        var inputMs;
	        units = normalizeUnits(typeof units !== 'undefined' ? units : 'millisecond');
	        if (units === 'millisecond') {
	            input = isMoment(input) ? input : local__createLocal(input);
	            return +this < +input;
	        } else {
	            inputMs = isMoment(input) ? +input : +local__createLocal(input);
	            return +this.clone().endOf(units) < inputMs;
	        }
	    }
	
	    function isBetween (from, to, units) {
	        return this.isAfter(from, units) && this.isBefore(to, units);
	    }
	
	    function isSame (input, units) {
	        var inputMs;
	        units = normalizeUnits(units || 'millisecond');
	        if (units === 'millisecond') {
	            input = isMoment(input) ? input : local__createLocal(input);
	            return +this === +input;
	        } else {
	            inputMs = +local__createLocal(input);
	            return +(this.clone().startOf(units)) <= inputMs && inputMs <= +(this.clone().endOf(units));
	        }
	    }
	
	    function absFloor (number) {
	        if (number < 0) {
	            return Math.ceil(number);
	        } else {
	            return Math.floor(number);
	        }
	    }
	
	    function diff (input, units, asFloat) {
	        var that = cloneWithOffset(input, this),
	            zoneDelta = (that.utcOffset() - this.utcOffset()) * 6e4,
	            delta, output;
	
	        units = normalizeUnits(units);
	
	        if (units === 'year' || units === 'month' || units === 'quarter') {
	            output = monthDiff(this, that);
	            if (units === 'quarter') {
	                output = output / 3;
	            } else if (units === 'year') {
	                output = output / 12;
	            }
	        } else {
	            delta = this - that;
	            output = units === 'second' ? delta / 1e3 : // 1000
	                units === 'minute' ? delta / 6e4 : // 1000 * 60
	                units === 'hour' ? delta / 36e5 : // 1000 * 60 * 60
	                units === 'day' ? (delta - zoneDelta) / 864e5 : // 1000 * 60 * 60 * 24, negate dst
	                units === 'week' ? (delta - zoneDelta) / 6048e5 : // 1000 * 60 * 60 * 24 * 7, negate dst
	                delta;
	        }
	        return asFloat ? output : absFloor(output);
	    }
	
	    function monthDiff (a, b) {
	        // difference in months
	        var wholeMonthDiff = ((b.year() - a.year()) * 12) + (b.month() - a.month()),
	            // b is in (anchor - 1 month, anchor + 1 month)
	            anchor = a.clone().add(wholeMonthDiff, 'months'),
	            anchor2, adjust;
	
	        if (b - anchor < 0) {
	            anchor2 = a.clone().add(wholeMonthDiff - 1, 'months');
	            // linear across the month
	            adjust = (b - anchor) / (anchor - anchor2);
	        } else {
	            anchor2 = a.clone().add(wholeMonthDiff + 1, 'months');
	            // linear across the month
	            adjust = (b - anchor) / (anchor2 - anchor);
	        }
	
	        return -(wholeMonthDiff + adjust);
	    }
	
	    utils_hooks__hooks.defaultFormat = 'YYYY-MM-DDTHH:mm:ssZ';
	
	    function toString () {
	        return this.clone().locale('en').format('ddd MMM DD YYYY HH:mm:ss [GMT]ZZ');
	    }
	
	    function moment_format__toISOString () {
	        var m = this.clone().utc();
	        if (0 < m.year() && m.year() <= 9999) {
	            if ('function' === typeof Date.prototype.toISOString) {
	                // native implementation is ~50x faster, use it when we can
	                return this.toDate().toISOString();
	            } else {
	                return formatMoment(m, 'YYYY-MM-DD[T]HH:mm:ss.SSS[Z]');
	            }
	        } else {
	            return formatMoment(m, 'YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]');
	        }
	    }
	
	    function format (inputString) {
	        var output = formatMoment(this, inputString || utils_hooks__hooks.defaultFormat);
	        return this.localeData().postformat(output);
	    }
	
	    function from (time, withoutSuffix) {
	        return create__createDuration({to: this, from: time}).locale(this.locale()).humanize(!withoutSuffix);
	    }
	
	    function fromNow (withoutSuffix) {
	        return this.from(local__createLocal(), withoutSuffix);
	    }
	
	    function locale (key) {
	        var newLocaleData;
	
	        if (key === undefined) {
	            return this._locale._abbr;
	        } else {
	            newLocaleData = locale_locales__getLocale(key);
	            if (newLocaleData != null) {
	                this._locale = newLocaleData;
	            }
	            return this;
	        }
	    }
	
	    var lang = deprecate(
	        'moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.',
	        function (key) {
	            if (key === undefined) {
	                return this.localeData();
	            } else {
	                return this.locale(key);
	            }
	        }
	    );
	
	    function localeData () {
	        return this._locale;
	    }
	
	    function startOf (units) {
	        units = normalizeUnits(units);
	        // the following switch intentionally omits break keywords
	        // to utilize falling through the cases.
	        switch (units) {
	        case 'year':
	            this.month(0);
	            /* falls through */
	        case 'quarter':
	        case 'month':
	            this.date(1);
	            /* falls through */
	        case 'week':
	        case 'isoWeek':
	        case 'day':
	            this.hours(0);
	            /* falls through */
	        case 'hour':
	            this.minutes(0);
	            /* falls through */
	        case 'minute':
	            this.seconds(0);
	            /* falls through */
	        case 'second':
	            this.milliseconds(0);
	        }
	
	        // weeks are a special case
	        if (units === 'week') {
	            this.weekday(0);
	        }
	        if (units === 'isoWeek') {
	            this.isoWeekday(1);
	        }
	
	        // quarters are also special
	        if (units === 'quarter') {
	            this.month(Math.floor(this.month() / 3) * 3);
	        }
	
	        return this;
	    }
	
	    function endOf (units) {
	        units = normalizeUnits(units);
	        if (units === undefined || units === 'millisecond') {
	            return this;
	        }
	        return this.startOf(units).add(1, (units === 'isoWeek' ? 'week' : units)).subtract(1, 'ms');
	    }
	
	    function to_type__valueOf () {
	        return +this._d - ((this._offset || 0) * 60000);
	    }
	
	    function unix () {
	        return Math.floor(+this / 1000);
	    }
	
	    function toDate () {
	        return this._offset ? new Date(+this) : this._d;
	    }
	
	    function toArray () {
	        var m = this;
	        return [m.year(), m.month(), m.date(), m.hour(), m.minute(), m.second(), m.millisecond()];
	    }
	
	    function moment_valid__isValid () {
	        return valid__isValid(this);
	    }
	
	    function parsingFlags () {
	        return extend({}, this._pf);
	    }
	
	    function invalidAt () {
	        return this._pf.overflow;
	    }
	
	    addFormatToken(0, ['gg', 2], 0, function () {
	        return this.weekYear() % 100;
	    });
	
	    addFormatToken(0, ['GG', 2], 0, function () {
	        return this.isoWeekYear() % 100;
	    });
	
	    function addWeekYearFormatToken (token, getter) {
	        addFormatToken(0, [token, token.length], 0, getter);
	    }
	
	    addWeekYearFormatToken('gggg',     'weekYear');
	    addWeekYearFormatToken('ggggg',    'weekYear');
	    addWeekYearFormatToken('GGGG',  'isoWeekYear');
	    addWeekYearFormatToken('GGGGG', 'isoWeekYear');
	
	    // ALIASES
	
	    addUnitAlias('weekYear', 'gg');
	    addUnitAlias('isoWeekYear', 'GG');
	
	    // PARSING
	
	    addRegexToken('G',      matchSigned);
	    addRegexToken('g',      matchSigned);
	    addRegexToken('GG',     match1to2, match2);
	    addRegexToken('gg',     match1to2, match2);
	    addRegexToken('GGGG',   match1to4, match4);
	    addRegexToken('gggg',   match1to4, match4);
	    addRegexToken('GGGGG',  match1to6, match6);
	    addRegexToken('ggggg',  match1to6, match6);
	
	    addWeekParseToken(['gggg', 'ggggg', 'GGGG', 'GGGGG'], function (input, week, config, token) {
	        week[token.substr(0, 2)] = toInt(input);
	    });
	
	    addWeekParseToken(['gg', 'GG'], function (input, week, config, token) {
	        week[token] = utils_hooks__hooks.parseTwoDigitYear(input);
	    });
	
	    // HELPERS
	
	    function weeksInYear(year, dow, doy) {
	        return weekOfYear(local__createLocal([year, 11, 31 + dow - doy]), dow, doy).week;
	    }
	
	    // MOMENTS
	
	    function getSetWeekYear (input) {
	        var year = weekOfYear(this, this.localeData()._week.dow, this.localeData()._week.doy).year;
	        return input == null ? year : this.add((input - year), 'y');
	    }
	
	    function getSetISOWeekYear (input) {
	        var year = weekOfYear(this, 1, 4).year;
	        return input == null ? year : this.add((input - year), 'y');
	    }
	
	    function getISOWeeksInYear () {
	        return weeksInYear(this.year(), 1, 4);
	    }
	
	    function getWeeksInYear () {
	        var weekInfo = this.localeData()._week;
	        return weeksInYear(this.year(), weekInfo.dow, weekInfo.doy);
	    }
	
	    addFormatToken('Q', 0, 0, 'quarter');
	
	    // ALIASES
	
	    addUnitAlias('quarter', 'Q');
	
	    // PARSING
	
	    addRegexToken('Q', match1);
	    addParseToken('Q', function (input, array) {
	        array[MONTH] = (toInt(input) - 1) * 3;
	    });
	
	    // MOMENTS
	
	    function getSetQuarter (input) {
	        return input == null ? Math.ceil((this.month() + 1) / 3) : this.month((input - 1) * 3 + this.month() % 3);
	    }
	
	    addFormatToken('D', ['DD', 2], 'Do', 'date');
	
	    // ALIASES
	
	    addUnitAlias('date', 'D');
	
	    // PARSING
	
	    addRegexToken('D',  match1to2);
	    addRegexToken('DD', match1to2, match2);
	    addRegexToken('Do', function (isStrict, locale) {
	        return isStrict ? locale._ordinalParse : locale._ordinalParseLenient;
	    });
	
	    addParseToken(['D', 'DD'], DATE);
	    addParseToken('Do', function (input, array) {
	        array[DATE] = toInt(input.match(match1to2)[0], 10);
	    });
	
	    // MOMENTS
	
	    var getSetDayOfMonth = makeGetSet('Date', true);
	
	    addFormatToken('d', 0, 'do', 'day');
	
	    addFormatToken('dd', 0, 0, function (format) {
	        return this.localeData().weekdaysMin(this, format);
	    });
	
	    addFormatToken('ddd', 0, 0, function (format) {
	        return this.localeData().weekdaysShort(this, format);
	    });
	
	    addFormatToken('dddd', 0, 0, function (format) {
	        return this.localeData().weekdays(this, format);
	    });
	
	    addFormatToken('e', 0, 0, 'weekday');
	    addFormatToken('E', 0, 0, 'isoWeekday');
	
	    // ALIASES
	
	    addUnitAlias('day', 'd');
	    addUnitAlias('weekday', 'e');
	    addUnitAlias('isoWeekday', 'E');
	
	    // PARSING
	
	    addRegexToken('d',    match1to2);
	    addRegexToken('e',    match1to2);
	    addRegexToken('E',    match1to2);
	    addRegexToken('dd',   matchWord);
	    addRegexToken('ddd',  matchWord);
	    addRegexToken('dddd', matchWord);
	
	    addWeekParseToken(['dd', 'ddd', 'dddd'], function (input, week, config) {
	        var weekday = config._locale.weekdaysParse(input);
	        // if we didn't get a weekday name, mark the date as invalid
	        if (weekday != null) {
	            week.d = weekday;
	        } else {
	            config._pf.invalidWeekday = input;
	        }
	    });
	
	    addWeekParseToken(['d', 'e', 'E'], function (input, week, config, token) {
	        week[token] = toInt(input);
	    });
	
	    // HELPERS
	
	    function parseWeekday(input, locale) {
	        if (typeof input === 'string') {
	            if (!isNaN(input)) {
	                input = parseInt(input, 10);
	            }
	            else {
	                input = locale.weekdaysParse(input);
	                if (typeof input !== 'number') {
	                    return null;
	                }
	            }
	        }
	        return input;
	    }
	
	    // LOCALES
	
	    var defaultLocaleWeekdays = 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday'.split('_');
	    function localeWeekdays (m) {
	        return this._weekdays[m.day()];
	    }
	
	    var defaultLocaleWeekdaysShort = 'Sun_Mon_Tue_Wed_Thu_Fri_Sat'.split('_');
	    function localeWeekdaysShort (m) {
	        return this._weekdaysShort[m.day()];
	    }
	
	    var defaultLocaleWeekdaysMin = 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_');
	    function localeWeekdaysMin (m) {
	        return this._weekdaysMin[m.day()];
	    }
	
	    function localeWeekdaysParse (weekdayName) {
	        var i, mom, regex;
	
	        if (!this._weekdaysParse) {
	            this._weekdaysParse = [];
	        }
	
	        for (i = 0; i < 7; i++) {
	            // make the regex if we don't have it already
	            if (!this._weekdaysParse[i]) {
	                mom = local__createLocal([2000, 1]).day(i);
	                regex = '^' + this.weekdays(mom, '') + '|^' + this.weekdaysShort(mom, '') + '|^' + this.weekdaysMin(mom, '');
	                this._weekdaysParse[i] = new RegExp(regex.replace('.', ''), 'i');
	            }
	            // test the regex
	            if (this._weekdaysParse[i].test(weekdayName)) {
	                return i;
	            }
	        }
	    }
	
	    // MOMENTS
	
	    function getSetDayOfWeek (input) {
	        var day = this._isUTC ? this._d.getUTCDay() : this._d.getDay();
	        if (input != null) {
	            input = parseWeekday(input, this.localeData());
	            return this.add(input - day, 'd');
	        } else {
	            return day;
	        }
	    }
	
	    function getSetLocaleDayOfWeek (input) {
	        var weekday = (this.day() + 7 - this.localeData()._week.dow) % 7;
	        return input == null ? weekday : this.add(input - weekday, 'd');
	    }
	
	    function getSetISODayOfWeek (input) {
	        // behaves the same as moment#day except
	        // as a getter, returns 7 instead of 0 (1-7 range instead of 0-6)
	        // as a setter, sunday should belong to the previous week.
	        return input == null ? this.day() || 7 : this.day(this.day() % 7 ? input : input - 7);
	    }
	
	    addFormatToken('H', ['HH', 2], 0, 'hour');
	    addFormatToken('h', ['hh', 2], 0, function () {
	        return this.hours() % 12 || 12;
	    });
	
	    function meridiem (token, lowercase) {
	        addFormatToken(token, 0, 0, function () {
	            return this.localeData().meridiem(this.hours(), this.minutes(), lowercase);
	        });
	    }
	
	    meridiem('a', true);
	    meridiem('A', false);
	
	    // ALIASES
	
	    addUnitAlias('hour', 'h');
	
	    // PARSING
	
	    function matchMeridiem (isStrict, locale) {
	        return locale._meridiemParse;
	    }
	
	    addRegexToken('a',  matchMeridiem);
	    addRegexToken('A',  matchMeridiem);
	    addRegexToken('H',  match1to2);
	    addRegexToken('h',  match1to2);
	    addRegexToken('HH', match1to2, match2);
	    addRegexToken('hh', match1to2, match2);
	
	    addParseToken(['H', 'HH'], HOUR);
	    addParseToken(['a', 'A'], function (input, array, config) {
	        config._isPm = config._locale.isPM(input);
	        config._meridiem = input;
	    });
	    addParseToken(['h', 'hh'], function (input, array, config) {
	        array[HOUR] = toInt(input);
	        config._pf.bigHour = true;
	    });
	
	    // LOCALES
	
	    function localeIsPM (input) {
	        // IE8 Quirks Mode & IE7 Standards Mode do not allow accessing strings like arrays
	        // Using charAt should be more compatible.
	        return ((input + '').toLowerCase().charAt(0) === 'p');
	    }
	
	    var defaultLocaleMeridiemParse = /[ap]\.?m?\.?/i;
	    function localeMeridiem (hours, minutes, isLower) {
	        if (hours > 11) {
	            return isLower ? 'pm' : 'PM';
	        } else {
	            return isLower ? 'am' : 'AM';
	        }
	    }
	
	
	    // MOMENTS
	
	    // Setting the hour should keep the time, because the user explicitly
	    // specified which hour he wants. So trying to maintain the same hour (in
	    // a new timezone) makes sense. Adding/subtracting hours does not follow
	    // this rule.
	    var getSetHour = makeGetSet('Hours', true);
	
	    addFormatToken('m', ['mm', 2], 0, 'minute');
	
	    // ALIASES
	
	    addUnitAlias('minute', 'm');
	
	    // PARSING
	
	    addRegexToken('m',  match1to2);
	    addRegexToken('mm', match1to2, match2);
	    addParseToken(['m', 'mm'], MINUTE);
	
	    // MOMENTS
	
	    var getSetMinute = makeGetSet('Minutes', false);
	
	    addFormatToken('s', ['ss', 2], 0, 'second');
	
	    // ALIASES
	
	    addUnitAlias('second', 's');
	
	    // PARSING
	
	    addRegexToken('s',  match1to2);
	    addRegexToken('ss', match1to2, match2);
	    addParseToken(['s', 'ss'], SECOND);
	
	    // MOMENTS
	
	    var getSetSecond = makeGetSet('Seconds', false);
	
	    addFormatToken('S', 0, 0, function () {
	        return ~~(this.millisecond() / 100);
	    });
	
	    addFormatToken(0, ['SS', 2], 0, function () {
	        return ~~(this.millisecond() / 10);
	    });
	
	    function millisecond__milliseconds (token) {
	        addFormatToken(0, [token, 3], 0, 'millisecond');
	    }
	
	    millisecond__milliseconds('SSS');
	    millisecond__milliseconds('SSSS');
	
	    // ALIASES
	
	    addUnitAlias('millisecond', 'ms');
	
	    // PARSING
	
	    addRegexToken('S',    match1to3, match1);
	    addRegexToken('SS',   match1to3, match2);
	    addRegexToken('SSS',  match1to3, match3);
	    addRegexToken('SSSS', matchUnsigned);
	    addParseToken(['S', 'SS', 'SSS', 'SSSS'], function (input, array) {
	        array[MILLISECOND] = toInt(('0.' + input) * 1000);
	    });
	
	    // MOMENTS
	
	    var getSetMillisecond = makeGetSet('Milliseconds', false);
	
	    addFormatToken('z',  0, 0, 'zoneAbbr');
	    addFormatToken('zz', 0, 0, 'zoneName');
	
	    // MOMENTS
	
	    function getZoneAbbr () {
	        return this._isUTC ? 'UTC' : '';
	    }
	
	    function getZoneName () {
	        return this._isUTC ? 'Coordinated Universal Time' : '';
	    }
	
	    var momentPrototype__proto = Moment.prototype;
	
	    momentPrototype__proto.add          = add_subtract__add;
	    momentPrototype__proto.calendar     = moment_calendar__calendar;
	    momentPrototype__proto.clone        = clone;
	    momentPrototype__proto.diff         = diff;
	    momentPrototype__proto.endOf        = endOf;
	    momentPrototype__proto.format       = format;
	    momentPrototype__proto.from         = from;
	    momentPrototype__proto.fromNow      = fromNow;
	    momentPrototype__proto.get          = getSet;
	    momentPrototype__proto.invalidAt    = invalidAt;
	    momentPrototype__proto.isAfter      = isAfter;
	    momentPrototype__proto.isBefore     = isBefore;
	    momentPrototype__proto.isBetween    = isBetween;
	    momentPrototype__proto.isSame       = isSame;
	    momentPrototype__proto.isValid      = moment_valid__isValid;
	    momentPrototype__proto.lang         = lang;
	    momentPrototype__proto.locale       = locale;
	    momentPrototype__proto.localeData   = localeData;
	    momentPrototype__proto.max          = prototypeMax;
	    momentPrototype__proto.min          = prototypeMin;
	    momentPrototype__proto.parsingFlags = parsingFlags;
	    momentPrototype__proto.set          = getSet;
	    momentPrototype__proto.startOf      = startOf;
	    momentPrototype__proto.subtract     = add_subtract__subtract;
	    momentPrototype__proto.toArray      = toArray;
	    momentPrototype__proto.toDate       = toDate;
	    momentPrototype__proto.toISOString  = moment_format__toISOString;
	    momentPrototype__proto.toJSON       = moment_format__toISOString;
	    momentPrototype__proto.toString     = toString;
	    momentPrototype__proto.unix         = unix;
	    momentPrototype__proto.valueOf      = to_type__valueOf;
	
	    // Year
	    momentPrototype__proto.year       = getSetYear;
	    momentPrototype__proto.isLeapYear = getIsLeapYear;
	
	    // Week Year
	    momentPrototype__proto.weekYear    = getSetWeekYear;
	    momentPrototype__proto.isoWeekYear = getSetISOWeekYear;
	
	    // Quarter
	    momentPrototype__proto.quarter = momentPrototype__proto.quarters = getSetQuarter;
	
	    // Month
	    momentPrototype__proto.month       = getSetMonth;
	    momentPrototype__proto.daysInMonth = getDaysInMonth;
	
	    // Week
	    momentPrototype__proto.week           = momentPrototype__proto.weeks        = getSetWeek;
	    momentPrototype__proto.isoWeek        = momentPrototype__proto.isoWeeks     = getSetISOWeek;
	    momentPrototype__proto.weeksInYear    = getWeeksInYear;
	    momentPrototype__proto.isoWeeksInYear = getISOWeeksInYear;
	
	    // Day
	    momentPrototype__proto.date       = getSetDayOfMonth;
	    momentPrototype__proto.day        = momentPrototype__proto.days             = getSetDayOfWeek;
	    momentPrototype__proto.weekday    = getSetLocaleDayOfWeek;
	    momentPrototype__proto.isoWeekday = getSetISODayOfWeek;
	    momentPrototype__proto.dayOfYear  = getSetDayOfYear;
	
	    // Hour
	    momentPrototype__proto.hour = momentPrototype__proto.hours = getSetHour;
	
	    // Minute
	    momentPrototype__proto.minute = momentPrototype__proto.minutes = getSetMinute;
	
	    // Second
	    momentPrototype__proto.second = momentPrototype__proto.seconds = getSetSecond;
	
	    // Millisecond
	    momentPrototype__proto.millisecond = momentPrototype__proto.milliseconds = getSetMillisecond;
	
	    // Offset
	    momentPrototype__proto.utcOffset            = getSetOffset;
	    momentPrototype__proto.utc                  = setOffsetToUTC;
	    momentPrototype__proto.local                = setOffsetToLocal;
	    momentPrototype__proto.parseZone            = setOffsetToParsedOffset;
	    momentPrototype__proto.hasAlignedHourOffset = hasAlignedHourOffset;
	    momentPrototype__proto.isDST                = isDaylightSavingTime;
	    momentPrototype__proto.isDSTShifted         = isDaylightSavingTimeShifted;
	    momentPrototype__proto.isLocal              = isLocal;
	    momentPrototype__proto.isUtcOffset          = isUtcOffset;
	    momentPrototype__proto.isUtc                = isUtc;
	    momentPrototype__proto.isUTC                = isUtc;
	
	    // Timezone
	    momentPrototype__proto.zoneAbbr = getZoneAbbr;
	    momentPrototype__proto.zoneName = getZoneName;
	
	    // Deprecations
	    momentPrototype__proto.dates  = deprecate('dates accessor is deprecated. Use date instead.', getSetDayOfMonth);
	    momentPrototype__proto.months = deprecate('months accessor is deprecated. Use month instead', getSetMonth);
	    momentPrototype__proto.years  = deprecate('years accessor is deprecated. Use year instead', getSetYear);
	    momentPrototype__proto.zone   = deprecate('moment().zone is deprecated, use moment().utcOffset instead. https://github.com/moment/moment/issues/1779', getSetZone);
	
	    var momentPrototype = momentPrototype__proto;
	
	    function moment__createUnix (input) {
	        return local__createLocal(input * 1000);
	    }
	
	    function moment__createInZone () {
	        return local__createLocal.apply(null, arguments).parseZone();
	    }
	
	    var defaultCalendar = {
	        sameDay : '[Today at] LT',
	        nextDay : '[Tomorrow at] LT',
	        nextWeek : 'dddd [at] LT',
	        lastDay : '[Yesterday at] LT',
	        lastWeek : '[Last] dddd [at] LT',
	        sameElse : 'L'
	    };
	
	    function locale_calendar__calendar (key, mom, now) {
	        var output = this._calendar[key];
	        return typeof output === 'function' ? output.call(mom, now) : output;
	    }
	
	    var defaultLongDateFormat = {
	        LTS  : 'h:mm:ss A',
	        LT   : 'h:mm A',
	        L    : 'MM/DD/YYYY',
	        LL   : 'MMMM D, YYYY',
	        LLL  : 'MMMM D, YYYY LT',
	        LLLL : 'dddd, MMMM D, YYYY LT'
	    };
	
	    function longDateFormat (key) {
	        var output = this._longDateFormat[key];
	        if (!output && this._longDateFormat[key.toUpperCase()]) {
	            output = this._longDateFormat[key.toUpperCase()].replace(/MMMM|MM|DD|dddd/g, function (val) {
	                return val.slice(1);
	            });
	            this._longDateFormat[key] = output;
	        }
	        return output;
	    }
	
	    var defaultInvalidDate = 'Invalid date';
	
	    function invalidDate () {
	        return this._invalidDate;
	    }
	
	    var defaultOrdinal = '%d';
	    var defaultOrdinalParse = /\d{1,2}/;
	
	    function ordinal (number) {
	        return this._ordinal.replace('%d', number);
	    }
	
	    function preParsePostFormat (string) {
	        return string;
	    }
	
	    var defaultRelativeTime = {
	        future : 'in %s',
	        past   : '%s ago',
	        s  : 'a few seconds',
	        m  : 'a minute',
	        mm : '%d minutes',
	        h  : 'an hour',
	        hh : '%d hours',
	        d  : 'a day',
	        dd : '%d days',
	        M  : 'a month',
	        MM : '%d months',
	        y  : 'a year',
	        yy : '%d years'
	    };
	
	    function relative__relativeTime (number, withoutSuffix, string, isFuture) {
	        var output = this._relativeTime[string];
	        return (typeof output === 'function') ?
	            output(number, withoutSuffix, string, isFuture) :
	            output.replace(/%d/i, number);
	    }
	
	    function pastFuture (diff, output) {
	        var format = this._relativeTime[diff > 0 ? 'future' : 'past'];
	        return typeof format === 'function' ? format(output) : format.replace(/%s/i, output);
	    }
	
	    function locale_set__set (config) {
	        var prop, i;
	        for (i in config) {
	            prop = config[i];
	            if (typeof prop === 'function') {
	                this[i] = prop;
	            } else {
	                this['_' + i] = prop;
	            }
	        }
	        // Lenient ordinal parsing accepts just a number in addition to
	        // number + (possibly) stuff coming from _ordinalParseLenient.
	        this._ordinalParseLenient = new RegExp(this._ordinalParse.source + '|' + /\d{1,2}/.source);
	    }
	
	    var prototype__proto = Locale.prototype;
	
	    prototype__proto._calendar       = defaultCalendar;
	    prototype__proto.calendar        = locale_calendar__calendar;
	    prototype__proto._longDateFormat = defaultLongDateFormat;
	    prototype__proto.longDateFormat  = longDateFormat;
	    prototype__proto._invalidDate    = defaultInvalidDate;
	    prototype__proto.invalidDate     = invalidDate;
	    prototype__proto._ordinal        = defaultOrdinal;
	    prototype__proto.ordinal         = ordinal;
	    prototype__proto._ordinalParse   = defaultOrdinalParse;
	    prototype__proto.preparse        = preParsePostFormat;
	    prototype__proto.postformat      = preParsePostFormat;
	    prototype__proto._relativeTime   = defaultRelativeTime;
	    prototype__proto.relativeTime    = relative__relativeTime;
	    prototype__proto.pastFuture      = pastFuture;
	    prototype__proto.set             = locale_set__set;
	
	    // Month
	    prototype__proto.months       =        localeMonths;
	    prototype__proto._months      = defaultLocaleMonths;
	    prototype__proto.monthsShort  =        localeMonthsShort;
	    prototype__proto._monthsShort = defaultLocaleMonthsShort;
	    prototype__proto.monthsParse  =        localeMonthsParse;
	
	    // Week
	    prototype__proto.week = localeWeek;
	    prototype__proto._week = defaultLocaleWeek;
	    prototype__proto.firstDayOfYear = localeFirstDayOfYear;
	    prototype__proto.firstDayOfWeek = localeFirstDayOfWeek;
	
	    // Day of Week
	    prototype__proto.weekdays       =        localeWeekdays;
	    prototype__proto._weekdays      = defaultLocaleWeekdays;
	    prototype__proto.weekdaysMin    =        localeWeekdaysMin;
	    prototype__proto._weekdaysMin   = defaultLocaleWeekdaysMin;
	    prototype__proto.weekdaysShort  =        localeWeekdaysShort;
	    prototype__proto._weekdaysShort = defaultLocaleWeekdaysShort;
	    prototype__proto.weekdaysParse  =        localeWeekdaysParse;
	
	    // Hours
	    prototype__proto.isPM = localeIsPM;
	    prototype__proto._meridiemParse = defaultLocaleMeridiemParse;
	    prototype__proto.meridiem = localeMeridiem;
	
	    function lists__get (format, index, field, setter) {
	        var locale = locale_locales__getLocale();
	        var utc = create_utc__createUTC().set(setter, index);
	        return locale[field](utc, format);
	    }
	
	    function list (format, index, field, count, setter) {
	        if (typeof format === 'number') {
	            index = format;
	            format = undefined;
	        }
	
	        format = format || '';
	
	        if (index != null) {
	            return lists__get(format, index, field, setter);
	        }
	
	        var i;
	        var out = [];
	        for (i = 0; i < count; i++) {
	            out[i] = lists__get(format, i, field, setter);
	        }
	        return out;
	    }
	
	    function lists__listMonths (format, index) {
	        return list(format, index, 'months', 12, 'month');
	    }
	
	    function lists__listMonthsShort (format, index) {
	        return list(format, index, 'monthsShort', 12, 'month');
	    }
	
	    function lists__listWeekdays (format, index) {
	        return list(format, index, 'weekdays', 7, 'day');
	    }
	
	    function lists__listWeekdaysShort (format, index) {
	        return list(format, index, 'weekdaysShort', 7, 'day');
	    }
	
	    function lists__listWeekdaysMin (format, index) {
	        return list(format, index, 'weekdaysMin', 7, 'day');
	    }
	
	    locale_locales__getSetGlobalLocale('en', {
	        ordinalParse: /\d{1,2}(th|st|nd|rd)/,
	        ordinal : function (number) {
	            var b = number % 10,
	                output = (toInt(number % 100 / 10) === 1) ? 'th' :
	                (b === 1) ? 'st' :
	                (b === 2) ? 'nd' :
	                (b === 3) ? 'rd' : 'th';
	            return number + output;
	        }
	    });
	
	    // Side effect imports
	    utils_hooks__hooks.lang = deprecate('moment.lang is deprecated. Use moment.locale instead.', locale_locales__getSetGlobalLocale);
	    utils_hooks__hooks.langData = deprecate('moment.langData is deprecated. Use moment.localeData instead.', locale_locales__getLocale);
	
	    var mathAbs = Math.abs;
	
	    function duration_abs__abs () {
	        var data           = this._data;
	
	        this._milliseconds = mathAbs(this._milliseconds);
	        this._days         = mathAbs(this._days);
	        this._months       = mathAbs(this._months);
	
	        data.milliseconds  = mathAbs(data.milliseconds);
	        data.seconds       = mathAbs(data.seconds);
	        data.minutes       = mathAbs(data.minutes);
	        data.hours         = mathAbs(data.hours);
	        data.months        = mathAbs(data.months);
	        data.years         = mathAbs(data.years);
	
	        return this;
	    }
	
	    function duration_add_subtract__addSubtract (duration, input, value, direction) {
	        var other = create__createDuration(input, value);
	
	        duration._milliseconds += direction * other._milliseconds;
	        duration._days         += direction * other._days;
	        duration._months       += direction * other._months;
	
	        return duration._bubble();
	    }
	
	    // supports only 2.0-style add(1, 's') or add(duration)
	    function duration_add_subtract__add (input, value) {
	        return duration_add_subtract__addSubtract(this, input, value, 1);
	    }
	
	    // supports only 2.0-style subtract(1, 's') or subtract(duration)
	    function duration_add_subtract__subtract (input, value) {
	        return duration_add_subtract__addSubtract(this, input, value, -1);
	    }
	
	    function bubble () {
	        var milliseconds = this._milliseconds;
	        var days         = this._days;
	        var months       = this._months;
	        var data         = this._data;
	        var seconds, minutes, hours, years = 0;
	
	        // The following code bubbles up values, see the tests for
	        // examples of what that means.
	        data.milliseconds = milliseconds % 1000;
	
	        seconds           = absFloor(milliseconds / 1000);
	        data.seconds      = seconds % 60;
	
	        minutes           = absFloor(seconds / 60);
	        data.minutes      = minutes % 60;
	
	        hours             = absFloor(minutes / 60);
	        data.hours        = hours % 24;
	
	        days += absFloor(hours / 24);
	
	        // Accurately convert days to years, assume start from year 0.
	        years = absFloor(daysToYears(days));
	        days -= absFloor(yearsToDays(years));
	
	        // 30 days to a month
	        // TODO (iskren): Use anchor date (like 1st Jan) to compute this.
	        months += absFloor(days / 30);
	        days   %= 30;
	
	        // 12 months -> 1 year
	        years  += absFloor(months / 12);
	        months %= 12;
	
	        data.days   = days;
	        data.months = months;
	        data.years  = years;
	
	        return this;
	    }
	
	    function daysToYears (days) {
	        // 400 years have 146097 days (taking into account leap year rules)
	        return days * 400 / 146097;
	    }
	
	    function yearsToDays (years) {
	        // years * 365 + absFloor(years / 4) -
	        //     absFloor(years / 100) + absFloor(years / 400);
	        return years * 146097 / 400;
	    }
	
	    function as (units) {
	        var days;
	        var months;
	        var milliseconds = this._milliseconds;
	
	        units = normalizeUnits(units);
	
	        if (units === 'month' || units === 'year') {
	            days   = this._days   + milliseconds / 864e5;
	            months = this._months + daysToYears(days) * 12;
	            return units === 'month' ? months : months / 12;
	        } else {
	            // handle milliseconds separately because of floating point math errors (issue #1867)
	            days = this._days + Math.round(yearsToDays(this._months / 12));
	            switch (units) {
	                case 'week'   : return days / 7            + milliseconds / 6048e5;
	                case 'day'    : return days                + milliseconds / 864e5;
	                case 'hour'   : return days * 24           + milliseconds / 36e5;
	                case 'minute' : return days * 24 * 60      + milliseconds / 6e4;
	                case 'second' : return days * 24 * 60 * 60 + milliseconds / 1000;
	                // Math.floor prevents floating point math errors here
	                case 'millisecond': return Math.floor(days * 24 * 60 * 60 * 1000) + milliseconds;
	                default: throw new Error('Unknown unit ' + units);
	            }
	        }
	    }
	
	    // TODO: Use this.as('ms')?
	    function duration_as__valueOf () {
	        return (
	            this._milliseconds +
	            this._days * 864e5 +
	            (this._months % 12) * 2592e6 +
	            toInt(this._months / 12) * 31536e6
	        );
	    }
	
	    function makeAs (alias) {
	        return function () {
	            return this.as(alias);
	        };
	    }
	
	    var asMilliseconds = makeAs('ms');
	    var asSeconds      = makeAs('s');
	    var asMinutes      = makeAs('m');
	    var asHours        = makeAs('h');
	    var asDays         = makeAs('d');
	    var asWeeks        = makeAs('w');
	    var asMonths       = makeAs('M');
	    var asYears        = makeAs('y');
	
	    function duration_get__get (units) {
	        units = normalizeUnits(units);
	        return this[units + 's']();
	    }
	
	    function makeGetter(name) {
	        return function () {
	            return this._data[name];
	        };
	    }
	
	    var duration_get__milliseconds = makeGetter('milliseconds');
	    var seconds      = makeGetter('seconds');
	    var minutes      = makeGetter('minutes');
	    var hours        = makeGetter('hours');
	    var days         = makeGetter('days');
	    var months       = makeGetter('months');
	    var years        = makeGetter('years');
	
	    function weeks () {
	        return absFloor(this.days() / 7);
	    }
	
	    var round = Math.round;
	    var thresholds = {
	        s: 45,  // seconds to minute
	        m: 45,  // minutes to hour
	        h: 22,  // hours to day
	        d: 26,  // days to month
	        M: 11   // months to year
	    };
	
	    // helper function for moment.fn.from, moment.fn.fromNow, and moment.duration.fn.humanize
	    function substituteTimeAgo(string, number, withoutSuffix, isFuture, locale) {
	        return locale.relativeTime(number || 1, !!withoutSuffix, string, isFuture);
	    }
	
	    function duration_humanize__relativeTime (posNegDuration, withoutSuffix, locale) {
	        var duration = create__createDuration(posNegDuration).abs();
	        var seconds  = round(duration.as('s'));
	        var minutes  = round(duration.as('m'));
	        var hours    = round(duration.as('h'));
	        var days     = round(duration.as('d'));
	        var months   = round(duration.as('M'));
	        var years    = round(duration.as('y'));
	
	        var a = seconds < thresholds.s && ['s', seconds]  ||
	                minutes === 1          && ['m']           ||
	                minutes < thresholds.m && ['mm', minutes] ||
	                hours   === 1          && ['h']           ||
	                hours   < thresholds.h && ['hh', hours]   ||
	                days    === 1          && ['d']           ||
	                days    < thresholds.d && ['dd', days]    ||
	                months  === 1          && ['M']           ||
	                months  < thresholds.M && ['MM', months]  ||
	                years   === 1          && ['y']           || ['yy', years];
	
	        a[2] = withoutSuffix;
	        a[3] = +posNegDuration > 0;
	        a[4] = locale;
	        return substituteTimeAgo.apply(null, a);
	    }
	
	    // This function allows you to set a threshold for relative time strings
	    function duration_humanize__getSetRelativeTimeThreshold (threshold, limit) {
	        if (thresholds[threshold] === undefined) {
	            return false;
	        }
	        if (limit === undefined) {
	            return thresholds[threshold];
	        }
	        thresholds[threshold] = limit;
	        return true;
	    }
	
	    function humanize (withSuffix) {
	        var locale = this.localeData();
	        var output = duration_humanize__relativeTime(this, !withSuffix, locale);
	
	        if (withSuffix) {
	            output = locale.pastFuture(+this, output);
	        }
	
	        return locale.postformat(output);
	    }
	
	    var iso_string__abs = Math.abs;
	
	    function iso_string__toISOString() {
	        // inspired by https://github.com/dordille/moment-isoduration/blob/master/moment.isoduration.js
	        var Y = iso_string__abs(this.years());
	        var M = iso_string__abs(this.months());
	        var D = iso_string__abs(this.days());
	        var h = iso_string__abs(this.hours());
	        var m = iso_string__abs(this.minutes());
	        var s = iso_string__abs(this.seconds() + this.milliseconds() / 1000);
	        var total = this.asSeconds();
	
	        if (!total) {
	            // this is the same as C#'s (Noda) and python (isodate)...
	            // but not other JS (goog.date)
	            return 'P0D';
	        }
	
	        return (total < 0 ? '-' : '') +
	            'P' +
	            (Y ? Y + 'Y' : '') +
	            (M ? M + 'M' : '') +
	            (D ? D + 'D' : '') +
	            ((h || m || s) ? 'T' : '') +
	            (h ? h + 'H' : '') +
	            (m ? m + 'M' : '') +
	            (s ? s + 'S' : '');
	    }
	
	    var duration_prototype__proto = Duration.prototype;
	
	    duration_prototype__proto.abs            = duration_abs__abs;
	    duration_prototype__proto.add            = duration_add_subtract__add;
	    duration_prototype__proto.subtract       = duration_add_subtract__subtract;
	    duration_prototype__proto.as             = as;
	    duration_prototype__proto.asMilliseconds = asMilliseconds;
	    duration_prototype__proto.asSeconds      = asSeconds;
	    duration_prototype__proto.asMinutes      = asMinutes;
	    duration_prototype__proto.asHours        = asHours;
	    duration_prototype__proto.asDays         = asDays;
	    duration_prototype__proto.asWeeks        = asWeeks;
	    duration_prototype__proto.asMonths       = asMonths;
	    duration_prototype__proto.asYears        = asYears;
	    duration_prototype__proto.valueOf        = duration_as__valueOf;
	    duration_prototype__proto._bubble        = bubble;
	    duration_prototype__proto.get            = duration_get__get;
	    duration_prototype__proto.milliseconds   = duration_get__milliseconds;
	    duration_prototype__proto.seconds        = seconds;
	    duration_prototype__proto.minutes        = minutes;
	    duration_prototype__proto.hours          = hours;
	    duration_prototype__proto.days           = days;
	    duration_prototype__proto.weeks          = weeks;
	    duration_prototype__proto.months         = months;
	    duration_prototype__proto.years          = years;
	    duration_prototype__proto.humanize       = humanize;
	    duration_prototype__proto.toISOString    = iso_string__toISOString;
	    duration_prototype__proto.toString       = iso_string__toISOString;
	    duration_prototype__proto.toJSON         = iso_string__toISOString;
	    duration_prototype__proto.locale         = locale;
	    duration_prototype__proto.localeData     = localeData;
	
	    // Deprecations
	    duration_prototype__proto.toIsoString = deprecate('toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)', iso_string__toISOString);
	    duration_prototype__proto.lang = lang;
	
	    // Side effect imports
	
	    addFormatToken('X', 0, 0, 'unix');
	    addFormatToken('x', 0, 0, 'valueOf');
	
	    // PARSING
	
	    addRegexToken('x', matchSigned);
	    addRegexToken('X', matchTimestamp);
	    addParseToken('X', function (input, array, config) {
	        config._d = new Date(parseFloat(input, 10) * 1000);
	    });
	    addParseToken('x', function (input, array, config) {
	        config._d = new Date(toInt(input));
	    });
	
	    // Side effect imports
	
	
	    utils_hooks__hooks.version = '2.10.2';
	
	    setHookCallback(local__createLocal);
	
	    utils_hooks__hooks.fn                    = momentPrototype;
	    utils_hooks__hooks.min                   = min;
	    utils_hooks__hooks.max                   = max;
	    utils_hooks__hooks.utc                   = create_utc__createUTC;
	    utils_hooks__hooks.unix                  = moment__createUnix;
	    utils_hooks__hooks.months                = lists__listMonths;
	    utils_hooks__hooks.isDate                = isDate;
	    utils_hooks__hooks.locale                = locale_locales__getSetGlobalLocale;
	    utils_hooks__hooks.invalid               = valid__createInvalid;
	    utils_hooks__hooks.duration              = create__createDuration;
	    utils_hooks__hooks.isMoment              = isMoment;
	    utils_hooks__hooks.weekdays              = lists__listWeekdays;
	    utils_hooks__hooks.parseZone             = moment__createInZone;
	    utils_hooks__hooks.localeData            = locale_locales__getLocale;
	    utils_hooks__hooks.isDuration            = isDuration;
	    utils_hooks__hooks.monthsShort           = lists__listMonthsShort;
	    utils_hooks__hooks.weekdaysMin           = lists__listWeekdaysMin;
	    utils_hooks__hooks.defineLocale          = defineLocale;
	    utils_hooks__hooks.weekdaysShort         = lists__listWeekdaysShort;
	    utils_hooks__hooks.normalizeUnits        = normalizeUnits;
	    utils_hooks__hooks.relativeTimeThreshold = duration_humanize__getSetRelativeTimeThreshold;
	
	    var _moment = utils_hooks__hooks;
	
	    return _moment;
	
	}));
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(19)(module)))

/***/ },
/* 17 */
/***/ function(module, exports, __webpack_require__) {

	var map = {
		"./de": 23,
		"./de-at": 22,
		"./de-at.js": 22,
		"./de.js": 23,
		"./fr": 25,
		"./fr-ca": 24,
		"./fr-ca.js": 24,
		"./fr.js": 25,
		"./hu": 26,
		"./hu.js": 26
	};
	function webpackContext(req) {
		return __webpack_require__(webpackContextResolve(req));
	};
	function webpackContextResolve(req) {
		return map[req] || (function() { throw new Error("Cannot find module '" + req + "'.") }());
	};
	webpackContext.keys = function webpackContextKeys() {
		return Object.keys(map);
	};
	webpackContext.resolve = webpackContextResolve;
	module.exports = webpackContext;


/***/ },
/* 18 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(__webpack_amd_options__) {module.exports = __webpack_amd_options__;
	
	/* WEBPACK VAR INJECTION */}.call(exports, {}))

/***/ },
/* 19 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = function(module) {
		if(!module.webpackPolyfill) {
			module.deprecate = function() {};
			module.paths = [];
			// module.parent = undefined by default
			module.children = [];
			module.webpackPolyfill = 1;
		}
		return module;
	}


/***/ },
/* 20 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = "\n  <div class=\"col-lg-12\">\n    <h3>[[formTitle]]</h3>\n    <div ng-repeat=\"field in fields\" class=\"row\">\n\n      <div class=\"form-group col-lg-4\">\n\n      <div ng-switch on=\"field.type\">\n        <div ng-switch-when=\"text\">\n          <label for=\"{{field.name}}\" class=\"control-label\">{{field.label}}</label>\n          <input type=\"text\" ng-model=\"field.value\" class=\"form-control\" id=\"{{field.name}}\" placeholder=\"{{field.placeholder}}\"/>\n        </div>\n        <div ng-switch-when=\"boolean\">\n          <div class=\"checkbox\">\n            <label for=\"{{field.name}}\">\n              <input type=\"checkbox\" ng-model=\"field.value\" id=\"{{field.name}}\" placeholder=\"{{field.placeholder}}\"/> {{field.label}}\n            </label>\n          </div>\n        </div>\n      </div>\n\n      </div>\n    </div>\n    <div class=\"row\">\n      <div class=\"form-group\">\n        <button class=\"btn\" ng-click=\"submitAction()\">[[submitText]]</button>\n      </div>\n    </div>\n\n</div>\n"

/***/ },
/* 21 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = "<div class=\"table-responsive\">\n    <table class=\"table table-striped\">\n        <thead>\n            <tr>\n                <th>#</th>\n                <th ng-repeat=\"field in fields\" ng-bind=\"field.label\"></th>\n                <th>Actions</th>\n            </tr>\n        </thead>\n        <tbody>\n            <tr ng-repeat=\"item in items\" ng-class=\"{highlight: item==selected}\">\n                <td ng-bind=\"$index+1\"></td>\n                <td ng-repeat=\"field in fields\">\n                     <div ng-switch on=\"field.type\">\n                        <div ng-switch-when=\"text\" ng-bind=\"item[field.name]\">\n                        </div>\n                        <div ng-switch-when=\"boolean\">\n                            <a href=\"#\" class=\"table-boolean glyphicon\"\n                             ng-class=\"item[field.name] ? 'glyphicon-ok' : 'glyphicon-remove'\"></a>\n                        </div>\n                     </div>\n                </td>\n                <td>\n                    <!-- expression inside the ngClick: we delegate in the parent scope the updateAction by passing in the current item as 'item', which becomes an scoped value in the parent scope of this directive. Therefore, 'item' will be available in the parent scope to manipulate - Use of '&' in the directive to achieve this -->\n                    <a ng-if=\"isUpdateActionDefined\" href=\"#\" ng-click=\"updateAction({item: item})\"><span class=\"glyphicon glyphicon-pencil\"></span>&nbsp;</a>\n                    <!-- TODO: delete action -->\n                    <a ng-if=\"isDeleteActionDefined\"><span class=\"glyphicon glyphicon-remove\"></span></a>\n                </td>\n            </tr>\n        </tbody>\n    </table>\n</div>"

/***/ },
/* 22 */
/***/ function(module, exports, __webpack_require__) {

	//! moment.js locale configuration
	//! locale : austrian german (de-at)
	//! author : lluchs : https://github.com/lluchs
	//! author: Menelion Elensúle: https://github.com/Oire
	//! author : Martin Groller : https://github.com/MadMG
	
	(function (global, factory) {
	   true ? factory(__webpack_require__(16)) :
	   typeof define === 'function' && define.amd ? define(['moment'], factory) :
	   factory(global.moment)
	}(this, function (moment) { 'use strict';
	
	
	    function processRelativeTime(number, withoutSuffix, key, isFuture) {
	        var format = {
	            'm': ['eine Minute', 'einer Minute'],
	            'h': ['eine Stunde', 'einer Stunde'],
	            'd': ['ein Tag', 'einem Tag'],
	            'dd': [number + ' Tage', number + ' Tagen'],
	            'M': ['ein Monat', 'einem Monat'],
	            'MM': [number + ' Monate', number + ' Monaten'],
	            'y': ['ein Jahr', 'einem Jahr'],
	            'yy': [number + ' Jahre', number + ' Jahren']
	        };
	        return withoutSuffix ? format[key][0] : format[key][1];
	    }
	
	    var de_at = moment.defineLocale('de-at', {
	        months : 'Jänner_Februar_März_April_Mai_Juni_Juli_August_September_Oktober_November_Dezember'.split('_'),
	        monthsShort : 'Jän._Febr._Mrz._Apr._Mai_Jun._Jul._Aug._Sept._Okt._Nov._Dez.'.split('_'),
	        weekdays : 'Sonntag_Montag_Dienstag_Mittwoch_Donnerstag_Freitag_Samstag'.split('_'),
	        weekdaysShort : 'So._Mo._Di._Mi._Do._Fr._Sa.'.split('_'),
	        weekdaysMin : 'So_Mo_Di_Mi_Do_Fr_Sa'.split('_'),
	        longDateFormat : {
	            LT: 'HH:mm',
	            LTS: 'HH:mm:ss',
	            L : 'DD.MM.YYYY',
	            LL : 'D. MMMM YYYY',
	            LLL : 'D. MMMM YYYY LT',
	            LLLL : 'dddd, D. MMMM YYYY LT'
	        },
	        calendar : {
	            sameDay: '[Heute um] LT [Uhr]',
	            sameElse: 'L',
	            nextDay: '[Morgen um] LT [Uhr]',
	            nextWeek: 'dddd [um] LT [Uhr]',
	            lastDay: '[Gestern um] LT [Uhr]',
	            lastWeek: '[letzten] dddd [um] LT [Uhr]'
	        },
	        relativeTime : {
	            future : 'in %s',
	            past : 'vor %s',
	            s : 'ein paar Sekunden',
	            m : processRelativeTime,
	            mm : '%d Minuten',
	            h : processRelativeTime,
	            hh : '%d Stunden',
	            d : processRelativeTime,
	            dd : processRelativeTime,
	            M : processRelativeTime,
	            MM : processRelativeTime,
	            y : processRelativeTime,
	            yy : processRelativeTime
	        },
	        ordinalParse: /\d{1,2}\./,
	        ordinal : '%d.',
	        week : {
	            dow : 1, // Monday is the first day of the week.
	            doy : 4  // The week that contains Jan 4th is the first week of the year.
	        }
	    });
	
	    return de_at;
	
	}));

/***/ },
/* 23 */
/***/ function(module, exports, __webpack_require__) {

	//! moment.js locale configuration
	//! locale : german (de)
	//! author : lluchs : https://github.com/lluchs
	//! author: Menelion Elensúle: https://github.com/Oire
	
	(function (global, factory) {
	   true ? factory(__webpack_require__(16)) :
	   typeof define === 'function' && define.amd ? define(['moment'], factory) :
	   factory(global.moment)
	}(this, function (moment) { 'use strict';
	
	
	    function processRelativeTime(number, withoutSuffix, key, isFuture) {
	        var format = {
	            'm': ['eine Minute', 'einer Minute'],
	            'h': ['eine Stunde', 'einer Stunde'],
	            'd': ['ein Tag', 'einem Tag'],
	            'dd': [number + ' Tage', number + ' Tagen'],
	            'M': ['ein Monat', 'einem Monat'],
	            'MM': [number + ' Monate', number + ' Monaten'],
	            'y': ['ein Jahr', 'einem Jahr'],
	            'yy': [number + ' Jahre', number + ' Jahren']
	        };
	        return withoutSuffix ? format[key][0] : format[key][1];
	    }
	
	    var de = moment.defineLocale('de', {
	        months : 'Januar_Februar_März_April_Mai_Juni_Juli_August_September_Oktober_November_Dezember'.split('_'),
	        monthsShort : 'Jan._Febr._Mrz._Apr._Mai_Jun._Jul._Aug._Sept._Okt._Nov._Dez.'.split('_'),
	        weekdays : 'Sonntag_Montag_Dienstag_Mittwoch_Donnerstag_Freitag_Samstag'.split('_'),
	        weekdaysShort : 'So._Mo._Di._Mi._Do._Fr._Sa.'.split('_'),
	        weekdaysMin : 'So_Mo_Di_Mi_Do_Fr_Sa'.split('_'),
	        longDateFormat : {
	            LT: 'HH:mm',
	            LTS: 'HH:mm:ss',
	            L : 'DD.MM.YYYY',
	            LL : 'D. MMMM YYYY',
	            LLL : 'D. MMMM YYYY LT',
	            LLLL : 'dddd, D. MMMM YYYY LT'
	        },
	        calendar : {
	            sameDay: '[Heute um] LT [Uhr]',
	            sameElse: 'L',
	            nextDay: '[Morgen um] LT [Uhr]',
	            nextWeek: 'dddd [um] LT [Uhr]',
	            lastDay: '[Gestern um] LT [Uhr]',
	            lastWeek: '[letzten] dddd [um] LT [Uhr]'
	        },
	        relativeTime : {
	            future : 'in %s',
	            past : 'vor %s',
	            s : 'ein paar Sekunden',
	            m : processRelativeTime,
	            mm : '%d Minuten',
	            h : processRelativeTime,
	            hh : '%d Stunden',
	            d : processRelativeTime,
	            dd : processRelativeTime,
	            M : processRelativeTime,
	            MM : processRelativeTime,
	            y : processRelativeTime,
	            yy : processRelativeTime
	        },
	        ordinalParse: /\d{1,2}\./,
	        ordinal : '%d.',
	        week : {
	            dow : 1, // Monday is the first day of the week.
	            doy : 4  // The week that contains Jan 4th is the first week of the year.
	        }
	    });
	
	    return de;
	
	}));

/***/ },
/* 24 */
/***/ function(module, exports, __webpack_require__) {

	//! moment.js locale configuration
	//! locale : canadian french (fr-ca)
	//! author : Jonathan Abourbih : https://github.com/jonbca
	
	(function (global, factory) {
	   true ? factory(__webpack_require__(16)) :
	   typeof define === 'function' && define.amd ? define(['moment'], factory) :
	   factory(global.moment)
	}(this, function (moment) { 'use strict';
	
	
	    var fr_ca = moment.defineLocale('fr-ca', {
	        months : 'janvier_février_mars_avril_mai_juin_juillet_août_septembre_octobre_novembre_décembre'.split('_'),
	        monthsShort : 'janv._févr._mars_avr._mai_juin_juil._août_sept._oct._nov._déc.'.split('_'),
	        weekdays : 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
	        weekdaysShort : 'dim._lun._mar._mer._jeu._ven._sam.'.split('_'),
	        weekdaysMin : 'Di_Lu_Ma_Me_Je_Ve_Sa'.split('_'),
	        longDateFormat : {
	            LT : 'HH:mm',
	            LTS : 'LT:ss',
	            L : 'YYYY-MM-DD',
	            LL : 'D MMMM YYYY',
	            LLL : 'D MMMM YYYY LT',
	            LLLL : 'dddd D MMMM YYYY LT'
	        },
	        calendar : {
	            sameDay: '[Aujourd\'hui à] LT',
	            nextDay: '[Demain à] LT',
	            nextWeek: 'dddd [à] LT',
	            lastDay: '[Hier à] LT',
	            lastWeek: 'dddd [dernier à] LT',
	            sameElse: 'L'
	        },
	        relativeTime : {
	            future : 'dans %s',
	            past : 'il y a %s',
	            s : 'quelques secondes',
	            m : 'une minute',
	            mm : '%d minutes',
	            h : 'une heure',
	            hh : '%d heures',
	            d : 'un jour',
	            dd : '%d jours',
	            M : 'un mois',
	            MM : '%d mois',
	            y : 'un an',
	            yy : '%d ans'
	        },
	        ordinalParse: /\d{1,2}(er|)/,
	        ordinal : function (number) {
	            return number + (number === 1 ? 'er' : '');
	        }
	    });
	
	    return fr_ca;
	
	}));

/***/ },
/* 25 */
/***/ function(module, exports, __webpack_require__) {

	//! moment.js locale configuration
	//! locale : french (fr)
	//! author : John Fischer : https://github.com/jfroffice
	
	(function (global, factory) {
	   true ? factory(__webpack_require__(16)) :
	   typeof define === 'function' && define.amd ? define(['moment'], factory) :
	   factory(global.moment)
	}(this, function (moment) { 'use strict';
	
	
	    var fr = moment.defineLocale('fr', {
	        months : 'janvier_février_mars_avril_mai_juin_juillet_août_septembre_octobre_novembre_décembre'.split('_'),
	        monthsShort : 'janv._févr._mars_avr._mai_juin_juil._août_sept._oct._nov._déc.'.split('_'),
	        weekdays : 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
	        weekdaysShort : 'dim._lun._mar._mer._jeu._ven._sam.'.split('_'),
	        weekdaysMin : 'Di_Lu_Ma_Me_Je_Ve_Sa'.split('_'),
	        longDateFormat : {
	            LT : 'HH:mm',
	            LTS : 'LT:ss',
	            L : 'DD/MM/YYYY',
	            LL : 'D MMMM YYYY',
	            LLL : 'D MMMM YYYY LT',
	            LLLL : 'dddd D MMMM YYYY LT'
	        },
	        calendar : {
	            sameDay: '[Aujourd\'hui à] LT',
	            nextDay: '[Demain à] LT',
	            nextWeek: 'dddd [à] LT',
	            lastDay: '[Hier à] LT',
	            lastWeek: 'dddd [dernier à] LT',
	            sameElse: 'L'
	        },
	        relativeTime : {
	            future : 'dans %s',
	            past : 'il y a %s',
	            s : 'quelques secondes',
	            m : 'une minute',
	            mm : '%d minutes',
	            h : 'une heure',
	            hh : '%d heures',
	            d : 'un jour',
	            dd : '%d jours',
	            M : 'un mois',
	            MM : '%d mois',
	            y : 'un an',
	            yy : '%d ans'
	        },
	        ordinalParse: /\d{1,2}(er|)/,
	        ordinal : function (number) {
	            return number + (number === 1 ? 'er' : '');
	        },
	        week : {
	            dow : 1, // Monday is the first day of the week.
	            doy : 4  // The week that contains Jan 4th is the first week of the year.
	        }
	    });
	
	    return fr;
	
	}));

/***/ },
/* 26 */
/***/ function(module, exports, __webpack_require__) {

	//! moment.js locale configuration
	//! locale : hungarian (hu)
	//! author : Adam Brunner : https://github.com/adambrunner
	
	(function (global, factory) {
	   true ? factory(__webpack_require__(16)) :
	   typeof define === 'function' && define.amd ? define(['moment'], factory) :
	   factory(global.moment)
	}(this, function (moment) { 'use strict';
	
	
	    var weekEndings = 'vasárnap hétfőn kedden szerdán csütörtökön pénteken szombaton'.split(' ');
	    function translate(number, withoutSuffix, key, isFuture) {
	        var num = number,
	            suffix;
	        switch (key) {
	        case 's':
	            return (isFuture || withoutSuffix) ? 'néhány másodperc' : 'néhány másodperce';
	        case 'm':
	            return 'egy' + (isFuture || withoutSuffix ? ' perc' : ' perce');
	        case 'mm':
	            return num + (isFuture || withoutSuffix ? ' perc' : ' perce');
	        case 'h':
	            return 'egy' + (isFuture || withoutSuffix ? ' óra' : ' órája');
	        case 'hh':
	            return num + (isFuture || withoutSuffix ? ' óra' : ' órája');
	        case 'd':
	            return 'egy' + (isFuture || withoutSuffix ? ' nap' : ' napja');
	        case 'dd':
	            return num + (isFuture || withoutSuffix ? ' nap' : ' napja');
	        case 'M':
	            return 'egy' + (isFuture || withoutSuffix ? ' hónap' : ' hónapja');
	        case 'MM':
	            return num + (isFuture || withoutSuffix ? ' hónap' : ' hónapja');
	        case 'y':
	            return 'egy' + (isFuture || withoutSuffix ? ' év' : ' éve');
	        case 'yy':
	            return num + (isFuture || withoutSuffix ? ' év' : ' éve');
	        }
	        return '';
	    }
	    function week(isFuture) {
	        return (isFuture ? '' : '[múlt] ') + '[' + weekEndings[this.day()] + '] LT[-kor]';
	    }
	
	    var hu = moment.defineLocale('hu', {
	        months : 'január_február_március_április_május_június_július_augusztus_szeptember_október_november_december'.split('_'),
	        monthsShort : 'jan_feb_márc_ápr_máj_jún_júl_aug_szept_okt_nov_dec'.split('_'),
	        weekdays : 'vasárnap_hétfő_kedd_szerda_csütörtök_péntek_szombat'.split('_'),
	        weekdaysShort : 'vas_hét_kedd_sze_csüt_pén_szo'.split('_'),
	        weekdaysMin : 'v_h_k_sze_cs_p_szo'.split('_'),
	        longDateFormat : {
	            LT : 'H:mm',
	            LTS : 'LT:ss',
	            L : 'YYYY.MM.DD.',
	            LL : 'YYYY. MMMM D.',
	            LLL : 'YYYY. MMMM D., LT',
	            LLLL : 'YYYY. MMMM D., dddd LT'
	        },
	        meridiemParse: /de|du/i,
	        isPM: function (input) {
	            return input.charAt(1).toLowerCase() === 'u';
	        },
	        meridiem : function (hours, minutes, isLower) {
	            if (hours < 12) {
	                return isLower === true ? 'de' : 'DE';
	            } else {
	                return isLower === true ? 'du' : 'DU';
	            }
	        },
	        calendar : {
	            sameDay : '[ma] LT[-kor]',
	            nextDay : '[holnap] LT[-kor]',
	            nextWeek : function () {
	                return week.call(this, true);
	            },
	            lastDay : '[tegnap] LT[-kor]',
	            lastWeek : function () {
	                return week.call(this, false);
	            },
	            sameElse : 'L'
	        },
	        relativeTime : {
	            future : '%s múlva',
	            past : '%s',
	            s : translate,
	            m : translate,
	            mm : translate,
	            h : translate,
	            hh : translate,
	            d : translate,
	            dd : translate,
	            M : translate,
	            MM : translate,
	            y : translate,
	            yy : translate
	        },
	        ordinalParse: /\d{1,2}\./,
	        ordinal : '%d.',
	        week : {
	            dow : 1, // Monday is the first day of the week.
	            doy : 7  // The week that contains Jan 1st is the first week of the year.
	        }
	    });
	
	    return hu;
	
	}));

/***/ }
/******/ ])
//# sourceMappingURL=init.js.map