@if ($BillingStatus == 'Hospital Billable')

    @include('dispense.ExistingPatient.ForHospitalBillable')
@else
    <div class="SelectPaymentMethodShow">
        <!--begin::Card body-->
        <div class="card-body pt-3 bg-light table-responsive">
            <div class="col-12">
                @include('dispense.WizardData.WizardTotal')
            </div>
        </div>
        <div class="card-body shadow-lg pt-3 bg-light table-responsive">
            <div class="row">

                <div class="mb-3 col-md-4 ">
                    <label id="label" for="" class=" required form-label">Select
                        Payment Method</label>
                    <select required name="id" class="form-select    PaymentMethodSelect"
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

                    {{-- <input type="text" class="d-none"
                        id="PaymentSessionID" value="{{ $PaymentSessionID }}"> --}}

                </div>


                <div class="mb-3 col-md-4  ">
                    <label id="label" for="" class="required form-label">Enter

                        Amount paid by customer

                    </label>

                    <input type="text" class="form-control IntOnlyNow"
                        placeholder="Customer Bill" id="PatientBillable">
                </div>

                <input type="text" class="d-none TotalSumHereInput" value="">

                <div class="mb-3 col-md-4  ">
                    <label id="label" for="" class="required form-label">

                        Customer Balance/Credit

                    </label>

                    <input type="text" class="form-control IntOnlyNow"
                        placeholder="Customer Outstanding" id="Outstanding" value="0"
                        readonly>
                </div>
                <div class="float-end my-3">
                    <a id="ExistingStartProcessingPayment"
                        class="btn btn-danger shadow-lg" href="#submit">
                        Print Receipt
                    </a>
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
@endif
