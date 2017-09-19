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
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	var _Builder = __webpack_require__(1);
	
	var _Builder2 = _interopRequireDefault(_Builder);
	
	var _OrderCollectionElement = __webpack_require__(87);
	
	var _OrderCollectionElement2 = _interopRequireDefault(_OrderCollectionElement);
	
	var _OrderCollection = __webpack_require__(106);
	
	var _OrderCollection2 = _interopRequireDefault(_OrderCollection);
	
	var _ColumnsSelector = __webpack_require__(109);
	
	var _ColumnsSelector2 = _interopRequireDefault(_ColumnsSelector);
	
	var _Filter = __webpack_require__(110);
	
	var _Filter2 = _interopRequireDefault(_Filter);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	$(document).ready(function () {
	    var components = [_OrderCollectionElement2.default, _OrderCollection2.default, _ColumnsSelector2.default, _Filter2.default];
	
	    var builder = new _Builder2.default(components);
	    builder.bootstrap({
	        afterComponentCreated: function afterComponentCreated(node) {
	            node.attr('data-initialization-state', 'complete');
	        }
	    }).init($(document.body));
	});

/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	
	var _classCallCheck2 = __webpack_require__(2);
	
	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);
	
	var _createClass2 = __webpack_require__(3);
	
	var _createClass3 = _interopRequireDefault(_createClass2);
	
	var _Selector = __webpack_require__(22);
	
	var _Selector2 = _interopRequireDefault(_Selector);
	
	var _Component = __webpack_require__(23);
	
	var _Component2 = _interopRequireDefault(_Component);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var Builder = function () {
	    function Builder(components) {
	        (0, _classCallCheck3.default)(this, Builder);
	
	        this.components = components;
	    }
	
	    (0, _createClass3.default)(Builder, [{
	        key: 'bootstrap',
	        value: function bootstrap(parameters) {
	            var componentMap = this._buildComponentMap();
	            $(document).on(_Component2.default.events.INIT_COMPONENTS, function (event, node) {
	                var $node = $(node);
	                var componentNodes = $node.find(_Selector2.default.component()).addBack(_Selector2.default.component());
	                var componentDescriptions = [];
	
	                $.each(componentNodes, function (idx, node) {
	                    var $node = $(node);
	                    componentDescriptions.push({
	                        node: $node,
	                        name: _Selector2.default.componentName($node)
	                    });
	                });
	
	                function getComponentHierarhy(component) {
	                    var currentComponent = component;
	                    var hierarchy = [];
	                    while (currentComponent.id !== 'Component' && '__proto__' in currentComponent && currentComponent.__proto__ !== null) {
	                        hierarchy.push(currentComponent);
	                        currentComponent = currentComponent.__proto__;
	                    }
	                    return hierarchy;
	                }
	
	                $.each(componentDescriptions, function (idx, componentDescr) {
	                    var nodeComponentNames = componentDescr.name.split(' ');
	                    var fullNodeNames = nodeComponentNames;
	                    var nodeComponents = [];
	
	                    $.each(nodeComponentNames, function (idx, componentName) {
	                        if (componentName in componentMap) {
	                            var component = componentMap[componentName];
	                            var componentHierarchy = getComponentHierarhy(component);
	                            var componentHierachyNames = componentHierarchy.map(function (hirComponent) {
	                                return Builder._componentName(hirComponent);
	                            });
	                            nodeComponents.push(component);
	                            fullNodeNames = fullNodeNames.concat(componentHierachyNames);
	                        } else {
	                            console.log('Component ' + componentName + ' does not register in component list');
	                        }
	                    });
	
	                    componentDescr.components = nodeComponents;
	                    componentDescr.fullNodeNames = $.unique(fullNodeNames);
	                });
	
	                // Doing separate pass to make component find each other while initializing
	                $.each(componentDescriptions, function (idx, componentDescr) {
	                    componentDescr.node.attr('data-widget', componentDescr.fullNodeNames.join(' '));
	                });
	
	                $.each(componentDescriptions, function (idx, componentDescr) {
	                    $.each(componentDescr.components, function (idx, component) {
	                        console.log('Attach component ' + component.name);
	                        var componentInstance = new component(componentDescr.node);
	                        console.log('Component ' + Builder._componentName(component) + ' had been initialized');
	                    });
	                });
	
	                $.each(componentDescriptions, function (idx, componentDescr) {
	                    componentDescr.node.trigger(_Component2.default.events.AFTER_INIT_ALL_COMPONENTS);
	                });
	
	                if ('afterComponentCreated' in parameters) {
	                    parameters.afterComponentCreated.call(null, $node);
	                }
	            });
	            return this;
	        }
	    }, {
	        key: 'init',
	        value: function init($node) {
	            $(document).trigger(_Component2.default.events.INIT_COMPONENTS, $node);
	            return this;
	        }
	    }, {
	        key: '_buildComponentMap',
	        value: function _buildComponentMap() {
	            var componentMap = {};
	            $.each(this.components, function (idx, component) {
	                var name = Builder._componentName(component);
	                if (name in componentMap) {
	                    throw new Error('Component ' + name + ' was already registered');
	                }
	                componentMap[name] = component;
	            });
	            return componentMap;
	        }
	    }], [{
	        key: '_componentName',
	        value: function _componentName(component) {
	            var className = component.id;
	            return className.replace(/\.?([A-Z])/g, function (x, y) {
	                return "_" + y.toLowerCase();
	            }).replace(/^_/, "");
	        }
	    }]);
	    return Builder;
	}();
	
	exports.default = Builder;

/***/ }),
/* 2 */
/***/ (function(module, exports) {

	"use strict";
	
	exports.__esModule = true;
	
	exports.default = function (instance, Constructor) {
	  if (!(instance instanceof Constructor)) {
	    throw new TypeError("Cannot call a class as a function");
	  }
	};

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	exports.__esModule = true;
	
	var _defineProperty = __webpack_require__(4);
	
	var _defineProperty2 = _interopRequireDefault(_defineProperty);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = function () {
	  function defineProperties(target, props) {
	    for (var i = 0; i < props.length; i++) {
	      var descriptor = props[i];
	      descriptor.enumerable = descriptor.enumerable || false;
	      descriptor.configurable = true;
	      if ("value" in descriptor) descriptor.writable = true;
	      (0, _defineProperty2.default)(target, descriptor.key, descriptor);
	    }
	  }
	
	  return function (Constructor, protoProps, staticProps) {
	    if (protoProps) defineProperties(Constructor.prototype, protoProps);
	    if (staticProps) defineProperties(Constructor, staticProps);
	    return Constructor;
	  };
	}();

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(5), __esModule: true };

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(6);
	var $Object = __webpack_require__(9).Object;
	module.exports = function defineProperty(it, key, desc) {
	  return $Object.defineProperty(it, key, desc);
	};


/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

	var $export = __webpack_require__(7);
	// 19.1.2.4 / 15.2.3.6 Object.defineProperty(O, P, Attributes)
	$export($export.S + $export.F * !__webpack_require__(17), 'Object', { defineProperty: __webpack_require__(13).f });


/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

	var global = __webpack_require__(8);
	var core = __webpack_require__(9);
	var ctx = __webpack_require__(10);
	var hide = __webpack_require__(12);
	var PROTOTYPE = 'prototype';
	
	var $export = function (type, name, source) {
	  var IS_FORCED = type & $export.F;
	  var IS_GLOBAL = type & $export.G;
	  var IS_STATIC = type & $export.S;
	  var IS_PROTO = type & $export.P;
	  var IS_BIND = type & $export.B;
	  var IS_WRAP = type & $export.W;
	  var exports = IS_GLOBAL ? core : core[name] || (core[name] = {});
	  var expProto = exports[PROTOTYPE];
	  var target = IS_GLOBAL ? global : IS_STATIC ? global[name] : (global[name] || {})[PROTOTYPE];
	  var key, own, out;
	  if (IS_GLOBAL) source = name;
	  for (key in source) {
	    // contains in native
	    own = !IS_FORCED && target && target[key] !== undefined;
	    if (own && key in exports) continue;
	    // export native or passed
	    out = own ? target[key] : source[key];
	    // prevent global pollution for namespaces
	    exports[key] = IS_GLOBAL && typeof target[key] != 'function' ? source[key]
	    // bind timers to global for call from export context
	    : IS_BIND && own ? ctx(out, global)
	    // wrap global constructors for prevent change them in library
	    : IS_WRAP && target[key] == out ? (function (C) {
	      var F = function (a, b, c) {
	        if (this instanceof C) {
	          switch (arguments.length) {
	            case 0: return new C();
	            case 1: return new C(a);
	            case 2: return new C(a, b);
	          } return new C(a, b, c);
	        } return C.apply(this, arguments);
	      };
	      F[PROTOTYPE] = C[PROTOTYPE];
	      return F;
	    // make static versions for prototype methods
	    })(out) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
	    // export proto methods to core.%CONSTRUCTOR%.methods.%NAME%
	    if (IS_PROTO) {
	      (exports.virtual || (exports.virtual = {}))[key] = out;
	      // export proto methods to core.%CONSTRUCTOR%.prototype.%NAME%
	      if (type & $export.R && expProto && !expProto[key]) hide(expProto, key, out);
	    }
	  }
	};
	// type bitmap
	$export.F = 1;   // forced
	$export.G = 2;   // global
	$export.S = 4;   // static
	$export.P = 8;   // proto
	$export.B = 16;  // bind
	$export.W = 32;  // wrap
	$export.U = 64;  // safe
	$export.R = 128; // real proto method for `library`
	module.exports = $export;


/***/ }),
/* 8 */
/***/ (function(module, exports) {

	// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
	var global = module.exports = typeof window != 'undefined' && window.Math == Math
	  ? window : typeof self != 'undefined' && self.Math == Math ? self
	  // eslint-disable-next-line no-new-func
	  : Function('return this')();
	if (typeof __g == 'number') __g = global; // eslint-disable-line no-undef


/***/ }),
/* 9 */
/***/ (function(module, exports) {

	var core = module.exports = { version: '2.5.1' };
	if (typeof __e == 'number') __e = core; // eslint-disable-line no-undef


/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

	// optional / simple context binding
	var aFunction = __webpack_require__(11);
	module.exports = function (fn, that, length) {
	  aFunction(fn);
	  if (that === undefined) return fn;
	  switch (length) {
	    case 1: return function (a) {
	      return fn.call(that, a);
	    };
	    case 2: return function (a, b) {
	      return fn.call(that, a, b);
	    };
	    case 3: return function (a, b, c) {
	      return fn.call(that, a, b, c);
	    };
	  }
	  return function (/* ...args */) {
	    return fn.apply(that, arguments);
	  };
	};


/***/ }),
/* 11 */
/***/ (function(module, exports) {

	module.exports = function (it) {
	  if (typeof it != 'function') throw TypeError(it + ' is not a function!');
	  return it;
	};


/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

	var dP = __webpack_require__(13);
	var createDesc = __webpack_require__(21);
	module.exports = __webpack_require__(17) ? function (object, key, value) {
	  return dP.f(object, key, createDesc(1, value));
	} : function (object, key, value) {
	  object[key] = value;
	  return object;
	};


/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

	var anObject = __webpack_require__(14);
	var IE8_DOM_DEFINE = __webpack_require__(16);
	var toPrimitive = __webpack_require__(20);
	var dP = Object.defineProperty;
	
	exports.f = __webpack_require__(17) ? Object.defineProperty : function defineProperty(O, P, Attributes) {
	  anObject(O);
	  P = toPrimitive(P, true);
	  anObject(Attributes);
	  if (IE8_DOM_DEFINE) try {
	    return dP(O, P, Attributes);
	  } catch (e) { /* empty */ }
	  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported!');
	  if ('value' in Attributes) O[P] = Attributes.value;
	  return O;
	};


/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

	var isObject = __webpack_require__(15);
	module.exports = function (it) {
	  if (!isObject(it)) throw TypeError(it + ' is not an object!');
	  return it;
	};


/***/ }),
/* 15 */
/***/ (function(module, exports) {

	module.exports = function (it) {
	  return typeof it === 'object' ? it !== null : typeof it === 'function';
	};


/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = !__webpack_require__(17) && !__webpack_require__(18)(function () {
	  return Object.defineProperty(__webpack_require__(19)('div'), 'a', { get: function () { return 7; } }).a != 7;
	});


/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

	// Thank's IE8 for his funny defineProperty
	module.exports = !__webpack_require__(18)(function () {
	  return Object.defineProperty({}, 'a', { get: function () { return 7; } }).a != 7;
	});


/***/ }),
/* 18 */
/***/ (function(module, exports) {

	module.exports = function (exec) {
	  try {
	    return !!exec();
	  } catch (e) {
	    return true;
	  }
	};


/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

	var isObject = __webpack_require__(15);
	var document = __webpack_require__(8).document;
	// typeof document.createElement is 'object' in old IE
	var is = isObject(document) && isObject(document.createElement);
	module.exports = function (it) {
	  return is ? document.createElement(it) : {};
	};


/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

	// 7.1.1 ToPrimitive(input [, PreferredType])
	var isObject = __webpack_require__(15);
	// instead of the ES6 spec version, we didn't implement @@toPrimitive case
	// and the second argument - flag - preferred type is a string
	module.exports = function (it, S) {
	  if (!isObject(it)) return it;
	  var fn, val;
	  if (S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
	  if (typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it))) return val;
	  if (!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
	  throw TypeError("Can't convert object to primitive value");
	};


/***/ }),
/* 21 */
/***/ (function(module, exports) {

	module.exports = function (bitmap, value) {
	  return {
	    enumerable: !(bitmap & 1),
	    configurable: !(bitmap & 2),
	    writable: !(bitmap & 4),
	    value: value
	  };
	};


/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	
	var _classCallCheck2 = __webpack_require__(2);
	
	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);
	
	var _createClass2 = __webpack_require__(3);
	
	var _createClass3 = _interopRequireDefault(_createClass2);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var Selector = function () {
	    function Selector() {
	        (0, _classCallCheck3.default)(this, Selector);
	    }
	
	    (0, _createClass3.default)(Selector, null, [{
	        key: 'component',
	        value: function component() {
	            if (arguments.length == 0) {
	                return '[data-widget]';
	            } else if (arguments.length == 1) {
	                return '[data-widget~=' + arguments[0] + ']';
	            } else {
	                throw new Error('Unknown variant of function called');
	            }
	        }
	    }, {
	        key: 'componentName',
	        value: function componentName($node) {
	            return $node.data('widget');
	        }
	    }]);
	    return Selector;
	}();
	
	exports.default = Selector;

/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	
	var _classCallCheck2 = __webpack_require__(2);
	
	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);
	
	var _createClass2 = __webpack_require__(3);
	
	var _createClass3 = _interopRequireDefault(_createClass2);
	
	var _ComponentFinder = __webpack_require__(24);
	
	var _ComponentFinder2 = _interopRequireDefault(_ComponentFinder);
	
	var _PropertyParser = __webpack_require__(25);
	
	var _PropertyParser2 = _interopRequireDefault(_PropertyParser);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var EVENTS = {
	    INIT_COMPONENTS: 'init_components',
	    AFTER_INIT_ALL_COMPONENTS: 'after_init_all_components',
	    REMOVE: 'remove'
	};
	
	var Component = function () {
	    function Component($node) {
	        var _this = this;
	
	        (0, _classCallCheck3.default)(this, Component);
	
	        this.$node = $node;
	        this.$node.on(EVENTS.REMOVE, function (e) {
	            e.stopPropagation();
	            _this.destroy();
	        });
	
	        var parameters = $node.data();
	        delete parameters.widget;
	        this.props = this.parseParameters(parameters);
	
	        this.init();
	    }
	
	    (0, _createClass3.default)(Component, [{
	        key: 'parseParameters',
	        value: function parseParameters(parameters) {
	            return _PropertyParser2.default.parse(parameters, this.propTypes());
	        }
	    }, {
	        key: 'propTypes',
	        value: function propTypes() {
	            // abstract method
	            return {};
	        }
	    }, {
	        key: 'init',
	        value: function init() {
	            // abstract method
	        }
	    }, {
	        key: 'destroy',
	        value: function destroy() {
	            var children = _ComponentFinder2.default.all_childrens(this.$node);
	            children.forEach(function ($componentNode) {
	                $componentNode.triggerHandler(EVENTS.REMOVE);
	            });
	            this.$node.unbind(EVENTS.REMOVE);
	            this.$node.remove();
	            console.log('Destroyed component ' + this.constructor.name);
	        }
	    }], [{
	        key: 'events',
	        get: function get() {
	            return EVENTS;
	        }
	    }, {
	        key: 'id',
	        get: function get() {
	            return 'Component';
	        }
	    }]);
	    return Component;
	}();
	
	exports.default = Component;

/***/ }),
/* 24 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	
	var _Selector = __webpack_require__(22);
	
	var _Selector2 = _interopRequireDefault(_Selector);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var parentComponent = function parentComponent($node, componentName) {
	    return $node.closest(_Selector2.default.component(componentName));
	};
	
	var allChildrenComponents = function allChildrenComponents($node) {
	    var node = $node.get(0);
	    var components = [];
	
	    function traversal(node) {
	        for (var i = 0; i < node.childNodes.length; i++) {
	            var childElement = node.childNodes[i];
	            if (childElement.nodeType != 1) {
	                continue;
	            }
	            if (childElement.hasAttribute('data-widget')) {
	                components.push($(childElement));
	                continue;
	            }
	            traversal(childElement);
	        }
	    }
	
	    traversal(node);
	    return components;
	};
	
	var namedChildrenComponents = function namedChildrenComponents($node, componentName) {
	    var node = $node.get(0);
	    var components = [];
	
	    function traversal(node) {
	        for (var i = 0; i < node.childNodes.length; i++) {
	            var childElement = node.childNodes[i];
	            if (childElement.nodeType != 1) {
	                continue;
	            }
	            if (childElement.hasAttribute('data-widget')) {
	                var $component = $(childElement);
	                if ($component.is(_Selector2.default.component(componentName))) {
	                    components.push($component);
	                    continue;
	                }
	                if (!(childElement.hasAttribute('role') && childElement.getAttribute('role') == 'presentation')) {
	                    break;
	                }
	            }
	            traversal(childElement);
	        }
	    }
	
	    traversal(node);
	    return components;
	};
	
	var childrenComponents = function childrenComponents() {
	    if (arguments.length == 1) {
	        return allChildrenComponents(arguments[0]);
	    } else if (arguments.length == 2) {
	        return namedChildrenComponents(arguments[0], arguments[1]);
	    } else {
	        throw new Error('Unknown variant of function');
	    }
	};
	
	var singleChildren = function singleChildren($node, componentName) {
	    var components = childrenComponents($node, componentName);
	    if (components.length != 1) {
	        return null;
	    }
	    return components[0];
	};
	
	var ComponentFinder = {
	    all_childrens: childrenComponents,
	    children: singleChildren,
	    parent: parentComponent
	};
	
	exports.default = ComponentFinder;

/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	
	var _typeof2 = __webpack_require__(26);
	
	var _typeof3 = _interopRequireDefault(_typeof2);
	
	var _slicedToArray2 = __webpack_require__(78);
	
	var _slicedToArray3 = _interopRequireDefault(_slicedToArray2);
	
	var _classCallCheck2 = __webpack_require__(2);
	
	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);
	
	var _createClass2 = __webpack_require__(3);
	
	var _createClass3 = _interopRequireDefault(_createClass2);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var PropertyParser = function () {
	    function PropertyParser() {
	        (0, _classCallCheck3.default)(this, PropertyParser);
	    }
	
	    (0, _createClass3.default)(PropertyParser, null, [{
	        key: 'parse',
	        value: function parse(obj, schema) {
	            var props = {};
	            for (var propertyName in schema) {
	                if (schema.hasOwnProperty(propertyName)) {
	                    props[propertyName] = PropertyParser.parseProperty(obj, schema, propertyName);
	                }
	            }
	            return props;
	        }
	    }, {
	        key: 'parseProperty',
	        value: function parseProperty(obj, schema, propertyName) {
	            var propertyDescription = schema[propertyName];
	            if (propertyName in obj) {
	                var _PropertyParser$valid = PropertyParser.validate(obj[propertyName], propertyDescription),
	                    _PropertyParser$valid2 = (0, _slicedToArray3.default)(_PropertyParser$valid, 2),
	                    success = _PropertyParser$valid2[0],
	                    errors = _PropertyParser$valid2[1];
	
	                if (success) {
	                    return obj[propertyName];
	                } else {
	                    throw new Error(errors);
	                }
	            }
	            if ('default' in propertyDescription) {
	                return propertyDescription.default;
	            }
	            var propertyIsRequired = !('required' in propertyDescription) || 'required' in propertyDescription && propertyDescription.required === true;
	            if (propertyIsRequired) {
	                throw new Error('Component ' + this.constructor.name + ' must have parameter ' + propertyName);
	            }
	        }
	    }, {
	        key: 'validate',
	        value: function validate(obj, schema) {
	            if ('type' in schema) {
	                if (!((typeof obj === 'undefined' ? 'undefined' : (0, _typeof3.default)(obj)) === schema.type)) {
	                    return [false, 'type must be ' + schema.type + ', but is ' + (typeof obj === 'undefined' ? 'undefined' : (0, _typeof3.default)(obj))];
	                }
	            }
	            return [true, null];
	        }
	    }]);
	    return PropertyParser;
	}();
	
	exports.default = PropertyParser;

/***/ }),
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	exports.__esModule = true;
	
	var _iterator = __webpack_require__(27);
	
	var _iterator2 = _interopRequireDefault(_iterator);
	
	var _symbol = __webpack_require__(63);
	
	var _symbol2 = _interopRequireDefault(_symbol);
	
	var _typeof = typeof _symbol2.default === "function" && typeof _iterator2.default === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof _symbol2.default === "function" && obj.constructor === _symbol2.default && obj !== _symbol2.default.prototype ? "symbol" : typeof obj; };
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = typeof _symbol2.default === "function" && _typeof(_iterator2.default) === "symbol" ? function (obj) {
	  return typeof obj === "undefined" ? "undefined" : _typeof(obj);
	} : function (obj) {
	  return obj && typeof _symbol2.default === "function" && obj.constructor === _symbol2.default && obj !== _symbol2.default.prototype ? "symbol" : typeof obj === "undefined" ? "undefined" : _typeof(obj);
	};

/***/ }),
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(28), __esModule: true };

/***/ }),
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(29);
	__webpack_require__(58);
	module.exports = __webpack_require__(62).f('iterator');


/***/ }),
/* 29 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	var $at = __webpack_require__(30)(true);
	
	// 21.1.3.27 String.prototype[@@iterator]()
	__webpack_require__(33)(String, 'String', function (iterated) {
	  this._t = String(iterated); // target
	  this._i = 0;                // next index
	// 21.1.5.2.1 %StringIteratorPrototype%.next()
	}, function () {
	  var O = this._t;
	  var index = this._i;
	  var point;
	  if (index >= O.length) return { value: undefined, done: true };
	  point = $at(O, index);
	  this._i += point.length;
	  return { value: point, done: false };
	});


/***/ }),
/* 30 */
/***/ (function(module, exports, __webpack_require__) {

	var toInteger = __webpack_require__(31);
	var defined = __webpack_require__(32);
	// true  -> String#at
	// false -> String#codePointAt
	module.exports = function (TO_STRING) {
	  return function (that, pos) {
	    var s = String(defined(that));
	    var i = toInteger(pos);
	    var l = s.length;
	    var a, b;
	    if (i < 0 || i >= l) return TO_STRING ? '' : undefined;
	    a = s.charCodeAt(i);
	    return a < 0xd800 || a > 0xdbff || i + 1 === l || (b = s.charCodeAt(i + 1)) < 0xdc00 || b > 0xdfff
	      ? TO_STRING ? s.charAt(i) : a
	      : TO_STRING ? s.slice(i, i + 2) : (a - 0xd800 << 10) + (b - 0xdc00) + 0x10000;
	  };
	};


/***/ }),
/* 31 */
/***/ (function(module, exports) {

	// 7.1.4 ToInteger
	var ceil = Math.ceil;
	var floor = Math.floor;
	module.exports = function (it) {
	  return isNaN(it = +it) ? 0 : (it > 0 ? floor : ceil)(it);
	};


/***/ }),
/* 32 */
/***/ (function(module, exports) {

	// 7.2.1 RequireObjectCoercible(argument)
	module.exports = function (it) {
	  if (it == undefined) throw TypeError("Can't call method on  " + it);
	  return it;
	};


/***/ }),
/* 33 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	var LIBRARY = __webpack_require__(34);
	var $export = __webpack_require__(7);
	var redefine = __webpack_require__(35);
	var hide = __webpack_require__(12);
	var has = __webpack_require__(36);
	var Iterators = __webpack_require__(37);
	var $iterCreate = __webpack_require__(38);
	var setToStringTag = __webpack_require__(54);
	var getPrototypeOf = __webpack_require__(56);
	var ITERATOR = __webpack_require__(55)('iterator');
	var BUGGY = !([].keys && 'next' in [].keys()); // Safari has buggy iterators w/o `next`
	var FF_ITERATOR = '@@iterator';
	var KEYS = 'keys';
	var VALUES = 'values';
	
	var returnThis = function () { return this; };
	
	module.exports = function (Base, NAME, Constructor, next, DEFAULT, IS_SET, FORCED) {
	  $iterCreate(Constructor, NAME, next);
	  var getMethod = function (kind) {
	    if (!BUGGY && kind in proto) return proto[kind];
	    switch (kind) {
	      case KEYS: return function keys() { return new Constructor(this, kind); };
	      case VALUES: return function values() { return new Constructor(this, kind); };
	    } return function entries() { return new Constructor(this, kind); };
	  };
	  var TAG = NAME + ' Iterator';
	  var DEF_VALUES = DEFAULT == VALUES;
	  var VALUES_BUG = false;
	  var proto = Base.prototype;
	  var $native = proto[ITERATOR] || proto[FF_ITERATOR] || DEFAULT && proto[DEFAULT];
	  var $default = $native || getMethod(DEFAULT);
	  var $entries = DEFAULT ? !DEF_VALUES ? $default : getMethod('entries') : undefined;
	  var $anyNative = NAME == 'Array' ? proto.entries || $native : $native;
	  var methods, key, IteratorPrototype;
	  // Fix native
	  if ($anyNative) {
	    IteratorPrototype = getPrototypeOf($anyNative.call(new Base()));
	    if (IteratorPrototype !== Object.prototype && IteratorPrototype.next) {
	      // Set @@toStringTag to native iterators
	      setToStringTag(IteratorPrototype, TAG, true);
	      // fix for some old engines
	      if (!LIBRARY && !has(IteratorPrototype, ITERATOR)) hide(IteratorPrototype, ITERATOR, returnThis);
	    }
	  }
	  // fix Array#{values, @@iterator}.name in V8 / FF
	  if (DEF_VALUES && $native && $native.name !== VALUES) {
	    VALUES_BUG = true;
	    $default = function values() { return $native.call(this); };
	  }
	  // Define iterator
	  if ((!LIBRARY || FORCED) && (BUGGY || VALUES_BUG || !proto[ITERATOR])) {
	    hide(proto, ITERATOR, $default);
	  }
	  // Plug for library
	  Iterators[NAME] = $default;
	  Iterators[TAG] = returnThis;
	  if (DEFAULT) {
	    methods = {
	      values: DEF_VALUES ? $default : getMethod(VALUES),
	      keys: IS_SET ? $default : getMethod(KEYS),
	      entries: $entries
	    };
	    if (FORCED) for (key in methods) {
	      if (!(key in proto)) redefine(proto, key, methods[key]);
	    } else $export($export.P + $export.F * (BUGGY || VALUES_BUG), NAME, methods);
	  }
	  return methods;
	};


/***/ }),
/* 34 */
/***/ (function(module, exports) {

	module.exports = true;


/***/ }),
/* 35 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(12);


/***/ }),
/* 36 */
/***/ (function(module, exports) {

	var hasOwnProperty = {}.hasOwnProperty;
	module.exports = function (it, key) {
	  return hasOwnProperty.call(it, key);
	};


/***/ }),
/* 37 */
/***/ (function(module, exports) {

	module.exports = {};


/***/ }),
/* 38 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	var create = __webpack_require__(39);
	var descriptor = __webpack_require__(21);
	var setToStringTag = __webpack_require__(54);
	var IteratorPrototype = {};
	
	// 25.1.2.1.1 %IteratorPrototype%[@@iterator]()
	__webpack_require__(12)(IteratorPrototype, __webpack_require__(55)('iterator'), function () { return this; });
	
	module.exports = function (Constructor, NAME, next) {
	  Constructor.prototype = create(IteratorPrototype, { next: descriptor(1, next) });
	  setToStringTag(Constructor, NAME + ' Iterator');
	};


/***/ }),
/* 39 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
	var anObject = __webpack_require__(14);
	var dPs = __webpack_require__(40);
	var enumBugKeys = __webpack_require__(52);
	var IE_PROTO = __webpack_require__(49)('IE_PROTO');
	var Empty = function () { /* empty */ };
	var PROTOTYPE = 'prototype';
	
	// Create object with fake `null` prototype: use iframe Object with cleared prototype
	var createDict = function () {
	  // Thrash, waste and sodomy: IE GC bug
	  var iframe = __webpack_require__(19)('iframe');
	  var i = enumBugKeys.length;
	  var lt = '<';
	  var gt = '>';
	  var iframeDocument;
	  iframe.style.display = 'none';
	  __webpack_require__(53).appendChild(iframe);
	  iframe.src = 'javascript:'; // eslint-disable-line no-script-url
	  // createDict = iframe.contentWindow.Object;
	  // html.removeChild(iframe);
	  iframeDocument = iframe.contentWindow.document;
	  iframeDocument.open();
	  iframeDocument.write(lt + 'script' + gt + 'document.F=Object' + lt + '/script' + gt);
	  iframeDocument.close();
	  createDict = iframeDocument.F;
	  while (i--) delete createDict[PROTOTYPE][enumBugKeys[i]];
	  return createDict();
	};
	
	module.exports = Object.create || function create(O, Properties) {
	  var result;
	  if (O !== null) {
	    Empty[PROTOTYPE] = anObject(O);
	    result = new Empty();
	    Empty[PROTOTYPE] = null;
	    // add "__proto__" for Object.getPrototypeOf polyfill
	    result[IE_PROTO] = O;
	  } else result = createDict();
	  return Properties === undefined ? result : dPs(result, Properties);
	};


/***/ }),
/* 40 */
/***/ (function(module, exports, __webpack_require__) {

	var dP = __webpack_require__(13);
	var anObject = __webpack_require__(14);
	var getKeys = __webpack_require__(41);
	
	module.exports = __webpack_require__(17) ? Object.defineProperties : function defineProperties(O, Properties) {
	  anObject(O);
	  var keys = getKeys(Properties);
	  var length = keys.length;
	  var i = 0;
	  var P;
	  while (length > i) dP.f(O, P = keys[i++], Properties[P]);
	  return O;
	};


/***/ }),
/* 41 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.2.14 / 15.2.3.14 Object.keys(O)
	var $keys = __webpack_require__(42);
	var enumBugKeys = __webpack_require__(52);
	
	module.exports = Object.keys || function keys(O) {
	  return $keys(O, enumBugKeys);
	};


/***/ }),
/* 42 */
/***/ (function(module, exports, __webpack_require__) {

	var has = __webpack_require__(36);
	var toIObject = __webpack_require__(43);
	var arrayIndexOf = __webpack_require__(46)(false);
	var IE_PROTO = __webpack_require__(49)('IE_PROTO');
	
	module.exports = function (object, names) {
	  var O = toIObject(object);
	  var i = 0;
	  var result = [];
	  var key;
	  for (key in O) if (key != IE_PROTO) has(O, key) && result.push(key);
	  // Don't enum bug & hidden keys
	  while (names.length > i) if (has(O, key = names[i++])) {
	    ~arrayIndexOf(result, key) || result.push(key);
	  }
	  return result;
	};


/***/ }),
/* 43 */
/***/ (function(module, exports, __webpack_require__) {

	// to indexed object, toObject with fallback for non-array-like ES3 strings
	var IObject = __webpack_require__(44);
	var defined = __webpack_require__(32);
	module.exports = function (it) {
	  return IObject(defined(it));
	};


/***/ }),
/* 44 */
/***/ (function(module, exports, __webpack_require__) {

	// fallback for non-array-like ES3 and non-enumerable old V8 strings
	var cof = __webpack_require__(45);
	// eslint-disable-next-line no-prototype-builtins
	module.exports = Object('z').propertyIsEnumerable(0) ? Object : function (it) {
	  return cof(it) == 'String' ? it.split('') : Object(it);
	};


/***/ }),
/* 45 */
/***/ (function(module, exports) {

	var toString = {}.toString;
	
	module.exports = function (it) {
	  return toString.call(it).slice(8, -1);
	};


/***/ }),
/* 46 */
/***/ (function(module, exports, __webpack_require__) {

	// false -> Array#indexOf
	// true  -> Array#includes
	var toIObject = __webpack_require__(43);
	var toLength = __webpack_require__(47);
	var toAbsoluteIndex = __webpack_require__(48);
	module.exports = function (IS_INCLUDES) {
	  return function ($this, el, fromIndex) {
	    var O = toIObject($this);
	    var length = toLength(O.length);
	    var index = toAbsoluteIndex(fromIndex, length);
	    var value;
	    // Array#includes uses SameValueZero equality algorithm
	    // eslint-disable-next-line no-self-compare
	    if (IS_INCLUDES && el != el) while (length > index) {
	      value = O[index++];
	      // eslint-disable-next-line no-self-compare
	      if (value != value) return true;
	    // Array#indexOf ignores holes, Array#includes - not
	    } else for (;length > index; index++) if (IS_INCLUDES || index in O) {
	      if (O[index] === el) return IS_INCLUDES || index || 0;
	    } return !IS_INCLUDES && -1;
	  };
	};


/***/ }),
/* 47 */
/***/ (function(module, exports, __webpack_require__) {

	// 7.1.15 ToLength
	var toInteger = __webpack_require__(31);
	var min = Math.min;
	module.exports = function (it) {
	  return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
	};


/***/ }),
/* 48 */
/***/ (function(module, exports, __webpack_require__) {

	var toInteger = __webpack_require__(31);
	var max = Math.max;
	var min = Math.min;
	module.exports = function (index, length) {
	  index = toInteger(index);
	  return index < 0 ? max(index + length, 0) : min(index, length);
	};


/***/ }),
/* 49 */
/***/ (function(module, exports, __webpack_require__) {

	var shared = __webpack_require__(50)('keys');
	var uid = __webpack_require__(51);
	module.exports = function (key) {
	  return shared[key] || (shared[key] = uid(key));
	};


/***/ }),
/* 50 */
/***/ (function(module, exports, __webpack_require__) {

	var global = __webpack_require__(8);
	var SHARED = '__core-js_shared__';
	var store = global[SHARED] || (global[SHARED] = {});
	module.exports = function (key) {
	  return store[key] || (store[key] = {});
	};


/***/ }),
/* 51 */
/***/ (function(module, exports) {

	var id = 0;
	var px = Math.random();
	module.exports = function (key) {
	  return 'Symbol('.concat(key === undefined ? '' : key, ')_', (++id + px).toString(36));
	};


/***/ }),
/* 52 */
/***/ (function(module, exports) {

	// IE 8- don't enum bug keys
	module.exports = (
	  'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'
	).split(',');


/***/ }),
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

	var document = __webpack_require__(8).document;
	module.exports = document && document.documentElement;


/***/ }),
/* 54 */
/***/ (function(module, exports, __webpack_require__) {

	var def = __webpack_require__(13).f;
	var has = __webpack_require__(36);
	var TAG = __webpack_require__(55)('toStringTag');
	
	module.exports = function (it, tag, stat) {
	  if (it && !has(it = stat ? it : it.prototype, TAG)) def(it, TAG, { configurable: true, value: tag });
	};


/***/ }),
/* 55 */
/***/ (function(module, exports, __webpack_require__) {

	var store = __webpack_require__(50)('wks');
	var uid = __webpack_require__(51);
	var Symbol = __webpack_require__(8).Symbol;
	var USE_SYMBOL = typeof Symbol == 'function';
	
	var $exports = module.exports = function (name) {
	  return store[name] || (store[name] =
	    USE_SYMBOL && Symbol[name] || (USE_SYMBOL ? Symbol : uid)('Symbol.' + name));
	};
	
	$exports.store = store;


/***/ }),
/* 56 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.2.9 / 15.2.3.2 Object.getPrototypeOf(O)
	var has = __webpack_require__(36);
	var toObject = __webpack_require__(57);
	var IE_PROTO = __webpack_require__(49)('IE_PROTO');
	var ObjectProto = Object.prototype;
	
	module.exports = Object.getPrototypeOf || function (O) {
	  O = toObject(O);
	  if (has(O, IE_PROTO)) return O[IE_PROTO];
	  if (typeof O.constructor == 'function' && O instanceof O.constructor) {
	    return O.constructor.prototype;
	  } return O instanceof Object ? ObjectProto : null;
	};


/***/ }),
/* 57 */
/***/ (function(module, exports, __webpack_require__) {

	// 7.1.13 ToObject(argument)
	var defined = __webpack_require__(32);
	module.exports = function (it) {
	  return Object(defined(it));
	};


/***/ }),
/* 58 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(59);
	var global = __webpack_require__(8);
	var hide = __webpack_require__(12);
	var Iterators = __webpack_require__(37);
	var TO_STRING_TAG = __webpack_require__(55)('toStringTag');
	
	var DOMIterables = ('CSSRuleList,CSSStyleDeclaration,CSSValueList,ClientRectList,DOMRectList,DOMStringList,' +
	  'DOMTokenList,DataTransferItemList,FileList,HTMLAllCollection,HTMLCollection,HTMLFormElement,HTMLSelectElement,' +
	  'MediaList,MimeTypeArray,NamedNodeMap,NodeList,PaintRequestList,Plugin,PluginArray,SVGLengthList,SVGNumberList,' +
	  'SVGPathSegList,SVGPointList,SVGStringList,SVGTransformList,SourceBufferList,StyleSheetList,TextTrackCueList,' +
	  'TextTrackList,TouchList').split(',');
	
	for (var i = 0; i < DOMIterables.length; i++) {
	  var NAME = DOMIterables[i];
	  var Collection = global[NAME];
	  var proto = Collection && Collection.prototype;
	  if (proto && !proto[TO_STRING_TAG]) hide(proto, TO_STRING_TAG, NAME);
	  Iterators[NAME] = Iterators.Array;
	}


/***/ }),
/* 59 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	var addToUnscopables = __webpack_require__(60);
	var step = __webpack_require__(61);
	var Iterators = __webpack_require__(37);
	var toIObject = __webpack_require__(43);
	
	// 22.1.3.4 Array.prototype.entries()
	// 22.1.3.13 Array.prototype.keys()
	// 22.1.3.29 Array.prototype.values()
	// 22.1.3.30 Array.prototype[@@iterator]()
	module.exports = __webpack_require__(33)(Array, 'Array', function (iterated, kind) {
	  this._t = toIObject(iterated); // target
	  this._i = 0;                   // next index
	  this._k = kind;                // kind
	// 22.1.5.2.1 %ArrayIteratorPrototype%.next()
	}, function () {
	  var O = this._t;
	  var kind = this._k;
	  var index = this._i++;
	  if (!O || index >= O.length) {
	    this._t = undefined;
	    return step(1);
	  }
	  if (kind == 'keys') return step(0, index);
	  if (kind == 'values') return step(0, O[index]);
	  return step(0, [index, O[index]]);
	}, 'values');
	
	// argumentsList[@@iterator] is %ArrayProto_values% (9.4.4.6, 9.4.4.7)
	Iterators.Arguments = Iterators.Array;
	
	addToUnscopables('keys');
	addToUnscopables('values');
	addToUnscopables('entries');


/***/ }),
/* 60 */
/***/ (function(module, exports) {

	module.exports = function () { /* empty */ };


/***/ }),
/* 61 */
/***/ (function(module, exports) {

	module.exports = function (done, value) {
	  return { value: value, done: !!done };
	};


/***/ }),
/* 62 */
/***/ (function(module, exports, __webpack_require__) {

	exports.f = __webpack_require__(55);


/***/ }),
/* 63 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(64), __esModule: true };

/***/ }),
/* 64 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(65);
	__webpack_require__(75);
	__webpack_require__(76);
	__webpack_require__(77);
	module.exports = __webpack_require__(9).Symbol;


/***/ }),
/* 65 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	// ECMAScript 6 symbols shim
	var global = __webpack_require__(8);
	var has = __webpack_require__(36);
	var DESCRIPTORS = __webpack_require__(17);
	var $export = __webpack_require__(7);
	var redefine = __webpack_require__(35);
	var META = __webpack_require__(66).KEY;
	var $fails = __webpack_require__(18);
	var shared = __webpack_require__(50);
	var setToStringTag = __webpack_require__(54);
	var uid = __webpack_require__(51);
	var wks = __webpack_require__(55);
	var wksExt = __webpack_require__(62);
	var wksDefine = __webpack_require__(67);
	var enumKeys = __webpack_require__(68);
	var isArray = __webpack_require__(71);
	var anObject = __webpack_require__(14);
	var toIObject = __webpack_require__(43);
	var toPrimitive = __webpack_require__(20);
	var createDesc = __webpack_require__(21);
	var _create = __webpack_require__(39);
	var gOPNExt = __webpack_require__(72);
	var $GOPD = __webpack_require__(74);
	var $DP = __webpack_require__(13);
	var $keys = __webpack_require__(41);
	var gOPD = $GOPD.f;
	var dP = $DP.f;
	var gOPN = gOPNExt.f;
	var $Symbol = global.Symbol;
	var $JSON = global.JSON;
	var _stringify = $JSON && $JSON.stringify;
	var PROTOTYPE = 'prototype';
	var HIDDEN = wks('_hidden');
	var TO_PRIMITIVE = wks('toPrimitive');
	var isEnum = {}.propertyIsEnumerable;
	var SymbolRegistry = shared('symbol-registry');
	var AllSymbols = shared('symbols');
	var OPSymbols = shared('op-symbols');
	var ObjectProto = Object[PROTOTYPE];
	var USE_NATIVE = typeof $Symbol == 'function';
	var QObject = global.QObject;
	// Don't use setters in Qt Script, https://github.com/zloirock/core-js/issues/173
	var setter = !QObject || !QObject[PROTOTYPE] || !QObject[PROTOTYPE].findChild;
	
	// fallback for old Android, https://code.google.com/p/v8/issues/detail?id=687
	var setSymbolDesc = DESCRIPTORS && $fails(function () {
	  return _create(dP({}, 'a', {
	    get: function () { return dP(this, 'a', { value: 7 }).a; }
	  })).a != 7;
	}) ? function (it, key, D) {
	  var protoDesc = gOPD(ObjectProto, key);
	  if (protoDesc) delete ObjectProto[key];
	  dP(it, key, D);
	  if (protoDesc && it !== ObjectProto) dP(ObjectProto, key, protoDesc);
	} : dP;
	
	var wrap = function (tag) {
	  var sym = AllSymbols[tag] = _create($Symbol[PROTOTYPE]);
	  sym._k = tag;
	  return sym;
	};
	
	var isSymbol = USE_NATIVE && typeof $Symbol.iterator == 'symbol' ? function (it) {
	  return typeof it == 'symbol';
	} : function (it) {
	  return it instanceof $Symbol;
	};
	
	var $defineProperty = function defineProperty(it, key, D) {
	  if (it === ObjectProto) $defineProperty(OPSymbols, key, D);
	  anObject(it);
	  key = toPrimitive(key, true);
	  anObject(D);
	  if (has(AllSymbols, key)) {
	    if (!D.enumerable) {
	      if (!has(it, HIDDEN)) dP(it, HIDDEN, createDesc(1, {}));
	      it[HIDDEN][key] = true;
	    } else {
	      if (has(it, HIDDEN) && it[HIDDEN][key]) it[HIDDEN][key] = false;
	      D = _create(D, { enumerable: createDesc(0, false) });
	    } return setSymbolDesc(it, key, D);
	  } return dP(it, key, D);
	};
	var $defineProperties = function defineProperties(it, P) {
	  anObject(it);
	  var keys = enumKeys(P = toIObject(P));
	  var i = 0;
	  var l = keys.length;
	  var key;
	  while (l > i) $defineProperty(it, key = keys[i++], P[key]);
	  return it;
	};
	var $create = function create(it, P) {
	  return P === undefined ? _create(it) : $defineProperties(_create(it), P);
	};
	var $propertyIsEnumerable = function propertyIsEnumerable(key) {
	  var E = isEnum.call(this, key = toPrimitive(key, true));
	  if (this === ObjectProto && has(AllSymbols, key) && !has(OPSymbols, key)) return false;
	  return E || !has(this, key) || !has(AllSymbols, key) || has(this, HIDDEN) && this[HIDDEN][key] ? E : true;
	};
	var $getOwnPropertyDescriptor = function getOwnPropertyDescriptor(it, key) {
	  it = toIObject(it);
	  key = toPrimitive(key, true);
	  if (it === ObjectProto && has(AllSymbols, key) && !has(OPSymbols, key)) return;
	  var D = gOPD(it, key);
	  if (D && has(AllSymbols, key) && !(has(it, HIDDEN) && it[HIDDEN][key])) D.enumerable = true;
	  return D;
	};
	var $getOwnPropertyNames = function getOwnPropertyNames(it) {
	  var names = gOPN(toIObject(it));
	  var result = [];
	  var i = 0;
	  var key;
	  while (names.length > i) {
	    if (!has(AllSymbols, key = names[i++]) && key != HIDDEN && key != META) result.push(key);
	  } return result;
	};
	var $getOwnPropertySymbols = function getOwnPropertySymbols(it) {
	  var IS_OP = it === ObjectProto;
	  var names = gOPN(IS_OP ? OPSymbols : toIObject(it));
	  var result = [];
	  var i = 0;
	  var key;
	  while (names.length > i) {
	    if (has(AllSymbols, key = names[i++]) && (IS_OP ? has(ObjectProto, key) : true)) result.push(AllSymbols[key]);
	  } return result;
	};
	
	// 19.4.1.1 Symbol([description])
	if (!USE_NATIVE) {
	  $Symbol = function Symbol() {
	    if (this instanceof $Symbol) throw TypeError('Symbol is not a constructor!');
	    var tag = uid(arguments.length > 0 ? arguments[0] : undefined);
	    var $set = function (value) {
	      if (this === ObjectProto) $set.call(OPSymbols, value);
	      if (has(this, HIDDEN) && has(this[HIDDEN], tag)) this[HIDDEN][tag] = false;
	      setSymbolDesc(this, tag, createDesc(1, value));
	    };
	    if (DESCRIPTORS && setter) setSymbolDesc(ObjectProto, tag, { configurable: true, set: $set });
	    return wrap(tag);
	  };
	  redefine($Symbol[PROTOTYPE], 'toString', function toString() {
	    return this._k;
	  });
	
	  $GOPD.f = $getOwnPropertyDescriptor;
	  $DP.f = $defineProperty;
	  __webpack_require__(73).f = gOPNExt.f = $getOwnPropertyNames;
	  __webpack_require__(70).f = $propertyIsEnumerable;
	  __webpack_require__(69).f = $getOwnPropertySymbols;
	
	  if (DESCRIPTORS && !__webpack_require__(34)) {
	    redefine(ObjectProto, 'propertyIsEnumerable', $propertyIsEnumerable, true);
	  }
	
	  wksExt.f = function (name) {
	    return wrap(wks(name));
	  };
	}
	
	$export($export.G + $export.W + $export.F * !USE_NATIVE, { Symbol: $Symbol });
	
	for (var es6Symbols = (
	  // 19.4.2.2, 19.4.2.3, 19.4.2.4, 19.4.2.6, 19.4.2.8, 19.4.2.9, 19.4.2.10, 19.4.2.11, 19.4.2.12, 19.4.2.13, 19.4.2.14
	  'hasInstance,isConcatSpreadable,iterator,match,replace,search,species,split,toPrimitive,toStringTag,unscopables'
	).split(','), j = 0; es6Symbols.length > j;)wks(es6Symbols[j++]);
	
	for (var wellKnownSymbols = $keys(wks.store), k = 0; wellKnownSymbols.length > k;) wksDefine(wellKnownSymbols[k++]);
	
	$export($export.S + $export.F * !USE_NATIVE, 'Symbol', {
	  // 19.4.2.1 Symbol.for(key)
	  'for': function (key) {
	    return has(SymbolRegistry, key += '')
	      ? SymbolRegistry[key]
	      : SymbolRegistry[key] = $Symbol(key);
	  },
	  // 19.4.2.5 Symbol.keyFor(sym)
	  keyFor: function keyFor(sym) {
	    if (!isSymbol(sym)) throw TypeError(sym + ' is not a symbol!');
	    for (var key in SymbolRegistry) if (SymbolRegistry[key] === sym) return key;
	  },
	  useSetter: function () { setter = true; },
	  useSimple: function () { setter = false; }
	});
	
	$export($export.S + $export.F * !USE_NATIVE, 'Object', {
	  // 19.1.2.2 Object.create(O [, Properties])
	  create: $create,
	  // 19.1.2.4 Object.defineProperty(O, P, Attributes)
	  defineProperty: $defineProperty,
	  // 19.1.2.3 Object.defineProperties(O, Properties)
	  defineProperties: $defineProperties,
	  // 19.1.2.6 Object.getOwnPropertyDescriptor(O, P)
	  getOwnPropertyDescriptor: $getOwnPropertyDescriptor,
	  // 19.1.2.7 Object.getOwnPropertyNames(O)
	  getOwnPropertyNames: $getOwnPropertyNames,
	  // 19.1.2.8 Object.getOwnPropertySymbols(O)
	  getOwnPropertySymbols: $getOwnPropertySymbols
	});
	
	// 24.3.2 JSON.stringify(value [, replacer [, space]])
	$JSON && $export($export.S + $export.F * (!USE_NATIVE || $fails(function () {
	  var S = $Symbol();
	  // MS Edge converts symbol values to JSON as {}
	  // WebKit converts symbol values to JSON as null
	  // V8 throws on boxed symbols
	  return _stringify([S]) != '[null]' || _stringify({ a: S }) != '{}' || _stringify(Object(S)) != '{}';
	})), 'JSON', {
	  stringify: function stringify(it) {
	    if (it === undefined || isSymbol(it)) return; // IE8 returns string on undefined
	    var args = [it];
	    var i = 1;
	    var replacer, $replacer;
	    while (arguments.length > i) args.push(arguments[i++]);
	    replacer = args[1];
	    if (typeof replacer == 'function') $replacer = replacer;
	    if ($replacer || !isArray(replacer)) replacer = function (key, value) {
	      if ($replacer) value = $replacer.call(this, key, value);
	      if (!isSymbol(value)) return value;
	    };
	    args[1] = replacer;
	    return _stringify.apply($JSON, args);
	  }
	});
	
	// 19.4.3.4 Symbol.prototype[@@toPrimitive](hint)
	$Symbol[PROTOTYPE][TO_PRIMITIVE] || __webpack_require__(12)($Symbol[PROTOTYPE], TO_PRIMITIVE, $Symbol[PROTOTYPE].valueOf);
	// 19.4.3.5 Symbol.prototype[@@toStringTag]
	setToStringTag($Symbol, 'Symbol');
	// 20.2.1.9 Math[@@toStringTag]
	setToStringTag(Math, 'Math', true);
	// 24.3.3 JSON[@@toStringTag]
	setToStringTag(global.JSON, 'JSON', true);


/***/ }),
/* 66 */
/***/ (function(module, exports, __webpack_require__) {

	var META = __webpack_require__(51)('meta');
	var isObject = __webpack_require__(15);
	var has = __webpack_require__(36);
	var setDesc = __webpack_require__(13).f;
	var id = 0;
	var isExtensible = Object.isExtensible || function () {
	  return true;
	};
	var FREEZE = !__webpack_require__(18)(function () {
	  return isExtensible(Object.preventExtensions({}));
	});
	var setMeta = function (it) {
	  setDesc(it, META, { value: {
	    i: 'O' + ++id, // object ID
	    w: {}          // weak collections IDs
	  } });
	};
	var fastKey = function (it, create) {
	  // return primitive with prefix
	  if (!isObject(it)) return typeof it == 'symbol' ? it : (typeof it == 'string' ? 'S' : 'P') + it;
	  if (!has(it, META)) {
	    // can't set metadata to uncaught frozen object
	    if (!isExtensible(it)) return 'F';
	    // not necessary to add metadata
	    if (!create) return 'E';
	    // add missing metadata
	    setMeta(it);
	  // return object ID
	  } return it[META].i;
	};
	var getWeak = function (it, create) {
	  if (!has(it, META)) {
	    // can't set metadata to uncaught frozen object
	    if (!isExtensible(it)) return true;
	    // not necessary to add metadata
	    if (!create) return false;
	    // add missing metadata
	    setMeta(it);
	  // return hash weak collections IDs
	  } return it[META].w;
	};
	// add metadata on freeze-family methods calling
	var onFreeze = function (it) {
	  if (FREEZE && meta.NEED && isExtensible(it) && !has(it, META)) setMeta(it);
	  return it;
	};
	var meta = module.exports = {
	  KEY: META,
	  NEED: false,
	  fastKey: fastKey,
	  getWeak: getWeak,
	  onFreeze: onFreeze
	};


/***/ }),
/* 67 */
/***/ (function(module, exports, __webpack_require__) {

	var global = __webpack_require__(8);
	var core = __webpack_require__(9);
	var LIBRARY = __webpack_require__(34);
	var wksExt = __webpack_require__(62);
	var defineProperty = __webpack_require__(13).f;
	module.exports = function (name) {
	  var $Symbol = core.Symbol || (core.Symbol = LIBRARY ? {} : global.Symbol || {});
	  if (name.charAt(0) != '_' && !(name in $Symbol)) defineProperty($Symbol, name, { value: wksExt.f(name) });
	};


/***/ }),
/* 68 */
/***/ (function(module, exports, __webpack_require__) {

	// all enumerable object keys, includes symbols
	var getKeys = __webpack_require__(41);
	var gOPS = __webpack_require__(69);
	var pIE = __webpack_require__(70);
	module.exports = function (it) {
	  var result = getKeys(it);
	  var getSymbols = gOPS.f;
	  if (getSymbols) {
	    var symbols = getSymbols(it);
	    var isEnum = pIE.f;
	    var i = 0;
	    var key;
	    while (symbols.length > i) if (isEnum.call(it, key = symbols[i++])) result.push(key);
	  } return result;
	};


/***/ }),
/* 69 */
/***/ (function(module, exports) {

	exports.f = Object.getOwnPropertySymbols;


/***/ }),
/* 70 */
/***/ (function(module, exports) {

	exports.f = {}.propertyIsEnumerable;


/***/ }),
/* 71 */
/***/ (function(module, exports, __webpack_require__) {

	// 7.2.2 IsArray(argument)
	var cof = __webpack_require__(45);
	module.exports = Array.isArray || function isArray(arg) {
	  return cof(arg) == 'Array';
	};


/***/ }),
/* 72 */
/***/ (function(module, exports, __webpack_require__) {

	// fallback for IE11 buggy Object.getOwnPropertyNames with iframe and window
	var toIObject = __webpack_require__(43);
	var gOPN = __webpack_require__(73).f;
	var toString = {}.toString;
	
	var windowNames = typeof window == 'object' && window && Object.getOwnPropertyNames
	  ? Object.getOwnPropertyNames(window) : [];
	
	var getWindowNames = function (it) {
	  try {
	    return gOPN(it);
	  } catch (e) {
	    return windowNames.slice();
	  }
	};
	
	module.exports.f = function getOwnPropertyNames(it) {
	  return windowNames && toString.call(it) == '[object Window]' ? getWindowNames(it) : gOPN(toIObject(it));
	};


/***/ }),
/* 73 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.2.7 / 15.2.3.4 Object.getOwnPropertyNames(O)
	var $keys = __webpack_require__(42);
	var hiddenKeys = __webpack_require__(52).concat('length', 'prototype');
	
	exports.f = Object.getOwnPropertyNames || function getOwnPropertyNames(O) {
	  return $keys(O, hiddenKeys);
	};


/***/ }),
/* 74 */
/***/ (function(module, exports, __webpack_require__) {

	var pIE = __webpack_require__(70);
	var createDesc = __webpack_require__(21);
	var toIObject = __webpack_require__(43);
	var toPrimitive = __webpack_require__(20);
	var has = __webpack_require__(36);
	var IE8_DOM_DEFINE = __webpack_require__(16);
	var gOPD = Object.getOwnPropertyDescriptor;
	
	exports.f = __webpack_require__(17) ? gOPD : function getOwnPropertyDescriptor(O, P) {
	  O = toIObject(O);
	  P = toPrimitive(P, true);
	  if (IE8_DOM_DEFINE) try {
	    return gOPD(O, P);
	  } catch (e) { /* empty */ }
	  if (has(O, P)) return createDesc(!pIE.f.call(O, P), O[P]);
	};


/***/ }),
/* 75 */
/***/ (function(module, exports) {



/***/ }),
/* 76 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(67)('asyncIterator');


/***/ }),
/* 77 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(67)('observable');


/***/ }),
/* 78 */
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	exports.__esModule = true;
	
	var _isIterable2 = __webpack_require__(79);
	
	var _isIterable3 = _interopRequireDefault(_isIterable2);
	
	var _getIterator2 = __webpack_require__(83);
	
	var _getIterator3 = _interopRequireDefault(_getIterator2);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = function () {
	  function sliceIterator(arr, i) {
	    var _arr = [];
	    var _n = true;
	    var _d = false;
	    var _e = undefined;
	
	    try {
	      for (var _i = (0, _getIterator3.default)(arr), _s; !(_n = (_s = _i.next()).done); _n = true) {
	        _arr.push(_s.value);
	
	        if (i && _arr.length === i) break;
	      }
	    } catch (err) {
	      _d = true;
	      _e = err;
	    } finally {
	      try {
	        if (!_n && _i["return"]) _i["return"]();
	      } finally {
	        if (_d) throw _e;
	      }
	    }
	
	    return _arr;
	  }
	
	  return function (arr, i) {
	    if (Array.isArray(arr)) {
	      return arr;
	    } else if ((0, _isIterable3.default)(Object(arr))) {
	      return sliceIterator(arr, i);
	    } else {
	      throw new TypeError("Invalid attempt to destructure non-iterable instance");
	    }
	  };
	}();

/***/ }),
/* 79 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(80), __esModule: true };

/***/ }),
/* 80 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(58);
	__webpack_require__(29);
	module.exports = __webpack_require__(81);


/***/ }),
/* 81 */
/***/ (function(module, exports, __webpack_require__) {

	var classof = __webpack_require__(82);
	var ITERATOR = __webpack_require__(55)('iterator');
	var Iterators = __webpack_require__(37);
	module.exports = __webpack_require__(9).isIterable = function (it) {
	  var O = Object(it);
	  return O[ITERATOR] !== undefined
	    || '@@iterator' in O
	    // eslint-disable-next-line no-prototype-builtins
	    || Iterators.hasOwnProperty(classof(O));
	};


/***/ }),
/* 82 */
/***/ (function(module, exports, __webpack_require__) {

	// getting tag from 19.1.3.6 Object.prototype.toString()
	var cof = __webpack_require__(45);
	var TAG = __webpack_require__(55)('toStringTag');
	// ES3 wrong here
	var ARG = cof(function () { return arguments; }()) == 'Arguments';
	
	// fallback for IE11 Script Access Denied error
	var tryGet = function (it, key) {
	  try {
	    return it[key];
	  } catch (e) { /* empty */ }
	};
	
	module.exports = function (it) {
	  var O, T, B;
	  return it === undefined ? 'Undefined' : it === null ? 'Null'
	    // @@toStringTag case
	    : typeof (T = tryGet(O = Object(it), TAG)) == 'string' ? T
	    // builtinTag case
	    : ARG ? cof(O)
	    // ES3 arguments fallback
	    : (B = cof(O)) == 'Object' && typeof O.callee == 'function' ? 'Arguments' : B;
	};


/***/ }),
/* 83 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(84), __esModule: true };

/***/ }),
/* 84 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(58);
	__webpack_require__(29);
	module.exports = __webpack_require__(85);


/***/ }),
/* 85 */
/***/ (function(module, exports, __webpack_require__) {

	var anObject = __webpack_require__(14);
	var get = __webpack_require__(86);
	module.exports = __webpack_require__(9).getIterator = function (it) {
	  var iterFn = get(it);
	  if (typeof iterFn != 'function') throw TypeError(it + ' is not iterable!');
	  return anObject(iterFn.call(it));
	};


/***/ }),
/* 86 */
/***/ (function(module, exports, __webpack_require__) {

	var classof = __webpack_require__(82);
	var ITERATOR = __webpack_require__(55)('iterator');
	var Iterators = __webpack_require__(37);
	module.exports = __webpack_require__(9).getIteratorMethod = function (it) {
	  if (it != undefined) return it[ITERATOR]
	    || it['@@iterator']
	    || Iterators[classof(it)];
	};


/***/ }),
/* 87 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	
	var _getPrototypeOf = __webpack_require__(88);
	
	var _getPrototypeOf2 = _interopRequireDefault(_getPrototypeOf);
	
	var _classCallCheck2 = __webpack_require__(2);
	
	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);
	
	var _createClass2 = __webpack_require__(3);
	
	var _createClass3 = _interopRequireDefault(_createClass2);
	
	var _possibleConstructorReturn2 = __webpack_require__(92);
	
	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);
	
	var _get2 = __webpack_require__(93);
	
	var _get3 = _interopRequireDefault(_get2);
	
	var _inherits2 = __webpack_require__(97);
	
	var _inherits3 = _interopRequireDefault(_inherits2);
	
	var _Component2 = __webpack_require__(23);
	
	var _Component3 = _interopRequireDefault(_Component2);
	
	var _Utils = __webpack_require__(105);
	
	var _Utils2 = _interopRequireDefault(_Utils);
	
	var _ComponentFinder = __webpack_require__(24);
	
	var _ComponentFinder2 = _interopRequireDefault(_ComponentFinder);
	
	var _OrderCollection = __webpack_require__(106);
	
	var _OrderCollection2 = _interopRequireDefault(_OrderCollection);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var OrderCollectionElement = function (_Component) {
	    (0, _inherits3.default)(OrderCollectionElement, _Component);
	
	    function OrderCollectionElement() {
	        (0, _classCallCheck3.default)(this, OrderCollectionElement);
	        return (0, _possibleConstructorReturn3.default)(this, (OrderCollectionElement.__proto__ || (0, _getPrototypeOf2.default)(OrderCollectionElement)).apply(this, arguments));
	    }
	
	    (0, _createClass3.default)(OrderCollectionElement, [{
	        key: 'init',
	        value: function init() {
	            var _this2 = this;
	
	            (0, _get3.default)(OrderCollectionElement.prototype.__proto__ || (0, _getPrototypeOf2.default)(OrderCollectionElement.prototype), 'init', this).call(this);
	
	            var parentComponent = _ComponentFinder2.default.parent(this.$node, 'order_collection');
	            var removeElementButton = _Utils2.default.single_element(this.$node, 'remove_element');
	
	            removeElementButton.on('click', function () {
	                parentComponent.trigger(_OrderCollection2.default.events.REMOVE_ELEMENT, _this2.$node);
	            });
	        }
	    }], [{
	        key: 'id',
	        get: function get() {
	            return 'OrderCollectionElement';
	        }
	    }]);
	    return OrderCollectionElement;
	}(_Component3.default);
	
	exports.default = OrderCollectionElement;

/***/ }),
/* 88 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(89), __esModule: true };

/***/ }),
/* 89 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(90);
	module.exports = __webpack_require__(9).Object.getPrototypeOf;


/***/ }),
/* 90 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.2.9 Object.getPrototypeOf(O)
	var toObject = __webpack_require__(57);
	var $getPrototypeOf = __webpack_require__(56);
	
	__webpack_require__(91)('getPrototypeOf', function () {
	  return function getPrototypeOf(it) {
	    return $getPrototypeOf(toObject(it));
	  };
	});


/***/ }),
/* 91 */
/***/ (function(module, exports, __webpack_require__) {

	// most Object methods by ES6 should accept primitives
	var $export = __webpack_require__(7);
	var core = __webpack_require__(9);
	var fails = __webpack_require__(18);
	module.exports = function (KEY, exec) {
	  var fn = (core.Object || {})[KEY] || Object[KEY];
	  var exp = {};
	  exp[KEY] = exec(fn);
	  $export($export.S + $export.F * fails(function () { fn(1); }), 'Object', exp);
	};


/***/ }),
/* 92 */
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	exports.__esModule = true;
	
	var _typeof2 = __webpack_require__(26);
	
	var _typeof3 = _interopRequireDefault(_typeof2);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = function (self, call) {
	  if (!self) {
	    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
	  }
	
	  return call && ((typeof call === "undefined" ? "undefined" : (0, _typeof3.default)(call)) === "object" || typeof call === "function") ? call : self;
	};

/***/ }),
/* 93 */
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	exports.__esModule = true;
	
	var _getPrototypeOf = __webpack_require__(88);
	
	var _getPrototypeOf2 = _interopRequireDefault(_getPrototypeOf);
	
	var _getOwnPropertyDescriptor = __webpack_require__(94);
	
	var _getOwnPropertyDescriptor2 = _interopRequireDefault(_getOwnPropertyDescriptor);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = function get(object, property, receiver) {
	  if (object === null) object = Function.prototype;
	  var desc = (0, _getOwnPropertyDescriptor2.default)(object, property);
	
	  if (desc === undefined) {
	    var parent = (0, _getPrototypeOf2.default)(object);
	
	    if (parent === null) {
	      return undefined;
	    } else {
	      return get(parent, property, receiver);
	    }
	  } else if ("value" in desc) {
	    return desc.value;
	  } else {
	    var getter = desc.get;
	
	    if (getter === undefined) {
	      return undefined;
	    }
	
	    return getter.call(receiver);
	  }
	};

/***/ }),
/* 94 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(95), __esModule: true };

/***/ }),
/* 95 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(96);
	var $Object = __webpack_require__(9).Object;
	module.exports = function getOwnPropertyDescriptor(it, key) {
	  return $Object.getOwnPropertyDescriptor(it, key);
	};


/***/ }),
/* 96 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.2.6 Object.getOwnPropertyDescriptor(O, P)
	var toIObject = __webpack_require__(43);
	var $getOwnPropertyDescriptor = __webpack_require__(74).f;
	
	__webpack_require__(91)('getOwnPropertyDescriptor', function () {
	  return function getOwnPropertyDescriptor(it, key) {
	    return $getOwnPropertyDescriptor(toIObject(it), key);
	  };
	});


/***/ }),
/* 97 */
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	exports.__esModule = true;
	
	var _setPrototypeOf = __webpack_require__(98);
	
	var _setPrototypeOf2 = _interopRequireDefault(_setPrototypeOf);
	
	var _create = __webpack_require__(102);
	
	var _create2 = _interopRequireDefault(_create);
	
	var _typeof2 = __webpack_require__(26);
	
	var _typeof3 = _interopRequireDefault(_typeof2);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	exports.default = function (subClass, superClass) {
	  if (typeof superClass !== "function" && superClass !== null) {
	    throw new TypeError("Super expression must either be null or a function, not " + (typeof superClass === "undefined" ? "undefined" : (0, _typeof3.default)(superClass)));
	  }
	
	  subClass.prototype = (0, _create2.default)(superClass && superClass.prototype, {
	    constructor: {
	      value: subClass,
	      enumerable: false,
	      writable: true,
	      configurable: true
	    }
	  });
	  if (superClass) _setPrototypeOf2.default ? (0, _setPrototypeOf2.default)(subClass, superClass) : subClass.__proto__ = superClass;
	};

/***/ }),
/* 98 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(99), __esModule: true };

/***/ }),
/* 99 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(100);
	module.exports = __webpack_require__(9).Object.setPrototypeOf;


/***/ }),
/* 100 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.3.19 Object.setPrototypeOf(O, proto)
	var $export = __webpack_require__(7);
	$export($export.S, 'Object', { setPrototypeOf: __webpack_require__(101).set });


/***/ }),
/* 101 */
/***/ (function(module, exports, __webpack_require__) {

	// Works with __proto__ only. Old v8 can't work with null proto objects.
	/* eslint-disable no-proto */
	var isObject = __webpack_require__(15);
	var anObject = __webpack_require__(14);
	var check = function (O, proto) {
	  anObject(O);
	  if (!isObject(proto) && proto !== null) throw TypeError(proto + ": can't set as prototype!");
	};
	module.exports = {
	  set: Object.setPrototypeOf || ('__proto__' in {} ? // eslint-disable-line
	    function (test, buggy, set) {
	      try {
	        set = __webpack_require__(10)(Function.call, __webpack_require__(74).f(Object.prototype, '__proto__').set, 2);
	        set(test, []);
	        buggy = !(test instanceof Array);
	      } catch (e) { buggy = true; }
	      return function setPrototypeOf(O, proto) {
	        check(O, proto);
	        if (buggy) O.__proto__ = proto;
	        else set(O, proto);
	        return O;
	      };
	    }({}, false) : undefined),
	  check: check
	};


/***/ }),
/* 102 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(103), __esModule: true };

/***/ }),
/* 103 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(104);
	var $Object = __webpack_require__(9).Object;
	module.exports = function create(P, D) {
	  return $Object.create(P, D);
	};


/***/ }),
/* 104 */
/***/ (function(module, exports, __webpack_require__) {

	var $export = __webpack_require__(7);
	// 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
	$export($export.S, 'Object', { create: __webpack_require__(39) });


/***/ }),
/* 105 */
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	
	var _classCallCheck2 = __webpack_require__(2);
	
	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);
	
	var _createClass2 = __webpack_require__(3);
	
	var _createClass3 = _interopRequireDefault(_createClass2);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var Utils = function () {
	    function Utils() {
	        (0, _classCallCheck3.default)(this, Utils);
	    }
	
	    (0, _createClass3.default)(Utils, null, [{
	        key: "single_element",
	        value: function single_element($node, elementName) {
	            //todo prevent select elements of child components
	            return $node.find("[data-component-role=" + elementName + "]");
	        }
	    }, {
	        key: "callMethod",
	        value: function callMethod($node, name) {
	            var data = {};
	            $node.trigger(name, data);
	            return data.returnResult;
	        }
	    }, {
	        key: "registerMethod",
	        value: function registerMethod($node, name, method) {
	            $node.on(name, function (e, data) {
	                data.returnResult = method();
	            });
	        }
	    }]);
	    return Utils;
	}();
	
	exports.default = Utils;

/***/ }),
/* 106 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	
	var _stringify = __webpack_require__(107);
	
	var _stringify2 = _interopRequireDefault(_stringify);
	
	var _getPrototypeOf = __webpack_require__(88);
	
	var _getPrototypeOf2 = _interopRequireDefault(_getPrototypeOf);
	
	var _classCallCheck2 = __webpack_require__(2);
	
	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);
	
	var _createClass2 = __webpack_require__(3);
	
	var _createClass3 = _interopRequireDefault(_createClass2);
	
	var _possibleConstructorReturn2 = __webpack_require__(92);
	
	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);
	
	var _get2 = __webpack_require__(93);
	
	var _get3 = _interopRequireDefault(_get2);
	
	var _inherits2 = __webpack_require__(97);
	
	var _inherits3 = _interopRequireDefault(_inherits2);
	
	var _Component2 = __webpack_require__(23);
	
	var _Component3 = _interopRequireDefault(_Component2);
	
	var _Utils = __webpack_require__(105);
	
	var _Utils2 = _interopRequireDefault(_Utils);
	
	var _ComponentFinder = __webpack_require__(24);
	
	var _ComponentFinder2 = _interopRequireDefault(_ComponentFinder);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var EVENTS = {
	    REMOVE_ELEMENT: 'collection.remove_element'
	};
	
	var OrderCollection = function (_Component) {
	    (0, _inherits3.default)(OrderCollection, _Component);
	
	    function OrderCollection() {
	        (0, _classCallCheck3.default)(this, OrderCollection);
	        return (0, _possibleConstructorReturn3.default)(this, (OrderCollection.__proto__ || (0, _getPrototypeOf2.default)(OrderCollection)).apply(this, arguments));
	    }
	
	    (0, _createClass3.default)(OrderCollection, [{
	        key: 'propTypes',
	        value: function propTypes() {
	            return {
	                prototype: { type: 'string' }
	            };
	        }
	    }, {
	        key: 'init',
	        value: function init() {
	            var _this2 = this;
	
	            (0, _get3.default)(OrderCollection.prototype.__proto__ || (0, _getPrototypeOf2.default)(OrderCollection.prototype), 'init', this).call(this);
	
	            var entityContainer = _Utils2.default.single_element(this.$node, 'entity_container');
	            var childItems = _ComponentFinder2.default.all_childrens(entityContainer);
	            this.state = { index: childItems.length };
	
	            var addButton = _Utils2.default.single_element(this.$node, 'add_element');
	            addButton.on('click', function (e) {
	                e.preventDefault();
	                _this2.addElement();
	            });
	            this.$node.on(EVENTS.REMOVE_ELEMENT, function (e, elementNode) {
	                return _this2.removeElement($(elementNode));
	            });
	        }
	    }, {
	        key: 'addElement',
	        value: function addElement() {
	            var expanded = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
	
	            var prototype = this.$node.data('prototype');
	
	            var newItem = $(prototype.replace(/__name__/g, this.state.index));
	            newItem.attr('data-expanded', (0, _stringify2.default)(expanded));
	            var entityContainer = _Utils2.default.single_element(this.$node, 'entity_container');
	            entityContainer.append(newItem);
	
	            this.state.index++;
	
	            $(document).trigger(_Component3.default.events.INIT_COMPONENTS, newItem);
	            return newItem;
	        }
	    }, {
	        key: 'removeElement',
	        value: function removeElement($elementNode) {
	            $elementNode.trigger('remove');
	        }
	    }], [{
	        key: 'id',
	        get: function get() {
	            return 'OrderCollection';
	        }
	    }, {
	        key: 'events',
	        get: function get() {
	            return EVENTS;
	        }
	    }]);
	    return OrderCollection;
	}(_Component3.default);
	
	exports.default = OrderCollection;

/***/ }),
/* 107 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(108), __esModule: true };

/***/ }),
/* 108 */
/***/ (function(module, exports, __webpack_require__) {

	var core = __webpack_require__(9);
	var $JSON = core.JSON || (core.JSON = { stringify: JSON.stringify });
	module.exports = function stringify(it) { // eslint-disable-line no-unused-vars
	  return $JSON.stringify.apply($JSON, arguments);
	};


/***/ }),
/* 109 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	
	var _getPrototypeOf = __webpack_require__(88);
	
	var _getPrototypeOf2 = _interopRequireDefault(_getPrototypeOf);
	
	var _classCallCheck2 = __webpack_require__(2);
	
	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);
	
	var _createClass2 = __webpack_require__(3);
	
	var _createClass3 = _interopRequireDefault(_createClass2);
	
	var _possibleConstructorReturn2 = __webpack_require__(92);
	
	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);
	
	var _get2 = __webpack_require__(93);
	
	var _get3 = _interopRequireDefault(_get2);
	
	var _inherits2 = __webpack_require__(97);
	
	var _inherits3 = _interopRequireDefault(_inherits2);
	
	var _Component2 = __webpack_require__(23);
	
	var _Component3 = _interopRequireDefault(_Component2);
	
	var _Utils = __webpack_require__(105);
	
	var _Utils2 = _interopRequireDefault(_Utils);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var ColumnsSelector = function (_Component) {
	    (0, _inherits3.default)(ColumnsSelector, _Component);
	
	    function ColumnsSelector() {
	        (0, _classCallCheck3.default)(this, ColumnsSelector);
	        return (0, _possibleConstructorReturn3.default)(this, (ColumnsSelector.__proto__ || (0, _getPrototypeOf2.default)(ColumnsSelector)).apply(this, arguments));
	    }
	
	    (0, _createClass3.default)(ColumnsSelector, [{
	        key: 'init',
	        value: function init() {
	            var _this2 = this;
	
	            (0, _get3.default)(ColumnsSelector.prototype.__proto__ || (0, _getPrototypeOf2.default)(ColumnsSelector.prototype), 'init', this).call(this);
	
	            this.controls = {
	                allColumnsList: _Utils2.default.single_element(this.$node, 'all_columns_list'),
	                targetColumns: _Utils2.default.single_element(this.$node, 'target_columns'),
	                selectedFields: _Utils2.default.single_element(this.$node, 'selected_fields'),
	
	                addColumnButton: _Utils2.default.single_element(this.$node, 'add_column_button'),
	                delColumnButton: _Utils2.default.single_element(this.$node, 'del_column_button'),
	                moveUpColumnButton: _Utils2.default.single_element(this.$node, 'move_up_column_button'),
	                moveDownColumnButton: _Utils2.default.single_element(this.$node, 'move_down_column_button')
	            };
	
	            this.controls.addColumnButton.on('click', function () {
	                var selectedOptions = _this2.controls.allColumnsList.find('option:selected');
	                if (selectedOptions.length) {
	                    selectedOptions.each(function (idx, selectedOption) {
	                        var selectedValue = $(selectedOption).val();
	                        var selectedLabel = $(selectedOption).text();
	                        if (_this2.controls.targetColumns.find('option[value=\'' + selectedValue + '\']').length === 0) {
	                            var newOption = $('<option></option>').attr('value', selectedValue).text(selectedLabel);
	                            _this2.controls.targetColumns.append(newOption);
	                        }
	                    });
	                    _this2.syncModel();
	                }
	            });
	
	            this.controls.delColumnButton.on('click', function () {
	                _this2.controls.targetColumns.find('option:selected').remove();
	                _this2.syncModel();
	            });
	
	            this.controls.moveUpColumnButton.on('click', function () {
	                var selectedOption = _this2.controls.targetColumns.find('option:selected');
	                if (selectedOption.length) {
	                    selectedOption.first().prev().before(selectedOption);
	                    _this2.syncModel();
	                }
	            });
	
	            this.controls.moveDownColumnButton.on('click', function () {
	                var selectedOption = _this2.controls.targetColumns.find('option:selected');
	                if (selectedOption.length) {
	                    selectedOption.last().next().after(selectedOption);
	                    _this2.syncModel();
	                }
	            });
	        }
	    }, {
	        key: 'syncModel',
	        value: function syncModel() {
	            var selectedFields = this.controls.targetColumns.find('option').map(function () {
	                return this.value;
	            }).get().join(',');
	
	            this.controls.selectedFields.val(selectedFields);
	        }
	    }], [{
	        key: 'id',
	        get: function get() {
	            return 'ColumnsSelector';
	        }
	    }]);
	    return ColumnsSelector;
	}(_Component3.default);
	
	exports.default = ColumnsSelector;

/***/ }),
/* 110 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	
	var _getPrototypeOf = __webpack_require__(88);
	
	var _getPrototypeOf2 = _interopRequireDefault(_getPrototypeOf);
	
	var _classCallCheck2 = __webpack_require__(2);
	
	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);
	
	var _createClass2 = __webpack_require__(3);
	
	var _createClass3 = _interopRequireDefault(_createClass2);
	
	var _possibleConstructorReturn2 = __webpack_require__(92);
	
	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);
	
	var _get2 = __webpack_require__(93);
	
	var _get3 = _interopRequireDefault(_get2);
	
	var _inherits2 = __webpack_require__(97);
	
	var _inherits3 = _interopRequireDefault(_inherits2);
	
	var _Component2 = __webpack_require__(23);
	
	var _Component3 = _interopRequireDefault(_Component2);
	
	var _Utils = __webpack_require__(105);
	
	var _Utils2 = _interopRequireDefault(_Utils);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	var Filter = function (_Component) {
	    (0, _inherits3.default)(Filter, _Component);
	
	    function Filter() {
	        (0, _classCallCheck3.default)(this, Filter);
	        return (0, _possibleConstructorReturn3.default)(this, (Filter.__proto__ || (0, _getPrototypeOf2.default)(Filter)).apply(this, arguments));
	    }
	
	    (0, _createClass3.default)(Filter, [{
	        key: 'init',
	        value: function init() {
	            (0, _get3.default)(Filter.prototype.__proto__ || (0, _getPrototypeOf2.default)(Filter.prototype), 'init', this).call(this);
	            this.filterTable = _Utils2.default.single_element(this.$node, 'filter_table');
	            this.fieldSelector = _Utils2.default.single_element(this.$node, 'field_selector');
	            this.initHideButtons();
	
	            var self = this;
	
	            var hideButtons = _Utils2.default.single_element(this.$node, 'hide_filter_row');
	            hideButtons.each(function (idx, hideButton) {
	                $(hideButton).on('click', function () {
	                    var rowName = $(this).attr('data-field');
	                    self.hideRow(rowName);
	                });
	            });
	
	            var displayButtons = this.fieldSelector.find('li');
	            displayButtons.each(function (idx, displayButton) {
	                $(displayButton).on('click', function () {
	                    var rowName = $(this).attr('data-field');
	                    self.revertRowVisibility(rowName);
	                });
	            });
	        }
	    }, {
	        key: 'initHideButtons',
	        value: function initHideButtons() {
	            var _this2 = this;
	
	            this.$node.find('li[data-field]').each(function (idx, element) {
	                var fieldName = $(element).attr('data-field');
	                var tableRow = _this2.filterTable.find('tr[data-field=\'' + fieldName + '\']');
	                var needDisplayTableRow = tableRow.attr('data-display');
	
	                if (needDisplayTableRow) {
	                    _Utils2.default.single_element($(element), 'row_visibility').prop('checked', true);
	                } else {
	                    _Utils2.default.single_element($(element), 'row_visibility').prop('checked', false);
	                    tableRow.find(":input").attr("disabled", true);
	                }
	            });
	        }
	    }, {
	        key: 'hideRow',
	        value: function hideRow(rowName) {
	            var tableRow = this.filterTable.find('tr[data-field=\'' + rowName + '\']');
	            tableRow.hide();
	            tableRow.find(":input").attr("disabled", true);
	            var rowSelector = this.fieldSelector.find('li[data-field=\'' + rowName + '\']');
	            _Utils2.default.single_element(rowSelector, 'row_visibility').prop('checked', false);
	        }
	    }, {
	        key: 'showRow',
	        value: function showRow(rowName) {
	            var tableRow = this.filterTable.find('tr[data-field=\'' + rowName + '\']');
	            tableRow.find(":input").attr("disabled", false);
	            tableRow.show();
	            var rowSelector = this.fieldSelector.find('li[data-field=\'' + rowName + '\']');
	            _Utils2.default.single_element(rowSelector, 'row_visibility').prop('checked', true);
	        }
	    }, {
	        key: 'revertRowVisibility',
	        value: function revertRowVisibility(rowName) {
	            var tableRow = this.filterTable.find('tr[data-field=\'' + rowName + '\']');
	            if (tableRow.is(':visible')) {
	                this.hideRow(rowName);
	            } else {
	                this.showRow(rowName);
	            }
	        }
	    }], [{
	        key: 'id',
	        get: function get() {
	            return 'Filter';
	        }
	    }]);
	    return Filter;
	}(_Component3.default);
	
	exports.default = Filter;

/***/ })
/******/ ]);
//# sourceMappingURL=app.js.map