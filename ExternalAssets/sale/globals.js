// global.host = $('.Virtualhost').val();
global.Virtualhost = 'http://d.pharma/api/';
const GetVirtualHost = $('#GetVirtualHost').val();

global.GLOBAL_PATH = GetVirtualHost + '/';

global.DOMAIN_NAME = location.host;
global.PROTOCOL = location.protocol;

global.GLOBAL_API_PATH = PROTOCOL + '//' + DOMAIN_NAME + '/api/';

//alert(GLOBAL_API_PATH);

global.TotalSumHere2 = $('.TotalSumHere2');
global.GoToPay = $('.GoToPay');

require('../existing/ReloadTimer');

//alert(GLOBAL_API_PATH);

window.addEventListener('DOMContentLoaded', () => {



    if ($('.TotalSumHere2').length > 0) {



        setInterval(function () {

            if ($('.TotalSumHere2').val() == "0" || $('.TotalSumHere2').val() == 0) {


                GoToPay.hide();

            } else {

                GoToPay.show();

                // alert($('.TotalSumHere2').val())
            }


        }, 1000);

    }
});


global.SelectDrugSelect = $('.SelectDrugSelect');

global.StockPilesTable = $('.SelectStockPileTable');

global.DisplayStockHere = $('.DisplayStockHere');

global.spinner_display_switch = $('.spinner_display_switch');

global.DocumentTypeShowHere = $('.DocumentTypeShowHere');

global.TotalAmountShowHere = $('.TotalAmountShowHere');

global.TotalSumHere = $('.TotalSumHere');



global.GeneratePaymentSession = () => {

    axios.get('api/GeneratePaymentSession')
        .then(function (response) {
            // handle success
            if (response.data.status == "success") {

                var PaymentSessionID = $('#PaymentSessionID');

                PaymentSessionID.val(response.data.PaymentSessionID);

                $('#PatientName').val('');
                $('#PatientPhone').val('');
                $('#PatientEmail').val('');

                console.log(`Sessions Ejected and Regenerated`);

            } else {

                Swal.fire('OOPS', 'A network error ocurred, Check your connection', 'error');

            }
        })
        .catch(function (error) {
            // handle error
            CatchAxiosError(error);
        })

}


/*******Existing Patient Globals */
window.addEventListener('DOMContentLoaded', () => {

    if ($('.SelectPaymentMethodShow').length > 0 && $('.PatientSelectShow').length > 0) {
        global.SelectPaymentMethodShow = $('.SelectPaymentMethodShow');

        global.PatientSelectShow = $('.PatientSelectShow');

        PatientSelectShow.hide();

        // alert('true');

    }

});



/*******Existing Patient */
