@include('header.header')

<body id="kt_body" class="bg-body"
    style="height: 100%; overflow-y: hidden;">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative"
                style="background-image: url({{ asset('assets/login.jpg') }});
               ">
                <!--begin::Wrapper-->
                <div
                    class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                    <!--begin::Content-->
                    <div style=" background-color:rgba(0,0,0,0.5)"
                        class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
                        <!--begin::Logo-->
                        @include('logos.login-logo')
                        <!--end::Logo-->
                        <!--begin::Title-->
                        <h1 class="fw-bolder text-light fs-2qx pb-3 pb-md-10">
                            D-Pharma V5.0.2</h1>
                        <!--end::Title-->
                        <!--begin::Description-->
                        <p class=" fw-bolder fs-3 text-light">
                            Redefining Enterprise Pharmacy Automation
                            <br />
                        </p>
                        <!--end::Description-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Illustration-->
                    <div
                        class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px">
                    </div>
                    <!--end::Illustration-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid py-10">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column flex-column-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-dark mb-3">Sign In
                                </h1>

                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label
                                    class="form-label fs-6 fw-bolder text-dark">Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-lg "
                                    type="email" name="email" required autofocus
                                    autocomplete="off" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack mb-2">
                                    <!--begin::Label-->
                                    <label
                                        class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                    <!--end::Label-->

                                </div>

                                <input class="form-control form-control-lg "
                                    type="password" name="password" required
                                    autocomplete="current-password"
                                    autocomplete="off" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="text-center">
                                <!--begin::Submit button-->
                                <button type="submit"
                                    class="btn btn-lg btn-xl shadow-xl btn-danger w-100 mb-5">
                                    <span class="indicator-label">

                                        <i class="fas  me-2 fa-sign-in-alt"
                                            aria-hidden="true"></i>

                                        Continue</span>

                                </button>



                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->

            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>





    @include('scripts.scripts')
