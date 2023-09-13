(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/auth/login-form.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/auth/login-form.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    oldValues: {
      type: Object,
      "default": function _default() {
        return {};
      }
    },
    csrf_token: {
      type: String,
      "default": ''
    },
    routes: {
      type: Array,
      "default": function _default() {
        return [];
      }
    }
  },
  data: function data() {
    return {
      email: this.oldValues.email || '',
      hasPassedCheckpoint: !!this.oldValues.email,
      isLoading: false
    };
  },
  methods: {
    clearIconClick: function clearIconClick() {
      this.email = '';
    },
    onValidate: function onValidate(event) {
      var _this = this;
      event.preventDefault();
      if (!this.email) {
        alert("Veuillez saisir votre adresse email");
        return;
      }
      if (this.hasPassedCheckpoint) {
        event.target.submit();
        return;
      }
      var formData = new FormData();
      formData.append('_token', this.csrf_token);
      formData.append('email', this.email);
      this.isLoading = true;
      fetch('/connexion/checkpoint', {
        method: 'POST',
        body: formData,
        headers: {
          'Accept': 'application/json'
        }
      }).then(function (response) {
        return response.json();
      }).then(function (result) {
        if (result.error) {
          if (result.status === 419) {
            alert("La page a expiré et va être rafraîchie. Merci de réessayer.") && location.reload();
          } else {
            _this.loginErrorHandler(result.error);
          }
        } else if (result.redirect && result.redirect !== '') {
          location.href = result.redirect;
        } else {
          _this.hasPassedCheckpoint = true;
          _this.isLoading = false;
        }
      })["catch"](function (error) {
        return _this.loginErrorHandler(error);
      });
    },
    onEmailChange: function onEmailChange() {
      this.hasPassedCheckpoint = false;
    },
    loginErrorHandler: function loginErrorHandler(error) {
      console.log("checkpoint error :", error);
      alert("Une erreur imprévue a eu lieu.");
      this.isLoading = false;
    },
    onSubmit: function onSubmit(event) {
      this.onValidate(event);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/auth/login-form.vue?vue&type=template&id=462d14d4&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/auth/login-form.vue?vue&type=template&id=462d14d4& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("section", {
    staticClass: "mh-40 container is-flex is-flex-direction-column is-justify-content-center py-6"
  }, [_c("div", {
    staticClass: "columns"
  }, [_c("div", {
    staticClass: "column is-half mx-auto"
  }, [_c("form", {
    attrs: {
      method: "post",
      action: _vm.login_route
    },
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.onSubmit.apply(null, arguments);
      }
    }
  }, [_c("div", {
    staticClass: "is-flex is-flex-direction-column gap-2"
  }, [_c("h1", {
    staticClass: "title is-3"
  }, [_vm._v("Identifiez-vous")]), _vm._v(" "), _c("b-field", [_c("b-input", {
    attrs: {
      size: "is-medium",
      rounded: "",
      placeholder: "Votre adresse email...",
      type: "email",
      icon: "email",
      "icon-right": "close-circle",
      "icon-right-clickable": "",
      name: "email"
    },
    on: {
      "icon-right-click": _vm.clearIconClick,
      change: _vm.onEmailChange
    },
    model: {
      value: _vm.email,
      callback: function callback($$v) {
        _vm.email = $$v;
      },
      expression: "email"
    }
  })], 1), _vm._v(" "), _vm.hasPassedCheckpoint ? _c("b-field", [_c("b-input", {
    attrs: {
      rounded: "",
      icon: "lock",
      size: "is-medium",
      type: "password",
      placeholder: "Votre mot de passe...",
      "password-reveal": "",
      name: "password"
    }
  })], 1) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "buttons is-justify-content-space-between"
  }, [_c("b-button", {
    attrs: {
      tag: "a",
      href: _vm.routes.password_request,
      type: "is-text",
      rounded: ""
    }
  }, [_vm._v("Mot de passe oublié ?")]), _vm._v(" "), _c("b-button", {
    attrs: {
      "native-type": "submit",
      type: "is-primary",
      size: "is-medium",
      rounded: "",
      loading: _vm.isLoading,
      disabled: _vm.isLoading
    }
  }, [_vm.isLoading ? _c("span", [_vm._v("Chargement")]) : _vm.hasPassedCheckpoint ? _c("span", [_vm._v("Valider")]) : _c("span", [_vm._v("Suivant")])])], 1), _vm._v(" "), _c("b-button", {
    attrs: {
      tag: "a",
      href: _vm.routes.register,
      rounded: "",
      type: "is-light",
      size: "is-medium",
      expanded: ""
    }
  }, [_vm._v("Créer un compte")])], 1), _vm._v(" "), _c("input", {
    attrs: {
      type: "hidden",
      name: "_token"
    },
    domProps: {
      value: _vm.csrf_token
    }
  })])])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/pages/auth/login-form.vue":
/*!************************************************!*\
  !*** ./resources/js/pages/auth/login-form.vue ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _login_form_vue_vue_type_template_id_462d14d4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./login-form.vue?vue&type=template&id=462d14d4& */ "./resources/js/pages/auth/login-form.vue?vue&type=template&id=462d14d4&");
/* harmony import */ var _login_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./login-form.vue?vue&type=script&lang=js& */ "./resources/js/pages/auth/login-form.vue?vue&type=script&lang=js&");
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _login_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _login_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _login_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _login_form_vue_vue_type_template_id_462d14d4___WEBPACK_IMPORTED_MODULE_0__["render"],
  _login_form_vue_vue_type_template_id_462d14d4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/auth/login-form.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/auth/login-form.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/pages/auth/login-form.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_login_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./login-form.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/auth/login-form.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_login_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/auth/login-form.vue?vue&type=template&id=462d14d4&":
/*!*******************************************************************************!*\
  !*** ./resources/js/pages/auth/login-form.vue?vue&type=template&id=462d14d4& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_login_form_vue_vue_type_template_id_462d14d4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./login-form.vue?vue&type=template&id=462d14d4& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/auth/login-form.vue?vue&type=template&id=462d14d4&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_login_form_vue_vue_type_template_id_462d14d4___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_login_form_vue_vue_type_template_id_462d14d4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);