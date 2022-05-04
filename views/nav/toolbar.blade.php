<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <i class="fas fa-2x text-danger me-2 fw-bolder fa-info-circle"
                aria-hidden="true"></i>
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-2 my-1">

                @isset($Title)
                    {{ $Title }}
                @endisset
                <!--begin::Separator-->
                <span
                    class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class=" fs-4 text-dark fw-bold my-1 ms-1">

                    @isset($Desc)
                        {{ $Desc }}
                    @endisset

                </small>


                <!--end::Description-->
            </h1>

            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->
            <div class="me-4">
                <!--begin::Menu-->


                <!--end::Menu-->
            </div>
            <!--end::Wrapper-->
            @include('buttons.btn')
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
