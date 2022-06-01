/**ProcessThePaymentNow */

require('./ProcessThePaymentNow.js');

/**ProcessThePaymentNow */

window.addEventListener('DOMContentLoaded', () => {



    global.DisplayReceiptTable = (receipt) => {

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



    $(document).on("click", "#StartProcessingPayment", function () {


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
                ProcessThePaymentNow().then(

                    console.log(`Processing Step One Complete`)

                ).then(GeneratePaymentSession(),
                    DisplayCartItemsHere.html(' '),
                    TotalSumHere.html(' ')

                )
            }
        })


    });
});
