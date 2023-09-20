(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OurPartners.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/OurPartners.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      al: {
        itemsToShow: 1,
        breakpoints: {
          768: {
            itemsToShow: 4
          }
        }
      },
      items: [{
        image: '/images/logo-partenaires/FADEAR-cmjn-01-01.png',
        title: 'Les ADEAR',
        text: 'Ce sont les associations de développement de l’emploi agricole et rural. Présentes dans une soixantaine de départements, elles ont mis en place un dispositif d’accompagnement des porteurs de projet qui souhaitent s’installer en agriculture ou transmettre. Elles soutiennent les valeurs de l’agriculture paysanne et accompagnent une grande diversité de projets. Plus d\'informations'
      }, {
        image: '/images/logo-partenaires/LOGO_RESEAU_CIVAM_FOND_TRANSPARENT.PNG',
        title: 'Les CIVAM',
        text: 'Ce sont les Centres d’Initiatives pour Valoriser l’Agriculture et le Milieu rural. Ils ont pour mission de rassembler agriculteurs et ruraux d’un même territoire pour développer de nouvelles initiatives, se former, échanger, expérimenter et innover. Plus de 140 groupes existent sur l’ensemble du territoire. Plus d\'informations en cliquant sur ce lien'
      }, {
        image: '/images/logo-partenaires/logo_inpact_Plan%20de%20travail%201.png',
        title: 'InPACT',
        text: 'Initiatives pour une Agriculture citoyenne et territoriale est un regroupement de 10 réseaux associatifs agricoles partageant une même vision de l’agriculture. Avec des champs d’action et des approches de l’accompagnement variés, le réseau InPACT dont est membre Terre de Liens est un acteur central de l’accompagnement à l’installation et à la transmission. Des déclinaisons régionales ou plus locales d’InPACT associent parfois une diversité plus grande encore d’acteurs qui font des pas de côté en agriculture (GAB, association d’éducation populaire, couveuse d’activité, ...). Plus d\'informations en cliquant sur ce lien'
      }, {
        image: '/images/logo-partenaires/logo%20IA%20fond%20transparent.png',
        title: 'Les AFOCG',
        text: 'Ce sont les Associations de Formation collective à la gestion. Elles ont pour mission de rendre leur adhérents autonome dans leur comptabilité et dans leur gestion, et de les accompagner dans les différentes étapes de développement de leur entreprise (création, évolution, etc.).'
      }, {
        image: '/images/logo-partenaires/logo-fnab-new.png',
        title: 'Les GAB',
        text: 'Les groupements d’agriculture biologique sont présents au niveau départemental. Ils accueillent et accompagnent les porteurs de projet en agriculture biologique ou en conversion à la bio, organisent des formations et des temps d’échanges entre agriculteurs et consommateurs Plus d\'informations'
      }, {
        image: '/images/logo-partenaires/Logo%20Reneta%20-%20RVB.png',
        title: 'Le RENETA',
        text: 'C’est le réseau national des espaces test agricoles, dispositifs permettant à des porteurs de projet de tester la viabilité et la vivabilité de leur projet agricole Plus d\'informations'
      }, {
        image: '/images/logo/logo_TdL_cartouche_blanc-rouge_500.png',
        title: 'Terre de Liens',
        text: 'Le réseau associatif Terre de Liens peut vous accueillir, vous orienter et vous accompagner sur le volet foncier de votre projet.'
      }]
    };
  },
  methods: {
    openDialog: function openDialog(title, text) {
      this.$buefy.dialog.alert({
        title: title,
        message: text,
        confirmText: 'Fermer'
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OurPartners.vue?vue&type=template&id=65f1db7c&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/OurPartners.vue?vue&type=template&id=65f1db7c& ***!
  \********************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("b-carousel-list", _vm._b({
    attrs: {
      data: _vm.items,
      "arrow-hover": false,
      "as-indicator": ""
    },
    scopedSlots: _vm._u([{
      key: "item",
      fn: function fn(list) {
        return [_c("figure", {
          staticClass: "image is-128x128 is-clickable",
          on: {
            click: function click($event) {
              return _vm.openDialog(list.title, list.text);
            },
            touchend: function touchend($event) {
              return _vm.openDialog(list.title, list.text);
            }
          }
        }, [_c("img", {
          attrs: {
            src: list.image
          }
        })])];
      }
    }])
  }, "b-carousel-list", _vm.al, false));
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OurPartners.vue?vue&type=style&index=0&id=65f1db7c&lang=scss&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/OurPartners.vue?vue&type=style&index=0&id=65f1db7c&lang=scss& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".carousel-slide, .carousel-slide figure {\n  display: flex;\n  justify-content: center;\n  align-items: center;\n}\n.carousel-slide figure.image {\n  background-color: white;\n  border-radius: 20px;\n  height: 220px;\n  width: 220px;\n}\n.carousel-slide img {\n  width: 70%;\n}\n.carousel-list.has-shadow {\n  box-shadow: none;\n}\n@media (max-width: 1024px) {\n.carousel-list {\n    width: 100vw;\n}\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OurPartners.vue?vue&type=style&index=0&id=65f1db7c&lang=scss&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/OurPartners.vue?vue&type=style&index=0&id=65f1db7c&lang=scss& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--7-2!../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../node_modules/vue-loader/lib??vue-loader-options!./OurPartners.vue?vue&type=style&index=0&id=65f1db7c&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OurPartners.vue?vue&type=style&index=0&id=65f1db7c&lang=scss&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./resources/js/components/OurPartners.vue":
/*!*************************************************!*\
  !*** ./resources/js/components/OurPartners.vue ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _OurPartners_vue_vue_type_template_id_65f1db7c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OurPartners.vue?vue&type=template&id=65f1db7c& */ "./resources/js/components/OurPartners.vue?vue&type=template&id=65f1db7c&");
/* harmony import */ var _OurPartners_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OurPartners.vue?vue&type=script&lang=js& */ "./resources/js/components/OurPartners.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _OurPartners_vue_vue_type_style_index_0_id_65f1db7c_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./OurPartners.vue?vue&type=style&index=0&id=65f1db7c&lang=scss& */ "./resources/js/components/OurPartners.vue?vue&type=style&index=0&id=65f1db7c&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _OurPartners_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _OurPartners_vue_vue_type_template_id_65f1db7c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _OurPartners_vue_vue_type_template_id_65f1db7c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/OurPartners.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/OurPartners.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/components/OurPartners.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OurPartners_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./OurPartners.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OurPartners.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OurPartners_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/OurPartners.vue?vue&type=style&index=0&id=65f1db7c&lang=scss&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/OurPartners.vue?vue&type=style&index=0&id=65f1db7c&lang=scss& ***!
  \***********************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_OurPartners_vue_vue_type_style_index_0_id_65f1db7c_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--7-2!../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../node_modules/vue-loader/lib??vue-loader-options!./OurPartners.vue?vue&type=style&index=0&id=65f1db7c&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OurPartners.vue?vue&type=style&index=0&id=65f1db7c&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_OurPartners_vue_vue_type_style_index_0_id_65f1db7c_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_OurPartners_vue_vue_type_style_index_0_id_65f1db7c_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_OurPartners_vue_vue_type_style_index_0_id_65f1db7c_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_OurPartners_vue_vue_type_style_index_0_id_65f1db7c_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/OurPartners.vue?vue&type=template&id=65f1db7c&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/OurPartners.vue?vue&type=template&id=65f1db7c& ***!
  \********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_OurPartners_vue_vue_type_template_id_65f1db7c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./OurPartners.vue?vue&type=template&id=65f1db7c& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OurPartners.vue?vue&type=template&id=65f1db7c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_OurPartners_vue_vue_type_template_id_65f1db7c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_OurPartners_vue_vue_type_template_id_65f1db7c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);