<div class="col-md-3">
    <!--begin::Statistics Widget 5-->
    <a href="#"
        class="card shadow-lg bg-light-warning  hoverable card-xl-stretch mb-2 ">
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                <i class="fas fa-clock text-success fw-bolder fa-2x"
                    aria-hidden="true"></i>
            </span>
            <!--end::Svg Icon-->
            <div class="text-dark fw-bolder fs-5 mb-1 mt-1">
                {{ number_format($Expiring) }}
            </div>
            <div class="progress h-7px bg-success bg-opacity-50 mt-1">
                <div class="progress-bar bg-success" role="progressbar"
                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
            <div class="fw-bolder text-danger fs-2">Expiring Stock


            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>

<div class="col-md-3">
    <!--begin::Statistics Widget 5-->
    <a href="#"
        class="card shadow-lg bg-success  hoverable card-xl-stretch mb-2 ">
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                <i class="fas fa-biohazard text-danger fw-bolder fa-2x"
                    aria-hidden="true"></i>
            </span>
            <!--end::Svg Icon-->
            <div class="text-dark fw-bolder fs-5 mb-1 mt-1">
                {{ number_format($Expired) }}
            </div>
            <div class="progress h-7px bg-success bg-opacity-50 mt-1">
                <div class="progress-bar bg-dark" role="progressbar"
                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
            <div class="fw-bolder text-danger fs-2">Expired Stock


            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>

<div class="col-md-3">
    <!--begin::Statistics Widget 5-->
    <a href="#" class="card shadow-lg bg-info  hoverable card-xl-stretch mb-2 ">
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                <i class="fas fa-people-carry text-light fw-bolder fa-2x"
                    aria-hidden="true"></i>
            </span>
            <!--end::Svg Icon-->
            <div class="text-light fw-bolder fs-5 mb-1 mt-1">
                {{ $VendorsExpiring }}
            </div>
            <div class="progress h-7px bg-success bg-opacity-50 mt-1">
                <div class="progress-bar bg-success" role="progressbar"
                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
            <div class="fw-bolder text-light fs-2">Expiring Vendors


            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>
<div class="col-md-3">
    <!--begin::Statistics Widget 5-->
    <a href="#"
        class="card shadow-lg bg-danger  hoverable card-xl-stretch mb-2 ">
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                <i class="fas fa-users text-light fw-bolder fa-2x"
                    aria-hidden="true"></i>
            </span>
            <!--end::Svg Icon-->
            <div class="text-light fw-bolder fs-5 mb-1 mt-1">
                {{ number_format($Users) }}
            </div>
            <div class="progress h-7px bg-success bg-opacity-50 mt-1">
                <div class="progress-bar bg-success" role="progressbar"
                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
            <div class="fw-bolder text-light fs-2">User Accounts


            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>
