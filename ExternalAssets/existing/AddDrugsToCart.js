window.addEventListener('DOMContentLoaded', () => {
    $(document).on("click", ".ConfirmDrugExistingSelectionToCache", function () {


        var PaymentSessionID = $('#PaymentSessionID').val();
        var QtySelected = $('.QtySelected').val();
        var DispensedBy = $('#DispensedBy').val();
        var StockID = $(this).data('stockid');

        if (QtySelected.length != 0 && StockID.length != 0) {


            let FORM_DATA = {


                PaymentSessionID: PaymentSessionID,
                StockID: StockID,
                DispensedBy: DispensedBy,
                QtySelected: QtySelected,
            };

            axios.post(GLOBAL_API_PATH + 'ExistingCartItems', FORM_DATA)
                .then(function (response) {
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
                })
                .catch(function (error) {
                    console.log(error);
                    CatchAxiosError(error);
                });




        } else {

            Swal.fire('Oops', 'The stock item and quantity cannot be empty',
                'error')
        }



    });
});
