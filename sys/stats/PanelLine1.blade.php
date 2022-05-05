<div class="col-md-3">
    <!--begin::Statistics Widget 5-->
    <a href="#"
        class="card shadow-lg bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                <i class="fas me-1 fa-money-check-alt text-light fw-bolder fa-2x"
                    aria-hidden="true"></i> <span class="text-light fw-bolder">
                    ({{ date('M-Y') }})</span>
            </span>
            <!--end::Svg Icon-->
            <div class="text-inverse-info fw-bolder fs-5 mb-1 mt-3">UGX
                {{ number_format($TotalSales->sum('SubTotal'), 2) }}

            </div>
            <div class="fw-bold text-inverse-info fs-2">Total Sales


            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>

<div class="col-md-3">
    <!--begin::Statistics Widget 5-->
    <a href="#"
        class="card shadow-lg bg-dark hoverable card-xl-stretch mb-5 mb-xl-8">
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                <i class="fas me-1 fa-money-bill-wave-alt text-light fw-bolder fa-2x"
                    aria-hidden="true"></i> <span class="text-light fw-bolder">
                    ({{ date('M-Y') }})</span>
            </span>
            <!--end::Svg Icon-->
            <div class="text-inverse-info fw-bolder fs-5 mb-1 mt-3">UGX
                {{ number_format($CreditSales->sum('SubTotal'), 2) }}

            </div>
            <div class="fw-bold text-inverse-info fs-2">Credit Sales


            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>

<div class="col-md-3">
    <!--begin::Statistics Widget 5-->
    <a href="#"
        class="card shadow-lg bg-light-warning hoverable card-xl-stretch mb-1 ">
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                <i class="fas fa-hand-holding-medical text-success fw-bolder fa-2x"
                    aria-hidden="true"></i>
            </span>
            <!--end::Svg Icon-->
            <div class="text-dark fw-bolder fs-5 mb-1 mt-1">
                {{ number_format($DrugsInStock) }}
            </div>
            <div class="progress h-7px bg-success bg-opacity-50 mt-1">
                <div class="progress-bar bg-success" role="progressbar"
                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
            <div class="fw-bolder text-danger fs-2">Drugs in Stock


            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>

<div class="col-md-3">
    <!--begin::Statistics Widget 5-->
    <a href="#"
        class="card shadow-lg bg-light-danger hoverable card-xl-stretch mb-1 ">
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                <i class="fas fa-low-vision text-success fw-bolder fa-2x"
                    aria-hidden="true"></i>
            </span>
            <!--end::Svg Icon-->
            <div class="text-dark fw-bolder fs-5 mb-1 mt-1">
                {{ number_format($LowInStock) }}
            </div>
            <div class="progress h-7px bg-success bg-opacity-50 mt-1">
                <div class="progress-bar bg-success" role="progressbar"
                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
            <div class="fw-bolder text-danger fs-2">Drugs Low in Stock


            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>
