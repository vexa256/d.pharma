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

            ReceiptItemsShowHere.append(`<td>${data.DrugName}</td>`);
            ReceiptItemsShowHere.append(`<td>${data.GenericName}</td>`);
            ReceiptItemsShowHere.append(`<td>${data.Units}</td>`);
            ReceiptItemsShowHere.append(`<td> ${data.Currency} ${data.SellingPrice.toLocaleString()}  </td>`);
            ReceiptItemsShowHere.append(`<td> ${data.Qty.toLocaleString()}  ${data.Units}  </td>`);

            ReceiptItemsShowHere.append(`<td>  ${data.Currency} ${data.SubTotal.toLocaleString()}  </td>`);


            ReceiptItemsShowHere.append(CloseTr);
        });


        //PaymentModalWindow.show();


    }



    $(document).on("click", "#ExistingStartProcessingPayment", function () {

        if ($('.PaymentMethodSelect').val() != 'NotSelected') {



            Swal.fire({
                title: 'Are you sure??',
                text: "You want to process this payment?. This action is not reversible ",
                icon: 'info',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Yes, Process Payment',
                denyButtonText: `Cancel Action`,
            }).then(function (result) {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    spinner_display_switch.show();
                    ExistingProcessThePaymentNow().then(

                        console.log(`Processing Step One Complete`)

                    ).then(
                        //stepper.goTo(1),
                        setTimeout(function () {
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
});
