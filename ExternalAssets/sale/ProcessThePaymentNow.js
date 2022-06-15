window.addEventListener('DOMContentLoaded', () => {

    $("#PatientBillable").on("keyup change", function(e) {


        var PatientBillable = Number($('#PatientBillable').val());

        var TotalSumHereInput = Number($('.TotalSumHereInput').val());

        var Outstanding = TotalSumHereInput - PatientBillable;

        $('#Outstanding').val(Outstanding);

        if (PatientBillable == 0 || PatientBillable == null || PatientBillable == NaN) {
            $('#Outstanding').val(0);
        }

    })




    global.ProcessThePaymentNow = () => {

        return new Promise((resolve, reject) => {
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

            global.PaymentModalWindow =
                new bootstrap.Modal(document.getElementById('PaymentModalWindow'), {
                    keyboard: false
                });

            if (PaymentMethodSelect.length == 0 || PatientBillable.length == 0 || Outstanding.length == 0) {


                Swal.fire('OOPS, A minor error ocurred', 'The payment method or Amount Paid  cannot be empty. Select a payment method and try again', 'error');

                return false;

            } else if (PatientName.length == 0 || PatientPhone.length == 0 ||
                PatientEmail.length == 0) {

                Swal.fire('OOPS, A minor error ocurred', 'This payment has been processed already. Please  register a new patient to dispense Stock items to', 'error');
                return false;

            } else if (PaymentMethodSelect.length != 0 && PatientBillable.length != 0 && Outstanding.length != 0) {


                let FORM_DATA = {

                    PaymentMethod: PaymentMethodSelect,
                    PaymentSessionID: PaymentSessionID,
                    Balance: PatientBillable,
                    Outstanding: Outstanding,
                    PatientEmail: PatientEmail,
                    PatientEmail: PatientEmail,
                    PatientName: PatientName,
                    PatientPhone: PatientPhone,

                };

                axios.post(GLOBAL_API_PATH + 'ProcessDispense', FORM_DATA)

                .then(function(response) {

                        if (response.data.status == "out_of_stock") {

                            Swal.fire('OOPS, Item(s)  out of stock', response.data.Message, 'error');

                        } else if (response.data.status == 'Item_Already_purchased') {

                            var receipt = response.data.receipt;

                            DocumentTypeShowHere.html(response.data.DocumentType);
                            TotalAmountShowHere.html(`UGX ${response.data.TotalSum.toLocaleString()}`);


                            DisplayReceiptTable(receipt);

                            $('#PatientBillable').val(0);
                            $('#Outstanding').val(0);

                            stepper.goTo(1),
                                setTimeout(function() {
                                    printJS('invoice-POS', 'html')
                                    spinner_display_switch.hide();
                                }, 2000);

                        } else {

                            var receipt = response.data.receipt;

                            DocumentTypeShowHere.html(response.data.DocumentType);
                            TotalAmountShowHere.html(`UGX ${response.data.TotalSum.toLocaleString()}`);

                            $('#PatientBillable').val(0);
                            $('#Outstanding').val(0);

                            DisplayReceiptTable(receipt);

                            stepper.goTo(1),
                                setTimeout(function() {
                                    printJS('invoice-POS', 'html')
                                    spinner_display_switch.hide();
                                }, 2000);
                        }
                        console.log(response.data.receipt);
                    })
                    .catch(function(error) {

                        CatchAxiosError(error);

                        spinner_display_switch.hide();
                    });

            }

        });



    }

    /**Func Closure */

})