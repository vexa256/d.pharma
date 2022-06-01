 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
    {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Let\'s manage our pharmacy inventory.', $Msg = null) !!}
</div>
<div class="card-body pt-3 bg-light shadow-lg table-responsive">
    {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'New Drug', $Icon = 'fa-plus') }}
    <table
        class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
        <thead>
            <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                <th>Drug Name </th>
                <th>Category</th>
                <th>Buying Price</th>
                <th>Selling Price</th>
                <th>MIN QTY</th>


                <th>Date Added</th>
                <th class="bg-dark text-light">Manage Drug </th>
            </tr>
        </thead>
        <tbody>
            @isset($Drugs)
                @foreach ($Drugs as $data)
                    <tr>

                        <td>{{ $data->DrugName }}</td>
                        <td>{{ $data->CatName }}</td>
                        <td>{{ $data->Currency }} {{ $data->UnitBuyingPrice }}
                        </td>
                        <td>{{ $data->Currency }} {{ $data->UnitSellingPrice }}
                        </td>
                        <td>{{ $data->MinimumQty }} {{ $data->Unit }}</td>

                        <td>{!! date('F j, Y', strtotime($data->created_at)) !!}</td>

                        <td>

                            <a
                                class="btn shadow-lg btn-danger btn-sm admin"
                                href="{{ route('DrugSettings', ['id' =>$data->id]) }}">

                                <i class="fas fa-cogs" aria-hidden="true"></i>
                            </a>

                        </td>








                    </tr>
                @endforeach
            @endisset



        </tbody>
    </table>
</div>
<!--end::Card body-->
@include('drugs.NewDrug')


