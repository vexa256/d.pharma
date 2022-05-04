global.GLOBAL_PATH = GetVirtualHost + '/';

global.DOMAIN_NAME = location.host;
global.PROTOCOL = location.protocol;

global.GLOBAL_API_PATH = PROTOCOL + '//' + DOMAIN_NAME + '/api/';
global.spinner_display_switch = $('.spinner_display_switch');
spinner_display_switch.show();

global.StartNDADataTable = () => {
    $(".NdaTable").DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        pageLength: 15,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true,
        dom: "Bfrtip",

        buttons: ["excel"],
    });
}



global.FetchNdaDrugList = () => {
    StartNDADataTable();
    //const SelectedDrugId = $('.SelectedDrugId').val();

    const Route = 'GetNdaApi';


    var QtySelected = $('#QtySelected').val();


    axios.get(GLOBAL_API_PATH + Route)
        .then(function (response) {

            if (response.data.status == 'success') {


                global.NDA_DRUG_LIST = response.data.Drugs;

                console.log(NDA_DRUG_LIST);

                DisplayNdaDrugList(NDA_DRUG_LIST);


            } else {

                Swal.fire('OOPS', 'A network error has occurred, Please try again', 'error');
            }


        })
        .catch(function (error) {
            // handle error


            console.log(error);
            CatchAxiosError(error);

            Swal.fire('OOPS', 'A network error has occurred, Please try again', 'error');

            spinner_display_switch.hide();
        });




}



global.DisplayNdaDrugList = async (DrugsList) => {

    spinner_display_switch.show();
    global.DisplayNdaDrugListHere = $('.DisplayNdaDrugListHere');
    DisplayNdaDrugListHere.html('');

    var Tr = '<tr>';
    var CloseTr = '</tr>';

    DrugsList.forEach((item) => {

        DisplayNdaDrugListHere.append(Tr);
        DisplayNdaDrugListHere.append(`<td>${item.DrugName}</td>`);
        DisplayNdaDrugListHere.append(`<td>${item.GenericName}</td>`);

        DisplayNdaDrugListHere.append(`<td><a data-generic=" ${item.GenericName }"
        data-name=" ${item.DrugName }"
        data-did="${item.DID } "
        data-bs-toggle="modal"
        class="btn shadow-lg btn-danger btn-sm admin TriggerNDA"
        href="#EnableNDA"> <i class="fas fa-check"
            aria-hidden="true"></i>
</a>
</td>`);

        DisplayNdaDrugListHere.append(CloseTr);
    });






    spinner_display_switch.hide();



}



window.addEventListener('DOMContentLoaded', (event) => {

    FetchNdaDrugList();


});
