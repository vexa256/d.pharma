global.DisplayCartTable = (CartItems, Total) => {

    var TotalSumHere = $('.TotalSumHere');
    var TotalSumHereInput = $('.TotalSumHereInput');
    TotalSumHere.text('UGX ' + Total.toLocaleString());

    if (TotalSumHereInput.length > 0) {

        TotalSumHereInput.val(Total);



    }

    global.DisplayCartItemsHere = $('.DisplayCartItemsHere');
    DisplayCartItemsHere.html('');

    var Tr = '<tr>';
    var CloseTr = '</tr>';



    CartItems.forEach((item) => {

        DisplayCartItemsHere.append(Tr);
        DisplayCartItemsHere.append(`<td>${item.PatientName}</td>`);
        DisplayCartItemsHere.append(`<td>${item.PatientPhone}</td>`);
        DisplayCartItemsHere.append(`<td>${item.PatientEmail}</td>`);
        DisplayCartItemsHere.append(`<td>${item.DrugName}</td>`);
        DisplayCartItemsHere.append(`<td>${item.GenericName}</td>`);
        DisplayCartItemsHere.append(`<td>${item.Units}</td>`);
        DisplayCartItemsHere.append(`<td>UGX ${item.UnitCost.toLocaleString()}</td>`);
        DisplayCartItemsHere.append(`<td>${item.Qty.toLocaleString()}</td>`);
        DisplayCartItemsHere.append(`<td>UGX ${item.SubTotal.toLocaleString()}</td>`);
        DisplayCartItemsHere.append(`<td><a data-id="${item.id}"
            class="btn shadow-lg btn-info btn-sm DeleteCartItem"
            href="#Update">

            <i class="fas fa-times"
                aria-hidden="true"></i>
        </a></td>`);

        DisplayCartItemsHere.append(CloseTr);

    });

}