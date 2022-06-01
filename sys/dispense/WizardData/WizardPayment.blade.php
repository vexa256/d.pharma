<!--begin::Step 1-->

<div class="flex-column " data-kt-stepper-element="content">
    <!--begin::Input group-->
    <div class="row mb-10 SelectPaymentMethod ">

        <div class="col-12">
            @include('dispense.WizardData.WizardTotal')
        </div>

        <div class="mb-3 col-md-4 ">
            <label id="label" for=""
                class=" required form-label">Select
                Payment Method to Use </label>
            <select required name="id"
                class="form-select PaymentMethodSelect "
                data-control="select2" data-placeholder="Select an option">
                <option></option>

                @isset($payment_methods)

                    @foreach ($payment_methods as $pay)
                        <option value="{{ $pay->PaymentMethod }}">
                            {{ $pay->PaymentMethod }}</option>
                    @endforeach
                @endisset

            </select>

        </div>


            <div class="mb-3 col-md-4  ">
                <label id="label" for=""
                    class="required form-label">Enter

                        Amount paid by customer

                </label>

        <input type="text" class="form-control IntOnlyNow" placeholder="Customer Bill" id="PatientBillable">
            </div>

         <input type="text" class="d-none TotalSumHereInput" value="">

            <div class="mb-3 col-md-4  ">
                <label id="label" for=""
                    class="required form-label">

                       Customer Balance/Credit

                </label>

        <input type="text" class="form-control IntOnlyNow" placeholder="Customer Outstanding" id="Outstanding" value="0" readonly>
            </div>

    </div>
</div>
