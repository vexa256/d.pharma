/******ConfirmDrugSelectionToCache */

window.addEventListener('DOMContentLoaded', () => {
    $(document).on("click", ".ConfirmDrugSelectionToCache", function () {

        var PatientName = $('#PatientName').val();
        var PatientPhone = $('#PatientPhone').val();
        var PatientEmail = $('#PatientEmail').val();
        var PaymentSessionID = $('#PaymentSessionID').val();
        var QtySelected = $('#QtySelected').val();
        var DispensedBy = $('#DispensedBy').val();
        var StockID = $(this).data('stockid');

        if (PatientName.length != 0 && PatientPhone.length != 0 && PatientEmail.length != 0 && PaymentSessionID.length != 0) {


            let FORM_DATA = {

                PatientName: PatientName,
                PatientPhone: PatientPhone,
                PatientEmail: PatientEmail,
                PaymentSessionID: PaymentSessionID,
                StockID: StockID,
                DispensedBy: DispensedBy,
                QtySelected: QtySelected,
            };

            axios.post(GLOBAL_API_PATH + 'RecordDispenseCache', FORM_DATA)
                .then(function (response) {
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
                })
                .catch(function (error) {
                    console.log(error);
                    CatchAxiosError(error);
                });




        } else {

            Swal.fire('Oops', 'Please fill in all the patient details first',
                'error')
        }



    });
});
