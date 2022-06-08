<div class="SelectPaymentMethodShow">
    <!--begin::Card body-->
    <div class="card-body pt-3 bg-light table-responsive">
    </div>
    <div class="card-body shadow-lg pt-3 bg-light table-responsive">
        <div class="row">
            <div class="col-md-12">


                <div class="mb-3 col-md-12  py-5   my-5">
                    <label id="label" for="" class="px-5   my-5 required form-label">Select
                        Payment Method</label>
                    <select required name="id"
                        class="form-select  py-5   my-5  PaymentMethodSelect"
                        data-control="select2" data-placeholder="Select an option">
                        <option value="NotSelected">Select a Payment Method
                        </option>
                        @isset($payment_methods)

                            @foreach ($payment_methods as $data)
                                <option value="{{ $data->PaymentMethod }}">
                                    {{ $data->PaymentMethod }}</option>
                            @endforeach
                        @endisset

                    </select>

                    <input type="text" class="d-none" id="PaymentSessionID"
                        value="{{ $PaymentSessionID }}">

                </div>
                <div class="float-end my-3">
                    <a id="ForPackagePatientExistingStartProcessingPayment"
                        class="btn btn-danger shadow-lg" href="#submit">
                        Print Receipt
                    </a>
                </div>



            </div>



        </div>


    </div>


    <input type="text" id="PaymentSessionID" class="d-none"
        value="{{ $PaymentSessionID }}">

    @isset($PatientData)
        <input type="text" id="PatientName" class="d-none"
            value="{{ $PatientData->PatientName }}">

        <input type="text" id="PatientPhone" class="d-none"
            value="{{ $PatientData->PatientPhone }}">
        <input type="text" id="PatientEmail" class="d-none"
            value="{{ $PatientData->PatientEmail }}">
    @endisset

    <input type="text" id="DispensedBy" class="d-none"
        value="{{ Auth::user()->name }}">

    @include('dispense.ExistingPatient.POS')

    @isset($ReloadTimer)
        <input type="text" class="d-none ReloadTimer" value="2">
    @endisset

</div>

<input type="text" id="RecordKey" class="d-none" value="{{ $RecordKey }}">
<div class="PatientSelectShow">
    @include('dispense.ExistingPatient.SelectPatient')
</div>
