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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./wp-content/themes/NeOntPartners/js/scripts.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./wp-content/themes/NeOntPartners/js/modules/StickyHeader.js":
/*!********************************************************************!*\
  !*** ./wp-content/themes/NeOntPartners/js/modules/StickyHeader.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nvar StickyHeader =\n/*#__PURE__*/\nfunction () {\n  function StickyHeader() {\n    _classCallCheck(this, StickyHeader);\n\n    this.stickyClass = document.getElementsByClassName(\"customize-support\");\n    this.stickyId = document.getElementById(\"sticky\");\n    this.events();\n  }\n\n  _createClass(StickyHeader, [{\n    key: \"events\",\n    value: function events() {\n      window.addEventListener(\"load\", this.pageFullyLoaded.bind(this), false);\n    }\n  }, {\n    key: \"pageFullyLoaded\",\n    value: function pageFullyLoaded(e) {\n      this.stickyId.className = this.stickyClass[0] ? \"admin-bar\" : \"sticky-header\";\n    }\n  }]);\n\n  return StickyHeader;\n}();\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (StickyHeader);\n\n//# sourceURL=webpack:///./wp-content/themes/NeOntPartners/js/modules/StickyHeader.js?");

/***/ }),

/***/ "./wp-content/themes/NeOntPartners/js/modules/search.js":
/*!**************************************************************!*\
  !*** ./wp-content/themes/NeOntPartners/js/modules/search.js ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nvar Search =\n/*#__PURE__*/\nfunction () {\n  // 1. describe and create/initiate our object\n  function Search() {\n    _classCallCheck(this, Search);\n\n    this.openSearch = document.getElementById(\"main-search\");\n    this.closeSearch = document.getElementById(\"close-main-search\");\n    this.searchOverlay = document.getElementById(\"search-overlay\");\n    this.events();\n  } // 2. events\n\n\n  _createClass(Search, [{\n    key: \"events\",\n    value: function events() {\n      this.openSearch.addEventListener('click', this.openOverlay.bind(this));\n      this.closeSearch.addEventListener('click', this.closeOverlay.bind(this));\n    } // 3. methods (function, action...)s\n\n  }, {\n    key: \"openOverlay\",\n    value: function openOverlay() {\n      this.searchOverlay.style.display = \"block\";\n    }\n  }, {\n    key: \"closeOverlay\",\n    value: function closeOverlay() {\n      this.searchOverlay.style.display = \"none\";\n    }\n  }]);\n\n  return Search;\n}();\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (Search);\n\n//# sourceURL=webpack:///./wp-content/themes/NeOntPartners/js/modules/search.js?");

/***/ }),

/***/ "./wp-content/themes/NeOntPartners/js/scripts.js":
/*!*******************************************************!*\
  !*** ./wp-content/themes/NeOntPartners/js/scripts.js ***!
  \*******************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _modules_search__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/search */ \"./wp-content/themes/NeOntPartners/js/modules/search.js\");\n/* harmony import */ var _modules_StickyHeader__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/StickyHeader */ \"./wp-content/themes/NeOntPartners/js/modules/StickyHeader.js\");\n//3rd party libraries\n//Modules / Classes\n\n //instantiate a new object usign our modules/classes\n//var search = new Search\n\nvar stickyHeader = new _modules_StickyHeader__WEBPACK_IMPORTED_MODULE_1__[\"default\"]();\n\n//# sourceURL=webpack:///./wp-content/themes/NeOntPartners/js/scripts.js?");

/***/ })

/******/ });