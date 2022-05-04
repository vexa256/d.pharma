<div class="row bg-dark px-4 py-4 rounded-2 me-7 mb-7">
    <div class="col">
        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
        <span class="svg-icon svg-icon-3x svg-icon-dark d-block my-2">

            <a href="#" class="text-warning fw-bold fs-5">Initial Patient Credit
            </a>

            <span class="text-light fs-6 fw-bolder ">
                UGX {{ number_format($Creditors->sum('CreditAmount'), 2) }}
            </span>


        </span>

        <!--end::Svg Icon-->
    </div>

    <div class="col">
        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
        <span class="svg-icon svg-icon-3x svg-icon-dark d-block my-2">

            <a href="#" class="text-warning fw-bold fs-5">Amount Paid
            </a>

            <span class="text-light fs-6 fw-bolder ">
                UGX {{ number_format($Creditors->sum('PaidAmount'), 2) }}
            </span>


        </span>

        <!--end::Svg Icon-->
    </div>


    <div class="col">
        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
        <span class="svg-icon svg-icon-3x svg-icon-dark d-block my-2">

            <a href="#" class="text-warning fw-bold fs-5"> Amount Due
            </a>

            <span class="text-light fs-6 fw-bolder ">
                UGX {{ number_format($Creditors->sum('Balance'), 2) }}
            </span>


        </span>

        <!--end::Svg Icon-->
    </div>

</div>
