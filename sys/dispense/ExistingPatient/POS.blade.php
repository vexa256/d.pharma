<div class="modal fade" data-backdrop="static" data-keyboard="false"
    id="PaymentModalWindow" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Print
                    Receipt
                </h5>
                <button type="button" class="close"
                    data-bs-dismiss="modal" class="fs-2"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row mb-10 ShowReceipt ">

                    <div class="row">

                        <div class="col-msd-4">
                            <div class="float-end">
                                <button onclick="printJS('invoice-POS', 'html')"
                                    type="button"
                                    class="btn mx-1 float-end btn-lg  mb-2 btn-danger">
                                    <i class="fas me-1 fa-print "
                                        aria-hidden="true"></i>Print
                                    Receipt</button>
                            </div>
                        </div>
                    </div>


                </div>
                <div id="invoice-POS" class="PrintThisArea">
                    <img src="{{ asset('logo_retina.png') }}" alt=""
                        width="200">
                    <br>
                    <br>

                    <address>

                        <strong> Website :</strong>
                        www.neogenesisfertility.com<br>
                        <strong>Email: </strong> info@neogenesisfertility.com
                        <br>
                        <strong> Phone : </strong>+256 394 853532 <br>
                        <strong>WhatsApp : </strong> +256 782429586 <br>
                        <strong>Address : </strong> Plot 120, 122 Bukoto St,
                        Kampala, Uganda
                        <br>




                    </address>

                    <br>
                    <strong>Date : {{ date('F j, Y, g:i a') }}</strong>
                    <br>

                    <center>
                        <h2> <span class="DocumentTypeShowHere"></span> </h2>
                        <br>
                        <h3> Total Amount <span
                                class="TotalAmountShowHere"></span></h3>
                    </center>
                    <br>

                    <table border="1" style="width: 100%">

                        <thead>
                            <tr>
                                <th>Drug Name</th>
                                <th>Generic Name</th>
                                <th>Units</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>

                            </tr>
                        </thead>

                        <tbody class="ReceiptItemsShowHere">
                            <tr>
                                <td>Stock Item</td>
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

                        <strong> Customer :</strong><span
                            class="PatientNameT"></span><br>
                        <strong>Customer's Email: </strong> <span
                            class="PatientEmailT">
                        </span><br>
                        <strong>Customer's Phone : </strong><span
                            class="PatientPhoneT">
                        </span><br>
                        <strong>Issued By : </strong> </strong><span
                            class="DispensedByT"> <br>

                            <br>


                    </address>
                    <p></p>


                    <!--End InvoiceBot-->
                </div>

            </div>

        </div>
    </div>
</div>
