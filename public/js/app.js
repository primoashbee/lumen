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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no exports provided */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/ashbeemorgado/devs/lumen/resources/js/app.js: Unexpected token (54:0)\n\n\u001b[0m \u001b[90m 52 | \u001b[39m\u001b[33mVue\u001b[39m\u001b[33m.\u001b[39mcomponent(\u001b[32m'deposit-dashboard'\u001b[39m\u001b[33m,\u001b[39m require(\u001b[32m'./components/DepositDashboardComponent.vue'\u001b[39m)\u001b[33m.\u001b[39m\u001b[36mdefault\u001b[39m)\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 53 | \u001b[39m\u001b[33mVue\u001b[39m\u001b[33m.\u001b[39mcomponent(\u001b[32m'payment-methods'\u001b[39m\u001b[33m,\u001b[39m require(\u001b[32m'./components/PaymentMethodComponent.vue'\u001b[39m)\u001b[33m.\u001b[39m\u001b[36mdefault\u001b[39m)\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 54 | \u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<\u001b[39m \u001b[33mHEAD\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    | \u001b[39m\u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 55 | \u001b[39m\u001b[33mVue\u001b[39m\u001b[33m.\u001b[39mcomponent(\u001b[32m'payment-methods-dashboard'\u001b[39m\u001b[33m,\u001b[39m require(\u001b[32m'./components/PaymentMethodDashboardComponent.vue'\u001b[39m)\u001b[33m.\u001b[39m\u001b[36mdefault\u001b[39m)\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 56 | \u001b[39m\u001b[33m===\u001b[39m\u001b[33m===\u001b[39m\u001b[33m=\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 57 | \u001b[39m\u001b[33mVue\u001b[39m\u001b[33m.\u001b[39mcomponent(\u001b[32m'product-component'\u001b[39m\u001b[33m,\u001b[39m require(\u001b[32m'./components/ProductSelectComponent.vue'\u001b[39m)\u001b[33m.\u001b[39m\u001b[36mdefault\u001b[39m)\u001b[33m;\u001b[39m\u001b[0m\n    at Parser.raise (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:7044:17)\n    at Parser.unexpected (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:8422:16)\n    at Parser.parseExprAtom (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:9701:20)\n    at Parser.parseExprSubscripts (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:9287:23)\n    at Parser.parseMaybeUnary (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:9267:21)\n    at Parser.parseExprOps (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:9137:23)\n    at Parser.parseMaybeConditional (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:9110:23)\n    at Parser.parseMaybeAssign (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:9065:21)\n    at Parser.parseExpression (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:9017:23)\n    at Parser.parseStatementContent (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:10853:23)\n    at Parser.parseStatement (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:10724:17)\n    at Parser.parseBlockOrModuleBlockBody (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:11298:25)\n    at Parser.parseBlockBody (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:11285:10)\n    at Parser.parseTopLevel (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:10655:10)\n    at Parser.parse (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:12264:10)\n    at parse (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/parser/lib/index.js:12315:38)\n    at parser (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/core/lib/parser/index.js:54:34)\n    at parser.next (<anonymous>)\n    at normalizeFile (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/core/lib/transformation/normalize-file.js:93:38)\n    at normalizeFile.next (<anonymous>)\n    at run (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/core/lib/transformation/index.js:31:50)\n    at run.next (<anonymous>)\n    at Function.transform (/Users/ashbeemorgado/devs/lumen/node_modules/@babel/core/lib/transform.js:27:41)\n    at transform.next (<anonymous>)\n    at step (/Users/ashbeemorgado/devs/lumen/node_modules/gensync/index.js:254:32)\n    at /Users/ashbeemorgado/devs/lumen/node_modules/gensync/index.js:266:13\n    at async.call.result.err.err (/Users/ashbeemorgado/devs/lumen/node_modules/gensync/index.js:216:11)");

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/ashbeemorgado/devs/lumen/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /Users/ashbeemorgado/devs/lumen/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });