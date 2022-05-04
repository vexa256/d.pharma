<!--begin::Actions-->
<div class="d-flex flex-stack">
    <!--begin::Wrapper-->
    <div class="me-2">
        <button type="button" class="btn btn-dark btn-active-light-primary"
            data-kt-stepper-action="previous">
            <i class="fas fa-arrow-left me-1" aria-hidden="true"></i>
            Back

        </button>
    </div>
    <!--end::Wrapper-->

    <!--begin::Wrapper-->
    <div>
        <button type="button" class="btn btn-primary"
            data-kt-stepper-action="submit" id="StartProcessingPayment">
            <span class="indicator-label">
                Submit
            </span>
            <span class="indicator-progress">
                Please wait... <span
                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>

        <button type="button" class="btn btn-dark shadow-lg"
            data-kt-stepper-action="next">
            Continue
            <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
        </button>
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Actions-->
