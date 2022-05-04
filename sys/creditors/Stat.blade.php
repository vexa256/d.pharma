<div class="row bg-dark px-4 py-4 rounded-2 me-7 mb-7">
    <div class="col-12">
        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
        <span class="svg-icon svg-icon-3x svg-icon-dark d-block my-2">

            <a href="#" class="text-warning fw-bold fs-5">Total Credit Issued To
                Patients
            </a>

            <span class="text-light fs-6 fw-bolder ">
                UGX {{ number_format($Creditors->sum('Total'), 2) }}
            </span>


        </span>

        <!--end::Svg Icon-->
    </div>

</div>
