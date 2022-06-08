/**ProcessThePaymentNow */

require('./ProcessPaymentNow.js');

/**ProcessThePaymentNow */

window.addEventListener('DOMContentLoaded', () => {


    global.ExistingDisplayReceiptTable = (receipt) => {

        var ReceiptItemsShowHere = $('.ReceiptItemsShowHere');

        ReceiptItemsShowHere.html(' ');

        var Tr = '<tr>';

        var CloseTr = '</tr>';

        receipt.forEach((data) => {

            ReceiptItemsShowHere.append(Tr);

            ReceiptItemsShowHere.append(`<td>${
                data.DrugName
            }</td>`);
            ReceiptItemsShowHere.append(`<td>${
                data.GenericName
            }</td>`);
            ReceiptItemsShowHere.append(`<td>${
                data.Units
            }</td>`);
            ReceiptItemsShowHere.append(`<td> ${
                data.Currency
            } ${
                data.SellingPrice.toLocaleString()
            }  </td>`);
            ReceiptItemsShowHere.append(`<td> ${
                data.Qty.toLocaleString()
            }  ${
                data.Units
            }  </td>`);

            ReceiptItemsShowHere.append(`<td>  ${
                data.Currency
            } ${
                data.SubTotal.toLocaleString()
            }  </td>`);


            ReceiptItemsShowHere.append(CloseTr);
        });


        // PaymentModalWindow.show();


    }

    if ($('#ForPackagePatientExistingStartProcessingPayment').length > 0) {

        $(document).on("click", "#ForPackagePatientExistingStartProcessingPayment", function() {

            if ($('.PaymentMethodSelect').val() != 'NotSelected') {


                Swal.fire({
                    title: 'Are you sure??',
                    text: "You want to process this payment?. This action is not reversible ",
                    icon: 'info',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Process Payment',
                    denyButtonText: `Cancel Action`
                }).then(function(result) {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                        spinner_display_switch.show();
                        ExistingProcessThePaymentNow().then(console.log(`Processing Step One Complete`)).then(
                            // stepper.goTo(1),
                            setTimeout(function() {
                                printJS('invoice-POS', 'html')
                                spinner_display_switch.hide();
                            }, 2000)
                        );
                    }
                })


            } else {


                Swal.fire('OOPS, A Minor error occurred', ' The payment method cannot be empty. Please select a payment method to proceed', 'error');
            }


        });

    } else if ($('#ExistingStartProcessingPayment').length > 0) {
        $(document).on("click", "#ExistingStartProcessingPayment", function() {

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
                        denyButtonText: `Cancel Action`
                    }).then(function(result) {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {

                            spinner_display_switch.show();
                            ExistingProcessThePaymentNow().then(console.log(`Processing Step One Complete`)).then(
                                // stepper.goTo(1),
                                setTimeout(function() {
                                    printJS('invoice-POS', 'html')
                                    spinner_display_switch.hide();
                                }, 2000)
                            );
                        }
                    })


                } else {


                    Swal.fire('OOPS, A Minor error occurred', ' The payment method cannot be empty. Please select a payment method to proceed', 'error');
                }

            }


        });
    }


});