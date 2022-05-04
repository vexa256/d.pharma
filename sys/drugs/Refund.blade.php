@isset($Drugs)
    @foreach ($Drugs as $data)
        <div class="modal fade" id="Refund{{ $data->StID }}">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header bg-gray">
                        <h5 class="modal-title" id="staticBackdropLabel">Record a
                            refund/exchange with the vendor for the
                            stock item
                            <span class="text-danger fw-bolder">
                                {{ $data->DrugName }} (Batch No.
                                {{ $data->BatchNumber }})
                            </span>
                        </h5>
                        <button type="button" class="close"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('RecordRefund') }}" method="POST">
                        <div class="modal-body">


                            @csrf

                            <input type="hidden" name="id"
                                value="{{ $data->StID }}">



                            <div class="mb-3 col-md-12">
                                <label class="required form-label">Amount of Money
                                    Recovered</label>
                                <input required="" type="text"
                                    name="AmountOfMoneyRecovered"
                                    class="form-control IntOnlyNow" value="">
                            </div>


                            <div class="mb-3 col-md-12">
                                <label class="required form-label">Qty
                                    Returned/Exchanged with vendor</label>
                                <input required="" type="text"
                                    name="QtyRefundedOrExchangedWithVendor"
                                    class="form-control IntOnlyNow" value="">
                            </div>


                            <div class="mb-3 col-md-12">
                                <label class="required form-label">Record
                                    Refund/Exchange
                                    Notes</label>
                                <textarea name="RefundDetails" class="editorme"></textarea>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info"
                                data-bs-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-dark">Save
                                Changes</button>

                    </form>
                </div>
            </div>
        </div>
        </div>
    @endforeach
@endisset
