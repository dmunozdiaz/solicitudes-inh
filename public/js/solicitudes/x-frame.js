/******/ (() => { // webpackBootstrap
    var __webpack_exports__ = {};
    /*!****************************************!*\
      !*** ./resources/js/tareas/x-frame.js ***!
      \****************************************/
    function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }
    
    function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
    
    function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }
    
    function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }
    
    function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }
    
    function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }
    
    function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }
    
    function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }
    
    function _wrapNativeSuper(Class) { var _cache = typeof Map === "function" ? new Map() : undefined; _wrapNativeSuper = function _wrapNativeSuper(Class) { if (Class === null || !_isNativeFunction(Class)) return Class; if (typeof Class !== "function") { throw new TypeError("Super expression must either be null or a function"); } if (typeof _cache !== "undefined") { if (_cache.has(Class)) return _cache.get(Class); _cache.set(Class, Wrapper); } function Wrapper() { return _construct(Class, arguments, _getPrototypeOf(this).constructor); } Wrapper.prototype = Object.create(Class.prototype, { constructor: { value: Wrapper, enumerable: false, writable: true, configurable: true } }); return _setPrototypeOf(Wrapper, Class); }; return _wrapNativeSuper(Class); }
    
    function _construct(Parent, args, Class) { if (_isNativeReflectConstruct()) { _construct = Reflect.construct; } else { _construct = function _construct(Parent, args, Class) { var a = [null]; a.push.apply(a, args); var Constructor = Function.bind.apply(Parent, a); var instance = new Constructor(); if (Class) _setPrototypeOf(instance, Class.prototype); return instance; }; } return _construct.apply(null, arguments); }
    
    function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }
    
    function _isNativeFunction(fn) { return Function.toString.call(fn).indexOf("[native code]") !== -1; }
    
    function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }
    
    function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }
    
    customElements.define('x-frame-bypass', /*#__PURE__*/function (_HTMLIFrameElement) {
      _inherits(_class, _HTMLIFrameElement);
    
      var _super = _createSuper(_class);
    
      function _class() {
        _classCallCheck(this, _class);
    
        return _super.call(this);
      }
    
      _createClass(_class, [{
        key: "attributeChangedCallback",
        value: function attributeChangedCallback() {
          this.load(this.src);
        }
      }, {
        key: "connectedCallback",
        value: function connectedCallback() {
          this.sandbox = '' + this.sandbox || 'allow-forms allow-modals allow-pointer-lock allow-popups allow-popups-to-escape-sandbox allow-presentation allow-same-origin allow-scripts allow-top-navigation-by-user-activation'; // all except allow-top-navigation
        }
      }, {
        key: "load",
        value: function load(url, options) {
          var _this = this;
    
          if (!url || !url.startsWith('http')) throw new Error("X-Frame-Bypass src ".concat(url, " does not start with http(s)://"));
          console.log('X-Frame-Bypass loading:', url);
          this.srcdoc = "<html>\n<head>\n\t<style>\n\t.loader {\n\t\tposition: absolute;\n\t\ttop: calc(50% - 25px);\n\t\tleft: calc(50% - 25px);\n\t\twidth: 50px;\n\t\theight: 50px;\n\t\tbackground-color: #333;\n\t\tborder-radius: 50%;  \n\t\tanimation: loader 1s infinite ease-in-out;\n\t}\n\t@keyframes loader {\n\t\t0% {\n\t\ttransform: scale(0);\n\t\t}\n\t\t100% {\n\t\ttransform: scale(1);\n\t\topacity: 0;\n\t\t}\n\t}\n\t</style>\n</head>\n<body>\n\t<div class=\"loader\"></div>\n</body>\n</html>";
          this.fetchProxy(url, options, 0).then(function (res) {
            return res.text();
          }).then(function (data) {
            if (data) _this.srcdoc = data.replace(/<head([^>]*)>/i, "<head$1>\n\t<base href=\"".concat(url, "\">\n\t<script>\n\t// X-Frame-Bypass navigation event handlers\n\tdocument.addEventListener('click', e => {\n\t\tif (frameElement && document.activeElement && document.activeElement.href) {\n\t\t\te.preventDefault()\n\t\t\tframeElement.load(document.activeElement.href)\n\t\t}\n\t})\n\tdocument.addEventListener('submit', e => {\n\t\tif (frameElement && document.activeElement && document.activeElement.form && document.activeElement.form.action) {\n\t\t\te.preventDefault()\n\t\t\tif (document.activeElement.form.method === 'post')\n\t\t\t\tframeElement.load(document.activeElement.form.action, {method: 'post', body: new FormData(document.activeElement.form)})\n\t\t\telse\n\t\t\t\tframeElement.load(document.activeElement.form.action + '?' + new URLSearchParams(new FormData(document.activeElement.form)))\n\t\t}\n\t})\n\t</script>"));
          })["catch"](function (e) {
            return console.error('Cannot load X-Frame-Bypass:', e);
          });
        }
      }, {
        key: "fetchProxy",
        value: function fetchProxy(url, options, i) {
          var _this2 = this;
    
          var proxies = (options || {}).proxies || ['https://cors-anywhere.herokuapp.com/', 'https://yacdn.org/proxy/', 'https://api.codetabs.com/v1/proxy/?quest='];
          return fetch(proxies[i] + url, options).then(function (res) {
            if (!res.ok) throw new Error("".concat(res.status, " ").concat(res.statusText));
            return res;
          })["catch"](function (error) {
            if (i === proxies.length - 1) throw error;
            return _this2.fetchProxy(url, options, i + 1);
          });
        }
      }], [{
        key: "observedAttributes",
        get: function get() {
          return ['src'];
        }
      }]);
    
      return _class;
    }( /*#__PURE__*/_wrapNativeSuper(HTMLIFrameElement)), {
      "extends": 'iframe'
    });
    /******/ })()
    ;