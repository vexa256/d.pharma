window.addEventListener('DOMContentLoaded', () => {

    global.ExistingProcessThePaymentNow = () => {

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



            } else {

                let FORM_DATA = {

                    PaymentMethod: PaymentMethodSelect,
                    PaymentSessionID: PaymentSessionID,
                    DEDUCTIBLE_BALANCE: localStorage.getItem('DEDUCTIBLE_BALANCE'),
                    RecordKey: $("#RecordKey").val(),
                };

                console.log(`The deductible balance is ${localStorage.getItem('DEDUCTIBLE_BALANCE')}`);

                axios.post(GLOBAL_API_PATH + 'ExistingProcessPayment', FORM_DATA)

                    .then(function (response) {
                        if (response.data.status == "out_of_stock") {

                            Swal.fire('OOPS, Item(s)  out of stock', response.data.Message, 'error');

                        } else if (response.data.status == 'issued') {

                            Swal.fire('Error', 'Transaction Completed, Please refresh the page');
                        } else {

                            var receipt = response.data.receipt;

                            DocumentTypeShowHere.html(response.data.DocumentType);
                            TotalAmountShowHere.html(`UGX ${response.data.TotalSum.toLocaleString()}`);

                            ExistingDisplayReceiptTable(receipt);

                            PatientSelectShow.show();

                            SelectPaymentMethodShow.hide();




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

    /*global.CathAlreadyIssuedError = (Message) => { let timerInterval Swal.fire({ title: 'This transaction Completed', html: Message + 'You will be automatically redirected to the select patient page in  <b></b> milliseconds.', timer: 4000, allowOutsideClick: false, allowEscapeKey: false, timerProgressBar: true, didOpen: () => { Swal.showLoading() const b = Swal.getHtmlContainer().querySelector('b') timerInterval = setInterval(() => { b.textContent = Swal.getTimerLeft() }, 100) }, willClose: () => { clearInterval(timerInterval) } }).then((result) => { /* Read more about handling dismissals below if (result.dismiss === Swal.DismissReason.timer) { window.location.replace(GLOBAL_PATH + 'SelectExistingPatient'); } }) }*/
})
