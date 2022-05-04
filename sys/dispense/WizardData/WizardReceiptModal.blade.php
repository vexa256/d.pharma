<div class="modal fade" data-backdrop="static" data-keyboard="false"
    id="PaymentModalWindow" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Print Receipt
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
                @include('dispense.POS')
            </div>

        </div>
    </div>
</div>
