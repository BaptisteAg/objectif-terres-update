(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/ads/components/SurveyModal.vue?vue&type=script&lang=js":
/*!*******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/ads/components/SurveyModal.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    ad: {
      type: Object,
      required: true
    },
    action: {
      type: String,
      required: true,
      validator: function validator(value) {
        return ['archive', 'delete'].includes(value);
      }
    }
  },
  data: function data() {
    return {
      surveyResponse: null,
      surveyComments: '',
      isLoading: false,
      showError: false
    };
  },
  methods: {
    handleClose: function handleClose() {
      if (!this.isLoading) {
        this.$emit('close');
      }
    },
    handleSubmit: function handleSubmit() {
      var _this = this;
      // Validate that a response is selected
      if (!this.surveyResponse) {
        this.showError = true;
        return;
      }
      this.showError = false;
      this.isLoading = true;

      // Submit survey data
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.post("/annonces/survey/".concat(this.ad.id, "/").concat(this.action), {
        survey_success_via_platform: this.surveyResponse,
        survey_comments: this.surveyComments
      }).then(function (response) {
        // Redirect or reload after successful submission
        if (response.data.redirect) {
          window.location.href = response.data.redirect;
        } else {
          window.location.reload();
        }
      })["catch"](function (error) {
        console.error('Survey submission error:', error);
        alert('Une erreur est survenue. Veuillez réessayer.');
        _this.isLoading = false;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/ads/components/SurveyModal.vue?vue&type=template&id=8395147c&scoped=true":
/*!*****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/ads/components/SurveyModal.vue?vue&type=template&id=8395147c&scoped=true ***!
  \*****************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "modal is-active p-8 p-0-mobile"
  }, [_c("div", {
    staticClass: "modal-background",
    on: {
      click: _vm.handleClose
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "modal-content"
  }, [_c("div", {
    staticClass: "card"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "card-content"
  }, [_vm.isLoading ? _c("div", [_c("p", [_vm._v("Envoi en cours...")])]) : _c("div", [_c("p", {
    staticClass: "mb-4"
  }, [_vm._v("\n            Afin d'archiver ou supprimer une annonce, veuillez répondre à la question suivante pour nous permettre d'améliorer Objectif-Terres\n          ")]), _vm._v(" "), _c("div", {
    staticClass: "field"
  }, [_vm._m(1), _vm._v(" "), _c("div", {
    staticClass: "control"
  }, [_c("label", {
    staticClass: "radio"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.surveyResponse,
      expression: "surveyResponse"
    }],
    attrs: {
      type: "radio",
      name: "survey_response",
      value: "oui"
    },
    domProps: {
      checked: _vm._q(_vm.surveyResponse, "oui")
    },
    on: {
      change: function change($event) {
        _vm.surveyResponse = "oui";
      }
    }
  }), _vm._v("\n                Oui\n              ")]), _vm._v(" "), _c("label", {
    staticClass: "radio ml-4"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.surveyResponse,
      expression: "surveyResponse"
    }],
    attrs: {
      type: "radio",
      name: "survey_response",
      value: "non"
    },
    domProps: {
      checked: _vm._q(_vm.surveyResponse, "non")
    },
    on: {
      change: function change($event) {
        _vm.surveyResponse = "non";
      }
    }
  }), _vm._v("\n                Non\n              ")])]), _vm._v(" "), _vm.showError ? _c("p", {
    staticClass: "help is-danger"
  }, [_vm._v("Veuillez répondre à cette question")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "field mt-4"
  }, [_c("label", {
    staticClass: "label"
  }, [_vm._v("\n              Si vous avez des remarques à nous faire pour nous améliorer (optionnel)\n            ")]), _vm._v(" "), _c("div", {
    staticClass: "control"
  }, [_c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.surveyComments,
      expression: "surveyComments"
    }],
    staticClass: "textarea",
    attrs: {
      placeholder: "N'hésitez pas à nous faire part de vos remarques...",
      rows: "4"
    },
    domProps: {
      value: _vm.surveyComments
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.surveyComments = $event.target.value;
      }
    }
  })])])])]), _vm._v(" "), _c("footer", {
    staticClass: "card-footer"
  }, [_c("div", {
    staticClass: "buttons card-footer-item"
  }, [_c("button", {
    staticClass: "button form-button basic secondary",
    attrs: {
      disabled: _vm.isLoading
    },
    on: {
      click: _vm.handleClose
    }
  }, [_c("span", [_vm._v("Annuler")])]), _vm._v(" "), _c("button", {
    staticClass: "button form-button basic is-danger",
    attrs: {
      disabled: _vm.isLoading
    },
    on: {
      click: _vm.handleSubmit
    }
  }, [_vm.action === "archive" ? _c("span", [_vm._v("Archiver mon annonce")]) : _c("span", [_vm._v("Supprimer mon annonce")])])]), _vm._v(" "), !_vm.isLoading ? _c("button", {
    staticClass: "modal-close is-large",
    attrs: {
      id: "close-modal",
      "aria-label": "close"
    },
    on: {
      click: _vm.handleClose
    }
  }) : _vm._e()])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("header", {
    staticClass: "card-header"
  }, [_c("p", {
    staticClass: "card-header-title"
  }, [_vm._v("\n          Archivage ou suppression d'une annonce - Enquête de succès\n        ")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    staticClass: "label"
  }, [_vm._v("\n              Votre annonce a-t-elle aboutie grâce à Objectif-Terres ? "), _c("span", {
    staticClass: "has-text-danger"
  }, [_vm._v("*")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/ads/components/SurveyModal.vue?vue&type=style&index=0&id=8395147c&scoped=true&lang=css":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/ads/components/SurveyModal.vue?vue&type=style&index=0&id=8395147c&scoped=true&lang=css ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.mb-4[data-v-8395147c] {\n  margin-bottom: 1rem;\n}\n.mt-4[data-v-8395147c] {\n  margin-top: 1rem;\n}\n.ml-4[data-v-8395147c] {\n  margin-left: 1rem;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/ads/components/SurveyModal.vue?vue&type=style&index=0&id=8395147c&scoped=true&lang=css":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/ads/components/SurveyModal.vue?vue&type=style&index=0&id=8395147c&scoped=true&lang=css ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader??ref--6-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./SurveyModal.vue?vue&type=style&index=0&id=8395147c&scoped=true&lang=css */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/ads/components/SurveyModal.vue?vue&type=style&index=0&id=8395147c&scoped=true&lang=css");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./resources/js/pages/ads/components/SurveyModal.vue":
/*!***********************************************************!*\
  !*** ./resources/js/pages/ads/components/SurveyModal.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SurveyModal_vue_vue_type_template_id_8395147c_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SurveyModal.vue?vue&type=template&id=8395147c&scoped=true */ "./resources/js/pages/ads/components/SurveyModal.vue?vue&type=template&id=8395147c&scoped=true");
/* harmony import */ var _SurveyModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SurveyModal.vue?vue&type=script&lang=js */ "./resources/js/pages/ads/components/SurveyModal.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _SurveyModal_vue_vue_type_style_index_0_id_8395147c_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./SurveyModal.vue?vue&type=style&index=0&id=8395147c&scoped=true&lang=css */ "./resources/js/pages/ads/components/SurveyModal.vue?vue&type=style&index=0&id=8395147c&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _SurveyModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _SurveyModal_vue_vue_type_template_id_8395147c_scoped_true__WEBPACK_IMPORTED_MODULE_0__["render"],
  _SurveyModal_vue_vue_type_template_id_8395147c_scoped_true__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "8395147c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/ads/components/SurveyModal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/ads/components/SurveyModal.vue?vue&type=script&lang=js":
/*!***********************************************************************************!*\
  !*** ./resources/js/pages/ads/components/SurveyModal.vue?vue&type=script&lang=js ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SurveyModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./SurveyModal.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/ads/components/SurveyModal.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SurveyModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/ads/components/SurveyModal.vue?vue&type=style&index=0&id=8395147c&scoped=true&lang=css":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/pages/ads/components/SurveyModal.vue?vue&type=style&index=0&id=8395147c&scoped=true&lang=css ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SurveyModal_vue_vue_type_style_index_0_id_8395147c_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader??ref--6-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./SurveyModal.vue?vue&type=style&index=0&id=8395147c&scoped=true&lang=css */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/ads/components/SurveyModal.vue?vue&type=style&index=0&id=8395147c&scoped=true&lang=css");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SurveyModal_vue_vue_type_style_index_0_id_8395147c_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SurveyModal_vue_vue_type_style_index_0_id_8395147c_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SurveyModal_vue_vue_type_style_index_0_id_8395147c_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SurveyModal_vue_vue_type_style_index_0_id_8395147c_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/pages/ads/components/SurveyModal.vue?vue&type=template&id=8395147c&scoped=true":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/pages/ads/components/SurveyModal.vue?vue&type=template&id=8395147c&scoped=true ***!
  \*****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_SurveyModal_vue_vue_type_template_id_8395147c_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./SurveyModal.vue?vue&type=template&id=8395147c&scoped=true */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/ads/components/SurveyModal.vue?vue&type=template&id=8395147c&scoped=true");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_SurveyModal_vue_vue_type_template_id_8395147c_scoped_true__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_SurveyModal_vue_vue_type_template_id_8395147c_scoped_true__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);