<!--begin::Stepper-->
<div class="stepper stepper-pills" id="PaymentWizard">
    @include('dispense.WizardData.WizardNav')
    <!--begin::Form-->
    <form class="form w-lg-1500px mx-auto" novalidate="novalidate"
        id="PaymentWizard_form">
        @csrf

        <input type="text" class="d-none" id="PaymentSessionID"
            value="{{ $PaymentSessionID }}">

        <input type="text" class="d-none" id="DispensedBy"
            value="{{ Auth::user()->name }}">
        <!--begin::Group-->
        <div class="mb-5">
            @include(
                'dispense.WizardData.WizardPatients'
            )
            @include(
                'dispense.WizardData.WizardDrugs'
            )

            @include(
                'dispense.WizardData.WizardPayment'
            )
        </div>
        <!--end::Group-->
        @include(
            'dispense.WizardData.WizardFooter'
        )

        @include(
            'dispense.WizardData.WizardReceiptModal'
        )
    </form>
    <!--end::Form-->
</div>
<!--end::Stepper-->

@include('dispense.WizardData.SelectDrug')
