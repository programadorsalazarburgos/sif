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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/cdm/active-users.js":
/*!******************************************!*\
  !*** ./resources/js/cdm/active-users.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

!function (t) {
  var e = {};

  function i(n) {
    if (e[n]) return e[n].exports;
    var s = e[n] = {
      i: n,
      l: !1,
      exports: {}
    };
    return t[n].call(s.exports, s, s.exports, i), s.l = !0, s.exports;
  }

  i.m = t, i.c = e, i.d = function (t, e, n) {
    i.o(t, e) || Object.defineProperty(t, e, {
      enumerable: !0,
      get: n
    });
  }, i.r = function (t) {
    "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {
      value: "Module"
    }), Object.defineProperty(t, "__esModule", {
      value: !0
    });
  }, i.t = function (t, e) {
    if (1 & e && (t = i(t)), 8 & e) return t;
    if (4 & e && "object" == _typeof(t) && t && t.__esModule) return t;
    var n = Object.create(null);
    if (i.r(n), Object.defineProperty(n, "default", {
      enumerable: !0,
      value: t
    }), 2 & e && "string" != typeof t) for (var s in t) {
      i.d(n, s, function (e) {
        return t[e];
      }.bind(null, s));
    }
    return n;
  }, i.n = function (t) {
    var e = t && t.__esModule ? function () {
      return t["default"];
    } : function () {
      return t;
    };
    return i.d(e, "a", e), e;
  }, i.o = function (t, e) {
    return Object.prototype.hasOwnProperty.call(t, e);
  }, i.p = "", i(i.s = 40);
}({
  40: function _(t, e) {
    gapi.analytics.ready(function () {
      gapi.analytics.createComponent("ActiveUsers", {
        initialize: function initialize() {
          this.activeUsers = 0, gapi.analytics.auth.once("signOut", this.handleSignOut_.bind(this));
        },
        execute: function execute() {
          this.polling_ && this.stop(), this.render_(), gapi.analytics.auth.isAuthorized() ? this.pollActiveUsers_() : gapi.analytics.auth.once("signIn", this.pollActiveUsers_.bind(this));
        },
        stop: function stop() {
          clearTimeout(this.timeout_), this.polling_ = !1, this.emit("stop", {
            activeUsers: this.activeUsers
          });
        },
        render_: function render_() {
          var t = this.get();
          this.container = "string" == typeof t.container ? document.getElementById(t.container) : t.container, this.container.innerHTML = t.template || this.template, this.container.querySelector("b").innerHTML = this.activeUsers;
        },
        pollActiveUsers_: function pollActiveUsers_() {
          var t = this.get(),
              e = 1e3 * (t.pollingInterval || 5);
          if (isNaN(e) || e < 5e3) throw new Error("Frequency must be 5 seconds or more.");
          this.polling_ = !0, gapi.client.analytics.data.realtime.get({
            ids: t.ids,
            metrics: "rt:activeUsers"
          }).then(function (t) {
            var i = t.result,
                n = i.totalResults ? +i.rows[0][0] : 0,
                s = this.activeUsers;
            this.emit("success", {
              activeUsers: this.activeUsers
            }), n != s && (this.activeUsers = n, this.onChange_(n - s)), 1 == this.polling_ && (this.timeout_ = setTimeout(this.pollActiveUsers_.bind(this), e));
          }.bind(this));
        },
        onChange_: function onChange_(t) {
          var e = this.container.querySelector("b");
          e && (e.innerHTML = this.activeUsers), this.emit("change", {
            activeUsers: this.activeUsers,
            delta: t
          }), t > 0 ? this.emit("increase", {
            activeUsers: this.activeUsers,
            delta: t
          }) : this.emit("decrease", {
            activeUsers: this.activeUsers,
            delta: t
          });
        },
        handleSignOut_: function handleSignOut_() {
          this.stop(), gapi.analytics.auth.once("signIn", this.handleSignIn_.bind(this));
        },
        handleSignIn_: function handleSignIn_() {
          this.pollActiveUsers_(), gapi.analytics.auth.once("signOut", this.handleSignOut_.bind(this));
        },
        template: '<div class="ActiveUsers">Active Users: <b class="ActiveUsers-value"></b></div>'
      });
    });
  }
});

/***/ }),

/***/ 4:
/*!************************************************!*\
  !*** multi ./resources/js/cdm/active-users.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\sif\framework\resources\js\cdm\active-users.js */"./resources/js/cdm/active-users.js");


/***/ })

/******/ });