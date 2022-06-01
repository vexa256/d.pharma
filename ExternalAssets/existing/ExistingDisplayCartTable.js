window.addEventListener('DOMContentLoaded', () => {

    global.ExistingDisplayCartTable = (CartItems, Total) => {

        if ($("#BillingStatus").val() == 'Hospital Billable') {

            var PackageBalance = $('#PackageBalance').data('balance');
            var ActualBalance = $('.ActualBalance');
            var FinalTotal = PackageBalance - Total;
            ActualBalance.html(`UGX ${FinalTotal.toLocaleString()}`);

            localStorage.setItem('DEDUCTIBLE_BALANCE', FinalTotal);
        }

        var TotalSumHere = $('.TotalSumHere');


        /*Ensure Cart is not empty */
        TotalSumHere2.val(Total);
        /*Ensure Cart is not empty */


        var TotalSumHereInput = $('.TotalSumHereInput');

        TotalSumHere.text('UGX ' + Total.toLocaleString());

        if (TotalSumHereInput.length > 0) {

            TotalSumHereInput.val(Total);



        }

        global.DisplayCartItemsHere = $('.ExistingDisplayCartItemsHere');
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
            class="btn shadow-lg btn-info btn-sm ExistingDeleteCartItem"
            href="#Update">

            <i class="fas fa-times"
                aria-hidden="true"></i>
        </a></td>`);

            DisplayCartItemsHere.append(CloseTr);

        });

    }

});
