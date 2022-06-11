<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true"
    data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
       
       @include('logos.main-logo')
        <!--end::Logo-->
        @include('nav.toggle')
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y my-2 py-5 py-lg-8" id="kt_aside_menu_wrapper"
            data-kt-scroll="true" data-kt-scroll-activate="{default: true, lg: true}"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
            data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true">
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span
                            class="menu-section text-muted text-uppercase fs-8 ls-1">Neogenesis
                            D-Pharma</span>
                    </div>
                </div>
                <div class="menu-item d-none">
                    <a class="menu-link " href="#">
                        <span class="menu-icon">
                            <i class="fas fa-chart-line fs-3" aria-hidden="true"></i>

                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>



                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span
                            class="menu-section text-muted text-uppercase fs-8 ls-1">Menu
                            Options</span>
                    </div>
                </div>


                @include('sidebar.Inventory')

                {{-- @include('sidebar.Staff') --}}
                {{-- @include('sidebar.Finance') --}}

                {{-- @include('sidebar.reports') --}}

                @include('sidebar.Users')


            </div>
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Aside menu-->
    <!--begin::Footer-->

    <!--end::Footer-->
</div>
