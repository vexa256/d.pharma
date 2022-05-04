@include('header.header')

<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" data-bs-offset="200"
    class="bg-white position-relative">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Header Section-->
        <div class="mb-0" id="home">
            <!--begin::Wrapper-->
            <div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg"
                style="background-image: url(assets/media/svg/illustrations/landing.svg)">
                <!--begin::Header-->
                <div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header"
                    data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center justify-content-between">
                            <!--begin::Logo-->
                            <div class="d-flex align-items-center flex-equal">
                                <!--begin::Mobile menu toggle-->
                                <button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none"
                                    id="kt_landing_menu_toggle">
                                    <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                                    <span class="svg-icon svg-icon-2hx">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
                                                <path
                                                    d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z"
                                                    fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </button>
                                <!--end::Mobile menu toggle-->
                                <!--begin::Logo image-->
                                <a href="/">
                                    <img alt="Logo" src="{{ asset('logos/logo.png') }}"
                                        class="logo-default h-25px h-lg-60px" />
                                    <img alt="Logo" src="{{ asset('logos/logo.png') }}"
                                        class="logo-sticky h-20px h-lg-60px" />
                                </a>
                                <!--end::Logo image-->
                            </div>
                            <!--end::Logo-->
                            <!--begin::Menu wrapper-->
                            <div class="d-lg-block" id="kt_header_nav_wrapper">
                                <div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true"
                                    data-kt-drawer-name="landing-menu"
                                    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                                    data-kt-drawer-width="200px" data-kt-drawer-direction="start"
                                    data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-place="true"
                                    data-kt-place-mode="prepend"
                                    data-kt-place-parent="{default: '#kt_body', lg: '#kt_header_nav_wrapper'}">
                                    <!--begin::Menu-->
                                    <div class="menu menu-column flex-nowrap menu-rounded menu-lg-row menu-title-gray-500 menu-state-title-primary nav nav-flush fs-5 fw-bold"
                                        id="kt_landing_menu">
                                        <!--begin::Menu item-->
                                        <div class="menu-item">
                                            <!--begin::Menu link-->
                                            <a class="menu-link nav-link active py-3 px-4 px-xxl-6"
                                                href="{{ url('/login') }}" data-kt-scroll-toggle="true"
                                                data-kt-drawer-dismiss="true">HR and Project Mgt</a>
                                            <!--end::Menu link-->
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item">
                                            <!--begin::Menu link-->
                                            <a class="menu-link nav-link py-3 px-4 px-xxl-6"
                                                href="{{ url('/login') }}" data-kt-scroll-toggle="true"
                                                data-kt-drawer-dismiss="true">Procurement and Inventory</a>
                                            <!--end::Menu link-->
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item">
                                            <!--begin::Menu link-->
                                            <a class="menu-link nav-link py-3 px-4 px-xxl-6"
                                                href="{{ url('/login') }}" data-kt-scroll-toggle="true"
                                                data-kt-drawer-dismiss="true">Analytics</a>
                                            <!--end::Menu link-->
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item">
                                            <!--begin::Menu link-->
                                            <a class="menu-link nav-link py-3 px-4 px-xxl-6" href="http://africhild.kh/"
                                                data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Knowledge
                                                Hub</a>
                                            <!--end::Menu link-->
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->

                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->

                                    </div>
                                    <!--end::Menu-->
                                </div>
                            </div>
                            <!--end::Menu wrapper-->
                            <!--begin::Toolbar-->

                            <!--end::Toolbar-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->
                <!--begin::Landing hero-->
                <div class="d-flex flex-column flex-center w-100 min-h-350px min-h-lg-500px px-9">
                    <!--begin::Heading-->
                    <div class="text-center mb-5 mb-lg-10 py-10 py-lg-20">
                        <!--begin::Title-->
                        <h1 class="text-white lh-base fw-bolder fs-2x fs-lg-3x mb-15">AfriChild Enterprise Modular Cloud
                            <br />
                            <span
                                style="background: linear-gradient(to right, #12CE5D 0%, #FFD80C 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
                                <span id="kt_landing_hero_text">Management Information System</span>
                            </span>
                        </h1>
                        <!--end::Title-->
                        <!--begin::Action-->

                        <!--end::Action-->
                    </div>
                    <!--end::Heading-->

                </div>
                <!--end::Landing hero-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Curve bottom-->
            <div class="landing-curve landing-dark-color mb-10 mb-lg-20">
                <svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z"
                        fill="currentColor"></path>
                </svg>
            </div>
            <!--end::Curve bottom-->
        </div>
        <!--end::Header Section-->
        <!--begin::How It Works Section-->

        <!--end::Footer Section-->
        <!--begin::Scrolltop-->
        <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
            <!--begin::Svg Icon | path: icons/duotone/Navigation/Up-2.svg-->
            <span class="svg-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <rect fill="#000000" opacity="0.5" x="11" y="10" width="2" height="10" rx="1" />
                        <path
                            d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                            fill="#000000" fill-rule="nonzero" />
                    </g>
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Scrolltop-->
    </div>
    <!--end::Main-->
    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="assets/plugins/custom/fslightbox/fslightbox.bundle.js"></script>
    <script src="assets/plugins/custom/typedjs/typedjs.bundle.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="assets/js/custom/landing.js"></script>
    <script src="assets/js/custom/pages/company/pricing.js"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
