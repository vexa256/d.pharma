<div class="card-body pt-3 bg-light shadow-lg table-responsive">
    {{ HeaderBtn($Toggle = 'Newp', $Class = 'btn-danger', $Label = 'Patient Payment log', $Icon = 'fa-plus') }}
    <table
        class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
        <thead>
            <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Credit</th>
                <th>Record Payment</th>

            </tr>
        </thead>
        <tbody> @isset($Credit)
             @foreach ($Credit as $data)
                <tr>
                    <td>{{ $data->PatientName }}</td>
                    <td>{{ $data->PatientEmail }}</td>
                    <td>{{ $data->PatientPhone }}</td>
                    <td class="bg-dark text-light">{{ number_format($data->Outstanding )}} UGX</td>
                    <td>
                        <a data-bs-toggle="modal" href="#New{{ $data->id }}" class="bg-danger btn btn-sm shadow-lg">

                           <i class="fa text-light fa-check" aria-hidden="true"></i>

                        </a>
                    </td>


                </tr>
            @endforeach @endisset </tbody>
    </table>
</div>


@isset($Credit)
             @foreach ($Credit as $dataz)
<div class="modal fade" id="New{{ $dataz->id }}">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title"> Register Credit Payment for the patient
                    <span class="text-danger">
                        {{ $dataz->PatientName }}
                    </span>
                </h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body ">

                <form action="{{ route('RecordDebtPay') }}" class="row"
                    method="POST" > @csrf
                    <div class="row">
                        <div class="mt-3  mb-3 col-md-12  ">
                            <label id="label" for=""
                                class=" required  form-label">Amount Paid By Patient</label>
                            <input type="text" name="AmountPaid" class="form-control IntOnlyNow" placeholder="" id="">
                        </div>

                        <input type="hidden" name="unique" value="{{ $dataz->_unique }}">

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
@endforeach @endisset


<div class="modal fade" id="Newp">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title">Credit Payment Log For The Selected Patient
                    <span class="text-danger">

                    </span>
                </h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body ">
                <table
                class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
                <thead>
                    <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                        <th>Amount Paid</th>
                        <th>Outstanding</th>
                        <th>Registered By</th>
                        <th>Record Date</th>


                    </tr>
                </thead>
                <tbody> @isset($credit_payment_logs)
                     @foreach ($credit_payment_logs as $dat)
                        <tr>   <td class="bg-dark text-light">{{ number_format($dat->AmountPaid )}} UGX</td>

                            <td class="bg-dark text-light">{{ number_format($dat->Outstanding )}} UGX</td>

                            <td>{{ $dat->RegisteredBy }}</td>

                            <td> {!! date('F j, Y', strtotime($data->created_at)) !!}</td>




                        </tr>
                    @endforeach @endisset </tbody>
            </table>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info"
                    data-bs-dismiss="modal">Close</button>

            </div>

        </div>
    </div>
</div>
