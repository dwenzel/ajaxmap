/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
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
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/resources/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/assets-bsb-map/scripts/bsb-map.js":
/*!***********************************************!*\
  !*** ./src/assets-bsb-map/scripts/bsb-map.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var _ = {
  BSB_ajaxMapConfigData: function BSB_ajaxMapConfigData() {
    //hold the api for ajaxmap
    window.ajaxMapConfig = {}; //function will be fired by clicking on a marker
    //gets the mapEntry and the place

    window.ajaxMapConfig.onMarkerClick = function (mapEntry, place) {
      var treeNode = place.placeInstance.treeNode; //has all domNodes

      console.log(treeNode); //  $('#tablediv').scrollTop($('#' + id).offset().top);
    }; //function to render the markup
    //gets the data


    window.ajaxMapConfig.renderPlaceTreesItem = function (data) {
      // const mapId = data.source.mapId
      console.log(data.node.data);
      var markup = 'hello' + data.node.data.address;
      return markup;
    };
  }
};

_.BSB_ajaxMapConfigData();

/***/ }),

/***/ "./src/assets-bsb-map/styles/bsb-map.scss":
/*!************************************************!*\
  !*** ./src/assets-bsb-map/styles/bsb-map.scss ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ 1:
/*!**********************************************************************************************!*\
  !*** multi ./src/assets-bsb-map/scripts/bsb-map.js ./src/assets-bsb-map/styles/bsb-map.scss ***!
  \**********************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/d.eggermann/Projekte/ajaxmap-ssh/FE-Development/src/assets-bsb-map/scripts/bsb-map.js */"./src/assets-bsb-map/scripts/bsb-map.js");
module.exports = __webpack_require__(/*! /Users/d.eggermann/Projekte/ajaxmap-ssh/FE-Development/src/assets-bsb-map/styles/bsb-map.scss */"./src/assets-bsb-map/styles/bsb-map.scss");


/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vc3JjL2Fzc2V0cy1ic2ItbWFwL3NjcmlwdHMvYnNiLW1hcC5qcyIsIndlYnBhY2s6Ly8vLi9zcmMvYXNzZXRzLWJzYi1tYXAvc3R5bGVzL2JzYi1tYXAuc2NzcyJdLCJuYW1lcyI6WyJfIiwiQlNCX2FqYXhNYXBDb25maWdEYXRhIiwid2luZG93IiwiYWpheE1hcENvbmZpZyIsIm9uTWFya2VyQ2xpY2siLCJtYXBFbnRyeSIsInBsYWNlIiwidHJlZU5vZGUiLCJwbGFjZUluc3RhbmNlIiwiY29uc29sZSIsImxvZyIsInJlbmRlclBsYWNlVHJlZXNJdGVtIiwiZGF0YSIsIm5vZGUiLCJtYXJrdXAiLCJhZGRyZXNzIl0sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7OztBQUdBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxrREFBMEMsZ0NBQWdDO0FBQzFFO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsZ0VBQXdELGtCQUFrQjtBQUMxRTtBQUNBLHlEQUFpRCxjQUFjO0FBQy9EOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxpREFBeUMsaUNBQWlDO0FBQzFFLHdIQUFnSCxtQkFBbUIsRUFBRTtBQUNySTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLG1DQUEyQiwwQkFBMEIsRUFBRTtBQUN2RCx5Q0FBaUMsZUFBZTtBQUNoRDtBQUNBO0FBQ0E7O0FBRUE7QUFDQSw4REFBc0QsK0RBQStEOztBQUVySDtBQUNBOzs7QUFHQTtBQUNBOzs7Ozs7Ozs7Ozs7QUNsRkEsSUFBTUEsQ0FBQyxHQUFHO0FBQ05DLHVCQUFxQixFQUFFLGlDQUFNO0FBRXpCO0FBQ0FDLFVBQU0sQ0FBQ0MsYUFBUCxHQUF1QixFQUF2QixDQUh5QixDQUt6QjtBQUNBOztBQUNBRCxVQUFNLENBQUNDLGFBQVAsQ0FBcUJDLGFBQXJCLEdBQXFDLFVBQVNDLFFBQVQsRUFBbUJDLEtBQW5CLEVBQTBCO0FBQzNELFVBQU1DLFFBQVEsR0FBR0QsS0FBSyxDQUFDRSxhQUFOLENBQW9CRCxRQUFyQyxDQUQyRCxDQUNkOztBQUU3Q0UsYUFBTyxDQUFDQyxHQUFSLENBQVlILFFBQVosRUFIMkQsQ0FJM0Q7QUFDSCxLQUxELENBUHlCLENBY3pCO0FBQ0E7OztBQUNBTCxVQUFNLENBQUNDLGFBQVAsQ0FBcUJRLG9CQUFyQixHQUE0QyxVQUFDQyxJQUFELEVBQVU7QUFDbEQ7QUFFQUgsYUFBTyxDQUFDQyxHQUFSLENBQVlFLElBQUksQ0FBQ0MsSUFBTCxDQUFVRCxJQUF0QjtBQUVBLFVBQUlFLE1BQU0sR0FBRyxVQUFRRixJQUFJLENBQUNDLElBQUwsQ0FBVUQsSUFBVixDQUFlRyxPQUFwQztBQUVBLGFBQU9ELE1BQVA7QUFDSCxLQVJEO0FBVUg7QUEzQkssQ0FBVjs7QUE4QkFkLENBQUMsQ0FBQ0MscUJBQUYsRzs7Ozs7Ozs7Ozs7QUM5QkEsdUMiLCJmaWxlIjoianMvYnNiLW1hcC5qcyIsInNvdXJjZXNDb250ZW50IjpbIiBcdC8vIFRoZSBtb2R1bGUgY2FjaGVcbiBcdHZhciBpbnN0YWxsZWRNb2R1bGVzID0ge307XG5cbiBcdC8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG4gXHRmdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cbiBcdFx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG4gXHRcdGlmKGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdKSB7XG4gXHRcdFx0cmV0dXJuIGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdLmV4cG9ydHM7XG4gXHRcdH1cbiBcdFx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcbiBcdFx0dmFyIG1vZHVsZSA9IGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdID0ge1xuIFx0XHRcdGk6IG1vZHVsZUlkLFxuIFx0XHRcdGw6IGZhbHNlLFxuIFx0XHRcdGV4cG9ydHM6IHt9XG4gXHRcdH07XG5cbiBcdFx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG4gXHRcdG1vZHVsZXNbbW9kdWxlSWRdLmNhbGwobW9kdWxlLmV4cG9ydHMsIG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG4gXHRcdC8vIEZsYWcgdGhlIG1vZHVsZSBhcyBsb2FkZWRcbiBcdFx0bW9kdWxlLmwgPSB0cnVlO1xuXG4gXHRcdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG4gXHRcdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbiBcdH1cblxuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5tID0gbW9kdWxlcztcblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGUgY2FjaGVcbiBcdF9fd2VicGFja19yZXF1aXJlX18uYyA9IGluc3RhbGxlZE1vZHVsZXM7XG5cbiBcdC8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb24gZm9yIGhhcm1vbnkgZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kID0gZnVuY3Rpb24oZXhwb3J0cywgbmFtZSwgZ2V0dGVyKSB7XG4gXHRcdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZXhwb3J0cywgbmFtZSkpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgbmFtZSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IGdldHRlciB9KTtcbiBcdFx0fVxuIFx0fTtcblxuIFx0Ly8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuIFx0XHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcbiBcdFx0fVxuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xuIFx0fTtcblxuIFx0Ly8gY3JlYXRlIGEgZmFrZSBuYW1lc3BhY2Ugb2JqZWN0XG4gXHQvLyBtb2RlICYgMTogdmFsdWUgaXMgYSBtb2R1bGUgaWQsIHJlcXVpcmUgaXRcbiBcdC8vIG1vZGUgJiAyOiBtZXJnZSBhbGwgcHJvcGVydGllcyBvZiB2YWx1ZSBpbnRvIHRoZSBuc1xuIFx0Ly8gbW9kZSAmIDQ6IHJldHVybiB2YWx1ZSB3aGVuIGFscmVhZHkgbnMgb2JqZWN0XG4gXHQvLyBtb2RlICYgOHwxOiBiZWhhdmUgbGlrZSByZXF1aXJlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnQgPSBmdW5jdGlvbih2YWx1ZSwgbW9kZSkge1xuIFx0XHRpZihtb2RlICYgMSkgdmFsdWUgPSBfX3dlYnBhY2tfcmVxdWlyZV9fKHZhbHVlKTtcbiBcdFx0aWYobW9kZSAmIDgpIHJldHVybiB2YWx1ZTtcbiBcdFx0aWYoKG1vZGUgJiA0KSAmJiB0eXBlb2YgdmFsdWUgPT09ICdvYmplY3QnICYmIHZhbHVlICYmIHZhbHVlLl9fZXNNb2R1bGUpIHJldHVybiB2YWx1ZTtcbiBcdFx0dmFyIG5zID0gT2JqZWN0LmNyZWF0ZShudWxsKTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yKG5zKTtcbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KG5zLCAnZGVmYXVsdCcsIHsgZW51bWVyYWJsZTogdHJ1ZSwgdmFsdWU6IHZhbHVlIH0pO1xuIFx0XHRpZihtb2RlICYgMiAmJiB0eXBlb2YgdmFsdWUgIT0gJ3N0cmluZycpIGZvcih2YXIga2V5IGluIHZhbHVlKSBfX3dlYnBhY2tfcmVxdWlyZV9fLmQobnMsIGtleSwgZnVuY3Rpb24oa2V5KSB7IHJldHVybiB2YWx1ZVtrZXldOyB9LmJpbmQobnVsbCwga2V5KSk7XG4gXHRcdHJldHVybiBucztcbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiL3Jlc291cmNlcy9cIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IDEpO1xuIiwiY29uc3QgXyA9IHtcbiAgICBCU0JfYWpheE1hcENvbmZpZ0RhdGE6ICgpID0+IHtcblxuICAgICAgICAvL2hvbGQgdGhlIGFwaSBmb3IgYWpheG1hcFxuICAgICAgICB3aW5kb3cuYWpheE1hcENvbmZpZyA9IHt9O1xuXG4gICAgICAgIC8vZnVuY3Rpb24gd2lsbCBiZSBmaXJlZCBieSBjbGlja2luZyBvbiBhIG1hcmtlclxuICAgICAgICAvL2dldHMgdGhlIG1hcEVudHJ5IGFuZCB0aGUgcGxhY2VcbiAgICAgICAgd2luZG93LmFqYXhNYXBDb25maWcub25NYXJrZXJDbGljayA9IGZ1bmN0aW9uKG1hcEVudHJ5LCBwbGFjZSkge1xuICAgICAgICAgICAgY29uc3QgdHJlZU5vZGUgPSBwbGFjZS5wbGFjZUluc3RhbmNlLnRyZWVOb2RlLy9oYXMgYWxsIGRvbU5vZGVzXG5cbiAgICAgICAgICAgIGNvbnNvbGUubG9nKHRyZWVOb2RlKTtcbiAgICAgICAgICAgIC8vICAkKCcjdGFibGVkaXYnKS5zY3JvbGxUb3AoJCgnIycgKyBpZCkub2Zmc2V0KCkudG9wKTtcbiAgICAgICAgfVxuXG4gICAgICAgIC8vZnVuY3Rpb24gdG8gcmVuZGVyIHRoZSBtYXJrdXBcbiAgICAgICAgLy9nZXRzIHRoZSBkYXRhXG4gICAgICAgIHdpbmRvdy5hamF4TWFwQ29uZmlnLnJlbmRlclBsYWNlVHJlZXNJdGVtID0gKGRhdGEpID0+IHtcbiAgICAgICAgICAgIC8vIGNvbnN0IG1hcElkID0gZGF0YS5zb3VyY2UubWFwSWRcblxuICAgICAgICAgICAgY29uc29sZS5sb2coZGF0YS5ub2RlLmRhdGEpO1xuXG4gICAgICAgICAgICBsZXQgbWFya3VwID0gJ2hlbGxvJytkYXRhLm5vZGUuZGF0YS5hZGRyZXNzO1xuXG4gICAgICAgICAgICByZXR1cm4gbWFya3VwO1xuICAgICAgICB9XG5cbiAgICB9XG59O1xuXG5fLkJTQl9hamF4TWFwQ29uZmlnRGF0YSgpO1xuXG5cblxuIiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luIl0sInNvdXJjZVJvb3QiOiIifQ==