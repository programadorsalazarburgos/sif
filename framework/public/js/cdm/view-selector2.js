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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/cdm/view-selector2.js":
/*!********************************************!*\
  !*** ./resources/js/cdm/view-selector2.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var gapi = window.gapi = window.gapi || {};
gapi._bs = new Date().getTime();
(function () {
  /*
  Copyright The Closure Library Authors.
  SPDX-License-Identifier: Apache-2.0
  */
  var g = this || self,
      h = function h(a) {
    return a;
  };

  var m = function m() {
    this.g = "";
  };

  m.prototype.toString = function () {
    return "SafeStyle{" + this.g + "}";
  };

  m.prototype.a = function (a) {
    this.g = a;
  };

  new m().a("");

  var n = function n() {
    this.f = "";
  };

  n.prototype.toString = function () {
    return "SafeStyleSheet{" + this.f + "}";
  };

  n.prototype.a = function (a) {
    this.f = a;
  };

  new n().a("");
  /*
  gapi.loader.OBJECT_CREATE_TEST_OVERRIDE &&*/

  var q = window,
      v = document,
      aa = q.location,
      ba = function ba() {},
      ca = /\[native code\]/,
      x = function x(a, b, c) {
    return a[b] = a[b] || c;
  },
      da = function da(a) {
    a = a.sort();

    for (var b = [], c = void 0, d = 0; d < a.length; d++) {
      var e = a[d];
      e != c && b.push(e);
      c = e;
    }

    return b;
  },
      C = function C() {
    var a;
    if ((a = Object.create) && ca.test(a)) a = a(null);else {
      a = {};

      for (var b in a) {
        a[b] = void 0;
      }
    }
    return a;
  },
      D = x(q, "gapi", {});

  var E;
  E = x(q, "___jsl", C());
  x(E, "I", 0);
  x(E, "hel", 10);

  var F = function F() {
    var a = aa.href;
    if (E.dpo) var b = E.h;else {
      b = E.h;
      var c = /([#].*&|[#])jsh=([^&#]*)/g,
          d = /([?#].*&|[?#])jsh=([^&#]*)/g;
      if (a = a && (c.exec(a) || d.exec(a))) try {
        b = decodeURIComponent(a[2]);
      } catch (e) {}
    }
    return b;
  },
      ea = function ea(a) {
    var b = x(E, "PQ", []);
    E.PQ = [];
    var c = b.length;
    if (0 === c) a();else for (var d = 0, e = function e() {
      ++d === c && a();
    }, f = 0; f < c; f++) {
      b[f](e);
    }
  },
      G = function G(a) {
    return x(x(E, "H", C()), a, C());
  };

  var H = x(E, "perf", C()),
      K = x(H, "g", C()),
      fa = x(H, "i", C());
  x(H, "r", []);
  C();
  C();

  var L = function L(a, b, c) {
    var d = H.r;
    "function" === typeof d ? d(a, b, c) : d.push([a, b, c]);
  },
      N = function N(a, b, c) {
    b && 0 < b.length && (b = M(b), c && 0 < c.length && (b += "___" + M(c)), 28 < b.length && (b = b.substr(0, 28) + (b.length - 28)), c = b, b = x(fa, "_p", C()), x(b, c, C())[a] = new Date().getTime(), L(a, "_p", c));
  },
      M = function M(a) {
    return a.join("__").replace(/\./g, "_").replace(/\-/g, "_").replace(/,/g, "_");
  };

  var O = C(),
      P = [],
      S = function S(a) {
    throw Error("Bad hint" + (a ? ": " + a : ""));
  };

  P.push(["jsl", function (a) {
    for (var b in a) {
      if (Object.prototype.hasOwnProperty.call(a, b)) {
        var c = a[b];
        "object" == _typeof(c) ? E[b] = x(E, b, []).concat(c) : x(E, b, c);
      }
    }

    if (b = a.u) a = x(E, "us", []), a.push(b), (b = /^https:(.*)$/.exec(b)) && a.push("http:" + b[1]);
  }]);

  var ia = /^(\/[a-zA-Z0-9_\-]+)+$/,
      T = [/\/amp\//, /\/amp$/, /^\/amp$/],
      ja = /^[a-zA-Z0-9\-_\.,!]+$/,
      ka = /^gapi\.loaded_[0-9]+$/,
      la = /^[a-zA-Z0-9,._-]+$/,
      pa = function pa(a, b, c, d) {
    var e = a.split(";"),
        f = e.shift(),
        l = O[f],
        k = null;
    l ? k = l(e, b, c, d) : S("no hint processor for: " + f);
    k || S("failed to generate load url");
    b = k;
    c = b.match(ma);
    (d = b.match(na)) && 1 === d.length && oa.test(b) && c && 1 === c.length || S("failed sanity: " + a);
    return k;
  },
      ra = function ra(a, b, c, d) {
    a = qa(a);
    ka.test(c) || S("invalid_callback");
    b = U(b);
    d = d && d.length ? U(d) : null;

    var e = function e(f) {
      return encodeURIComponent(f).replace(/%2C/g, ",");
    };

    return [encodeURIComponent(a.pathPrefix).replace(/%2C/g, ",").replace(/%2F/g, "/"), "/k=", e(a.version), "/m=", e(b), d ? "/exm=" + e(d) : "", "/rt=j/sv=1/d=1/ed=1", a.b ? "/am=" + e(a.b) : "", a.i ? "/rs=" + e(a.i) : "", a.j ? "/t=" + e(a.j) : "", "/cb=", e(c)].join("");
  },
      qa = function qa(a) {
    "/" !== a.charAt(0) && S("relative path");

    for (var b = a.substring(1).split("/"), c = []; b.length;) {
      a = b.shift();
      if (!a.length || 0 == a.indexOf(".")) S("empty/relative directory");else if (0 < a.indexOf("=")) {
        b.unshift(a);
        break;
      }
      c.push(a);
    }

    a = {};

    for (var d = 0, e = b.length; d < e; ++d) {
      var f = b[d].split("="),
          l = decodeURIComponent(f[0]),
          k = decodeURIComponent(f[1]);
      2 == f.length && l && k && (a[l] = a[l] || k);
    }

    b = "/" + c.join("/");
    ia.test(b) || S("invalid_prefix");
    c = 0;

    for (d = T.length; c < d; ++c) {
      T[c].test(b) && S("invalid_prefix");
    }

    c = V(a, "k", !0);
    d = V(a, "am");
    e = V(a, "rs");
    a = V(a, "t");
    return {
      pathPrefix: b,
      version: c,
      b: d,
      i: e,
      j: a
    };
  },
      U = function U(a) {
    for (var b = [], c = 0, d = a.length; c < d; ++c) {
      var e = a[c].replace(/\./g, "_").replace(/-/g, "_");
      la.test(e) && b.push(e);
    }

    return b.join(",");
  },
      V = function V(a, b, c) {
    a = a[b];
    !a && c && S("missing: " + b);

    if (a) {
      if (ja.test(a)) return a;
      S("invalid: " + b);
    }

    return null;
  },
      oa = /^https?:\/\/[a-z0-9_.-]+\.google(rs)?\.com(:\d+)?\/[a-zA-Z0-9_.,!=\-\/]+$/,
      na = /\/cb=/g,
      ma = /\/\//g,
      sa = function sa() {
    var a = F();
    if (!a) throw Error("Bad hint");
    return a;
  };

  O.m = function (a, b, c, d) {
    (a = a[0]) || S("missing_hint");
    return "https://apis.google.com" + ra(a, b, c, d);
  };

  var W = decodeURI("%73cript"),
      X = /^[-+_0-9\/A-Za-z]+={0,2}$/,
      ta = function ta(a, b) {
    for (var c = [], d = 0; d < a.length; ++d) {
      var e = a[d],
          f;

      if (f = e) {
        a: {
          for (f = 0; f < b.length; f++) {
            if (b[f] === e) break a;
          }

          f = -1;
        }

        f = 0 > f;
      }

      f && c.push(e);
    }

    return c;
  },
      ua = function ua() {
    var a = E.nonce;
    return void 0 !== a ? a && a === String(a) && a.match(X) ? a : E.nonce = null : v.querySelector ? (a = v.querySelector("script[nonce]")) ? (a = a.nonce || a.getAttribute("nonce") || "", a && a === String(a) && a.match(X) ? E.nonce = a : E.nonce = null) : null : null;
  },
      wa = function wa(a) {
    if ("loading" != v.readyState) va(a);else {
      var b = ua(),
          c = "";
      null !== b && (c = ' nonce="' + b + '"');
      a = "<" + W + ' src="' + encodeURI(a) + '"' + c + "></" + W + ">";
      v.write(Y ? Y.createHTML(a) : a);
    }
  },
      va = function va(a) {
    var b = v.createElement(W);
    b.setAttribute("src", Y ? Y.createScriptURL(a) : a);
    a = ua();
    null !== a && b.setAttribute("nonce", a);
    b.async = "true";
    (a = v.getElementsByTagName(W)[0]) ? a.parentNode.insertBefore(b, a) : (v.head || v.body || v.documentElement).appendChild(b);
  },
      xa = function xa(a, b) {
    var c = b && b._c;
    if (c) for (var d = 0; d < P.length; d++) {
      var e = P[d][0],
          f = P[d][1];
      f && Object.prototype.hasOwnProperty.call(c, e) && f(c[e], a, b);
    }
  },
      za = function za(a, b, c) {
    ya(function () {
      var d = b === F() ? x(D, "_", C()) : C();
      d = x(G(b), "_", d);
      a(d);
    }, c);
  },
      Ba = function Ba(a, b) {
    var c = b || {};
    "function" == typeof b && (c = {}, c.callback = b);
    xa(a, c);
    b = a ? a.split(":") : [];
    var d = c.h || sa(),
        e = x(E, "ah", C());

    if (e["::"] && b.length) {
      a = [];

      for (var f = null; f = b.shift();) {
        var l = f.split(".");
        l = e[f] || e[l[1] && "ns:" + l[0] || ""] || d;
        var k = a.length && a[a.length - 1] || null,
            w = k;
        k && k.hint == l || (w = {
          hint: l,
          c: []
        }, a.push(w));
        w.c.push(f);
      }

      var y = a.length;

      if (1 < y) {
        var z = c.callback;
        z && (c.callback = function () {
          0 == --y && z();
        });
      }

      for (; b = a.shift();) {
        Aa(b.c, c, b.hint);
      }
    } else Aa(b || [], c, d);
  },
      Aa = function Aa(a, b, c) {
    a = da(a) || [];
    var d = b.callback,
        e = b.config,
        f = b.timeout,
        l = b.ontimeout,
        k = b.onerror,
        w = void 0;
    "function" == typeof k && (w = k);
    var y = null,
        z = !1;
    if (f && !l || !f && l) throw "Timeout requires both the timeout parameter and ontimeout parameter to be set";
    k = x(G(c), "r", []).sort();

    var Q = x(G(c), "L", []).sort(),
        I = [].concat(k),
        ha = function ha(u, A) {
      if (z) return 0;
      q.clearTimeout(y);
      Q.push.apply(Q, p);
      var B = ((D || {}).config || {}).update;
      B ? B(e) : e && x(E, "cu", []).push(e);

      if (A) {
        N("me0", u, I);

        try {
          za(A, c, w);
        } finally {
          N("me1", u, I);
        }
      }

      return 1;
    };

    0 < f && (y = q.setTimeout(function () {
      z = !0;
      l();
    }, f));
    var p = ta(a, Q);

    if (p.length) {
      p = ta(a, k);
      var r = x(E, "CP", []),
          t = r.length;

      r[t] = function (u) {
        if (!u) return 0;
        N("ml1", p, I);

        var A = function A(J) {
          r[t] = null;
          ha(p, u) && ea(function () {
            d && d();
            J();
          });
        },
            B = function B() {
          var J = r[t + 1];
          J && J();
        };

        0 < t && r[t - 1] ? r[t] = function () {
          A(B);
        } : A(B);
      };

      if (p.length) {
        var R = "loaded_" + E.I++;

        D[R] = function (u) {
          r[t](u);
          D[R] = null;
        };

        a = pa(c, p, "gapi." + R, k);
        k.push.apply(k, p);
        N("ml0", p, I);
        b.sync || q.___gapisync ? wa(a) : va(a);
      } else r[t](ba);
    } else ha(p) && d && d();
  },
      Ca;

  var Da = null,
      Z = g.trustedTypes;
  if (Z && Z.createPolicy) try {
    Da = Z.createPolicy("gapi#gapi", {
      createHTML: h,
      createScript: h,
      createScriptURL: h
    });
  } catch (a) {
    g.console && g.console.error(a.message);
  }
  Ca = Da;
  var Y = Ca;

  var ya = function ya(a, b) {
    if (E.hee && 0 < E.hel) try {
      return a();
    } catch (c) {
      b && b(c), E.hel--, Ba("debug_error", function () {
        try {
          window.___jsl.hefn(c);
        } catch (d) {
          throw c;
        }
      });
    } else try {
      return a();
    } catch (c) {
      throw b && b(c), c;
    }
  };

  D.load = function (a, b) {
    return ya(function () {
      return Ba(a, b);
    });
  };

  K.bs0 = window.gapi._bs || new Date().getTime();
  L("bs0");
  K.bs1 = new Date().getTime();
  L("bs1");
  delete window.gapi._bs;
}).call(this);
gapi.load("view-selector2", {
  callback: window["gapi_onload"],
  _c: {
    "jsl": {
      "ci": {
        "deviceType": "desktop",
        "oauth-flow": {
          "authUrl": "https://accounts.google.com/o/oauth2/auth",
          "proxyUrl": "https://accounts.google.com/o/oauth2/postmessageRelay",
          "disableOpt": true,
          "idpIframeUrl": "https://accounts.google.com/o/oauth2/iframe",
          "usegapi": false
        },
        "debug": {
          "reportExceptionRate": 0.05,
          "forceIm": false,
          "rethrowException": false,
          "host": "https://apis.google.com"
        },
        "enableMultilogin": true,
        "googleapis.config": {
          "auth": {
            "useFirstPartyAuthV2": true
          }
        },
        "isPlusUser": false,
        "inline": {
          "css": 1
        },
        "disableRealtimeCallback": false,
        "drive_share": {
          "skipInitCommand": true
        },
        "csi": {
          "rate": 0.01
        },
        "client": {
          "cors": false
        },
        "isLoggedIn": true,
        "signInDeprecation": {
          "rate": 0.0
        },
        "include_granted_scopes": true,
        "llang": "es",
        "iframes": {
          "youtube": {
            "params": {
              "location": ["search", "hash"]
            },
            "url": ":socialhost:/:session_prefix:_/widget/render/youtube?usegapi=1",
            "methods": ["scroll", "openwindow"]
          },
          "ytsubscribe": {
            "url": "https://www.youtube.com/subscribe_embed?usegapi=1"
          },
          "plus_circle": {
            "params": {
              "url": ""
            },
            "url": ":socialhost:/:session_prefix::se:_/widget/plus/circle?usegapi=1"
          },
          "plus_share": {
            "params": {
              "url": ""
            },
            "url": ":socialhost:/:session_prefix::se:_/+1/sharebutton?plusShare=true&usegapi=1"
          },
          "rbr_s": {
            "params": {
              "url": ""
            },
            "url": ":socialhost:/:session_prefix::se:_/widget/render/recobarsimplescroller"
          },
          ":source:": "3p",
          "playemm": {
            "url": "https://play.google.com/work/embedded/search?usegapi=1&usegapi=1"
          },
          "savetoandroidpay": {
            "url": "https://pay.google.com/gp/v/widget/save"
          },
          "blogger": {
            "params": {
              "location": ["search", "hash"]
            },
            "url": ":socialhost:/:session_prefix:_/widget/render/blogger?usegapi=1",
            "methods": ["scroll", "openwindow"]
          },
          "evwidget": {
            "params": {
              "url": ""
            },
            "url": ":socialhost:/:session_prefix:_/events/widget?usegapi=1"
          },
          "partnersbadge": {
            "url": "https://www.gstatic.com/partners/badge/templates/badge.html?usegapi=1"
          },
          "dataconnector": {
            "url": "https://dataconnector.corp.google.com/:session_prefix:ui/widgetview?usegapi=1"
          },
          "surveyoptin": {
            "url": "https://www.google.com/shopping/customerreviews/optin?usegapi=1"
          },
          ":socialhost:": "https://apis.google.com",
          "shortlists": {
            "url": ""
          },
          "hangout": {
            "url": "https://talkgadget.google.com/:session_prefix:talkgadget/_/widget"
          },
          "plus_followers": {
            "params": {
              "url": ""
            },
            "url": ":socialhost:/_/im/_/widget/render/plus/followers?usegapi=1"
          },
          "post": {
            "params": {
              "url": ""
            },
            "url": ":socialhost:/:session_prefix::im_prefix:_/widget/render/post?usegapi=1"
          },
          ":gplus_url:": "https://plus.google.com",
          "signin": {
            "params": {
              "url": ""
            },
            "url": ":socialhost:/:session_prefix:_/widget/render/signin?usegapi=1",
            "methods": ["onauth"]
          },
          "rbr_i": {
            "params": {
              "url": ""
            },
            "url": ":socialhost:/:session_prefix::se:_/widget/render/recobarinvitation"
          },
          "share": {
            "url": ":socialhost:/:session_prefix::im_prefix:_/widget/render/share?usegapi=1"
          },
          "plusone": {
            "params": {
              "count": "",
              "size": "",
              "url": ""
            },
            "url": ":socialhost:/:session_prefix::se:_/+1/fastbutton?usegapi=1"
          },
          "comments": {
            "params": {
              "location": ["search", "hash"]
            },
            "url": ":socialhost:/:session_prefix:_/widget/render/comments?usegapi=1",
            "methods": ["scroll", "openwindow"]
          },
          ":im_socialhost:": "https://plus.googleapis.com",
          "backdrop": {
            "url": "https://clients3.google.com/cast/chromecast/home/widget/backdrop?usegapi=1"
          },
          "visibility": {
            "params": {
              "url": ""
            },
            "url": ":socialhost:/:session_prefix:_/widget/render/visibility?usegapi=1"
          },
          "autocomplete": {
            "params": {
              "url": ""
            },
            "url": ":socialhost:/:session_prefix:_/widget/render/autocomplete"
          },
          "additnow": {
            "url": "https://apis.google.com/marketplace/button?usegapi=1",
            "methods": ["launchurl"]
          },
          ":signuphost:": "https://plus.google.com",
          "ratingbadge": {
            "url": "https://www.google.com/shopping/customerreviews/badge?usegapi=1"
          },
          "appcirclepicker": {
            "url": ":socialhost:/:session_prefix:_/widget/render/appcirclepicker"
          },
          "follow": {
            "url": ":socialhost:/:session_prefix:_/widget/render/follow?usegapi=1"
          },
          "community": {
            "url": ":ctx_socialhost:/:session_prefix::im_prefix:_/widget/render/community?usegapi=1"
          },
          "sharetoclassroom": {
            "url": "https://www.gstatic.com/classroom/sharewidget/widget_stable.html?usegapi=1"
          },
          "ytshare": {
            "params": {
              "url": ""
            },
            "url": ":socialhost:/:session_prefix:_/widget/render/ytshare?usegapi=1"
          },
          "plus": {
            "url": ":socialhost:/:session_prefix:_/widget/render/badge?usegapi=1"
          },
          "family_creation": {
            "params": {
              "url": ""
            },
            "url": "https://families.google.com/webcreation?usegapi=1&usegapi=1"
          },
          "commentcount": {
            "url": ":socialhost:/:session_prefix:_/widget/render/commentcount?usegapi=1"
          },
          "configurator": {
            "url": ":socialhost:/:session_prefix:_/plusbuttonconfigurator?usegapi=1"
          },
          "zoomableimage": {
            "url": "https://ssl.gstatic.com/microscope/embed/"
          },
          "appfinder": {
            "url": "https://gsuite.google.com/:session_prefix:marketplace/appfinder?usegapi=1"
          },
          "savetowallet": {
            "url": "https://pay.google.com/gp/v/widget/save"
          },
          "person": {
            "url": ":socialhost:/:session_prefix:_/widget/render/person?usegapi=1"
          },
          "savetodrive": {
            "url": "https://drive.google.com/savetodrivebutton?usegapi=1",
            "methods": ["save"]
          },
          "page": {
            "url": ":socialhost:/:session_prefix:_/widget/render/page?usegapi=1"
          },
          "card": {
            "url": ":socialhost:/:session_prefix:_/hovercard/card"
          }
        }
      },
      "h": "m;/_/scs/apps-static/_/js/k=oz.gapi.es.ov9YdirM6TI.O/am=wQc/d=1/ct=zgms/rs=AGLTcCOyD2gliLOBDFB7GhyVy8X0n4Q6jQ/m=__features__",
      "u": "https://apis.google.com/js/view-selector2.js",
      "hee": true,
      "fp": "50939a1cffc34695362a4bdc910d88f4e983656d",
      "dpo": false
    },
    "fp": "50939a1cffc34695362a4bdc910d88f4e983656d",
    "annotation": ["interactivepost", "recobar", "signin2", "autocomplete", "profile"],
    "bimodal": ["signin", "share"]
  }
});

/***/ }),

/***/ 5:
/*!**************************************************!*\
  !*** multi ./resources/js/cdm/view-selector2.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\sif\framework\resources\js\cdm\view-selector2.js */"./resources/js/cdm/view-selector2.js");


/***/ })

/******/ });