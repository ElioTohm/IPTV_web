webpackJsonp([0],{

/***/ 46:
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// this module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate
    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ 47:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    /*
     * The component's data.
     */
    data: function data() {
        return {
            channels: [],

            genres: [],

            createForm: {
                errors: [],
                number: 0,
                name: '',
                stream: '',
                thumbnail: '',
                genres: []
            },

            editForm: {
                errors: [],
                number: 0,
                name: '',
                stream: '',
                thumbnail: '',
                genres: []
            },

            search: {
                errors: [],
                model: 'Channel',
                query: ''
            }

        };
    },


    /**
     * Prepare the component (Vue 2.x).
     */
    mounted: function mounted() {
        this.getChannel();
    },


    /**
     * Watcher for search data 
     */
    watch: {
        'search.query': function searchQuery() {
            var _this = this;

            if (this.search.query != '') {
                axios.get('/search', { params: this.search }).then(function (response) {
                    _this.channels = response.data;
                });
            } else {
                this.getChannel();
            }
        }
    },

    methods: {

        /**
         * Get all of the OAuth channels for the user.
         */
        getChannel: function getChannel() {
            var _this2 = this;

            axios.get('/channel').then(function (response) {
                _this2.channels = response.data.channels;
                _this2.genres = response.data.genres;
            });
        },


        /**
         * Show the form for adding new channel.
         */
        showAddChannelForm: function showAddChannelForm() {
            $('#modal-add-channel').modal('show');
        },


        /**
         * Create a new OAuth channel for the user.
         */
        store: function store() {
            this.persistChannel('post', '/channel', this.createForm, '#modal-create-channel');
        },


        /**
         * Edit the given channel.
         */
        edit: function edit(channel) {
            this.editForm.id = channel.id;
            this.editForm.name = channel.name;
            this.editForm.stream = channel.stream;
            this.editForm.thumbnail = channel.thumbnail;
            this.editForm.genre = channel.genre;
            this.editForm.number = channel.number;

            $('#modal-edit-channel').modal('show');
        },


        /**
         * Update the channel being edited.
         */
        update: function update() {
            this.persistChannel('put', '/channel/' + this.editForm.id, this.editForm, '#modal-edit-channel');
        },


        /**
        * Persist the channel to storage using the given form.
        */
        persistChannel: function persistChannel(method, uri, form, modal) {
            var _this3 = this;

            form.errors = [];

            axios[method](uri, form).then(function (response) {
                _this3.getChannel();

                form.errors = [];
                form.name = '';
                form.stream = '';
                form.thumbnail = '';
                form.genre = '';
                form.number = '';

                $(modal).modal('hide');
            }).catch(function (error) {
                if (_typeof(error.response.data) === 'object') {
                    form.errors = _.flatten(_.toArray(error.response.data));
                } else {
                    form.errors = ['Something went wrong. Please try again.'];
                }
            });
        },


        /**
         * Destroy the given client.
         */
        destroy: function destroy(channel) {
            var _this4 = this;

            axios.delete('/channel/' + channel.id).then(function (response) {
                _this4.getChannel();
            });
        }
    }
});

/***/ }),

/***/ 48:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "panel panel-default"
  }, [_c('div', {
    staticClass: "panel-heading"
  }, [_c('div', {
    staticStyle: {
      "display": "flex",
      "justify-content": "space-between",
      "align-items": "center"
    }
  }, [_c('span', [_vm._v("\n                    Channels \n                ")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.search.query),
      expression: "search.query"
    }],
    attrs: {
      "placeholder": "Search"
    },
    domProps: {
      "value": (_vm.search.query)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.search.query = $event.target.value
      }
    }
  }), _vm._v(" "), _c('a', {
    staticClass: "action-link",
    on: {
      "click": _vm.showAddChannelForm
    }
  }, [_vm._v("\n                    Add New Channel\n                ")])])]), _vm._v(" "), _c('div', {
    staticClass: "panel-body"
  }, [_c('table', {
    staticClass: "table table-striped"
  }, [_vm._m(0), _vm._v(" "), _c('tbody', _vm._l((_vm.channels), function(channel) {
    return _c('tr', {
      key: channel.id
    }, [_c('td', {
      staticClass: "col-md-2"
    }, [_vm._v(_vm._s(channel.number))]), _vm._v(" "), _c('td', {
      staticClass: "col-md-2"
    }, [_vm._v(_vm._s(channel.name))]), _vm._v(" "), _c('td', {
      staticClass: "col-md-3"
    }, [_vm._v(_vm._s(channel.stream))]), _vm._v(" "), _c('td', {
      staticClass: "col-md-3"
    }, [_vm._v(_vm._s(channel.thumbnail))]), _vm._v(" "), _c('td', {
      staticClass: "col-md-2"
    }, _vm._l((channel.genres), function(genre) {
      return _c('p', {
        key: genre.id
      }, [_vm._v("\n                                " + _vm._s(genre.name) + "\n                            ")])
    })), _vm._v(" "), _c('td', {
      staticClass: "col-md-1"
    }, [_c('a', {
      staticClass: "action-link",
      on: {
        "click": function($event) {
          _vm.edit(channel)
        }
      }
    }, [_vm._v("\n                                Edit\n                            ")])]), _vm._v(" "), _c('td', {
      staticClass: "col-md-1"
    }, [_c('a', {
      staticClass: "action-link text-danger",
      on: {
        "click": function($event) {
          _vm.destroy(channel)
        }
      }
    }, [_vm._v("\n                                Delete\n                            ")])])])
  }))])])]), _vm._v(" "), _c('div', {
    staticClass: "modal fade",
    attrs: {
      "id": "modal-add-channel",
      "tabindex": "-1",
      "role": "dialog"
    }
  }, [_c('div', {
    staticClass: "modal-dialog"
  }, [_c('div', {
    staticClass: "modal-content"
  }, [_vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "modal-body"
  }, [(_vm.createForm.errors.length > 0) ? _c('div', {
    staticClass: "alert alert-danger"
  }, [_vm._m(2), _vm._v(" "), _c('br'), _vm._v(" "), _c('ul', _vm._l((_vm.createForm.errors), function(error) {
    return _c('li', [_vm._v("\n                                " + _vm._s(error) + "\n                            ")])
  }))]) : _vm._e(), _vm._v(" "), _c('form', {
    staticClass: "form-horizontal",
    attrs: {
      "role": "form"
    }
  }, [_c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "col-md-3 control-label"
  }, [_vm._v("Number")]), _vm._v(" "), _c('div', {
    staticClass: "col-md-7"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.createForm.number),
      expression: "createForm.number"
    }],
    staticClass: "form-control",
    attrs: {
      "id": "create-channel-name",
      "type": "text"
    },
    domProps: {
      "value": (_vm.createForm.number)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.createForm.number = $event.target.value
      }
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "col-md-3 control-label"
  }, [_vm._v("Name")]), _vm._v(" "), _c('div', {
    staticClass: "col-md-7"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.createForm.name),
      expression: "createForm.name"
    }],
    staticClass: "form-control",
    attrs: {
      "id": "create-channel-name",
      "type": "text"
    },
    domProps: {
      "value": (_vm.createForm.name)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.createForm.name = $event.target.value
      }
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "col-md-3 control-label"
  }, [_vm._v("Stream")]), _vm._v(" "), _c('div', {
    staticClass: "col-md-7"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.createForm.stream),
      expression: "createForm.stream"
    }],
    staticClass: "form-control",
    attrs: {
      "id": "create-channel-name",
      "type": "text"
    },
    domProps: {
      "value": (_vm.createForm.stream)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.createForm.stream = $event.target.value
      }
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "col-md-3 control-label"
  }, [_vm._v("Thumbnail")]), _vm._v(" "), _c('div', {
    staticClass: "col-md-7"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.createForm.thumbnail),
      expression: "createForm.thumbnail"
    }],
    staticClass: "form-control",
    attrs: {
      "id": "create-channel-name",
      "type": "text"
    },
    domProps: {
      "value": (_vm.createForm.thumbnail)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.createForm.thumbnail = $event.target.value
      }
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "col-md-3 control-label"
  }, [_vm._v("Genre")]), _vm._v(" "), _c('div', {
    staticClass: "col-md-7"
  }, [_c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.createForm.genres),
      expression: "createForm.genres"
    }],
    staticClass: "form-control",
    attrs: {
      "multiple": ""
    },
    on: {
      "change": function($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function(o) {
          return o.selected
        }).map(function(o) {
          var val = "_value" in o ? o._value : o.value;
          return val
        });
        _vm.createForm.genres = $event.target.multiple ? $$selectedVal : $$selectedVal[0]
      }
    }
  }, _vm._l((_vm.genres), function(genre) {
    return _c('option', {
      key: genre.id,
      domProps: {
        "value": genre.id
      }
    }, [_vm._v(_vm._s(genre.name))])
  }))])])])]), _vm._v(" "), _c('div', {
    staticClass: "modal-footer"
  }, [_c('button', {
    staticClass: "btn btn-default",
    attrs: {
      "type": "button",
      "data-dismiss": "modal"
    }
  }, [_vm._v("Close")]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-primary",
    attrs: {
      "type": "button"
    },
    on: {
      "click": _vm.store
    }
  }, [_vm._v("\n                        Create\n                    ")])])])])]), _vm._v(" "), _c('div', {
    staticClass: "modal fade",
    attrs: {
      "id": "modal-edit-channel",
      "tabindex": "-1",
      "role": "dialog"
    }
  }, [_c('div', {
    staticClass: "modal-dialog"
  }, [_c('div', {
    staticClass: "modal-content"
  }, [_vm._m(3), _vm._v(" "), _c('div', {
    staticClass: "modal-body"
  }, [(_vm.editForm.errors.length > 0) ? _c('div', {
    staticClass: "alert alert-danger"
  }, [_vm._m(4), _vm._v(" "), _c('br'), _vm._v(" "), _c('ul', _vm._l((_vm.editForm.errors), function(error) {
    return _c('li', [_vm._v("\n                                " + _vm._s(error) + "\n                            ")])
  }))]) : _vm._e(), _vm._v(" "), _c('form', {
    staticClass: "form-horizontal",
    attrs: {
      "role": "form"
    }
  }, [_c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "col-md-3 control-label"
  }, [_vm._v("Number")]), _vm._v(" "), _c('div', {
    staticClass: "col-md-7"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.editForm.number),
      expression: "editForm.number"
    }],
    staticClass: "form-control",
    attrs: {
      "id": "create-channel-name",
      "type": "text"
    },
    domProps: {
      "value": (_vm.editForm.number)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.editForm.number = $event.target.value
      }
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "col-md-3 control-label"
  }, [_vm._v("Name")]), _vm._v(" "), _c('div', {
    staticClass: "col-md-7"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.editForm.name),
      expression: "editForm.name"
    }],
    staticClass: "form-control",
    attrs: {
      "id": "create-channel-name",
      "type": "text"
    },
    domProps: {
      "value": (_vm.editForm.name)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.editForm.name = $event.target.value
      }
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "col-md-3 control-label"
  }, [_vm._v("Stream")]), _vm._v(" "), _c('div', {
    staticClass: "col-md-7"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.editForm.stream),
      expression: "editForm.stream"
    }],
    staticClass: "form-control",
    attrs: {
      "id": "create-channel-name",
      "type": "text"
    },
    domProps: {
      "value": (_vm.editForm.stream)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.editForm.stream = $event.target.value
      }
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "col-md-3 control-label"
  }, [_vm._v("Thumbnail")]), _vm._v(" "), _c('div', {
    staticClass: "col-md-7"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.editForm.thumbnail),
      expression: "editForm.thumbnail"
    }],
    staticClass: "form-control",
    attrs: {
      "id": "create-channel-name",
      "type": "text"
    },
    domProps: {
      "value": (_vm.editForm.thumbnail)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.editForm.thumbnail = $event.target.value
      }
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "col-md-3 control-label"
  }, [_vm._v("Genre")]), _vm._v(" "), _c('div', {
    staticClass: "col-md-7"
  }, [_c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.editForm.genres),
      expression: "editForm.genres"
    }],
    staticClass: "form-control",
    attrs: {
      "multiple": ""
    },
    on: {
      "change": function($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function(o) {
          return o.selected
        }).map(function(o) {
          var val = "_value" in o ? o._value : o.value;
          return val
        });
        _vm.editForm.genres = $event.target.multiple ? $$selectedVal : $$selectedVal[0]
      }
    }
  }, _vm._l((_vm.genres), function(genre) {
    return _c('option', {
      key: genre.id,
      domProps: {
        "value": genre.id
      }
    }, [_vm._v(_vm._s(genre.name))])
  }))])])])]), _vm._v(" "), _c('div', {
    staticClass: "modal-footer"
  }, [_c('button', {
    staticClass: "btn btn-default",
    attrs: {
      "type": "button",
      "data-dismiss": "modal"
    }
  }, [_vm._v("Close")]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-primary",
    attrs: {
      "type": "button"
    },
    on: {
      "click": _vm.update
    }
  }, [_vm._v("\n                        Save Changes\n                    ")])])])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('thead', [_c('tr', [_c('th', {
    staticClass: "col-md-1"
  }, [_vm._v("number")]), _vm._v(" "), _c('th', {
    staticClass: "col-md-3"
  }, [_vm._v("name")]), _vm._v(" "), _c('th', {
    staticClass: "col-md-2"
  }, [_vm._v("stream")]), _vm._v(" "), _c('th', {
    staticClass: "col-md-2"
  }, [_vm._v("thumbnail")]), _vm._v(" "), _c('th', {
    staticClass: "col-md-2"
  }, [_vm._v("genre")]), _vm._v(" "), _c('th', {
    staticClass: "col-md-1"
  }), _vm._v(" "), _c('th', {
    staticClass: "col-md-1"
  })])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "modal-header"
  }, [_c('button', {
    staticClass: "close",
    attrs: {
      "type": "button ",
      "data-dismiss": "modal",
      "aria-hidden": "true"
    }
  }, [_vm._v("×")]), _vm._v(" "), _c('h4', {
    staticClass: "modal-title"
  }, [_vm._v("\n                        Add New Channel\n                    ")])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('p', [_c('strong', [_vm._v("Whoops!")]), _vm._v(" Something went wrong!")])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "modal-header"
  }, [_c('button', {
    staticClass: "close",
    attrs: {
      "type": "button ",
      "data-dismiss": "modal",
      "aria-hidden": "true"
    }
  }, [_vm._v("×")]), _vm._v(" "), _c('h4', {
    staticClass: "modal-title"
  }, [_vm._v("\n                        Edit Channel\n                    ")])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('p', [_c('strong', [_vm._v("Whoops!")]), _vm._v(" Something went wrong!")])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-5da30b6f", module.exports)
  }
}

/***/ }),

/***/ 9:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(46)(
  /* script */
  __webpack_require__(47),
  /* template */
  __webpack_require__(48),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/var/www/resources/assets/js/components/channels.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] channels.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5da30b6f", Component.options)
  } else {
    hotAPI.reload("data-v-5da30b6f", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});