window.addEventListener('DOMContentLoaded', () => {
    $(document).on("click", ".SelectExistingDrugButton", function () {


        var ExistingDrugSelected = $('.ExistingDrugSelected').val();
        var QtySelected = $('.QtySelected').val();

        FetchExistingDrugStockpiles(ExistingDrugSelected, QtySelected);

    });

    $(document).on("click", ".BackToDrugSelection", function () {

        HideModal('ModalSelectDrugStockPile');
        ShowModal('ModalSelectDrug');

    });
});
