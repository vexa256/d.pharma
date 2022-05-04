<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Chart showing vendor contract validity in
                months</h5>

            <div class="row">
                <div class="col-md-12 mt-5">
                    <div class="float-end ">
                        <a data-bs-toggle="modal" href="#Explain"
                            class="btn  btn-danger shadow-lg">
                            <i class="fas fa-chart-line fa-2x"
                                aria-hidden="true"></i>
                            Explain Graph
                        </a>
                    </div>
                </div>
            </div>


        </div>
        <div class="card-body">

            <h6 class="card-subtitle mb-2 text-muted ">Click the explain button
                for a
                tabular view of the statistics</h6>



            <p class="card-text">

                {!! $chart->container() !!}

            </p>

        </div>
    </div>

</div>

@include('inventory.VendorChartExplain')
@isset($Vendors)
    @foreach ($Vendors as $data)
        <form novalidate action="{{ route('VendorContractUpdate') }}"
            class="" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <input type="hidden" name="id" value="{{ $data->id }}">

                <input type="hidden" name="TableName" value="drugs_vendors">


                {{ RunUpdateModal($ModalID = $data->id,$Extra =' <div class="mb-3 col-md-12"> <label class="required form-label">Vendor contract terms</label> <textarea name="ContractTerms" class="editorme"></textarea> </div> ',$csrf = null,$Title = 'Update the  contract expiry date for the  vendor ' . $data->Name,$RecordID = $data->id,$col = '12',$te = '12',$TableName = 'drugs_vendors') }}
            </div>
        </form>
    @endforeach
@endisset
