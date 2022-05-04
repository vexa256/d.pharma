@include('header.header')
@include('body.body')

<input type="text" class="d-none Virtualhost"
    value="{{ request()->getHost() }}">

<!--all code above here is in header--->
@include('sidebar.sidebar')
<!--end::Aside-->
<!--begin::Wrapper-->
<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
    <!--begin::Header-->
    @include('nav.nav')
    <!--end::Header-->
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->

        @include('nav.toolbar')
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-fluid">

                @isset($Page)
                    @include($Page)
                @endisset

            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
    @include('footer.footer')
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>


@include('scroll.scrolltop')
@include('scripts.scripts')
