<!--begin::Step 1-->
<div class="flex-column " data-kt-stepper-element="content">
    <!--begin::Input group-->
    <div class="row mb-10 SelectPaymentMethod ">
        <div class="mb-3 col-md-12  py-5   my-5">
            <label id="label" for=""
                class="px-5   my-5 required form-label">Select
                Payment Method to Use | Credit not supported for unregistered
                patients</label>
            <select required name="id"
                class="form-select PaymentMethodSelect py-5   my-5 "
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
    </div>
</div>
