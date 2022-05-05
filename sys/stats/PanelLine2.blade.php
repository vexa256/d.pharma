<div class="col-md-3">
    <!--begin::Statistics Widget 5-->
    <a href="#" class="card shadow-lg bg-danger hoverable card-xl-stretch mb-2 ">
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                <i class="fas fa-box-open text-light fw-bolder fa-2x"
                    aria-hidden="true"></i>
            </span>
            <!--end::Svg Icon-->
            <div class="text-light fw-bolder fs-5 mb-1 mt-1">
                {{ number_format($ConsInStock) }}
            </div>
            <div class="progress h-7px bg-success bg-opacity-50 mt-1">
                <div class="progress-bar bg-success" role="progressbar"
                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
            <div class="fw-bolder text-light fs-2">Consumables' Stock


            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>
<div class="col-md-3">
    <!--begin::Statistics Widget 5-->
    <a href="#" class="card shadow-lg bg-dark hoverable card-xl-stretch mb-2 ">
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                <i class="fas fa-bell-slash text-light fw-bolder fa-2x"
                    aria-hidden="true"></i>
            </span>
            <!--end::Svg Icon-->
            <div class="text-light fw-bolder fs-5 mb-1 mt-1">
                {{ number_format($ConsLowInStock) }}
            </div>
            <div class="progress h-7px bg-success bg-opacity-50 mt-1">
                <div class="progress-bar bg-success" role="progressbar"
                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
            <div class="fw-bolder text-light fs-2">Consumables (Low)


            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>
<div class="col-md-3">
    <!--begin::Statistics Widget 5-->
    <a href="#"
        class="card shadow-lg bg-primary hoverable card-xl-stretch mb-2 ">
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                <i class="fas fa-user-injured text-light fw-bolder fa-2x"
                    aria-hidden="true"></i>
            </span>
            <!--end::Svg Icon-->
            <div class="text-light fw-bolder fs-5 mb-1 mt-1">
                {{ number_format($Patients) }}
            </div>
            <div class="progress h-7px bg-success bg-opacity-50 mt-1">
                <div class="progress-bar bg-success" role="progressbar"
                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
            <div class="fw-bolder text-light fs-2">Registered Clients


            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>

<div class="col-md-3">
    <!--begin::Statistics Widget 5-->
    <a href="#" class="card shadow-lg bg-info hoverable card-xl-stretch mb-2 ">
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                <i class="fas fa-user-shield text-light fw-bolder fa-2x"
                    aria-hidden="true"></i>
            </span>
            <!--end::Svg Icon-->
            <div class="text-light fw-bolder fs-5 mb-1 mt-1">
                {{ number_format($Vendors) }}
            </div>
            <div class="progress h-7px bg-success bg-opacity-50 mt-1">
                <div class="progress-bar bg-success" role="progressbar"
                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
            <div class="fw-bolder text-light fs-2">Registered Vendors


            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>
