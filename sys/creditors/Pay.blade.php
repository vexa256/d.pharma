@isset($Creditors)
    @foreach ($Creditors as $data)
        <div class="modal fade" id="Update{{ $data->id }}" data-backdrop="static"
            data-keyboard="false" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-light">
                        <h5 class="modal-title text-light">
                            Record Payment for the item <span class="text-danger">
                                {{ $data->DrugName }}
                            </span>

                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('EffectCreditPayment') }}">
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3 col-md-12">
                                <label class="required form-label">Amount
                                    Paid by patient in UGX</label>
                                <input required="" type="text" name="PaidAmount"
                                    class="form-control IntOnlyNow" value="">
                            </div>

                            <input type="hidden" name="id" value="{{ $data->id }}">


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
