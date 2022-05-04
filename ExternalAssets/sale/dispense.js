window.addEventListener('DOMContentLoaded', () => {


    StockPilesTable.hide();

    /***Trigger Method OnClick */

    $(document).on("click", ".GoToSelectDrug", function () {
        ShowSelectDrugsSelect();
    });



    $(document).on("click", ".SelectStockPile", function () {

        FetchDrugStockpiles();

    });

    /****FetchCartItems */



});
