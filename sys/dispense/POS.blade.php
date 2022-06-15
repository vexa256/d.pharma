<div id="invoice-POS" class="PrintThisArea">
    <img src="{{ asset('logo_retina.png') }}" alt="" width="200">
    <br>
    <br>

    <address>

        <strong> Website :</strong> www.neogenesisfertility.com<br>
        <strong>Email: </strong> info@neogenesisfertility.com <br>
        <strong> Phone : </strong>+256 394 853532 <br>
        <strong>WhatsApp : </strong> +256 782429586 <br>
        <strong>Address : </strong> Plot 120, 122 Bukoto St, Kampala, Uganda
        <br>




    </address>

    <br>
    <strong>Date : {{ date('F j, Y, g:i a') }}</strong>
    <br>

    <center>
        <h2> <span class="DocumentTypeShowHere"></span> </h2> <br>
        <h3> Total Amount <span class="TotalAmountShowHere"></span></h3>
    </center>
    <br>

    <table border="1" style="width: 100%">

        <thead>
            <tr>
                <th>Stock Item</th>
                <th>Generic Name</th>
                <th>Units</th>
                <th>Unit Price</th>
                <th>Qty</th>
                <th>Subtotal</th>

            </tr>
        </thead>

        <tbody class="ReceiptItemsShowHere">
            <tr>
                <td>Drug Name</td>
                <td>Generic Name</td>
                <td>Units</td>
                <td>Unit Price</td>
                <td>Qty</td>
                <td>Subtotal</td>

            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <address>

        <span class="PatientEmailT" style="display: none"> </span>
        <strong> Customer :</strong><span class="PatientNameT"></span><br>
        {{-- <strong>Customer's Email: </strong> <span class="PatientEmailT">
        </span><br> --}}
        <strong>Customer's Phone : </strong><span class="PatientPhoneT">
        </span><br>
        <strong>Issued By : </strong> </strong><span class="DispensedByT"> <br>

            <br>


    </address>
    <p></p>


    <!--End InvoiceBot-->
</div>
