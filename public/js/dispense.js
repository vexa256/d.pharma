/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./ExternalAssets/existing/AddDrugsToCart.js":
/*!***************************************************!*\
  !*** ./ExternalAssets/existing/AddDrugsToCart.js ***!
  \***************************************************/
/***/ (() => {

window.addEventListener('DOMContentLoaded', function () {
  $(document).on("click", ".ConfirmDrugExistingSelectionToCache", function () {
    var PaymentSessionID = $('#PaymentSessionID').val();
    var QtySelected = $('.QtySelected').val();
    var DispensedBy = $('#DispensedBy').val();
    var StockID = $(this).data('stockid');

    if (QtySelected.length != 0 && StockID.length != 0) {
      var FORM_DATA = {
        PaymentSessionID: PaymentSessionID,
        StockID: StockID,
        DispensedBy: DispensedBy,
        QtySelected: QtySelected
      };
      axios.post(GLOBAL_API_PATH + 'ExistingCartItems', FORM_DATA).then(function (response) {
        if (response.data.status == 'QtyError') {
          Swal.fire('Quantity Mismatch', response.data.Message, 'error');
          HideModal('ModalSelectDrugStockPile');
          ShowModal('ModalSelectDrug');
        } else if (response.data.status == 'success') {
          Swal.fire('Action Successful', response.data.Message, 'success');
          FetchExistingCartItems();
          HideModal('ModalSelectDrugStockPile');
          ShowModal('ModalSelectDrug');
        } else {
          Swal.fire('OOPS', 'A Minor error occurred, Try again', 'error');
        }
      })["catch"](function (error) {
        console.log(error);
        CatchAxiosError(error);
      });
    } else {
      Swal.fire('Oops', 'The stock item and quantity cannot be empty', 'error');
    }
  });
});

/***/ }),

/***/ "./ExternalAssets/existing/DrugAndStockSelect.js":
/*!*******************************************************!*\
  !*** ./ExternalAssets/existing/DrugAndStockSelect.js ***!
  \*******************************************************/
/***/ (() => {

window.addEventListener('DOMContentLoaded', function () {
  $(document).on("click", ".SelectExistingDrugButton", function () {
    var ExistingDrugSelected = $('.ExistingDrugSelected').val();
    var QtySelected = $('.QtySelected').val();
    FetchExistingDrugStockpiles(ExistingDrugSelected, QtySelected);
  });
  $(document).on("click", ".BackToDrugSelection", function () {
    HideModal('ModalSelectDrugStockPile');
    ShowModal('ModalSelectDrug');
  });
});

/***/ }),

/***/ "./ExternalAssets/existing/ExistingDeleteDrug.js":
/*!*******************************************************!*\
  !*** ./ExternalAssets/existing/ExistingDeleteDrug.js ***!
  \*******************************************************/
/***/ (() => {

window.addEventListener('DOMContentLoaded', function () {
  $(document).on("click", ".ExistingDeleteCartItem", function () {
    var id = $(this).data('id');
    axios.get(GLOBAL_API_PATH + 'RemoveDrugCartItem/' + id).then(function (response) {
      if (response.data.status == "success") {
        Swal.fire('Action Successful', response.data.Message, 'success');
        FetchExistingCartItems();
      }
    })["catch"](function (error) {
      console.log(error);
      CatchAxiosError(error);
    });
  });
});

/***/ }),

/***/ "./ExternalAssets/existing/ExistingDisplayCartTable.js":
/*!*************************************************************!*\
  !*** ./ExternalAssets/existing/ExistingDisplayCartTable.js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

window.addEventListener('DOMContentLoaded', function () {
  __webpack_require__.g.ExistingDisplayCartTable = function (CartItems, Total) {
    if ($("#BillingStatus").val() == 'Hospital Billable') {
      var PackageBalance = $('#PackageBalance').data('balance');
      var ActualBalance = $('.ActualBalance');
      var FinalTotal = PackageBalance - Total;
      ActualBalance.html("UGX ".concat(FinalTotal.toLocaleString()));
      localStorage.setItem('DEDUCTIBLE_BALANCE', FinalTotal);
    }

    var TotalSumHere = $('.TotalSumHere');
    /*Ensure Cart is not empty */

    TotalSumHere2.val(Total);
    /*Ensure Cart is not empty */

    var TotalSumHereInput = $('.TotalSumHereInput');
    TotalSumHere.text('UGX ' + Total.toLocaleString());

    if (TotalSumHereInput.length > 0) {
      TotalSumHereInput.val(Total);
    }

    __webpack_require__.g.DisplayCartItemsHere = $('.ExistingDisplayCartItemsHere');
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
      DisplayCartItemsHere.append("<td><a data-id=\"".concat(item.id, "\"\n            class=\"btn shadow-lg btn-info btn-sm ExistingDeleteCartItem\"\n            href=\"#Update\">\n\n            <i class=\"fas fa-times\"\n                aria-hidden=\"true\"></i>\n        </a></td>"));
      DisplayCartItemsHere.append(CloseTr);
    });
  };
});

/***/ }),

/***/ "./ExternalAssets/existing/ExistingFetchCartItems.js":
/*!***********************************************************!*\
  !*** ./ExternalAssets/existing/ExistingFetchCartItems.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.FetchExistingCartItems = function () {
  spinner_display_switch.show();
  var PaymentSessionID = $('#PaymentSessionID').val();
  var FORM_DATA = {
    PaymentSessionID: PaymentSessionID
  }; // alert(PaymentSessionID);

  axios.post(GLOBAL_API_PATH + 'GetDispenseCart', FORM_DATA).then(function (response) {
    spinner_display_switch.hide();

    if (response.data.status == "success") {
      ExistingDisplayCartTable(response.data.CartItems, response.data.Total);
    }
  })["catch"](function (error) {
    spinner_display_switch.hide();
    console.log(error);
    CatchAxiosError(error);
  });
};

window.addEventListener('DOMContentLoaded', function () {
  FetchExistingCartItems();
});

/***/ }),

/***/ "./ExternalAssets/existing/ExistingGlobals.js":
/*!****************************************************!*\
  !*** ./ExternalAssets/existing/ExistingGlobals.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

window.addEventListener('DOMContentLoaded', function () {
  __webpack_require__.g.HideModal = function (ModalId) {
    $('#' + ModalId).hide();
    $('.modal-backdrop').remove();
  };

  __webpack_require__.g.ShowModal = function (ModalId) {
    $('#' + ModalId).show();
    $('body').append("<div class=\"modal-backdrop show\"></div>");
  };

  $(document).on('click', '[data-bs-dismiss="modal"]', function () {
    $('.modal-backdrop').remove();
  });
});

/***/ }),

/***/ "./ExternalAssets/existing/ExistingSelectDrugStock.js":
/*!************************************************************!*\
  !*** ./ExternalAssets/existing/ExistingSelectDrugStock.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.FetchExistingDrugStockpiles = function (SelectedDrugId, QtySelected) {
  var Route = 'SelectStockPileForDispense/';
  spinner_display_switch.show();

  if (SelectedDrugId.length != 0 && QtySelected.length != 0) {
    axios.get(GLOBAL_API_PATH + Route + SelectedDrugId).then(function (response) {
      spinner_display_switch.hide();

      if (response.data.Count == 'true') {
        if (response.data.status == 'success') {
          var StockPiles = response.data.StockPiles;
          DisplayExistingTable(StockPiles);
          ShowStockPilesTable();
          HideModal('ModalSelectDrug');
          ShowModal('ModalSelectDrugStockPile');
        }
      } else {
        Swal.fire('OOPS', 'The selected stock item is out of stock. Please restock and try again', 'error');
      }
    })["catch"](function (error) {
      spinner_display_switch.hide(); // handle error

      console.log(error);
    });
  } else {
    spinner_display_switch.hide();
    Swal.fire('Oops', 'The stock item and quantity selection cannot be empty', 'error');
  }
};

/***/ }),

/***/ "./ExternalAssets/existing/ExistingStockpileTable.js":
/*!***********************************************************!*\
  !*** ./ExternalAssets/existing/ExistingStockpileTable.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.DisplayExistingTable = function (StockPiles) {
  DisplayStockHere.html(' ');
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
    DisplayStockHere.append("<td><a data-stockid = \"".concat(data.StockID, "\"\n        class=\"btn shadow-lg btn-info btn-sm ConfirmDrugExistingSelectionToCache\"\n        href=\"#Update\">\n\n        <i class=\"fas fa-check\"\n            aria-hidden=\"true\"></i>\n    </a></td>"));
    DisplayStockHere.append(CloseTr);
  });
};

/***/ }),

/***/ "./ExternalAssets/existing/ProcessPayment.js":
/*!***************************************************!*\
  !*** ./ExternalAssets/existing/ProcessPayment.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/**ProcessThePaymentNow */
__webpack_require__(/*! ./ProcessPaymentNow.js */ "./ExternalAssets/existing/ProcessPaymentNow.js");
/**ProcessThePaymentNow */


window.addEventListener('DOMContentLoaded', function () {
  __webpack_require__.g.ExistingDisplayReceiptTable = function (receipt) {
    var ReceiptItemsShowHere = $('.ReceiptItemsShowHere');
    ReceiptItemsShowHere.html(' ');
    var Tr = '<tr>';
    var CloseTr = '</tr>';
    receipt.forEach(function (data) {
      ReceiptItemsShowHere.append(Tr);
      ReceiptItemsShowHere.append("<td>".concat(data.DrugName, "</td>"));
      ReceiptItemsShowHere.append("<td>".concat(data.GenericName, "</td>"));
      ReceiptItemsShowHere.append("<td>".concat(data.Units, "</td>"));
      ReceiptItemsShowHere.append("<td> ".concat(data.Currency, " ").concat(data.SellingPrice.toLocaleString(), "  </td>"));
      ReceiptItemsShowHere.append("<td> ".concat(data.Qty.toLocaleString(), "  ").concat(data.Units, "  </td>"));
      ReceiptItemsShowHere.append("<td>  ".concat(data.Currency, " ").concat(data.SubTotal.toLocaleString(), "  </td>"));
      ReceiptItemsShowHere.append(CloseTr);
    }); // PaymentModalWindow.show();
  };

  if ($('#ForPackagePatientExistingStartProcessingPayment').length > 0) {
    $(document).on("click", "#ForPackagePatientExistingStartProcessingPayment", function () {
      if ($('.PaymentMethodSelect').val() != 'NotSelected') {
        Swal.fire({
          title: 'Are you sure??',
          text: "You want to process this payment?. This action is not reversible ",
          icon: 'info',
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonText: 'Yes, Process Payment',
          denyButtonText: "Cancel Action"
        }).then(function (result) {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            spinner_display_switch.show();
            ExistingProcessThePaymentNow().then(console.log("Processing Step One Complete")).then( // stepper.goTo(1),
            setTimeout(function () {
              printJS('invoice-POS', 'html');
              spinner_display_switch.hide();
            }, 2000));
          }
        });
      } else {
        Swal.fire('OOPS, A Minor error occurred', ' The payment method cannot be empty. Please select a payment method to proceed', 'error');
      }
    });
  } else if ($('#ExistingStartProcessingPayment').length > 0) {
    $(document).on("click", "#ExistingStartProcessingPayment", function () {
      var PatientBillable = $('#PatientBillable').val();
      var Outstanding = $('#Outstanding').val();

      if (PatientBillable == 0 || Outstanding == 0 || PatientBillable == null || PatientBillable == NaN || Outstanding == null || Outstanding == NaN) {
        Swal.fire('OOPS, A minor error ocurred', 'The payment method or Amount Paid  cannot be empty. Select a payment method and try again', 'error');
        return false;
      } else {
        if ($('.PaymentMethodSelect').val() != 'NotSelected') {
          Swal.fire({
            title: 'Are you sure??',
            text: "You want to process this payment?. This action is not reversible ",
            icon: 'info',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes, Process Payment',
            denyButtonText: "Cancel Action"
          }).then(function (result) {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              spinner_display_switch.show();
              ExistingProcessThePaymentNow().then(console.log("Processing Step One Complete")).then( // stepper.goTo(1),
              setTimeout(function () {
                printJS('invoice-POS', 'html');
                spinner_display_switch.hide();
              }, 2000));
            }
          });
        } else {
          Swal.fire('OOPS, A Minor error occurred', ' The payment method cannot be empty. Please select a payment method to proceed', 'error');
        }
      }
    });
  }
});

/***/ }),

/***/ "./ExternalAssets/existing/ProcessPaymentNow.js":
/*!******************************************************!*\
  !*** ./ExternalAssets/existing/ProcessPaymentNow.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

window.addEventListener('DOMContentLoaded', function () {
  $("#PatientBillable").on("keyup change", function (e) {
    var PatientBillable = Number($('#PatientBillable').val());
    var TotalSumHereInput = Number($('.TotalSumHereInput').val());
    var Outstanding = TotalSumHereInput - PatientBillable;
    $('#Outstanding').val(Outstanding);

    if (PatientBillable == 0 || PatientBillable == null || PatientBillable == NaN) {
      $('#Outstanding').val(0);
    }
  });

  if ($('#ForPackagePatientExistingStartProcessingPayment').length > 0) {
    __webpack_require__.g.ExistingProcessThePaymentNow = function () {
      return new Promise(function (resolve, reject) {
        spinner_display_switch.show();
        var PatientName = $('#PatientName').val();
        var PatientPhone = $('#PatientPhone').val();
        var PatientEmail = $('#PatientEmail').val();
        var DispensedBy = $('#DispensedBy').val();
        $('.PatientNameT').html(PatientName);
        $('.PatientPhoneT').html(PatientPhone);
        $('.PatientEmailT').html(PatientEmail);
        $('.DispensedByT').html(DispensedBy);
        var PaymentSessionID = $('#PaymentSessionID').val();
        var PaymentMethodSelect = $('.PaymentMethodSelect').val();
        __webpack_require__.g.PaymentModalWindow = new bootstrap.Modal(document.getElementById('PaymentModalWindow'), {
          keyboard: false
        });

        if (PaymentMethodSelect.length == 0) {
          Swal.fire('OOPS, A minor error ocurred', 'The payment method cannot be empty. Select a payment method and try again', 'error');
        } else {
          var FORM_DATA = {
            PaymentMethod: PaymentMethodSelect,
            PaymentSessionID: PaymentSessionID,
            DEDUCTIBLE_BALANCE: localStorage.getItem('DEDUCTIBLE_BALANCE'),
            RecordKey: $("#RecordKey").val()
          };
          console.log("The deductible balance is ".concat(localStorage.getItem('DEDUCTIBLE_BALANCE')));
          axios.post(GLOBAL_API_PATH + 'PackagePatientExistingProcessPayment', FORM_DATA).then(function (response) {
            if (response.data.status == "out_of_stock") {
              Swal.fire('OOPS, Item(s)  out of stock', response.data.Message, 'error');
            } else if (response.data.status == 'issued') {
              Swal.fire('Error', 'Transaction Completed, Please refresh the page');
            } else {
              var receipt = response.data.receipt;
              DocumentTypeShowHere.html(response.data.DocumentType);
              TotalAmountShowHere.html("UGX ".concat(response.data.TotalSum.toLocaleString()));
              ExistingDisplayReceiptTable(receipt);
              PatientSelectShow.show();
              SelectPaymentMethodShow.hide();
            }

            console.log(response.data.receipt);
          })["catch"](function (error) {
            CatchAxiosError(error);
            spinner_display_switch.hide();
          });
        }
      });
    };
  } else if ($('#ExistingStartProcessingPayment').length > 0) {
    __webpack_require__.g.ExistingProcessThePaymentNow = function () {
      return new Promise(function (resolve, reject) {
        spinner_display_switch.show();
        var PatientName = $('#PatientName').val();
        var PatientPhone = $('#PatientPhone').val();
        var PatientEmail = $('#PatientEmail').val();
        var DispensedBy = $('#DispensedBy').val();
        var PatientBillable = $('#PatientBillable').val();
        var Outstanding = $('#Outstanding').val();
        $('.PatientNameT').html(PatientName);
        $('.PatientPhoneT').html(PatientPhone);
        $('.PatientEmailT').html(PatientEmail);
        $('.DispensedByT').html(DispensedBy);
        var PaymentSessionID = $('#PaymentSessionID').val();
        var PaymentMethodSelect = $('.PaymentMethodSelect').val();
        __webpack_require__.g.PaymentModalWindow = new bootstrap.Modal(document.getElementById('PaymentModalWindow'), {
          keyboard: false
        });

        if (PaymentMethodSelect.length == 0 || PatientBillable == 0 || Outstanding == 0) {
          Swal.fire('OOPS, A minor error ocurred', 'The payment method or Amount Paid  cannot be empty. Select a payment method and try again', 'error');
          return false;
        } else if (PaymentMethodSelect.length != 0 && PatientBillable.length != 0 && Outstanding.length != 0) {
          var FORM_DATA = {
            PaymentMethod: PaymentMethodSelect,
            PaymentSessionID: PaymentSessionID,
            DEDUCTIBLE_BALANCE: localStorage.getItem('DEDUCTIBLE_BALANCE'),
            RecordKey: $("#RecordKey").val(),
            Balance: PatientBillable,
            Outstanding: Outstanding,
            PatientEmail: PatientEmail,
            PatientName: PatientName,
            PatientPhone: PatientPhone
          };
          console.log("The deductible balance is ".concat(localStorage.getItem('DEDUCTIBLE_BALANCE')));
          axios.post(GLOBAL_API_PATH + 'ExistingProcessPayment', FORM_DATA).then(function (response) {
            if (response.data.status == "out_of_stock") {
              Swal.fire('OOPS, Item(s)  out of stock', response.data.Message, 'error');
            } else if (response.data.status == 'issued') {
              Swal.fire('Error', 'Transaction Completed, Please refresh the page');
            } else {
              var receipt = response.data.receipt;
              DocumentTypeShowHere.html(response.data.DocumentType);
              TotalAmountShowHere.html("UGX ".concat(response.data.TotalSum.toLocaleString()));
              ExistingDisplayReceiptTable(receipt);
              PatientSelectShow.show();
              SelectPaymentMethodShow.hide();
            }

            console.log(response.data.receipt);
          })["catch"](function (error) {
            CatchAxiosError(error);
            spinner_display_switch.hide();
          });
        } else {
          Swal.fire('OOPS, A minor error ocurred', 'The payment method or Amount Paid  cannot be empty. Select a payment method and try again', 'error');
          return false;
        }
      });
    };
  }
});

/***/ }),

/***/ "./ExternalAssets/existing/ReloadTimer.js":
/*!************************************************!*\
  !*** ./ExternalAssets/existing/ReloadTimer.js ***!
  \************************************************/
/***/ (() => {

if ($('.ReloadTimer').length > 0) {
  if (window.performance) {
    console.info("window.performance works fine on this browser");
  }

  console.info(performance.navigation.type);

  if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
    console.info("This page is reloaded");
    window.location.replace(GLOBAL_PATH + 'SelectExistingPatient');
  }
}

/***/ }),

/***/ "./ExternalAssets/sale/CatchAllAxiosErrors.js":
/*!****************************************************!*\
  !*** ./ExternalAssets/sale/CatchAllAxiosErrors.js ***!
  \****************************************************/
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

/***/ "./ExternalAssets/sale/ConfirmDrugSelectionToCache.js":
/*!************************************************************!*\
  !*** ./ExternalAssets/sale/ConfirmDrugSelectionToCache.js ***!
  \************************************************************/
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
      axios.post(GLOBAL_API_PATH + 'RecordDispenseCache', FORM_DATA).then(function (response) {
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

/***/ "./ExternalAssets/sale/DeleteCartItem.js":
/*!***********************************************!*\
  !*** ./ExternalAssets/sale/DeleteCartItem.js ***!
  \***********************************************/
/***/ (() => {

window.addEventListener('DOMContentLoaded', function () {
  $(document).on("click", ".DeleteCartItem", function () {
    var id = $(this).data('id');
    axios.get(GLOBAL_API_PATH + 'RemoveDrugCartItem/' + id).then(function (response) {
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

/***/ "./ExternalAssets/sale/DisplayCartItems.js":
/*!*************************************************!*\
  !*** ./ExternalAssets/sale/DisplayCartItems.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.DisplayCartTable = function (CartItems, Total) {
  var TotalSumHere = $('.TotalSumHere');
  var TotalSumHereInput = $('.TotalSumHereInput');
  TotalSumHere.text('UGX ' + Total.toLocaleString());

  if (TotalSumHereInput.length > 0) {
    TotalSumHereInput.val(Total);
  }

  __webpack_require__.g.DisplayCartItemsHere = $('.DisplayCartItemsHere');
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

/***/ "./ExternalAssets/sale/FetchCartItems.js":
/*!***********************************************!*\
  !*** ./ExternalAssets/sale/FetchCartItems.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.FetchCartItems = function () {
  var PaymentSessionID = $('#PaymentSessionID').val();
  var FORM_DATA = {
    PaymentSessionID: PaymentSessionID
  };
  axios.post(GLOBAL_API_PATH + 'GetDispenseCart', FORM_DATA).then(function (response) {
    if (response.data.status == "success") {
      DisplayCartTable(response.data.CartItems, response.data.Total);
    }
  })["catch"](function (error) {
    console.log(error);
    CatchAxiosError(error);
  });
};

/***/ }),

/***/ "./ExternalAssets/sale/FetchDrugStockPiles.js":
/*!****************************************************!*\
  !*** ./ExternalAssets/sale/FetchDrugStockPiles.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/***Fetch Selected Drug StockPiles */
__webpack_require__.g.FetchDrugStockpiles = function () {
  var SelectedDrugId = $('.SelectedDrugId').val();
  var Route = 'SelectStockPileForDispense/';
  var QtySelected = $('#QtySelected').val();

  if (SelectedDrugId.length != 0 && QtySelected.length != 0) {
    axios.get(GLOBAL_API_PATH + Route + SelectedDrugId).then(function (response) {
      if (response.data.Count == 'true') {
        if (response.data.status == 'success') {
          var StockPiles = response.data.StockPiles;
          DisplayTable(StockPiles);
          ShowStockPilesTable();
        }
      } else {
        Swal.fire('OOPS', 'The selected item is out of stock. Please restock and try again', 'error');
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

/***/ "./ExternalAssets/sale/ProcessPayment.js":
/*!***********************************************!*\
  !*** ./ExternalAssets/sale/ProcessPayment.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/**ProcessThePaymentNow */
__webpack_require__(/*! ./ProcessThePaymentNow.js */ "./ExternalAssets/sale/ProcessThePaymentNow.js");
/**ProcessThePaymentNow */


window.addEventListener('DOMContentLoaded', function () {
  __webpack_require__.g.DisplayReceiptTable = function (receipt) {
    var ReceiptItemsShowHere = $('.ReceiptItemsShowHere');
    ReceiptItemsShowHere.html(' ');
    var Tr = '<tr>';
    var CloseTr = '</tr>';
    receipt.forEach(function (data) {
      ReceiptItemsShowHere.append(Tr);
      ReceiptItemsShowHere.append("<td>".concat(data.DrugName, "</td>"));
      ReceiptItemsShowHere.append("<td>".concat(data.GenericName, "</td>"));
      ReceiptItemsShowHere.append("<td>".concat(data.Units, "</td>"));
      ReceiptItemsShowHere.append("<td> ".concat(data.Currency, " ").concat(data.SellingPrice.toLocaleString(), "  </td>"));
      ReceiptItemsShowHere.append("<td> ".concat(data.Qty.toLocaleString(), "  ").concat(data.Units, "  </td>"));
      ReceiptItemsShowHere.append("<td>  ".concat(data.Currency, " ").concat(data.SubTotal.toLocaleString(), "  </td>"));
      ReceiptItemsShowHere.append(CloseTr);
    }); //PaymentModalWindow.show();
  };

  $(document).on("click", "#StartProcessingPayment", function () {
    Swal.fire({
      title: 'Are you sure??',
      text: "You want to process this payment?. This action is not reversible ",
      icon: 'info',
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonText: 'Yes, Process Payment',
      denyButtonText: "Cancel Action"
    }).then(function (result) {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        spinner_display_switch.show();
        ProcessThePaymentNow().then(console.log("Processing Step One Complete")).then(GeneratePaymentSession(), DisplayCartItemsHere.html(' '), TotalSumHere.html(' '));
      }
    });
  });
});

/***/ }),

/***/ "./ExternalAssets/sale/ProcessThePaymentNow.js":
/*!*****************************************************!*\
  !*** ./ExternalAssets/sale/ProcessThePaymentNow.js ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

window.addEventListener('DOMContentLoaded', function () {
  $("#PatientBillable").on("keyup change", function (e) {
    var PatientBillable = Number($('#PatientBillable').val());
    var TotalSumHereInput = Number($('.TotalSumHereInput').val());
    var Outstanding = TotalSumHereInput - PatientBillable;
    $('#Outstanding').val(Outstanding);

    if (PatientBillable == 0 || PatientBillable == null || PatientBillable == NaN) {
      $('#Outstanding').val(0);
    }
  });

  __webpack_require__.g.ProcessThePaymentNow = function () {
    return new Promise(function (resolve, reject) {
      spinner_display_switch.show();
      var PatientName = $('#PatientName').val();
      var PatientPhone = $('#PatientPhone').val();
      var PatientEmail = $('#PatientEmail').val();
      var DispensedBy = $('#DispensedBy').val();
      var PatientBillable = $('#PatientBillable').val();
      var Outstanding = $('#Outstanding').val();
      $('.PatientNameT').html(PatientName);
      $('.PatientPhoneT').html(PatientPhone);
      $('.PatientEmailT').html(PatientEmail);
      $('.DispensedByT').html(DispensedBy);
      var PaymentSessionID = $('#PaymentSessionID').val();
      var PaymentMethodSelect = $('.PaymentMethodSelect').val();
      __webpack_require__.g.PaymentModalWindow = new bootstrap.Modal(document.getElementById('PaymentModalWindow'), {
        keyboard: false
      });

      if (PaymentMethodSelect.length == 0 || PatientBillable.length == 0 || Outstanding.length == 0) {
        Swal.fire('OOPS, A minor error ocurred', 'The payment method or Amount Paid  cannot be empty. Select a payment method and try again', 'error');
        return false;
      } else if (PatientName.length == 0 || PatientPhone.length == 0 || PatientEmail.length == 0) {
        Swal.fire('OOPS, A minor error ocurred', 'This payment has been processed already. Please  register a new patient to dispense Stock items to', 'error');
        return false;
      } else if (PaymentMethodSelect.length != 0 && PatientBillable.length != 0 && Outstanding.length != 0) {
        var _FORM_DATA;

        var FORM_DATA = (_FORM_DATA = {
          PaymentMethod: PaymentMethodSelect,
          PaymentSessionID: PaymentSessionID,
          Balance: PatientBillable,
          Outstanding: Outstanding,
          PatientEmail: PatientEmail
        }, _defineProperty(_FORM_DATA, "PatientEmail", PatientEmail), _defineProperty(_FORM_DATA, "PatientName", PatientName), _defineProperty(_FORM_DATA, "PatientPhone", PatientPhone), _FORM_DATA);
        axios.post(GLOBAL_API_PATH + 'ProcessDispense', FORM_DATA).then(function (response) {
          if (response.data.status == "out_of_stock") {
            Swal.fire('OOPS, Item(s)  out of stock', response.data.Message, 'error');
          } else if (response.data.status == 'Item_Already_purchased') {
            var receipt = response.data.receipt;
            DocumentTypeShowHere.html(response.data.DocumentType);
            TotalAmountShowHere.html("UGX ".concat(response.data.TotalSum.toLocaleString()));
            DisplayReceiptTable(receipt);
            $('#PatientBillable').val(0);
            $('#Outstanding').val(0);
            stepper.goTo(1), setTimeout(function () {
              printJS('invoice-POS', 'html');
              spinner_display_switch.hide();
            }, 2000);
          } else {
            var receipt = response.data.receipt;
            DocumentTypeShowHere.html(response.data.DocumentType);
            TotalAmountShowHere.html("UGX ".concat(response.data.TotalSum.toLocaleString()));
            $('#PatientBillable').val(0);
            $('#Outstanding').val(0);
            DisplayReceiptTable(receipt);
            stepper.goTo(1), setTimeout(function () {
              printJS('invoice-POS', 'html');
              spinner_display_switch.hide();
            }, 2000);
          }

          console.log(response.data.receipt);
        })["catch"](function (error) {
          CatchAxiosError(error);
          spinner_display_switch.hide();
        });
      }
    });
  };
  /**Func Closure */

});

/***/ }),

/***/ "./ExternalAssets/sale/ShowSelectDrugsSelect.js":
/*!******************************************************!*\
  !*** ./ExternalAssets/sale/ShowSelectDrugsSelect.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.ShowSelectDrugsSelect = function () {
  SelectDrugSelect.show();
  StockPilesTable.hide();
  DisplayStockHere.html('');
};

/***/ }),

/***/ "./ExternalAssets/sale/ShowStockPilesTable.js":
/*!****************************************************!*\
  !*** ./ExternalAssets/sale/ShowStockPilesTable.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.ShowStockPilesTable = function () {
  SelectDrugSelect.hide();
  StockPilesTable.show();
};

/***/ }),

/***/ "./ExternalAssets/sale/ShowTableStockPiles.js":
/*!****************************************************!*\
  !*** ./ExternalAssets/sale/ShowTableStockPiles.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__.g.DisplayTable = function (StockPiles) {
  DisplayStockHere.html(' ');
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

/***/ "./ExternalAssets/sale/dispense.js":
/*!*****************************************!*\
  !*** ./ExternalAssets/sale/dispense.js ***!
  \*****************************************/
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

/***/ "./ExternalAssets/sale/globals.js":
/*!****************************************!*\
  !*** ./ExternalAssets/sale/globals.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

// global.host = $('.Virtualhost').val();
__webpack_require__.g.Virtualhost = 'http://d.pharma/api/';
var GetVirtualHost = $('#GetVirtualHost').val();
__webpack_require__.g.GLOBAL_PATH = GetVirtualHost + '/';
__webpack_require__.g.DOMAIN_NAME = location.host;
__webpack_require__.g.PROTOCOL = location.protocol;
__webpack_require__.g.GLOBAL_API_PATH = PROTOCOL + '//' + DOMAIN_NAME + '/api/'; //alert(GLOBAL_API_PATH);

__webpack_require__.g.TotalSumHere2 = $('.TotalSumHere2');
__webpack_require__.g.GoToPay = $('.GoToPay');

__webpack_require__(/*! ../existing/ReloadTimer */ "./ExternalAssets/existing/ReloadTimer.js"); //alert(GLOBAL_API_PATH);


window.addEventListener('DOMContentLoaded', function () {
  if ($('.TotalSumHere2').length > 0) {
    setInterval(function () {
      if ($('.TotalSumHere2').val() == "0" || $('.TotalSumHere2').val() == 0) {
        GoToPay.hide();
      } else {
        GoToPay.show(); // alert($('.TotalSumHere2').val())
      }
    }, 1000);
  }
});
__webpack_require__.g.SelectDrugSelect = $('.SelectDrugSelect');
__webpack_require__.g.StockPilesTable = $('.SelectStockPileTable');
__webpack_require__.g.DisplayStockHere = $('.DisplayStockHere');
__webpack_require__.g.spinner_display_switch = $('.spinner_display_switch');
__webpack_require__.g.DocumentTypeShowHere = $('.DocumentTypeShowHere');
__webpack_require__.g.TotalAmountShowHere = $('.TotalAmountShowHere');
__webpack_require__.g.TotalSumHere = $('.TotalSumHere');

__webpack_require__.g.GeneratePaymentSession = function () {
  axios.get('api/GeneratePaymentSession').then(function (response) {
    // handle success
    if (response.data.status == "success") {
      var PaymentSessionID = $('#PaymentSessionID');
      PaymentSessionID.val(response.data.PaymentSessionID);
      $('#PatientName').val('');
      $('#PatientPhone').val('');
      $('#PatientEmail').val('');
      console.log("Sessions Ejected and Regenerated");
    } else {
      Swal.fire('OOPS', 'A network error ocurred, Check your connection', 'error');
    }
  })["catch"](function (error) {
    // handle error
    CatchAxiosError(error);
  });
};
/*******Existing Patient Globals */


window.addEventListener('DOMContentLoaded', function () {
  if ($('.SelectPaymentMethodShow').length > 0 && $('.PatientSelectShow').length > 0) {
    __webpack_require__.g.SelectPaymentMethodShow = $('.SelectPaymentMethodShow');
    __webpack_require__.g.PatientSelectShow = $('.PatientSelectShow');
    PatientSelectShow.hide(); // alert('true');
  }
});
/*******Existing Patient */

/***/ }),

/***/ "./node_modules/print-js/dist/print.js":
/*!*********************************************!*\
  !*** ./node_modules/print-js/dist/print.js ***!
  \*********************************************/
/***/ ((module) => {

(function webpackUniversalModuleDefinition(root, factory) {
	if(true)
		module.exports = factory();
	else {}
})(window, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __nested_webpack_require_539__(moduleId) {
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
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __nested_webpack_require_539__);
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
/******/ 	__nested_webpack_require_539__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__nested_webpack_require_539__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__nested_webpack_require_539__.d = function(exports, name, getter) {
/******/ 		if(!__nested_webpack_require_539__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__nested_webpack_require_539__.r = function(exports) {
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
/******/ 	__nested_webpack_require_539__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __nested_webpack_require_539__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__nested_webpack_require_539__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __nested_webpack_require_539__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__nested_webpack_require_539__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__nested_webpack_require_539__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__nested_webpack_require_539__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__nested_webpack_require_539__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __nested_webpack_require_539__(__nested_webpack_require_539__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __nested_webpack_require_4148__) {

"use strict";
__nested_webpack_require_4148__.r(__webpack_exports__);
/* harmony import */ var _sass_index_scss__WEBPACK_IMPORTED_MODULE_0__ = __nested_webpack_require_4148__(/*! ./sass/index.scss */ "./src/sass/index.scss");
/* harmony import */ var _sass_index_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__nested_webpack_require_4148__.n(_sass_index_scss__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _js_init__WEBPACK_IMPORTED_MODULE_1__ = __nested_webpack_require_4148__(/*! ./js/init */ "./src/js/init.js");


var printJS = _js_init__WEBPACK_IMPORTED_MODULE_1__["default"].init;

if (typeof window !== 'undefined') {
  window.printJS = printJS;
}

/* harmony default export */ __webpack_exports__["default"] = (printJS);

/***/ }),

/***/ "./src/js/browser.js":
/*!***************************!*\
  !*** ./src/js/browser.js ***!
  \***************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __nested_webpack_require_5091__) {

"use strict";
__nested_webpack_require_5091__.r(__webpack_exports__);
var Browser = {
  // Firefox 1.0+
  isFirefox: function isFirefox() {
    return typeof InstallTrigger !== 'undefined';
  },
  // Internet Explorer 6-11
  isIE: function isIE() {
    return navigator.userAgent.indexOf('MSIE') !== -1 || !!document.documentMode;
  },
  // Edge 20+
  isEdge: function isEdge() {
    return !Browser.isIE() && !!window.StyleMedia;
  },
  // Chrome 1+
  isChrome: function isChrome() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : window;
    return !!context.chrome;
  },
  // At least Safari 3+: "[object HTMLElementConstructor]"
  isSafari: function isSafari() {
    return Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0 || navigator.userAgent.toLowerCase().indexOf('safari') !== -1;
  },
  // IOS Chrome
  isIOSChrome: function isIOSChrome() {
    return navigator.userAgent.toLowerCase().indexOf('crios') !== -1;
  }
};
/* harmony default export */ __webpack_exports__["default"] = (Browser);

/***/ }),

/***/ "./src/js/functions.js":
/*!*****************************!*\
  !*** ./src/js/functions.js ***!
  \*****************************/
/*! exports provided: addWrapper, capitalizePrint, collectStyles, addHeader, cleanUp, isRawHTML */
/***/ (function(module, __webpack_exports__, __nested_webpack_require_6463__) {

"use strict";
__nested_webpack_require_6463__.r(__webpack_exports__);
/* harmony export (binding) */ __nested_webpack_require_6463__.d(__webpack_exports__, "addWrapper", function() { return addWrapper; });
/* harmony export (binding) */ __nested_webpack_require_6463__.d(__webpack_exports__, "capitalizePrint", function() { return capitalizePrint; });
/* harmony export (binding) */ __nested_webpack_require_6463__.d(__webpack_exports__, "collectStyles", function() { return collectStyles; });
/* harmony export (binding) */ __nested_webpack_require_6463__.d(__webpack_exports__, "addHeader", function() { return addHeader; });
/* harmony export (binding) */ __nested_webpack_require_6463__.d(__webpack_exports__, "cleanUp", function() { return cleanUp; });
/* harmony export (binding) */ __nested_webpack_require_6463__.d(__webpack_exports__, "isRawHTML", function() { return isRawHTML; });
/* harmony import */ var _modal__WEBPACK_IMPORTED_MODULE_0__ = __nested_webpack_require_6463__(/*! ./modal */ "./src/js/modal.js");
/* harmony import */ var _browser__WEBPACK_IMPORTED_MODULE_1__ = __nested_webpack_require_6463__(/*! ./browser */ "./src/js/browser.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



function addWrapper(htmlData, params) {
  var bodyStyle = 'font-family:' + params.font + ' !important; font-size: ' + params.font_size + ' !important; width:100%;';
  return '<div style="' + bodyStyle + '">' + htmlData + '</div>';
}
function capitalizePrint(obj) {
  return obj.charAt(0).toUpperCase() + obj.slice(1);
}
function collectStyles(element, params) {
  var win = document.defaultView || window; // String variable to hold styling for each element

  var elementStyle = ''; // Loop over computed styles

  var styles = win.getComputedStyle(element, '');

  for (var key = 0; key < styles.length; key++) {
    // Check if style should be processed
    if (params.targetStyles.indexOf('*') !== -1 || params.targetStyle.indexOf(styles[key]) !== -1 || targetStylesMatch(params.targetStyles, styles[key])) {
      if (styles.getPropertyValue(styles[key])) elementStyle += styles[key] + ':' + styles.getPropertyValue(styles[key]) + ';';
    }
  } // Print friendly defaults (deprecated)


  elementStyle += 'max-width: ' + params.maxWidth + 'px !important; font-size: ' + params.font_size + ' !important;';
  return elementStyle;
}

function targetStylesMatch(styles, value) {
  for (var i = 0; i < styles.length; i++) {
    if (_typeof(value) === 'object' && value.indexOf(styles[i]) !== -1) return true;
  }

  return false;
}

function addHeader(printElement, params) {
  // Create the header container div
  var headerContainer = document.createElement('div'); // Check if the header is text or raw html

  if (isRawHTML(params.header)) {
    headerContainer.innerHTML = params.header;
  } else {
    // Create header element
    var headerElement = document.createElement('h1'); // Create header text node

    var headerNode = document.createTextNode(params.header); // Build and style

    headerElement.appendChild(headerNode);
    headerElement.setAttribute('style', params.headerStyle);
    headerContainer.appendChild(headerElement);
  }

  printElement.insertBefore(headerContainer, printElement.childNodes[0]);
}
function cleanUp(params) {
  // If we are showing a feedback message to user, remove it
  if (params.showModal) _modal__WEBPACK_IMPORTED_MODULE_0__["default"].close(); // Check for a finished loading hook function

  if (params.onLoadingEnd) params.onLoadingEnd(); // If preloading pdf files, clean blob url

  if (params.showModal || params.onLoadingStart) window.URL.revokeObjectURL(params.printable); // Run onPrintDialogClose callback

  var event = 'mouseover';

  if (_browser__WEBPACK_IMPORTED_MODULE_1__["default"].isChrome() || _browser__WEBPACK_IMPORTED_MODULE_1__["default"].isFirefox()) {
    // Ps.: Firefox will require an extra click in the document to fire the focus event.
    event = 'focus';
  }

  var handler = function handler() {
    // Make sure the event only happens once.
    window.removeEventListener(event, handler);
    params.onPrintDialogClose(); // Remove iframe from the DOM

    var iframe = document.getElementById(params.frameId);

    if (iframe) {
      iframe.remove();
    }
  };

  window.addEventListener(event, handler);
}
function isRawHTML(raw) {
  var regexHtml = new RegExp('<([A-Za-z][A-Za-z0-9]*)\\b[^>]*>(.*?)</\\1>');
  return regexHtml.test(raw);
}

/***/ }),

/***/ "./src/js/html.js":
/*!************************!*\
  !*** ./src/js/html.js ***!
  \************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __nested_webpack_require_11361__) {

"use strict";
__nested_webpack_require_11361__.r(__webpack_exports__);
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_0__ = __nested_webpack_require_11361__(/*! ./functions */ "./src/js/functions.js");
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_1__ = __nested_webpack_require_11361__(/*! ./print */ "./src/js/print.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Get the DOM printable element
    var printElement = isHtmlElement(params.printable) ? params.printable : document.getElementById(params.printable); // Check if the element exists

    if (!printElement) {
      window.console.error('Invalid HTML element id: ' + params.printable);
      return;
    } // Clone the target element including its children (if available)


    params.printableElement = cloneElement(printElement, params); // Add header

    if (params.header) {
      Object(_functions__WEBPACK_IMPORTED_MODULE_0__["addHeader"])(params.printableElement, params);
    } // Print html element contents


    _print__WEBPACK_IMPORTED_MODULE_1__["default"].send(params, printFrame);
  }
});

function cloneElement(element, params) {
  // Clone the main node (if not already inside the recursion process)
  var clone = element.cloneNode(); // Loop over and process the children elements / nodes (including text nodes)

  var childNodesArray = Array.prototype.slice.call(element.childNodes);

  for (var i = 0; i < childNodesArray.length; i++) {
    // Check if we are skipping the current element
    if (params.ignoreElements.indexOf(childNodesArray[i].id) !== -1) {
      continue;
    } // Clone the child element


    var clonedChild = cloneElement(childNodesArray[i], params); // Attach the cloned child to the cloned parent node

    clone.appendChild(clonedChild);
  } // Get all styling for print element (for nodes of type element only)


  if (params.scanStyles && element.nodeType === 1) {
    clone.setAttribute('style', Object(_functions__WEBPACK_IMPORTED_MODULE_0__["collectStyles"])(element, params));
  } // Check if the element needs any state processing (copy user input data)


  switch (element.tagName) {
    case 'SELECT':
      // Copy the current selection value to its clone
      clone.value = element.value;
      break;

    case 'CANVAS':
      // Copy the canvas content to its clone
      clone.getContext('2d').drawImage(element, 0, 0);
      break;
  }

  return clone;
}

function isHtmlElement(printable) {
  // Check if element is instance of HTMLElement or has nodeType === 1 (for elements in iframe)
  return _typeof(printable) === 'object' && printable && (printable instanceof HTMLElement || printable.nodeType === 1);
}

/***/ }),

/***/ "./src/js/image.js":
/*!*************************!*\
  !*** ./src/js/image.js ***!
  \*************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __nested_webpack_require_14675__) {

"use strict";
__nested_webpack_require_14675__.r(__webpack_exports__);
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_0__ = __nested_webpack_require_14675__(/*! ./functions */ "./src/js/functions.js");
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_1__ = __nested_webpack_require_14675__(/*! ./print */ "./src/js/print.js");
/* harmony import */ var _browser__WEBPACK_IMPORTED_MODULE_2__ = __nested_webpack_require_14675__(/*! ./browser */ "./src/js/browser.js");



/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Check if we are printing one image or multiple images
    if (params.printable.constructor !== Array) {
      // Create array with one image
      params.printable = [params.printable];
    } // Create printable element (container)


    params.printableElement = document.createElement('div'); // Create all image elements and append them to the printable container

    params.printable.forEach(function (src) {
      // Create the image element
      var img = document.createElement('img');
      img.setAttribute('style', params.imageStyle); // Set image src with the file url

      img.src = src; // The following block is for Firefox, which for some reason requires the image's src to be fully qualified in
      // order to print it

      if (_browser__WEBPACK_IMPORTED_MODULE_2__["default"].isFirefox()) {
        var fullyQualifiedSrc = img.src;
        img.src = fullyQualifiedSrc;
      } // Create the image wrapper


      var imageWrapper = document.createElement('div'); // Append image to the wrapper element

      imageWrapper.appendChild(img); // Append wrapper to the printable element

      params.printableElement.appendChild(imageWrapper);
    }); // Check if we are adding a print header

    if (params.header) Object(_functions__WEBPACK_IMPORTED_MODULE_0__["addHeader"])(params.printableElement, params); // Print image

    _print__WEBPACK_IMPORTED_MODULE_1__["default"].send(params, printFrame);
  }
});

/***/ }),

/***/ "./src/js/init.js":
/*!************************!*\
  !*** ./src/js/init.js ***!
  \************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __nested_webpack_require_16897__) {

"use strict";
__nested_webpack_require_16897__.r(__webpack_exports__);
/* harmony import */ var _browser__WEBPACK_IMPORTED_MODULE_0__ = __nested_webpack_require_16897__(/*! ./browser */ "./src/js/browser.js");
/* harmony import */ var _modal__WEBPACK_IMPORTED_MODULE_1__ = __nested_webpack_require_16897__(/*! ./modal */ "./src/js/modal.js");
/* harmony import */ var _pdf__WEBPACK_IMPORTED_MODULE_2__ = __nested_webpack_require_16897__(/*! ./pdf */ "./src/js/pdf.js");
/* harmony import */ var _html__WEBPACK_IMPORTED_MODULE_3__ = __nested_webpack_require_16897__(/*! ./html */ "./src/js/html.js");
/* harmony import */ var _raw_html__WEBPACK_IMPORTED_MODULE_4__ = __nested_webpack_require_16897__(/*! ./raw-html */ "./src/js/raw-html.js");
/* harmony import */ var _image__WEBPACK_IMPORTED_MODULE_5__ = __nested_webpack_require_16897__(/*! ./image */ "./src/js/image.js");
/* harmony import */ var _json__WEBPACK_IMPORTED_MODULE_6__ = __nested_webpack_require_16897__(/*! ./json */ "./src/js/json.js");


function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }








var printTypes = ['pdf', 'html', 'image', 'json', 'raw-html'];
/* harmony default export */ __webpack_exports__["default"] = ({
  init: function init() {
    var params = {
      printable: null,
      fallbackPrintable: null,
      type: 'pdf',
      header: null,
      headerStyle: 'font-weight: 300;',
      maxWidth: 800,
      properties: null,
      gridHeaderStyle: 'font-weight: bold; padding: 5px; border: 1px solid #dddddd;',
      gridStyle: 'border: 1px solid lightgray; margin-bottom: -1px;',
      showModal: false,
      onError: function onError(error) {
        throw error;
      },
      onLoadingStart: null,
      onLoadingEnd: null,
      onPrintDialogClose: function onPrintDialogClose() {},
      onIncompatibleBrowser: function onIncompatibleBrowser() {},
      modalMessage: 'Retrieving Document...',
      frameId: 'printJS',
      printableElement: null,
      documentTitle: 'Document',
      targetStyle: ['clear', 'display', 'width', 'min-width', 'height', 'min-height', 'max-height'],
      targetStyles: ['border', 'box', 'break', 'text-decoration'],
      ignoreElements: [],
      repeatTableHeader: true,
      css: null,
      style: null,
      scanStyles: true,
      base64: false,
      // Deprecated
      onPdfOpen: null,
      font: 'TimesNewRoman',
      font_size: '12pt',
      honorMarginPadding: true,
      honorColor: false,
      imageStyle: 'max-width: 100%;'
    }; // Check if a printable document or object was supplied

    var args = arguments[0];

    if (args === undefined) {
      throw new Error('printJS expects at least 1 attribute.');
    } // Process parameters


    switch (_typeof(args)) {
      case 'string':
        params.printable = encodeURI(args);
        params.fallbackPrintable = params.printable;
        params.type = arguments[1] || params.type;
        break;

      case 'object':
        params.printable = args.printable;
        params.fallbackPrintable = typeof args.fallbackPrintable !== 'undefined' ? args.fallbackPrintable : params.printable;
        params.fallbackPrintable = params.base64 ? "data:application/pdf;base64,".concat(params.fallbackPrintable) : params.fallbackPrintable;

        for (var k in params) {
          if (k === 'printable' || k === 'fallbackPrintable') continue;
          params[k] = typeof args[k] !== 'undefined' ? args[k] : params[k];
        }

        break;

      default:
        throw new Error('Unexpected argument type! Expected "string" or "object", got ' + _typeof(args));
    } // Validate printable


    if (!params.printable) throw new Error('Missing printable information.'); // Validate type

    if (!params.type || typeof params.type !== 'string' || printTypes.indexOf(params.type.toLowerCase()) === -1) {
      throw new Error('Invalid print type. Available types are: pdf, html, image and json.');
    } // Check if we are showing a feedback message to the user (useful for large files)


    if (params.showModal) _modal__WEBPACK_IMPORTED_MODULE_1__["default"].show(params); // Check for a print start hook function

    if (params.onLoadingStart) params.onLoadingStart(); // To prevent duplication and issues, remove any used printFrame from the DOM

    var usedFrame = document.getElementById(params.frameId);
    if (usedFrame) usedFrame.parentNode.removeChild(usedFrame); // Create a new iframe for the print job

    var printFrame = document.createElement('iframe');

    if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isFirefox()) {
      // Set the iframe to be is visible on the page (guaranteed by fixed position) but hidden using opacity 0, because
      // this works in Firefox. The height needs to be sufficient for some part of the document other than the PDF
      // viewer's toolbar to be visible in the page
      printFrame.setAttribute('style', 'width: 1px; height: 100px; position: fixed; left: 0; top: 0; opacity: 0; border-width: 0; margin: 0; padding: 0');
    } else {
      // Hide the iframe in other browsers
      printFrame.setAttribute('style', 'visibility: hidden; height: 0; width: 0; position: absolute; border: 0');
    } // Set iframe element id


    printFrame.setAttribute('id', params.frameId); // For non pdf printing, pass an html document string to srcdoc (force onload callback)

    if (params.type !== 'pdf') {
      printFrame.srcdoc = '<html><head><title>' + params.documentTitle + '</title>'; // Attach css files

      if (params.css) {
        // Add support for single file
        if (!Array.isArray(params.css)) params.css = [params.css]; // Create link tags for each css file

        params.css.forEach(function (file) {
          printFrame.srcdoc += '<link rel="stylesheet" href="' + file + '">';
        });
      }

      printFrame.srcdoc += '</head><body></body></html>';
    } // Check printable type


    switch (params.type) {
      case 'pdf':
        // Check browser support for pdf and if not supported we will just open the pdf file instead
        if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isIE()) {
          try {
            console.info('Print.js doesn\'t support PDF printing in Internet Explorer.');
            var win = window.open(params.fallbackPrintable, '_blank');
            win.focus();
            params.onIncompatibleBrowser();
          } catch (error) {
            params.onError(error);
          } finally {
            // Make sure there is no loading modal opened
            if (params.showModal) _modal__WEBPACK_IMPORTED_MODULE_1__["default"].close();
            if (params.onLoadingEnd) params.onLoadingEnd();
          }
        } else {
          _pdf__WEBPACK_IMPORTED_MODULE_2__["default"].print(params, printFrame);
        }

        break;

      case 'image':
        _image__WEBPACK_IMPORTED_MODULE_5__["default"].print(params, printFrame);
        break;

      case 'html':
        _html__WEBPACK_IMPORTED_MODULE_3__["default"].print(params, printFrame);
        break;

      case 'raw-html':
        _raw_html__WEBPACK_IMPORTED_MODULE_4__["default"].print(params, printFrame);
        break;

      case 'json':
        _json__WEBPACK_IMPORTED_MODULE_6__["default"].print(params, printFrame);
        break;
    }
  }
});

/***/ }),

/***/ "./src/js/json.js":
/*!************************!*\
  !*** ./src/js/json.js ***!
  \************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __nested_webpack_require_24617__) {

"use strict";
__nested_webpack_require_24617__.r(__webpack_exports__);
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_0__ = __nested_webpack_require_24617__(/*! ./functions */ "./src/js/functions.js");
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_1__ = __nested_webpack_require_24617__(/*! ./print */ "./src/js/print.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Check if we received proper data
    if (_typeof(params.printable) !== 'object') {
      throw new Error('Invalid javascript data object (JSON).');
    } // Validate repeatTableHeader


    if (typeof params.repeatTableHeader !== 'boolean') {
      throw new Error('Invalid value for repeatTableHeader attribute (JSON).');
    } // Validate properties


    if (!params.properties || !Array.isArray(params.properties)) {
      throw new Error('Invalid properties array for your JSON data.');
    } // We will format the property objects to keep the JSON api compatible with older releases


    params.properties = params.properties.map(function (property) {
      return {
        field: _typeof(property) === 'object' ? property.field : property,
        displayName: _typeof(property) === 'object' ? property.displayName : property,
        columnSize: _typeof(property) === 'object' && property.columnSize ? property.columnSize + ';' : 100 / params.properties.length + '%;'
      };
    }); // Create a print container element

    params.printableElement = document.createElement('div'); // Check if we are adding a print header

    if (params.header) {
      Object(_functions__WEBPACK_IMPORTED_MODULE_0__["addHeader"])(params.printableElement, params);
    } // Build the printable html data


    params.printableElement.innerHTML += jsonToHTML(params); // Print the json data

    _print__WEBPACK_IMPORTED_MODULE_1__["default"].send(params, printFrame);
  }
});

function jsonToHTML(params) {
  // Get the row and column data
  var data = params.printable;
  var properties = params.properties; // Create a html table

  var htmlData = '<table style="border-collapse: collapse; width: 100%;">'; // Check if the header should be repeated

  if (params.repeatTableHeader) {
    htmlData += '<thead>';
  } // Add the table header row


  htmlData += '<tr>'; // Add the table header columns

  for (var a = 0; a < properties.length; a++) {
    htmlData += '<th style="width:' + properties[a].columnSize + ';' + params.gridHeaderStyle + '">' + Object(_functions__WEBPACK_IMPORTED_MODULE_0__["capitalizePrint"])(properties[a].displayName) + '</th>';
  } // Add the closing tag for the table header row


  htmlData += '</tr>'; // If the table header is marked as repeated, add the closing tag

  if (params.repeatTableHeader) {
    htmlData += '</thead>';
  } // Create the table body


  htmlData += '<tbody>'; // Add the table data rows

  for (var i = 0; i < data.length; i++) {
    // Add the row starting tag
    htmlData += '<tr>'; // Print selected properties only

    for (var n = 0; n < properties.length; n++) {
      var stringData = data[i]; // Support nested objects

      var property = properties[n].field.split('.');

      if (property.length > 1) {
        for (var p = 0; p < property.length; p++) {
          stringData = stringData[property[p]];
        }
      } else {
        stringData = stringData[properties[n].field];
      } // Add the row contents and styles


      htmlData += '<td style="width:' + properties[n].columnSize + params.gridStyle + '">' + stringData + '</td>';
    } // Add the row closing tag


    htmlData += '</tr>';
  } // Add the table and body closing tags


  htmlData += '</tbody></table>';
  return htmlData;
}

/***/ }),

/***/ "./src/js/modal.js":
/*!*************************!*\
  !*** ./src/js/modal.js ***!
  \*************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __nested_webpack_require_28932__) {

"use strict";
__nested_webpack_require_28932__.r(__webpack_exports__);
var Modal = {
  show: function show(params) {
    // Build modal
    var modalStyle = 'font-family:sans-serif; ' + 'display:table; ' + 'text-align:center; ' + 'font-weight:300; ' + 'font-size:30px; ' + 'left:0; top:0;' + 'position:fixed; ' + 'z-index: 9990;' + 'color: #0460B5; ' + 'width: 100%; ' + 'height: 100%; ' + 'background-color:rgba(255,255,255,.9);' + 'transition: opacity .3s ease;'; // Create wrapper

    var printModal = document.createElement('div');
    printModal.setAttribute('style', modalStyle);
    printModal.setAttribute('id', 'printJS-Modal'); // Create content div

    var contentDiv = document.createElement('div');
    contentDiv.setAttribute('style', 'display:table-cell; vertical-align:middle; padding-bottom:100px;'); // Add close button (requires print.css)

    var closeButton = document.createElement('div');
    closeButton.setAttribute('class', 'printClose');
    closeButton.setAttribute('id', 'printClose');
    contentDiv.appendChild(closeButton); // Add spinner (requires print.css)

    var spinner = document.createElement('span');
    spinner.setAttribute('class', 'printSpinner');
    contentDiv.appendChild(spinner); // Add message

    var messageNode = document.createTextNode(params.modalMessage);
    contentDiv.appendChild(messageNode); // Add contentDiv to printModal

    printModal.appendChild(contentDiv); // Append print modal element to document body

    document.getElementsByTagName('body')[0].appendChild(printModal); // Add event listener to close button

    document.getElementById('printClose').addEventListener('click', function () {
      Modal.close();
    });
  },
  close: function close() {
    var printModal = document.getElementById('printJS-Modal');

    if (printModal) {
      printModal.parentNode.removeChild(printModal);
    }
  }
};
/* harmony default export */ __webpack_exports__["default"] = (Modal);

/***/ }),

/***/ "./src/js/pdf.js":
/*!***********************!*\
  !*** ./src/js/pdf.js ***!
  \***********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __nested_webpack_require_31100__) {

"use strict";
__nested_webpack_require_31100__.r(__webpack_exports__);
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_0__ = __nested_webpack_require_31100__(/*! ./print */ "./src/js/print.js");
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_1__ = __nested_webpack_require_31100__(/*! ./functions */ "./src/js/functions.js");


/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Check if we have base64 data
    if (params.base64) {
      var bytesArray = Uint8Array.from(atob(params.printable), function (c) {
        return c.charCodeAt(0);
      });
      createBlobAndPrint(params, printFrame, bytesArray);
      return;
    } // Format pdf url


    params.printable = /^(blob|http|\/\/)/i.test(params.printable) ? params.printable : window.location.origin + (params.printable.charAt(0) !== '/' ? '/' + params.printable : params.printable); // Get the file through a http request (Preload)

    var req = new window.XMLHttpRequest();
    req.responseType = 'arraybuffer';
    req.addEventListener('error', function () {
      Object(_functions__WEBPACK_IMPORTED_MODULE_1__["cleanUp"])(params);
      params.onError(req.statusText, req); // Since we don't have a pdf document available, we will stop the print job
    });
    req.addEventListener('load', function () {
      // Check for errors
      if ([200, 201].indexOf(req.status) === -1) {
        Object(_functions__WEBPACK_IMPORTED_MODULE_1__["cleanUp"])(params);
        params.onError(req.statusText, req); // Since we don't have a pdf document available, we will stop the print job

        return;
      } // Print requested document


      createBlobAndPrint(params, printFrame, req.response);
    });
    req.open('GET', params.printable, true);
    req.send();
  }
});

function createBlobAndPrint(params, printFrame, data) {
  // Pass response or base64 data to a blob and create a local object url
  var localPdf = new window.Blob([data], {
    type: 'application/pdf'
  });
  localPdf = window.URL.createObjectURL(localPdf); // Set iframe src with pdf document url

  printFrame.setAttribute('src', localPdf);
  _print__WEBPACK_IMPORTED_MODULE_0__["default"].send(params, printFrame);
}

/***/ }),

/***/ "./src/js/print.js":
/*!*************************!*\
  !*** ./src/js/print.js ***!
  \*************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __nested_webpack_require_33544__) {

"use strict";
__nested_webpack_require_33544__.r(__webpack_exports__);
/* harmony import */ var _browser__WEBPACK_IMPORTED_MODULE_0__ = __nested_webpack_require_33544__(/*! ./browser */ "./src/js/browser.js");
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_1__ = __nested_webpack_require_33544__(/*! ./functions */ "./src/js/functions.js");


var Print = {
  send: function send(params, printFrame) {
    // Append iframe element to document body
    document.getElementsByTagName('body')[0].appendChild(printFrame); // Get iframe element

    var iframeElement = document.getElementById(params.frameId); // Wait for iframe to load all content

    iframeElement.onload = function () {
      if (params.type === 'pdf') {
        // Add a delay for Firefox. In my tests, 1000ms was sufficient but 100ms was not
        if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isFirefox()) {
          setTimeout(function () {
            return performPrint(iframeElement, params);
          }, 1000);
        } else {
          performPrint(iframeElement, params);
        }

        return;
      } // Get iframe element document


      var printDocument = iframeElement.contentWindow || iframeElement.contentDocument;
      if (printDocument.document) printDocument = printDocument.document; // Append printable element to the iframe body

      printDocument.body.appendChild(params.printableElement); // Add custom style

      if (params.type !== 'pdf' && params.style) {
        // Create style element
        var style = document.createElement('style');
        style.innerHTML = params.style; // Append style element to iframe's head

        printDocument.head.appendChild(style);
      } // If printing images, wait for them to load inside the iframe


      var images = printDocument.getElementsByTagName('img');

      if (images.length > 0) {
        loadIframeImages(Array.from(images)).then(function () {
          return performPrint(iframeElement, params);
        });
      } else {
        performPrint(iframeElement, params);
      }
    };
  }
};

function performPrint(iframeElement, params) {
  try {
    iframeElement.focus(); // If Edge or IE, try catch with execCommand

    if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isEdge() || _browser__WEBPACK_IMPORTED_MODULE_0__["default"].isIE()) {
      try {
        iframeElement.contentWindow.document.execCommand('print', false, null);
      } catch (e) {
        iframeElement.contentWindow.print();
      }
    } else {
      // Other browsers
      iframeElement.contentWindow.print();
    }
  } catch (error) {
    params.onError(error);
  } finally {
    if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isFirefox()) {
      // Move the iframe element off-screen and make it invisible
      iframeElement.style.visibility = 'hidden';
      iframeElement.style.left = '-1px';
    }

    Object(_functions__WEBPACK_IMPORTED_MODULE_1__["cleanUp"])(params);
  }
}

function loadIframeImages(images) {
  var promises = images.map(function (image) {
    if (image.src && image.src !== window.location.href) {
      return loadIframeImage(image);
    }
  });
  return Promise.all(promises);
}

function loadIframeImage(image) {
  return new Promise(function (resolve) {
    var pollImage = function pollImage() {
      !image || typeof image.naturalWidth === 'undefined' || image.naturalWidth === 0 || !image.complete ? setTimeout(pollImage, 500) : resolve();
    };

    pollImage();
  });
}

/* harmony default export */ __webpack_exports__["default"] = (Print);

/***/ }),

/***/ "./src/js/raw-html.js":
/*!****************************!*\
  !*** ./src/js/raw-html.js ***!
  \****************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __nested_webpack_require_37311__) {

"use strict";
__nested_webpack_require_37311__.r(__webpack_exports__);
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_0__ = __nested_webpack_require_37311__(/*! ./print */ "./src/js/print.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Create printable element (container)
    params.printableElement = document.createElement('div');
    params.printableElement.setAttribute('style', 'width:100%'); // Set our raw html as the printable element inner html content

    params.printableElement.innerHTML = params.printable; // Print html contents

    _print__WEBPACK_IMPORTED_MODULE_0__["default"].send(params, printFrame);
  }
});

/***/ }),

/***/ "./src/sass/index.scss":
/*!*****************************!*\
  !*** ./src/sass/index.scss ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ 0:
/*!****************************!*\
  !*** multi ./src/index.js ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports, __nested_webpack_require_38488__) {

module.exports = __nested_webpack_require_38488__(/*! ./src/index.js */"./src/index.js");


/***/ })

/******/ })["default"];
});
//# sourceMappingURL=print.map

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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
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
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!*******************************!*\
  !*** ./ExternalAssets/app.js ***!
  \*******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var print_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! print-js */ "./node_modules/print-js/dist/print.js");
/* harmony import */ var print_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(print_js__WEBPACK_IMPORTED_MODULE_0__);

/*****JavaScript For the onetime sale of drugs */

__webpack_require__(/*! ./sale/globals.js */ "./ExternalAssets/sale/globals.js");

__webpack_require__(/*! ./sale/ShowStockPilesTable.js */ "./ExternalAssets/sale/ShowStockPilesTable.js");

__webpack_require__(/*! ./sale/ShowSelectDrugsSelect.js */ "./ExternalAssets/sale/ShowSelectDrugsSelect.js");

__webpack_require__(/*! ./sale/ShowTableStockPiles.js */ "./ExternalAssets/sale/ShowTableStockPiles.js");

__webpack_require__(/*! ./sale/FetchDrugStockPiles.js */ "./ExternalAssets/sale/FetchDrugStockPiles.js");

__webpack_require__(/*! ./sale/CatchAllAxiosErrors.js */ "./ExternalAssets/sale/CatchAllAxiosErrors.js");

__webpack_require__(/*! ./sale/ConfirmDrugSelectionToCache.js */ "./ExternalAssets/sale/ConfirmDrugSelectionToCache.js");

__webpack_require__(/*! ./sale/DisplayCartItems.js */ "./ExternalAssets/sale/DisplayCartItems.js");

__webpack_require__(/*! ./sale/FetchCartItems.js */ "./ExternalAssets/sale/FetchCartItems.js");

__webpack_require__(/*! ./sale/DeleteCartItem.js */ "./ExternalAssets/sale/DeleteCartItem.js");

__webpack_require__(/*! ./sale/dispense.js */ "./ExternalAssets/sale/dispense.js");

__webpack_require__(/*! ./sale/ProcessPayment */ "./ExternalAssets/sale/ProcessPayment.js");
/*****JavaScript For the onetime sale of drugs */

/*****JavaScript For the existing sale of drugs */


__webpack_require__(/*! ./existing/ExistingGlobals.js */ "./ExternalAssets/existing/ExistingGlobals.js");

__webpack_require__(/*! ./existing/ExistingSelectDrugStock */ "./ExternalAssets/existing/ExistingSelectDrugStock.js");

__webpack_require__(/*! ./existing/ExistingStockpileTable */ "./ExternalAssets/existing/ExistingStockpileTable.js");

__webpack_require__(/*! ./existing/DrugAndStockSelect.js */ "./ExternalAssets/existing/DrugAndStockSelect.js");

__webpack_require__(/*! ./existing/AddDrugsToCart.js */ "./ExternalAssets/existing/AddDrugsToCart.js");

__webpack_require__(/*! ./existing/ExistingFetchCartItems.js */ "./ExternalAssets/existing/ExistingFetchCartItems.js");

__webpack_require__(/*! ./existing/ExistingDisplayCartTable.js */ "./ExternalAssets/existing/ExistingDisplayCartTable.js");

__webpack_require__(/*! ./existing/ExistingDeleteDrug.js */ "./ExternalAssets/existing/ExistingDeleteDrug.js");

__webpack_require__(/*! ./existing/ProcessPayment */ "./ExternalAssets/existing/ProcessPayment.js");
/*****JavaScript For the existing sale of drugs */
})();

/******/ })()
;