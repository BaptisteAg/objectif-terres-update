(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./resources/js/map.js":
/*!*****************************!*\
  !*** ./resources/js/map.js ***!
  \*****************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return _default; });
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var L = __webpack_require__.e(/*! import() */ 0).then(__webpack_require__.t.bind(null, /*! leaflet/dist/leaflet */ "./node_modules/leaflet/dist/leaflet.js", 7));
var token = 'pk.eyJ1IjoibWlja2l3YXkiLCJhIjoiY2s0YmE0NHZqMDZrejNrcGlxeWJmNHRtdCJ9.In4xuZz8wYnXmDX5jrrhCg';
var centerCoords = [46.290552, 2.771017];

var _default =
/*#__PURE__*/
function () {
  function _default(id) {
    _classCallCheck(this, _default);

    var map = L.map(id, {
      center: centerCoords,
      zoom: 5,
      zoomControl: true,
      scrollWheelZoom: false
    });
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + token, {
      maxZoom: 18,
      id: 'mapbox.satellite'
      /* mapbox.light / dark / streets / outdoors / satellite */

    }).addTo(map);
    this.map = map;
  }

  _createClass(_default, [{
    key: "addPolygon",
    value: function addPolygon(polygonData, _ref) {
      var _ref$color = _ref.color,
          color = _ref$color === void 0 ? '#b34818' : _ref$color,
          _ref$smoothFactor = _ref.smoothFactor,
          smoothFactor = _ref$smoothFactor === void 0 ? 0 : _ref$smoothFactor,
          _ref$callback = _ref.callback,
          callback = _ref$callback === void 0 ? null : _ref$callback;
      var polygon = L.geoJSON(polygonData.geojson, {
        smoothFactor: smoothFactor,
        style: {
          color: color
        }
      });
      polygon.addTo(this.map);
      return polygon;
    }
  }, {
    key: "fetchPolygonsData",
    value: function fetchPolygonsData(uri, formData) {
      formData.append('_token', window.csrf_token);
      return fetch('/locations/polygon/regions', {
        method: formData ? 'POST' : 'GET',
        body: formData
      }).then(function (response) {
        return response.json();
      });
    }
    /**
     *
     * @param {Polygon} polygon
     * @param tooltipText
     * @param className
     */

  }, {
    key: "bindTooltip",
    value: function bindTooltip(polygon, tooltipText, _ref2) {
      var _ref2$className = _ref2.className,
          className = _ref2$className === void 0 ? "" : _ref2$className;
      polygon.bindTooltip(tooltipText, {
        permanent: true,
        direction: "center",
        className: 'leaflet-tooltip ' + className
      }).openTooltip();
      polygon.addEventListener('mouseover', function (_) {
        polygon._tooltip._contentNode.classList.add('leaflet-tooltip-mouseover');
      });
      polygon.addEventListener('mouseout', function (_) {
        polygon._tooltip._contentNode.classList.remove('leaflet-tooltip-mouseover');
      });
    }
  }, {
    key: "bindPopup",
    value: function bindPopup(polygon, popupHtml, _ref3) {
      var _ref3$closable = _ref3.closable,
          closable = _ref3$closable === void 0 ? true : _ref3$closable,
          _ref3$open = _ref3.open,
          open = _ref3$open === void 0 ? false : _ref3$open;
      var popup = L.popup({
        closeOnClick: closable,
        autoClose: closable,
        direction: top,
        maxWidth: 560
      }).setContent(popupHtml);
      polygon.bindPopup(popup);

      if (open) {
        polygon.openPopup();
      }

      return popup;
    }
  }, {
    key: "remove",
    value: function remove(polygon) {
      this.map.removeLayer(polygon);
    }
  }]);

  return _default;
}();



/***/ })

}]);