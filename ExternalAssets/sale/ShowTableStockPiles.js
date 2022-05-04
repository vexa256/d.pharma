global.DisplayTable = (StockPiles) => {

    DisplayStockHere.html(' ');

    var Tr = '<tr>';

    var CloseTr = '</tr>';

    StockPiles.forEach((data) => {

        DisplayStockHere.append(Tr);

        DisplayStockHere.append(`<td>${data.DrugName}</td>`);
        DisplayStockHere.append(`<td>${data.GenericName}</td>`);
        DisplayStockHere.append(`<td>${data.StockTag}</td>`);
        DisplayStockHere.append(`<td>${data.BatchNumber}</td>`);
        DisplayStockHere.append(`<td>${data.StockQty.toLocaleString()}  ${data.Units}</td>`);
        DisplayStockHere.append(`<td>${data.Currency} ${data.UnitSellingPrice.toLocaleString()}</td>`);
        DisplayStockHere.append(`<td>${data.ExpiryDate}</td>`);
        DisplayStockHere.append(`<td><a data-stockid = "${data.StockID}"
        class="btn shadow-lg btn-info btn-sm ConfirmDrugSelectionToCache"
        href="#Update">

        <i class="fas fa-check"
            aria-hidden="true"></i>
    </a></td>`);

        DisplayStockHere.append(CloseTr);
    });


}
