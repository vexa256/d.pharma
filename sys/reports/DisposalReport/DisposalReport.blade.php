<!--begin::Card body-->
<div class="card-body pt-3 bg-light shadow-lg table-responsive">
    {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Stock Disposal Report for the months ' . $FromMonth . ' to ' . $ToMonth, $Msg = null) !!}
</div>
{{-- @include('reports.RefundReport.Stats') --}}

<div class="card-body pt-3 bg-light shadow-lg table-responsive">

    <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
        <thead>
            <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                <th>Stock Item</th>
                <th>Batch No.</th>
                <th>Vendor</th>
                <th>Loss With Profit (UGX)</th>
                <th>Loss Without Profit (UGX)</th>
                <th>Disposed Qty</th>
                <th> Buying Price</th>
                <th> Selling Price</th>
                <th> Month</th>
                <th> Year</th>
                <th> Notes</th>
                <th>Registered By</th>

            </tr>
        </thead>
        <tbody>
            @isset($Reports)
                @foreach ($Reports as $data)
                    <tr>
                        <td>{{ $data->DrugName }}</td>
                        <td>{{ $data->BatchNumber }}</td>
                        <td>{{ $data->Name }}</td>
                        <td>UGX {{ number_format($data->DisposalLossWithProfit) }}
                        </td>
                        <td>UGX
                            {{ number_format($data->DisposalLossWithoutProfit) }}
                        </td>
                        <td> {{ number_format($data->QuantityDisposed) }}
                            {{ $data->UnitName }}</td>
                        <td>UGX {{ number_format($data->BuyingPrice) }}</td>
                        <td>UGX {{ number_format($data->SellingPrice) }}</td>
                        <td>
                            <?php

                            $monthNum = $data->DisposedMonth;
                            $dateObj = DateTime::createFromFormat('!m', $monthNum);
                            echo $dateObj->format('F');

                            ?>
                        </td>

                        <td>
                            {{ $data->DisposedYear }}
                        </td>


                        <td>
                            {!! $data->DisposalNotes !!}
                        </td>

                        <td>
                            {{ $data->DisposalRegisteredBy }}
                        </td>






                    </tr>
                @endforeach
            @endisset



        </tbody>
    </table>
</div>
