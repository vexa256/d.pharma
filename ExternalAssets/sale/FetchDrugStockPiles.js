/***Fetch Selected Drug StockPiles */
global.FetchDrugStockpiles = () => {

    const SelectedDrugId = $('.SelectedDrugId').val();

    const Route = 'SelectStockPileForDispense/';


    var QtySelected = $('#QtySelected').val();

    if (SelectedDrugId.length != 0 && QtySelected.length != 0) {
        axios.get(GLOBAL_API_PATH + Route + SelectedDrugId)
            .then(function (response) {

                if (response.data.Count == 'true') {

                    if (response.data.status == 'success') {

                        const StockPiles = response.data.StockPiles;

                        DisplayTable(StockPiles);
                        ShowStockPilesTable();
                    }
                } else {

                    Swal.fire('OOPS', 'The selected item is out of stock. Please restock and try again', 'error');
                }


            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
    } else {

        Swal.fire('Oops', 'The drug and quantity selection cannot be empty', 'error');
    }


}
