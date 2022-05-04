window.addEventListener('DOMContentLoaded', () => {

    global.ProcessThePaymentNow = () => {

        return new Promise((resolve, reject) => {
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

            global.PaymentModalWindow =
                new bootstrap.Modal(document.getElementById('PaymentModalWindow'), {
                    keyboard: false
                });

            if (PaymentMethodSelect.length == 0) {

                Swal.fire('OOPS, A minor error ocurred', 'The payment method cannot be empty. Select a payment method and try again', 'error');



            } else if (PatientName.length == 0 || PatientPhone.length == 0 ||
                PatientEmail.length == 0) {

                Swal.fire('OOPS, A minor error ocurred', 'This payment has been processed already. Please  register a new patient to dispense Stock items to', 'error');


            } else {

                let FORM_DATA = {

                    PaymentMethod: PaymentMethodSelect,
                    PaymentSessionID: PaymentSessionID,

                };

                axios.post(GLOBAL_API_PATH + 'ProcessDispense', FORM_DATA)

                    .then(function (response) {

                        if (response.data.status == "out_of_stock") {

                            Swal.fire('OOPS, Item(s)  out of stock', response.data.Message, 'error');

                        } else if (response.data.status == 'Item_Already_purchased') {

                            var receipt = response.data.receipt;

                            DocumentTypeShowHere.html(response.data.DocumentType);
                            TotalAmountShowHere.html(`UGX ${response.data.TotalSum.toLocaleString()}`);


                            DisplayReceiptTable(receipt);

                        } else {

                            var receipt = response.data.receipt;

                            DocumentTypeShowHere.html(response.data.DocumentType);
                            TotalAmountShowHere.html(`UGX ${response.data.TotalSum.toLocaleString()}`);

                            DisplayReceiptTable(receipt);
                        }
                        console.log(response.data.receipt);
                    })
                    .catch(function (error) {

                        CatchAxiosError(error);

                        spinner_display_switch.hide();
                    });

            }

        });



    }

    /**Func Closure */

})
