<div class="container pt-3">
    <div class="row bg-dark px-4 py-4 rounded-2 me-7 mb-7">
        <div class="col-12">
            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
            <span class="svg-icon svg-icon-3x svg-icon-dark d-block my-2">



                @isset($CRR)
                    <a href="#" class="text-warning fw-bold fs-5">Total Credit Recovered
                        in the selected time frame

                    </a>
                    <span class="text-light fs-6 fw-bolder ">
                        UGX {{ number_format($Reports->sum('Total'), 2) }}
                    </span>
                @else
                    <a href="#" class="text-warning fw-bold fs-5">Total Sales for the
                        selected months

                    </a>
                    <span class="text-light fs-6 fw-bolder ">
                        UGX {{ number_format($Reports->sum('TotalSales'), 2) }}
                    </span>
                @endisset




            </span>

            {{-- {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'Credit Payment Report', $Icon = 'fa-binoculars') }} --}}
        </div>

    </div>

</div>
