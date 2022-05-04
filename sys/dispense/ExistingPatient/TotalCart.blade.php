@if ($BillingStatus == 'Hospital Billable')
    <div class="row bg-dark px-4 py-4 rounded-2 me-7 mb-7">
        <div class="col">
            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
            <span class="svg-icon svg-icon-3x svg-icon-dark d-block my-2">

                <a href="#" class="text-warning fw-bold fs-5">Total Bill :: </a>

                <span class="text-light fs-6 fw-bolder TotalSumHere">

                </span>


            </span>

            <!--end::Svg Icon-->
        </div>
        <div class="col">
            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
            <span class="svg-icon svg-icon-3x svg-icon-dark d-block my-2">

                <a style="font-size: 12px !important" href="#"
                    class="text-warning fw-bold fs-5">Patient Account
                    Balance</a>

                <span style="font-size: 12px !important" id="PackageBalance"
                    class="text-light fs-6 fw-bolder "
                    data-balance="{{ $PackageValue }}">
                    UGX {{ number_format($PackageValue, 2) }}
                </span>


            </span>

            <!--end::Svg Icon-->
        </div>

        <div class="col">
            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
            <span class="svg-icon svg-icon-3x svg-icon-dark d-block my-2">

                <a style="font-size: 12px !important" href="#"
                    class="text-warning fw-bold fs-6 "> Current
                    Account
                    Balance</a>

                <span style="font-size: 12px !important"
                    class="text-light fs-6 fw-bolder ActualBalance">

                </span>


            </span>

            <!--end::Svg Icon-->
        </div>
    </div>
@else
    <div class="col bg-dark px-6 py-8 rounded-2 me-7 mb-7">
        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
        <span class="svg-icon svg-icon-3x svg-icon-dark d-block my-2">


            <i class="fas fa-chart-area fa-3x" aria-hidden="true">

            </i> <span class="text-light fs-2 float-end fw-bolder TotalSumHere">

            </span>


        </span>
        <!--end::Svg Icon-->
        <a href="#" class="text-warning fw-bold fs-3">Total Bill</a>
    </div>
@endif
