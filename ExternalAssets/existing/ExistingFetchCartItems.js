global.FetchExistingCartItems = () => {
    spinner_display_switch.show();
    var PaymentSessionID = $('#PaymentSessionID').val();

    let FORM_DATA = {
        PaymentSessionID: PaymentSessionID,
    };

    // alert(PaymentSessionID);

    axios.post(GLOBAL_API_PATH + 'GetDispenseCart', FORM_DATA)
        .then(function (response) {
            spinner_display_switch.hide()
            if (response.data.status == "success") {

                ExistingDisplayCartTable(response.data.CartItems, response.data.Total)
            }

        })
        .catch(function (error) {

            spinner_display_switch.hide()
            console.log(error);
            CatchAxiosError(error);
        });



}


window.addEventListener('DOMContentLoaded', () => {

    FetchExistingCartItems();

});
