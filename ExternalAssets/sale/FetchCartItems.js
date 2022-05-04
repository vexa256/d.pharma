global.FetchCartItems = () => {

    var PaymentSessionID = $('#PaymentSessionID').val();

    let FORM_DATA = {
        PaymentSessionID: PaymentSessionID,
    };

    axios.post(GLOBAL_API_PATH + 'GetDispenseCart', FORM_DATA)
        .then(function (response) {

            if (response.data.status == "success") {

                DisplayCartTable(response.data.CartItems, response.data.Total)
            }

        })
        .catch(function (error) {
            console.log(error);
            CatchAxiosError(error);
        });



}
