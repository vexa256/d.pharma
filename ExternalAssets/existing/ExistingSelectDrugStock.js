global.FetchExistingDrugStockpiles = (SelectedDrugId, QtySelected) => {


    const Route = 'SelectStockPileForDispense/';
    spinner_display_switch.show();

    if (SelectedDrugId.length != 0 && QtySelected.length != 0) {
        axios.get(GLOBAL_API_PATH + Route + SelectedDrugId)
            .then(function (response) {

                spinner_display_switch.hide();

                if (response.data.Count == 'true') {

                    if (response.data.status == 'success') {

                        const StockPiles = response.data.StockPiles;

                        DisplayExistingTable(StockPiles);
                        ShowStockPilesTable();

                        HideModal('ModalSelectDrug');
                        ShowModal('ModalSelectDrugStockPile');
                    }
                } else {



                    Swal.fire('OOPS', 'The selected stock item is out of stock. Please restock and try again', 'error');
                }


            })
            .catch(function (error) {

                spinner_display_switch.hide();
                // handle error
                console.log(error);
            });
    } else {

        spinner_display_switch.hide();

        Swal.fire('Oops', 'The stock item and quantity selection cannot be empty', 'error');


    }


}
