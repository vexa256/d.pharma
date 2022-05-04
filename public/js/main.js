/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./ExternalAssets/js/CatchAllAxiosErrors.js":
/*!**************************************************!*\
  !*** ./ExternalAssets/js/CatchAllAxiosErrors.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.CatchAxiosError = function (error) {
  if (error.response) {
    // Request made and server responded
    console.log(error.response.data);
    console.log(error.response.status);
    console.log(error.response.headers);
  } else if (error.request) {
    // The request was made but no response was received
    console.log(error.request);
  } else {
    // Something happened in setting up the request that triggered an Error
    console.log('Error', error.message);
  }
};

/***/ }),

/***/ "./ExternalAssets/js/ConfirmDrugSelectionToCache.js":
/*!**********************************************************!*\
  !*** ./ExternalAssets/js/ConfirmDrugSelectionToCache.js ***!
  \**********************************************************/
/***/ (() => {

/******ConfirmDrugSelectionToCache */
window.addEventListener('DOMContentLoaded', function () {
  $(document).on("click", ".ConfirmDrugSelectionToCache", function () {
    var PatientName = $('#PatientName').val();
    var PatientPhone = $('#PatientPhone').val();
    var PatientEmail = $('#PatientEmail').val();
    var PaymentSessionID = $('#PaymentSessionID').val();
    var QtySelected = $('#QtySelected').val();
    var DispensedBy = $('#DispensedBy').val();
    var StockID = $(this).data('stockid');

    if (PatientName.length != 0 && PatientPhone.length != 0 && PatientEmail.length != 0 && PaymentSessionID.length != 0) {
      var FORM_DATA = {
        PatientName: PatientName,
        PatientPhone: PatientPhone,
        PatientEmail: PatientEmail,
        PaymentSessionID: PaymentSessionID,
        StockID: StockID,
        DispensedBy: DispensedBy,
        QtySelected: QtySelected
      };
      axios.post('api/RecordDispenseCache', FORM_DATA).then(function (response) {
        if (response.data.status == 'QtyError') {
          Swal.fire('Quantity Mismatch', response.data.Message, 'error');
          ShowSelectDrugsSelect();
        } else if (response.data.status == 'success') {
          Swal.fire('Action Successful', response.data.Message, 'success');
          FetchCartItems();
          ShowSelectDrugsSelect();
        } else {
          Swal.fire('OOPS', 'A Minor error occurred, Try again', 'error');
        }
      })["catch"](function (error) {
        console.log(error);
        CatchAxiosError(error);
      });
    } else {
      Swal.fire('Oops', 'Please fill in all the patient details first', 'error');
    }
  });
});

/***/ }),

/***/ "./ExternalAssets/js/DeleteCartItem.js":
/*!*********************************************!*\
  !*** ./ExternalAssets/js/DeleteCartItem.js ***!
  \*********************************************/
/***/ (() => {

window.addEventListener('DOMContentLoaded', function () {
  $(document).on("click", ".DeleteCartItem", function () {
    var id = $(this).data('id');
    axios.get('api/RemoveDrugCartItem/' + id).then(function (response) {
      if (response.data.status == "success") {
        Swal.fire('Action Successful', response.data.Message, 'success');
        FetchCartItems();
      }
    })["catch"](function (error) {
      console.log(error);
      CatchAxiosError(error);
    });
  });
});

/***/ }),

/***/ "./ExternalAssets/js/DisplayCartItems.js":
/*!***********************************************!*\
  !*** ./ExternalAssets/js/DisplayCartItems.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.DisplayCartTable = function (CartItems, Total) {
  var TotalSumHere = $('.TotalSumHere');
  TotalSumHere.text('UGX ' + $.number(parseFloat(Total), 3));
  var DisplayCartItemsHere = $('.DisplayCartItemsHere');
  DisplayCartItemsHere.html('');
  var Tr = '<tr>';
  var CloseTr = '</tr>';
  CartItems.forEach(function (item) {
    DisplayCartItemsHere.append(Tr);
    DisplayCartItemsHere.append("<td>".concat(item.PatientName, "</td>"));
    DisplayCartItemsHere.append("<td>".concat(item.PatientPhone, "</td>"));
    DisplayCartItemsHere.append("<td>".concat(item.PatientEmail, "</td>"));
    DisplayCartItemsHere.append("<td>".concat(item.DrugName, "</td>"));
    DisplayCartItemsHere.append("<td>".concat(item.GenericName, "</td>"));
    DisplayCartItemsHere.append("<td>".concat(item.Units, "</td>"));
    DisplayCartItemsHere.append("<td>UGX ".concat(item.UnitCost.toLocaleString(), "</td>"));
    DisplayCartItemsHere.append("<td>".concat(item.Qty.toLocaleString(), "</td>"));
    DisplayCartItemsHere.append("<td>UGX ".concat(item.SubTotal.toLocaleString(), "</td>"));
    DisplayCartItemsHere.append("<td><a data-id=\"".concat(item.id, "\"\n            class=\"btn shadow-lg btn-info btn-sm DeleteCartItem\"\n            href=\"#Update\">\n\n            <i class=\"fas fa-times\"\n                aria-hidden=\"true\"></i>\n        </a></td>"));
    DisplayCartItemsHere.append(CloseTr);
  });
};

/***/ }),

/***/ "./ExternalAssets/js/FetchCartItems.js":
/*!*********************************************!*\
  !*** ./ExternalAssets/js/FetchCartItems.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.FetchCartItems = function () {
  var PaymentSessionID = $('#PaymentSessionID').val();
  var FORM_DATA = {
    PaymentSessionID: PaymentSessionID
  };
  axios.post('api/GetDispenseCart', FORM_DATA).then(function (response) {
    if (response.data.status == "success") {
      DisplayCartTable(response.data.CartItems, response.data.Total);
    }
  })["catch"](function (error) {
    console.log(error);
    CatchAxiosError(error);
  });
};

/***/ }),

/***/ "./ExternalAssets/js/FetchDrugStockPiles.js":
/*!**************************************************!*\
  !*** ./ExternalAssets/js/FetchDrugStockPiles.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/***Fetch Selected Drug StockPiles */
__webpack_require__.g.FetchDrugStockpiles = function () {
  var SelectedDrugId = $('.SelectedDrugId').val();
  var Route = 'SelectStockPileForDispense/';
  var QtySelected = $('#QtySelected').val();

  if (SelectedDrugId.length != 0 && QtySelected.length != 0) {
    axios.get(Virtualhost + Route + SelectedDrugId).then(function (response) {
      if (response.data.Count == 'true') {
        if (response.data.status == 'success') {
          var StockPiles = response.data.StockPiles;
          DisplayTable(StockPiles);
          ShowStockPilesTable();
        }
      } else {
        Swal.fire('OOPS', 'The selected drug is out of stock. Please restock and try again', 'error');
      }
    })["catch"](function (error) {
      // handle error
      console.log(error);
    });
  } else {
    Swal.fire('Oops', 'The drug and quantity selection cannot be empty', 'error');
  }
};

/***/ }),

/***/ "./ExternalAssets/js/ShowSelectDrugsSelect.js":
/*!****************************************************!*\
  !*** ./ExternalAssets/js/ShowSelectDrugsSelect.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.ShowSelectDrugsSelect = function () {
  SelectDrugSelect.show();
  StockPilesTable.hide();
  DisplayStockHere.html('');
};

/***/ }),

/***/ "./ExternalAssets/js/ShowStockPilesTable.js":
/*!**************************************************!*\
  !*** ./ExternalAssets/js/ShowStockPilesTable.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.ShowStockPilesTable = function () {
  SelectDrugSelect.hide();
  StockPilesTable.show();
};

/***/ }),

/***/ "./ExternalAssets/js/ShowTableStockPiles.js":
/*!**************************************************!*\
  !*** ./ExternalAssets/js/ShowTableStockPiles.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.DisplayTable = function (StockPiles) {
  var Tr = '<tr>';
  var CloseTr = '</tr>';
  StockPiles.forEach(function (data) {
    DisplayStockHere.append(Tr);
    DisplayStockHere.append("<td>".concat(data.DrugName, "</td>"));
    DisplayStockHere.append("<td>".concat(data.GenericName, "</td>"));
    DisplayStockHere.append("<td>".concat(data.StockTag, "</td>"));
    DisplayStockHere.append("<td>".concat(data.BatchNumber, "</td>"));
    DisplayStockHere.append("<td>".concat(data.StockQty.toLocaleString(), "  ").concat(data.Units, "</td>"));
    DisplayStockHere.append("<td>".concat(data.Currency, " ").concat(data.UnitSellingPrice.toLocaleString(), "</td>"));
    DisplayStockHere.append("<td>".concat(data.ExpiryDate, "</td>"));
    DisplayStockHere.append("<td><a data-stockid = \"".concat(data.StockID, "\"\n        class=\"btn shadow-lg btn-info btn-sm ConfirmDrugSelectionToCache\"\n        href=\"#Update\">\n\n        <i class=\"fas fa-check\"\n            aria-hidden=\"true\"></i>\n    </a></td>"));
    DisplayStockHere.append(CloseTr);
  });
};

/***/ }),

/***/ "./ExternalAssets/js/dispense.js":
/*!***************************************!*\
  !*** ./ExternalAssets/js/dispense.js ***!
  \***************************************/
/***/ (() => {

window.addEventListener('DOMContentLoaded', function () {
  StockPilesTable.hide();
  /***Trigger Method OnClick */

  $(document).on("click", ".GoToSelectDrug", function () {
    ShowSelectDrugsSelect();
  });
  $(document).on("click", ".SelectStockPile", function () {
    FetchDrugStockpiles();
  });
  /****FetchCartItems */
});

/***/ }),

/***/ "./ExternalAssets/js/globals.js":
/*!**************************************!*\
  !*** ./ExternalAssets/js/globals.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

// global.host = $('.Virtualhost').val();
__webpack_require__.g.Virtualhost = '/api/';
__webpack_require__.g.SelectDrugSelect = $('.SelectDrugSelect');
__webpack_require__.g.StockPilesTable = $('.SelectStockPileTable');
__webpack_require__.g.DisplayStockHere = $('.DisplayStockHere');

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*******************************!*\
  !*** ./ExternalAssets/app.js ***!
  \*******************************/
__webpack_require__(/*! ./js/globals.js */ "./ExternalAssets/js/globals.js");

__webpack_require__(/*! ./js/ShowStockPilesTable.js */ "./ExternalAssets/js/ShowStockPilesTable.js");

__webpack_require__(/*! ./js/ShowSelectDrugsSelect.js */ "./ExternalAssets/js/ShowSelectDrugsSelect.js");

__webpack_require__(/*! ./js/ShowTableStockPiles.js */ "./ExternalAssets/js/ShowTableStockPiles.js");

__webpack_require__(/*! ./js/FetchDrugStockPiles.js */ "./ExternalAssets/js/FetchDrugStockPiles.js");

__webpack_require__(/*! ./js/CatchAllAxiosErrors.js */ "./ExternalAssets/js/CatchAllAxiosErrors.js");

__webpack_require__(/*! ./js/ConfirmDrugSelectionToCache.js */ "./ExternalAssets/js/ConfirmDrugSelectionToCache.js");

__webpack_require__(/*! ./js/DisplayCartItems.js */ "./ExternalAssets/js/DisplayCartItems.js");

__webpack_require__(/*! ./js/FetchCartItems.js */ "./ExternalAssets/js/FetchCartItems.js");

__webpack_require__(/*! ./js/DeleteCartItem.js */ "./ExternalAssets/js/DeleteCartItem.js");

__webpack_require__(/*! ./js/dispense.js */ "./ExternalAssets/js/dispense.js");
})();

/******/ })()
;